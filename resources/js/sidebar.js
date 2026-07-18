// Controle e Persistência do Estado do Menu Lateral (Sidebar)

export function toggleDropdown(button) {
    const item = button.closest('.sidebar-item');
    if (item) {
        item.classList.toggle('expanded');
        saveSidebarState();
    }
}

export function saveSidebarState() {
    const expandedMenus = [];

    document.querySelectorAll('.sidebar-item.expanded').forEach(item => {
        if (item.dataset.menu) {
            expandedMenus.push(item.dataset.menu);
        }
    });

    localStorage.setItem('sidebarExpandedMenus', JSON.stringify(expandedMenus));
}

export function loadSidebarState() {
    const expandedMenus = JSON.parse(
        localStorage.getItem('sidebarExpandedMenus') || '[]'
    );

    document.querySelectorAll('.sidebar-item').forEach(item => {
        item.classList.remove('expanded');

        if (expandedMenus.includes(item.dataset.menu)) {
            item.classList.add('expanded');
        }
    });
}

export function updateSidebarActiveStates() {
    const currentUrl = window.location.href.split('?')[0].replace(/\/$/, '');
    
    // Remove apenas os estados ativos antigos
    document.querySelectorAll('.sidebar-link, .submenu-link').forEach(el => {
        el.classList.remove('active');
        el.classList.remove('active-parent');
    });

    // Percorre todos os links para encontrar o correspondente
    let activeLink = null;
    document.querySelectorAll('.sidebar-menu a').forEach(link => {
        const href = link.getAttribute('href');
        if (href && href !== '#' && !href.startsWith('javascript:')) {
            const linkUrl = link.href.split('?')[0].replace(/\/$/, '');
            if (currentUrl === linkUrl) {
                activeLink = link;
            }
        }
    });

    if (activeLink) {
        activeLink.classList.add('active');

        const submenu = activeLink.closest('.submenu');
        if (submenu) {
            const parentItem = activeLink.closest('.sidebar-item');
            if (parentItem) {
                parentItem.classList.add('expanded');
                const parentLink = parentItem.querySelector('.sidebar-link');
                if (parentLink) {
                    parentLink.classList.add('active-parent');
                }
            }
        }
    }

    // Salva o estado atualizado
    saveSidebarState();
}

export function toggleMobileMenu() {
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    if (sidebar && backdrop) {
        sidebar.classList.toggle('mobile-open');
        backdrop.classList.toggle('active');
    }
}

// Expondo as funções no escopo global para permitir o uso em listeners do HTML inline (onclick)
window.toggleDropdown = toggleDropdown;
window.saveSidebarState = saveSidebarState;
window.loadSidebarState = loadSidebarState;
window.updateSidebarActiveStates = updateSidebarActiveStates;
window.toggleMobileMenu = toggleMobileMenu;

// Inicializa o estado do menu lateral no carregamento da página
document.addEventListener('DOMContentLoaded', () => {
    loadSidebarState();
    updateSidebarActiveStates();
    loadSidebarState();
});
