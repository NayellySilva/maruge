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
    
    <!-- Ícones Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>

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

    <!-- Inicializa os Ícones Lucide -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
