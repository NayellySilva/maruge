<aside class="sidebar" id="sidebar">
    <!-- Área da Marca/Logotipo -->
    <div class="sidebar-brand">
        <a href="/" class="flex items-center">
            <img src="{{ asset('logo-Painel3.png') }}" alt="Maruge Logo" style="height: 52px; width: auto;">
        </a>
        </div>

    <!-- Lista de Navegação -->
    <nav class="sidebar-menu">
        <!-- Dashboard -->
        <div class="sidebar-item">
            <a href="/" class="sidebar-link active">
                <span class="sidebar-link-content">
                    <i data-lucide="layout-grid"></i>
                    <span>Dashboard</span>
                </span>
            </a>
        </div>

        <!-- Secretaria -->
        <div class="sidebar-item">
            <button class="sidebar-link" onclick="toggleDropdown(this)">
                <span class="sidebar-link-content">
                    <i data-lucide="book-open"></i>
                    <span>Secretaria</span>
                </span>
                <i data-lucide="chevron-right" class="sidebar-chevron"></i>
            </button>
            <div class="submenu">
                <div class="submenu-list">
                    <a href="{{ route('coordenacao.pagina', 'turmas') }}" class="submenu-link">Turmas</a>
                    <a href="{{ route('coordenacao.pagina', 'funcionarios') }}" class="submenu-link">Funcionários</a>
                    <a href="{{ route('coordenacao.pagina', 'usuarios') }}" class="submenu-link">Usuários</a>
                    <a href="{{ route('coordenacao.pagina', 'alunos') }}" class="submenu-link">Alunos</a>
                    <a href="{{ route('coordenacao.pagina', 'disciplinas') }}" class="submenu-link">Disciplinas</a>
                    <a href="{{ route('coordenacao.pagina', 'lanche') }}" class="submenu-link">Lanche</a>
                </div>
            </div>
        </div>

        <!-- Relatórios -->
        <div class="sidebar-item">
            <button class="sidebar-link" onclick="toggleDropdown(this)">
                <span class="sidebar-link-content">
                    <i data-lucide="file-text"></i>
                    <span>Relatórios</span>
                </span>
                <i data-lucide="chevron-right" class="sidebar-chevron"></i>
            </button>
            <div class="submenu">
                <div class="submenu-list">
                    <a href="{{ route('coordenacao.pagina', 'relatorios-bimestrais') }}" class="submenu-link">Relatórios Bim.</a>
                    <a href="{{ route('coordenacao.pagina', 'mapa-de-notas') }}" class="submenu-link">Mapas de Notas</a>
                    <a href="{{ route('coordenacao.pagina', 'resultados') }}" class="submenu-link">Resultados</a>
                    <a href="{{ route('coordenacao.pagina', 'gabaritos') }}" class="submenu-link">Gabaritos</a>
                    <a href="{{ route('coordenacao.pagina', 'alunos-matriculados') }}" class="submenu-link">Alunos Matriculados</a>
                    <a href="{{ route('coordenacao.pagina', 'alunos-inativos-ou-transferidos') }}" class="submenu-link">Alunos Inativos / Transf.</a>
                    <a href="{{ route('coordenacao.pagina', 'alunos-por-turma') }}" class="submenu-link">Alunos Por Turma</a>
                    <a href="{{ route('coordenacao.pagina', 'alunos-pre-matriculados') }}" class="submenu-link">Alunos Pré-Matriculados</a>
                </div>
            </div>
        </div>

        <!-- Financeiro -->
        <div class="sidebar-item">
            <button class="sidebar-link" onclick="toggleDropdown(this)">
                <span class="sidebar-link-content">
                    <i data-lucide="dollar-sign"></i>
                    <span>Financeiro</span>
                </span>
                <i data-lucide="chevron-right" class="sidebar-chevron"></i>
            </button>
            <div class="submenu">
                <div class="submenu-list">
                    <a href="{{ route('coordenacao.pagina', 'contas-a-receber') }}" class="submenu-link">Receber</a>
                    <a href="{{ route('coordenacao.pagina', 'receitas-e-despesas') }}" class="submenu-link">Receitas e Despesas</a>
                    <a href="{{ route('coordenacao.pagina', 'estatistica-financeira') }}" class="submenu-link">Estatística</a>
                    <a href="{{ route('coordenacao.pagina', 'relatorios-financeiros') }}" class="submenu-link">Relatórios</a>
                </div>
            </div>
        </div>

        <!-- Ajuda -->
        <div class="sidebar-item">
            <button class="sidebar-link" onclick="toggleDropdown(this)">
                <span class="sidebar-link-content">
                    <i data-lucide="circle-help"></i>
                    <span>Ajuda</span>
                </span>
                <i data-lucide="chevron-right" class="sidebar-chevron"></i>
            </button>
            <div class="submenu">
                <div class="submenu-list">
                    <a href="{{ route('coordenacao.pagina', 'manual-de-ajuda') }}" class="submenu-link">Manual</a>
                    <a href="{{ route('coordenacao.pagina', 'canal-do-youtube') }}" class="submenu-link">YouTube</a>
                    <a href="{{ route('coordenacao.pagina', 'pagina-do-facebook') }}" class="submenu-link">FaceBook</a>
                    <a href="{{ route('coordenacao.pagina', 'sugestoes') }}" class="submenu-link">Sugestões</a>
                    <a href="{{ route('coordenacao.pagina', 'bate-papo') }}" class="submenu-link">Bate-Papo</a>
                    <a href="{{ route('coordenacao.pagina', 'contatos') }}" class="submenu-link">Contatos</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Seção do Perfil no Rodapé -->
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                NR
            </div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name" title="Nayana Roberta">Nayana Roberta</span>
                <span class="sidebar-user-role" title="Coordenação">Coordenação</span>
            </div>
        </div>
        <button class="sidebar-logout" title="Sair">
            <i data-lucide="log-out" style="width: 20px; height: 20px;"></i>
        </button>
    </div>
</aside>

<!-- JavaScript para Dropdowns e Alternador Mobile -->
<script>
    function toggleDropdown(button) {
        const item = button.closest('.sidebar-item');
        item.classList.toggle('expanded');
    }

    function toggleMobileMenu() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (sidebar && backdrop) {
            sidebar.classList.toggle('mobile-open');
            backdrop.classList.toggle('active');
        }
    }
</script>
