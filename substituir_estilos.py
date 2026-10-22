import os
import sys
import re
import argparse

STYLE_MAP = {
    'width: 50px;': 'largura-50',
    'width: 65px;': 'largura-65',
    'width: 70px;': 'largura-70',
    'width: 80px;': 'largura-80',
    'width: 100px;': 'largura-100',
    'min-width: 200px;': 'largura-min-200',
    'grid-column: span 2;': 'col-span-2',
    'display: flex; gap: 10px;': 'flex-gap-10',
    'display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;': 'linha-flex-fim',
    'flex: 1 1 50%; min-width: 0;': 'flex-base-50',
    'flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;': 'col-form-15',
    'flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;': 'col-form-20',
    'flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;': 'col-form-25',
    'flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;': 'col-form-40',
    'border-bottom: 1px solid #e2e8f0;': 'borda-inferior-suave',
    'padding: 5px 4px; text-align: center;': 'celula-centro',
    'padding: 5px 4px; text-transform: uppercase;': 'celula-maiuscula',
    'padding: 5px 4px; font-family: monospace;': 'celula-mono',
    'padding: 5px 4px; font-weight: bold; text-transform: uppercase;': 'celula-cabecalho',
}

def is_display_none(val):
    v = val.strip().lower()
    return v in ('display: none', 'display: none;', 'display:none', 'display:none;')

def is_blade_expr(val):
    return '{{' in val or '}}' in val or '@' in val or '{!!' in val or '!!}' in val

tag_regex = re.compile(r'(<[a-zA-Z0-9\-_:]+)([^>]*)(>)', re.DOTALL)
style_attr_regex = re.compile(r'\bstyle\s*=\s*(?:"([^"]*)"|\'([^\']*)\')', re.I)
class_attr_regex = re.compile(r'\bclass\s*=\s*(?:"([^"]*)"|\'([^\']*)\')', re.I)

def process_tag(match, stats):
    tag_start = match.group(1)
    attrs = match.group(2)
    tag_end = match.group(3)

    style_matches = list(style_attr_regex.finditer(attrs))
    if not style_matches:
        return match.group(0)

    new_attrs = attrs
    for sm in reversed(style_matches):
        val = sm.group(1) if sm.group(1) is not None else sm.group(2)
        style_quote = '"' if sm.group(1) is not None else "'"

        if is_blade_expr(val) or is_display_none(val):
            stats['ignorados'] += 1
            continue

        if val in STYLE_MAP:
            target_class = STYLE_MAP[val]
            stats['trocas'] += 1

            cm = class_attr_regex.search(new_attrs)
            if cm:
                existing_classes_raw = cm.group(1) if cm.group(1) is not None else cm.group(2)
                class_quote = '"' if cm.group(1) is not None else "'"
                class_list = existing_classes_raw.split()

                if target_class not in class_list:
                    class_list.append(target_class)
                new_class_val = " ".join(class_list)

                new_class_attr = f'class={class_quote}{new_class_val}{class_quote}'
                new_attrs = new_attrs[:cm.start()] + new_class_attr + new_attrs[cm.end():]

                pos = new_attrs.find(sm.group(0))
                if pos != -1:
                    start_pos = pos
                    while start_pos > 0 and new_attrs[start_pos - 1] in ' \t\r\n':
                        start_pos -= 1
                    new_attrs = new_attrs[:start_pos] + (' ' if start_pos > 0 and pos + len(sm.group(0)) < len(new_attrs) and new_attrs[pos + len(sm.group(0))] not in ' \t\r\n/>' else '') + new_attrs[pos + len(sm.group(0)):]
            else:
                new_class_attr = f'class={style_quote}{target_class}{style_quote}'
                new_attrs = new_attrs[:sm.start()] + new_class_attr + new_attrs[sm.end():]

    return f"{tag_start}{new_attrs}{tag_end}"

def build_include_map(views_dir):
    include_map = {}
    for root, dirs, files in os.walk(views_dir):
        for f in files:
            if f.endswith('.blade.php'):
                filepath = os.path.join(root, f)
                with open(filepath, 'r', encoding='utf-8', errors='ignore') as fp:
                    c = fp.read()
                includes = re.findall(r"@include(?:If|When)?\s*\(\s*['\"]([^'\",\s]+)['\"]", c)
                for inc in includes:
                    target_rel = inc.strip().replace('.', os.sep) + '.blade.php'
                    target_path = os.path.normpath(os.path.join(views_dir, target_rel))
                    include_map.setdefault(target_path, []).append(os.path.normpath(filepath))
    return include_map

def check_css_loaded(filepath, views_dir, include_map, visited=None):
    if visited is None:
        visited = set()
    norm_path = os.path.normpath(filepath)
    if norm_path in visited:
        return False
    visited.add(norm_path)

    try:
        with open(norm_path, 'r', encoding='utf-8', errors='ignore') as fp:
            content = fp.read()
    except Exception:
        return False

    # Link direto
    if 'utilitarios.css' in content:
        return True

    # Via layout do @extends
    extends_matches = re.findall(r"@extends\s*\(\s*['\"]([^'\"]+)['\"]\s*\)", content)
    for ext in extends_matches:
        layout_rel = ext.strip().replace('.', os.sep) + '.blade.php'
        layout_path = os.path.normpath(os.path.join(views_dir, layout_rel))
        if os.path.exists(layout_path) and check_css_loaded(layout_path, views_dir, include_map, visited.copy()):
            return True

    # Via inclusão em view pai (@include)
    if norm_path in include_map:
        parents = include_map[norm_path]
        if parents and all(check_css_loaded(p, views_dir, include_map, visited.copy()) for p in parents):
            return True

    return False

def process_file(filepath, apply_changes=False, css_loaded=False):
    with open(filepath, 'r', encoding='utf-8', errors='ignore') as fp:
        content = fp.read()

    stats = {'trocas': 0, 'ignorados': 0}
    
    new_content = tag_regex.sub(lambda m: process_tag(m, stats), content)

    # Se algum arquivo com trocas não carregar, NÃO aplique nele
    applied = False
    if apply_changes and css_loaded and stats['trocas'] > 0 and new_content != content:
        with open(filepath, 'w', encoding='utf-8') as fp:
            fp.write(new_content)
        applied = True

    return stats, applied

def main():
    parser = argparse.ArgumentParser(description="Substituir style inline por classes do utilitarios.css")
    parser.add_argument('--dry-run', action='store_true', default=False, help="Executa sem modificar os arquivos")
    parser.add_argument('--apply', action='store_true', help="Aplica as modificações de verdade")
    args = parser.parse_args()

    apply_changes = args.apply and not args.dry_run

    views_dir = r"c:\Users\nayel\maruge\resources\views"
    include_map = build_include_map(views_dir)
    reports = []

    for root, dirs, files in os.walk(views_dir):
        for f in sorted(files):
            if f.endswith('.blade.php'):
                filepath = os.path.join(root, f)
                rel_path = os.path.relpath(filepath, views_dir).replace('\\', '/')
                css_loaded = check_css_loaded(filepath, views_dir, include_map)
                stats, applied = process_file(filepath, apply_changes=apply_changes, css_loaded=css_loaded)
                if stats['trocas'] > 0 or stats['ignorados'] > 0:
                    reports.append({
                        'arquivo': rel_path,
                        'trocas': stats['trocas'],
                        'ignorados': stats['ignorados'],
                        'carrega_css': css_loaded,
                        'carrega_css_str': 'sim' if css_loaded else 'não',
                        'applied': applied
                    })

    # Sort: highest trocas first, then ignorados
    reports.sort(key=lambda x: (-x['trocas'], -x['ignorados'], x['arquivo']))

    total_trocas = sum(r['trocas'] for r in reports)
    total_ignorados = sum(r['ignorados'] for r in reports)
    files_with_trocas = [r for r in reports if r['trocas'] > 0]
    files_not_loading = [r for r in files_with_trocas if not r['carrega_css']]

    mode_str = "APLICADO" if apply_changes else "DRY-RUN (Simulação)"
    print(f"=== RELATÓRIO DO SCRIPT: {mode_str} ===\n")
    print(f"Total de arquivos com trocas: {len(files_with_trocas)}")
    print(f"Total de substituições (trocas): {total_trocas}")
    print(f"Total de estilos ignorados (display:none ou Blade): {total_ignorados}")
    print(f"Arquivos com trocas que NÃO carregam utilitarios.css: {len(files_not_loading)}\n")

    print("| Arquivo | Trocas | Ignorados | Carrega utilitarios.css |")
    print("| :--- | :---: | :---: | :---: |")
    for r in reports:
        print(f"| `{r['arquivo']}` | {r['trocas']} | {r['ignorados']} | {r['carrega_css_str']} |")

if __name__ == '__main__':
    main()
