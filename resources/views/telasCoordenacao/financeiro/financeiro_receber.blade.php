@extends('layouts.app')

@section('content')

@php
    try {
        $AnosLetivos = $AnosLetivos ?? \DB::table('tb_turmas')->select('AnoLetivo')->distinct()->orderBy('AnoLetivo', 'desc')->get();
    } catch (\Exception $e) {
        $AnosLetivos = collect();
    }
@endphp

<!-- Titulo e Endereco da Pagina -->
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Financeiro</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Recebimentos</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Recebimentos</h1>
            <p class="text-sm text-[#5c706b]">Localizar título por Código de Barras ou RA do aluno</p>
        </div>
    </div>

    <!-- Filtros de Busca e Seleção de Ano (Padrão do Sistema) -->
    <form method="POST" action="{{ url('/coordenacao/financeiro_pesq') }}" class="flex flex-col sm:flex-row gap-4 items-center">
        @csrf

        <!-- Campo de Busca por Código de Barras ou RA -->
        <div class="w-full sm:w-96">
            <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                <input type="text"
                       name="codbarras"
                       id="codbarras"
                       placeholder="Código de Barras ou RA do aluno"
                       required
                       class="w-full bg-transparent text-sm focus:outline-none">
                <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Filtrar por Ano Letivo -->
        <div class="w-full sm:w-48">
            <div class="relative">
                <select
                    name="AnoLetivo"
                    class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                >
                    <option value="">Ano Letivo</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                </select>
                <i
                    data-lucide="chevron-down"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                ></i>
            </div>
        </div>

        <!-- Botão Limpar -->
        <div>
            <button type="reset" class="bg-white hover:bg-[#f8faf9] text-[#5c706b] border border-[#e3e8e6] text-sm font-medium px-4 py-2.5 rounded-xl transition-all">
                Limpar
            </button>
        </div>
    </form>

    <!-- Terceira linhas, APENAS UM AVISO DE ALERTA -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-8 shadow-2xs">
        <div class="flex flex-col items-center justify-center text-center gap-3 py-6">
            <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#008a4b]">
                <i data-lucide="barcode" class="w-8 h-8"></i>
            </div>
            <h3 class="text-base font-semibold text-[#0a241e]">Localizar Título Financeiro</h3>
            <p class="text-sm text-[#5c706b] max-w-md">Por favor, informe o código de barras ou o número de RA do aluno na barra de pesquisa acima para carregar a ficha de mensalidades e dar baixa no recebimento.</p>
        </div>
    </div>

</div> <!--Fim do caminho-din-->

@endsection