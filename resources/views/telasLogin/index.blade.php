<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Entrar') | Maruge</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/login.js'])
</head>
<body class="min-h-screen bg-[#f8faf9] font-['Instrument_Sans',ui-sans-serif,system-ui,sans-serif] text-[#0a241e] antialiased">
<div class="min-h-screen lg:flex">

    <section class="relative hidden overflow-hidden lg:flex lg:w-[59%]">
        <img src="{{ Vite::asset('resources/img/bg.jpg') }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full object-cover">
        <div class="relative flex flex-1 flex-col justify-between bg-[#0a241e]/[0.84] px-16 py-14">
            <div class="flex items-center gap-3">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                <span class="text-sm font-semibold uppercase tracking-[0.08em] text-[#a7c4bb]">Sistema de Gestão Escolar</span>
            </div>

            <div class="flex flex-col gap-7">
                <div class="flex h-[130px] w-[130px] items-center justify-center rounded-full bg-white shadow-[0_0_0_8px_rgba(255,255,255,0.12)]">
                    <img src="{{ \App\Support\LogoColegio::src() }}" alt="Logo do Colégio Carinho da Mamãe" class="h-[88px] w-[84px] object-contain">
                </div>
                <div class="flex flex-col gap-3">
                    <h1 class="text-5xl font-bold leading-[1.1] tracking-tight text-white">Colégio<br>Carinho da Mamãe</h1>
                    <p class="max-w-[440px] text-lg leading-relaxed text-[#cfe3dc]">@yield('descricao')</p>
                </div>
            </div>

            <p class="text-sm text-[#8fb3a8]">Juazeiro do Norte · CE</p>
        </div>
    </section>

    <header class="flex flex-col items-center gap-3.5 bg-[#0a241e] px-6 pb-[72px] pt-12 text-center lg:hidden">
        <div class="flex h-[88px] w-[88px] items-center justify-center rounded-full bg-white shadow-[0_0_0_6px_rgba(255,255,255,0.12)]">
            <img src="{{ \App\Support\LogoColegio::src() }}" alt="Logo do Colégio Carinho da Mamãe" class="h-[58px] w-[56px] object-contain">
        </div>
        <p class="text-[22px] font-bold leading-tight text-white">Colégio Carinho da Mamãe</p>
    </header>

    <main class="-mt-10 flex flex-1 justify-center px-4 pb-6 lg:mt-0 lg:items-center lg:p-12">
        <div class="flex w-full max-w-[380px] flex-col gap-8 rounded-[20px] border border-[#e3e8e6] bg-white px-[22px] py-7 shadow-[0_10px_28px_rgba(10,36,30,0.08)] lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none">

            @yield('form')

            <div class="flex flex-col items-center gap-4">
                @yield('link_alternativo')
                <p class="text-center text-[13px] text-[#5c706b]">
                    Desenvolvido por <a href="http://maruge.com.br" class="text-[#5c706b] underline hover:text-[#0a241e]">Maruge · Sistema de Gestão Escolar</a>
                </p>
            </div>
        </div>
    </main>
</div>
</body>
</html>
