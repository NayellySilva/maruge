@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/docente') }}" class="hover:text-[#008a4b] transition-colors">Docente</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Relatórios</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Módulo de Relatórios</h1>
            <p class="text-sm text-[#5c706b]">Consulte e imprima mapas de notas, resultados e listas de alunos</p>
        </div>
    </div>

    <!-- Grade de Cards de Navegação -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Card: Mapas de Notas -->
        <a href="{{ url('/docente/mapas_notas') }}" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-all flex items-center gap-4 group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="map" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Mapas de Notas</h2>
                <p class="text-xs text-[#5c706b]">Mapas bimestrais e globais por turma</p>
            </div>
        </a>

        <!-- Card: Resultados -->
        <a href="{{ url('/docente/resultados') }}" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-all flex items-center gap-4 group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="award" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Resultados</h2>
                <p class="text-xs text-[#5c706b]">Parcial, final e aprovações semestrais</p>
            </div>
        </a>

        <!-- Card: Alunos Por Turma -->
        <a href="{{ url('/docente/relatorio_alunos_turmas') }}" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-all flex items-center gap-4 group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                <i data-lucide="users" class="w-7 h-7"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-base font-bold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Alunos Por Turma</h2>
                <p class="text-xs text-[#5c706b]">Listagem completa de alunos por turma</p>
            </div>
        </a>

    </div>

</div>
@endsection
