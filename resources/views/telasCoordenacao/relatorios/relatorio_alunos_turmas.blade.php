@extends('layouts.app')

@section('content')

@php
    if (!isset($turmas)) {
        try {
            $turmas = \App\Models\modelCoordenacao\tb_turma::relatorioTurmasAtivas();
        } catch (\Exception $e) {
            $turmas = collect();
        }
    }
    if (!isset($turmas_Inativas)) {
        try {
            $turmas_Inativas = \App\Models\modelCoordenacao\tb_turma::AnoLetivoTurmasInativas();
        } catch (\Exception $e) {
            $turmas_Inativas = collect();
        }
    }
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Relatórios</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Relatórios Alunos por Turmas</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Alunos Por Turma</h1>
            <p class="text-sm text-[#5c706b]">Selecione uma turma abaixo para gerar o relatório em formato de lista ou endereço.</p>
        </div>
        <div class="text-right">
            <span class="text-lg font-bold text-[#0a241e]">Turmas Encontradas: ({{ count($turmas) }})</span>
        </div>
    </div>

    <!-- Filtros de Busca e Seleção por Ano Letivo -->
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
        <!-- Localizar Turma por Palavra-Chave -->
        <div class="w-full md:w-80">
            <form method="POST" action="{{ url('/coordenacao/relatorio_pesquisar_turmas') }}" class="w-full">
                @csrf
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl overflow-hidden shadow-2xs">
                    <input type="text" name="pesquisar" placeholder="Pesquisar Turma" value="{{ request()->input('pesquisar') }}" class="w-full bg-transparent text-sm px-4 py-2.5 focus:outline-none text-[#0a241e]">
                    <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white px-4 py-2.5 transition-colors flex items-center justify-center">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu Dropdown de Filtro Customizado -->
        <div class="w-full sm:w-64">
            <form method="POST" action="{{ url('/coordenacao/relatorio_alunos_turmas_pesq') }}" class="w-full">
                @csrf
                <div class="relative" id="dropdown-container-turma-relatorio-turmas">
                    <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                    @php
                        $selectedTurmaAluTur = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-turma-relatorio-turmas', 'chevron-turma-relatorio-turmas')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-turma-relatorio-turmas" class="text-sm font-medium truncate {{ $selectedTurmaAluTur ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            {{ $selectedTurmaAluTur ? $selectedTurmaAluTur->NomeTurma : 'Filtrar por Turma' }}
                        </span>
                        <div id="chevron-turma-relatorio-turmas" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-turma-relatorio-turmas" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                        <!-- Campo de Busca -->
                        <div class="relative shrink-0">
                            <input type="text" onkeyup="filterDropdownOptions('search-turma-relatorio-turmas', 'option-turma-relatorio-turmas')" id="search-turma-relatorio-turmas" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        <!-- Lista de Opções com Rolagem -->
                        <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                            <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma-relatorio-turmas', 'dropdown-menu-turma-relatorio-turmas', 'chevron-turma-relatorio-turmas', true)"
                                 class="option-turma-relatorio-turmas flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">Todas as Turmas</span>
                            </div>
                            @foreach($turmas as $t)
                                <div onclick="selectSingleOption('{{ $t->idTurmas }}', '{{ $t->NomeTurma }}', 'idTurmas', 'label-turma-relatorio-turmas', 'dropdown-menu-turma-relatorio-turmas', 'chevron-turma-relatorio-turmas', true)"
                                     class="option-turma-relatorio-turmas flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $t->NomeTurma }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Turmas Cadastradas (Passo 1) -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase text-[#5c706b]">CÓD</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase text-[#5c706b]">NOME TURMA</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase text-[#5c706b]">ANO LETIVO</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase text-[#5c706b]">Pais/WhatsApp</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase text-[#5c706b]">Endereço</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($turmas as $turma)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#5c706b] font-mono">{{ $turma->idTurmas }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-[#0a241e] uppercase">{{ $turma->NomeTurma }}</td>
                            <td class="px-6 py-4 text-center text-sm font-medium text-[#5c706b]">{{ $turma->AnoLetivo }}</td>
                            <td class="px-6 py-4 text-center text-sm">
                                <a href="{{ url('/coordenacao/relatorio_alunos_turmas/' . $turma->idTurmas) }}" class="inline-flex items-center justify-center p-2 rounded-xl text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Gerar Relatório Pais/WhatsApp">
                                    <i data-lucide="printer" class="w-5 h-5"></i>
                                </a>
                            </td>
                            <td class="px-6 py-4 text-center text-sm">
                                <a href="{{ url('/coordenacao/relatorio_alunos_turmas_endereco/' . $turma->idTurmas) }}" class="inline-flex items-center justify-center p-2 rounded-xl text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Gerar Relatório por Endereço">
                                    <i data-lucide="map-pin" class="w-5 h-5"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-sm text-[#5c706b]">
                                Nenhuma turma encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection