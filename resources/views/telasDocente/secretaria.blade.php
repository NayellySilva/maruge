@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/docente') }}" class="hover:text-[#008a4b] transition-colors">Docente</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Secretaria</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Módulo Secretaria</h1>
            <p class="text-sm text-[#5c706b]">Acesse seu perfil funcional, declarações e lançamento de notas</p>
        </div>
    </div>

    <!-- Grade de Cards de Navegação -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Card: Perfil -->
        <a href="{{ url('/docente/funcionario_perfil') }}" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-all flex items-center gap-4 group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="user-round" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Meu Perfil</h2>
                <p class="text-xs text-[#5c706b]">Visualizar dados cadastrais e turmas</p>
            </div>
        </a>

        <!-- Card: Declarações -->
        <a href="{{ url('/docente/declaracoes') }}" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-all flex items-center gap-4 group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="file-check" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Declarações</h2>
                <p class="text-xs text-[#5c706b]">Declaração funcional do docente</p>
            </div>
        </a>

        <!-- Card: Lançar Notas -->
        <a href="{{ url('/docente/notas') }}" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-all flex items-center gap-4 group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="clipboard-pen" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Lançar Notas</h2>
                <p class="text-xs text-[#5c706b]">Lançamento de notas bimestrais e recuperação</p>
            </div>
        </a>

    </div>

</div>
@endsection
