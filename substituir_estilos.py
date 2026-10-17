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

# Regex to find HTML opening tags: e.g. <div ...> or <th ...>
# We match from '<' followed by a tag name up to '>'
# Making sure we do not match closing tags like </div>
tag_regex = re.compile(r'(<[a-zA-Z0-9\-_:]+)([^>]*)(>)', re.DOTALL)

# Regex to match style attribute within a tag's attribute string
style_attr_regex = re.compile(r'\bstyle\s*=\s*(?:"([^"]*)"|\'([^\']*)\')', re.I)

# Regex to match class attribute within a tag's attribute string
class_attr_regex = re.compile(r'\bclass\s*=\s*(?:"([^"]*)"|\'([^\']*)\')', re.I)

def process_tag(match, stats):
    tag_start = match.group(1)
    attrs = match.group(2)
    tag_end = match.group(3)

    # Check if this tag has a style attribute
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

            # Check if class attribute already exists in new_attrs
            cm = class_attr_regex.search(new_attrs)
            if cm:
                existing_classes_raw = cm.group(1) if cm.group(1) is not None else cm.group(2)
                class_quote = '"' if cm.group(1) is not None else "'"
                class_list = existing_classes_raw.split()

                if target_class not in class_list:
                    class_list.append(target_class)
                new_class_val = " ".join(class_list)

                # Replace class attribute with updated classes
                new_class_attr = f'class={class_quote}{new_class_val}{class_quote}'
                new_attrs = new_attrs[:cm.start()] + new_class_attr + new_attrs[cm.end():]

                # Now remove the style attribute (re-find it since indices may have shifted if class was before style)
                # To be safe, re-search style attribute with exact value
                escaped_val = re.escape(val)
                style_remove_re = re.compile(r'\s*\bstyle\s*=\s*' + re.escape(sm.group(0)), re.I)
                # If exact full match:
                if sm.group(0) in new_attrs:
                    # check leading space
                    pattern_to_remove = re.compile(r'\s*\bstyle\s*=\s*' + re.escape(sm.group(0)[sm.group(0).index('=') + 1:].strip()))
                    # simpler: remove sm.group(0) plus any leading whitespace
                    pos = new_attrs.find(sm.group(0))
                    if pos != -1:
                        start_pos = pos
                        while start_pos > 0 and new_attrs[start_pos - 1] in ' \t\r\n':
                            start_pos -= 1
                        new_attrs = new_attrs[:start_pos] + (' ' if start_pos > 0 and pos + len(sm.group(0)) < len(new_attrs) and new_attrs[pos + len(sm.group(0))] not in ' \t\r\n/>' else '') + new_attrs[pos + len(sm.group(0)):]
            else:
                # No class attribute exists; replace style with class
                new_class_attr = f'class={style_quote}{target_class}{style_quote}'
                new_attrs = new_attrs[:sm.start()] + new_class_attr + new_attrs[sm.end():]

    return f"{tag_start}{new_attrs}{tag_end}"

def process_file(filepath, apply_changes=False):
    with open(filepath, 'r', encoding='utf-8', errors='ignore') as fp:
        content = fp.read()

    stats = {'trocas': 0, 'ignorados': 0}
    
    new_content = tag_regex.sub(lambda m: process_tag(m, stats), content)

    if apply_changes and stats['trocas'] > 0 and new_content != content:
        with open(filepath, 'w', encoding='utf-8') as fp:
            fp.write(new_content)

    return stats, new_content != content

def main():
    parser = argparse.ArgumentParser(description="Substituir style inline por classes do utilitarios.css")
    parser.add_argument('--dry-run', action='store_true', default=True, help="Executa sem modificar os arquivos")
    parser.add_argument('--apply', action='store_true', help="Aplica as modificações de verdade")
    args = parser.parse_args()

    apply_changes = args.apply and not args.dry_run

    views_dir = r"c:\Users\nayel\maruge\resources\views"
    reports = []

    for root, dirs, files in os.walk(views_dir):
        for f in sorted(files):
            if f.endswith('.blade.php'):
                filepath = os.path.join(root, f)
                rel_path = os.path.relpath(filepath, views_dir).replace('\\', '/')
                stats, changed = process_file(filepath, apply_changes=apply_changes)
                if stats['trocas'] > 0 or stats['ignorados'] > 0:
                    reports.append({
                        'arquivo': rel_path,
                        'trocas': stats['trocas'],
                        'ignorados': stats['ignorados']
                    })

    # Sort: highest trocas first, then ignorados
    reports.sort(key=lambda x: (-x['trocas'], -x['ignorados'], x['arquivo']))

    total_trocas = sum(r['trocas'] for r in reports)
    total_ignorados = sum(r['ignorados'] for r in reports)
    files_with_trocas = sum(1 for r in reports if r['trocas'] > 0)
    files_with_ignorados = sum(1 for r in reports if r['ignorados'] > 0)

    mode_str = "APLICADO" if apply_changes else "DRY-RUN (Simulação)"
    print(f"=== RELATÓRIO DO SCRIPT: {mode_str} ===\n")
    print(f"Total de arquivos com trocas: {files_with_trocas}")
    print(f"Total de substituições (trocas): {total_trocas}")
    print(f"Total de estilos ignorados (display:none ou Blade): {total_ignorados}\n")

    print("| Arquivo | Trocas | Ignorados |")
    print("| :--- | :---: | :---: |")
    for r in reports:
        print(f"| `{r['arquivo']}` | {r['trocas']} | {r['ignorados']} |")

if __name__ == '__main__':
    main()
