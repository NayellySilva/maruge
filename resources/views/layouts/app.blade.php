<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Maruge') }}</title>

    <!-- Fontes do Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <!-- Estilos e Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <div class="dashboard-layout">
        <!-- Cabeçalho Mobile (Visível em telas menores) -->
        <header class="mobile-header">
            <button class="mobile-menu-toggle" onclick="toggleMobileMenu()" aria-label="Abrir menu">
                <i data-lucide="menu"></i>
            </button>
            <div class="flex items-center">
                <!-- Minilogo da marca para visualização mobile -->
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#00e676" stroke-width="2">
                    <path d="M12 22c4.5-0.2 8-3.7 8-8.5c0-3-1.5-5.5-4-5.5c-1.5 0-2.5 1-4 1s-2.5-1-4-1C5.5 8 4 10.5 4 13.5c0 4.8 3.5 8.3 8 8.5Z" />
                    <path d="M12 8c0-2.2 1.8-4 4-4" />
                </svg>
            </div>
            <div style="width: 24px;"></div> <!-- Espaçador para alinhar o logotipo ao centro -->
        </header>

        <!-- Camada de fundo (backdrop) para navegação mobile -->
        <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleMobileMenu()"></div>

        <!-- Componente da Barra Lateral (Sidebar) -->
        <x-sidebar />

        <!-- Área de Conteúdo Principal -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <!-- Script de Inicialização e Roteamento SPA -->
    <script>
        // Inicializa os Ícones Lucide
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                if (window.lucide) window.lucide.createIcons();
            });
        } else {
            if (window.lucide) window.lucide.createIcons();
        }

        document.addEventListener('DOMContentLoaded', () => {

            // Histórico de navegação (botão Voltar/Avançar do navegador)
            window.addEventListener('popstate', () => {
                loadPage(window.location.href, false);
            });

            // Intercepta os cliques em links internos do menu
            document.addEventListener('click', (e) => {
                const link = e.target.closest('a');
                if (!link) return;

                const href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript:')) return;
                if (link.getAttribute('target') === '_blank') return;

                const url = new URL(link.href, window.location.href);
                if (url.origin === window.location.origin) {
                    e.preventDefault();
                    loadPage(link.href, true);
                }
            });

            function isModalPage(urlStr) {
                return (urlStr.includes('disciplina_cad') && !urlStr.includes('turma_disciplina_cad')) || 
                       (urlStr.includes('disciplina_editar') && !urlStr.includes('turma_disciplina_editar'));
            }

            function getBackgroundPageUrl(urlStr) {
                if (isModalPage(urlStr)) {
                    return window.location.origin + '/coordenacao/disciplinas/disciplina_inf';
                }
                return null;
            }

            function initPageScripts(newContent) {
                // Atualiza os estados do sidebar
                if (typeof updateSidebarActiveStates === 'function') {
                    updateSidebarActiveStates();
                }
                if (typeof loadSidebarState === 'function') {
                    loadSidebarState();
                }

                // Executa scripts presentes na página carregada
                if (newContent) {
                    const scripts = newContent.querySelectorAll('script');
                    scripts.forEach(script => {
                        const newScript = document.createElement('script');
                        if (script.src) {
                            newScript.src = script.src;
                        } else {
                            newScript.textContent = script.textContent;
                        }
                        document.body.appendChild(newScript);
                        newScript.remove();
                    });
                }

                // Recria ícones Lucide
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            }

            function openModalFromUrl(url, pushState = true) {
                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Page load failed');
                        return response.text();
                    })
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Encontra o container do modal no HTML retornado
                        const modalOverlay = doc.querySelector('.fixed.inset-0.z-50');
                        if (modalOverlay) {
                            // Remove o modal atual se houver
                            const existingModal = document.getElementById('app-modal-container');
                            if (existingModal) {
                                existingModal.remove();
                            }

                            // Cria e anexa o novo container do modal
                            const modalContainer = document.createElement('div');
                            modalContainer.id = 'app-modal-container';
                            modalContainer.appendChild(modalOverlay);
                            document.body.appendChild(modalContainer);

                            // Atualiza os ícones dentro do modal
                            if (window.lucide) {
                                window.lucide.createIcons();
                            }

                            // Atualiza o histórico do navegador
                            if (pushState) {
                                history.pushState(null, '', url);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Modal load error, loading normally:', error);
                        window.location.href = url;
                    });
            }

            function loadBackgroundThenModal(bgUrl, modalUrl, pushState = true) {
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    mainContent.style.opacity = '0.5';
                    mainContent.style.transition = 'opacity 0.15s ease';
                }

                fetch(bgUrl)
                    .then(response => {
                        if (!response.ok) throw new Error('Page load failed');
                        return response.text();
                    })
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Atualiza o título
                        document.title = doc.title;

                        // Atualiza o conteúdo principal
                        const newContent = doc.querySelector('.main-content');
                        if (mainContent && newContent) {
                            mainContent.innerHTML = newContent.innerHTML;
                            mainContent.style.opacity = '1';
                        }

                        // Inicializa scripts e ícones do background
                        initPageScripts(newContent);

                        // Abre o modal por cima
                        openModalFromUrl(modalUrl, pushState);
                    })
                    .catch(error => {
                        console.error('Background load error, loading normally:', error);
                        window.location.href = modalUrl;
                    });
            }

            function loadPage(url, pushState = true) {
                // Fechar qualquer modal ativo ao navegar para uma página comum
                if (!isModalPage(url)) {
                    const modalContainer = document.getElementById('app-modal-container');
                    if (modalContainer) {
                        modalContainer.remove();
                    }
                }

                // Se a URL solicitada for de um modal
                if (isModalPage(url)) {
                    const bgUrl = getBackgroundPageUrl(url);
                    const currentBgUrl = getBackgroundPageUrl(window.location.href);

                    // Se já estivermos na página de fundo correta carregada no DOM
                    if (currentBgUrl === bgUrl && document.querySelector('.main-content').innerHTML.trim() !== '') {
                        openModalFromUrl(url, pushState);
                    } else {
                        // Caso contrário, carrega a página de listagem primeiro, depois o modal por cima
                        loadBackgroundThenModal(bgUrl, url, pushState);
                    }
                    return;
                }

                // Navegação SPA normal
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    mainContent.style.opacity = '0.5';
                    mainContent.style.transition = 'opacity 0.15s ease';
                }

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Page load failed');
                        return response.text();
                    })
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Atualiza o título
                        document.title = doc.title;

                        // Atualiza o conteúdo principal
                        const newContent = doc.querySelector('.main-content');
                        if (mainContent && newContent) {
                            mainContent.innerHTML = newContent.innerHTML;
                            mainContent.style.opacity = '1';
                        }

                        // Atualiza o histórico
                        if (pushState) {
                            history.pushState(null, '', url);
                        }

                        initPageScripts(newContent);
                    })
                    .catch(error => {
                        console.error('SPA load error, navigating normally:', error);
                        window.location.href = url;
                    });
            }

            // Ao carregar a página inicialmente, verifica se ela é uma tela de modal.
            const initialUrl = window.location.href;
            if (isModalPage(initialUrl)) {
                const mainContent = document.querySelector('.main-content');
                if (mainContent) {
                    const modalHtml = mainContent.innerHTML;
                    const bgUrl = getBackgroundPageUrl(initialUrl);

                    mainContent.innerHTML = '';
                    mainContent.style.opacity = '0.5';

                    fetch(bgUrl)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const bgContent = doc.querySelector('.main-content');
                            if (bgContent) {
                                mainContent.innerHTML = bgContent.innerHTML;
                                mainContent.style.opacity = '1';
                                initPageScripts(bgContent);
                            }

                            // Injeta o modal
                            const parser2 = new DOMParser();
                            const doc2 = parser2.parseFromString(modalHtml, 'text/html');
                            const modalOverlay = doc2.querySelector('.fixed.inset-0.z-50');

                            if (modalOverlay) {
                                const modalContainer = document.createElement('div');
                                modalContainer.id = 'app-modal-container';
                                modalContainer.appendChild(modalOverlay);
                                document.body.appendChild(modalContainer);

                                if (window.lucide) {
                                    window.lucide.createIcons();
                                }
                            }
                        });
                }
            }
        });
    </script>
</body>
</html>
