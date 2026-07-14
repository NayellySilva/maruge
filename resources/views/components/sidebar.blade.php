<aside class="sidebar" id="sidebar">
    <!-- Área da Marca/Logotipo -->
    <div class="sidebar-brand">
        <a href="/" class="flex items-center">
            <img src="{{ asset('logo-Painel3.png') }}" alt="Maruge Logo" style="height: 38px; width: auto;">
        </a>
        </div>

    <!-- Lista de Navegação -->
    <nav class="sidebar-menu">
        <!-- Dashboard (Ativo) -->
        <div class="sidebar-item">
            <a href="#" class="sidebar-link active">
                <span class="sidebar-link-content">
                    <i data-lucide="layout-grid"></i>
                    <span>Dashboard</span>
                </span>
            </a>
        </div>

        <!-- Secretaria (Expandido/Aberto por padrão) -->
        <div class="sidebar-item expanded">
            <button class="sidebar-link" onclick="toggleDropdown(this)">
                <span class="sidebar-link-content">
                    <i data-lucide="book-open"></i>
                    <span>Secretaria</span>
                </span>
                <i data-lucide="chevron-right" class="sidebar-chevron"></i>
            </button>
            <div class="submenu">
                <div class="submenu-list">
                    <a href="#" class="submenu-link">Turmas</a>
                    <a href="#" class="submenu-link">Funcionários</a>
                    <a href="#" class="submenu-link">Usuários</a>
                    <a href="#" class="submenu-link">Alunos</a>
                    <a href="#" class="submenu-link">Disciplinas</a>
                    <a href="#" class="submenu-link">Lanche</a>
                </div>
            </div>
        </div>

        <!-- Relatórios (Fechado por padrão) -->
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
                    <a href="#" class="submenu-link">Relatórios Bim.</a>
                    <a href="#" class="submenu-link">Mapas de Notas</a>
                    <a href="#" class="submenu-link">Resultados</a>
                    <a href="#" class="submenu-link">Gabaritos</a>
                    <a href="#" class="submenu-link">Alunos Matriculados</a>
                    <a href="#" class="submenu-link">Alunos Inativos / Transf.</a>
                    <a href="#" class="submenu-link">Alunos Por Turma</a>
                    <a href="#" class="submenu-link">Alunos Pré-Matriculados</a>
                </div>
            </div>
        </div>

        <!-- Financeiro (Fechado por padrão) -->
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
                    <a href="#" class="submenu-link">Receber</a>
                    <a href="#" class="submenu-link">Receitas e Despesas</a>
                    <a href="#" class="submenu-link">Estatística</a>
                    <a href="#" class="submenu-link">Relatórios</a>
                </div>
            </div>
        </div>

        <!-- Ajuda (Fechado por padrão) -->
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
                    <a href="#" class="submenu-link">Manual</a>
                    <a href="#" class="submenu-link">YouTube</a>
                    <a href="#" class="submenu-link">FaceBook</a>
                    <a href="#" class="submenu-link">Sugestões</a>
                    <a href="#" class="submenu-link">Bate-Papo</a>
                    <a href="#" class="submenu-link">Contatos</a>
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
