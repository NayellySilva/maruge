@extends('layouts.app')

@section('content')

@php
    if (!isset($escolas)) {
        try { $escolas = \App\Models\modelCoordenacao\tb_escola::informacaoEscolar(); } catch (\Exception $e) { $escolas = collect(); }
    }
    if (!isset($Alunos) && !isset($alunos)) {
        try {
            $Alunos = \App\Models\modelCoordenacao\tb_reserva::prematriculados();
        } catch (\Exception $e) { $Alunos = collect(); }
    }
    $listaAlunos = $Alunos ?? $alunos ?? [];
    if (!isset($turmas)) {
        try { $turmas = \DB::table('tb_turmas')->orderBy('NomeTurma')->get(); } catch (\Exception $e) { $turmas = collect(); }
    }
@endphp

<!-- Estilos para Caixa de Diálogo de Impressão -->
<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 10mm;
        }
        body * {
            visibility: hidden !important;
        }
        #printable-report-area, #printable-report-area * {
            visibility: visible !important;
        }
        #printable-report-area {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            background: white !important;
            color: black !important;
        }
        .print-hidden {
            display: none !important;
        }
    }
</style>

<div class="flex flex-col gap-6 print-hidden">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Relatórios</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Alunos Pré-Matriculados</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Lista de Alunos Pré-Matriculados</h1>
            <p class="text-sm text-[#5c706b]">Total de alunos: <strong>{{ count($listaAlunos) }}</strong></p>
        </div>
        <button onclick="window.print()" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer whitespace-nowrap">
            <i data-lucide="printer" class="w-5 h-5"></i>
            <span>Imprimir Relatório</span>
        </button>
    </div>

    <!-- Filtros de Busca e Seleção por Turma -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa por Aluno -->
        <div class="w-full sm:w-80">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                    <input type="text" name="pesquisar" placeholder="Pesquisar Aluno" value="{{ request()->input('pesquisar') }}" class="w-full bg-transparent text-sm focus:outline-none text-[#0a241e]">
                    <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu Dropdown de Filtro Customizado -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                <div class="relative" id="dropdown-container-turma-relatorio-pre">
                    <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                    @php
                        $selectedTurmaPre = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-turma-relatorio-pre', 'chevron-turma-relatorio-pre')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-turma-relatorio-pre" class="text-sm font-medium truncate {{ $selectedTurmaPre ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            {{ $selectedTurmaPre ? $selectedTurmaPre->NomeTurma : 'Filtrar por Turma' }}
                        </span>
                        <div id="chevron-turma-relatorio-pre" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-turma-relatorio-pre" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                        <!-- Campo de Busca -->
                        <div class="relative shrink-0">
                            <input type="text" onkeyup="filterDropdownOptions('search-turma-relatorio-pre', 'option-turma-relatorio-pre')" id="search-turma-relatorio-pre" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        <!-- Lista de Opções com Rolagem -->
                        <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                            <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma-relatorio-pre', 'dropdown-menu-turma-relatorio-pre', 'chevron-turma-relatorio-pre', true)"
                                 class="option-turma-relatorio-pre flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">Todas as Turmas</span>
                            </div>
                            @foreach($turmas as $t)
                                <div onclick="selectSingleOption('{{ $t->idTurmas }}', '{{ $t->NomeTurma }}', 'idTurmas', 'label-turma-relatorio-pre', 'dropdown-menu-turma-relatorio-pre', 'chevron-turma-relatorio-pre', true)"
                                     class="option-turma-relatorio-pre flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $t->NomeTurma }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(request()->input('pesquisar') || request()->input('idTurmas'))
            <a href="{{ url()->current() }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors whitespace-nowrap">
                Limpar filtros
            </a>
        @endif
    </div>

    <!-- Tabela de Alunos Pré-Matriculados Web -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nº</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">RA / CÓD</th>
                        <th class="px-4 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome Aluno</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Data Reserva</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma Pretendida</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Situação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($listaAlunos as $index => $aluno)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-4 py-3 text-center text-sm text-[#5c706b] font-mono">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-[#5c706b] font-mono">{{ $aluno->RA ?? '#' . ($aluno->idReservas ?? $aluno->idAluno) }}</td>
                            <td class="px-4 py-3 text-sm font-semibold text-[#0a241e]">{{ $aluno->NomeAluno }}</td>
                            <td class="px-4 py-3 text-center text-sm text-[#5c706b]">{{ $aluno->data_reserva ? date('d/m/Y', strtotime($aluno->data_reserva)) : '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm text-[#0a241e] font-medium">{{ $aluno->NomeTurma ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-sm">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                                    Pré-Matriculado
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-sm text-[#5c706b]">
                                Nenhum aluno pré-matriculado encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Área de Impressão Exclusiva (Formatada no modelo de referência) -->
<div id="printable-report-area" class="hidden print:block">
    <!-- Moldura de Cabeçalho da Escola com Borda Dupla -->
    <div style="border: 3px double #333; padding: 15px 20px; text-align: center; margin-bottom: 20px; width: 92%; margin-left: auto; margin-right: auto; box-sizing: border-box;">
        <img src="{{ asset('imgs/logoempresa_transparente.png') }}" width="130" style="display: block; margin: 0 auto 10px auto;">
        @forelse($escolas as $escola)
            <div style="font-weight: bold; font-size: 13px; text-transform: uppercase; line-height: 1.4; color: #111;">
                {{ $escola->Rua }} , {{ $escola->Numero }}<br>
                {{ $escola->Bairro }} - CEP:{{ $escola->CEP }}<br>
                {{ $escola->Cidade }} - {{ $escola->Estado }}<br>
                Tel: {{ $escola->Fone1 }} / {{ $escola->Fone2 }}<br>
                E-mail:{{ $escola->EmailColegio }}<br>
                CNPJ: {{ $escola->CNPJ }}<br>
                INEP:{{ $escola->NumeroInep }}
            </div>
        @empty
            <div style="font-weight: bold; font-size: 14px;">COLÉGIO MARUGE</div>
        @endforelse
    </div>

    <!-- Título do Relatório Impresso -->
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="font-size: 18px; font-weight: 800; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; color: #000;">
            LISTA DE ALUNOS PRÉ-MATRICULADOS / RESERVAS
        </h2>
        <p style="font-size: 14px; font-weight: bold; margin: 4px 0 0 0; color: #222;">
            Total de alunos: {{ count($listaAlunos) }}
        </p>
    </div>

    <!-- Tabela Impressa -->
    <table style="width: 100%; border-collapse: collapse; font-size: 9.5px; font-family: Arial, sans-serif;">
        <thead>
            <tr style="border-bottom: 2px solid #000;">
                <th style="padding: 6px 3px; text-align: center; font-weight: bold; width: 4%;">Nº</th>
                <th style="padding: 6px 4px; text-align: left; font-weight: bold; width: 12%;">RA / CÓD</th>
                <th style="padding: 6px 4px; text-align: left; font-weight: bold; width: 30%;">NOME DO ALUNO</th>
                <th style="padding: 6px 4px; text-align: center; font-weight: bold; width: 14%;">DATA RESERVA</th>
                <th style="padding: 6px 4px; text-align: center; font-weight: bold; width: 25%;">TURMA PRETENDIDA</th>
                <th style="padding: 6px 4px; text-align: center; font-weight: bold; width: 15%;">SITUAÇÃO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listaAlunos as $index => $aluno)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 5px 3px; text-align: center;">{{ $index + 1 }}</td>
                    <td style="padding: 5px 4px; font-family: monospace;">{{ $aluno->RA ?? '#' . ($aluno->idReservas ?? $aluno->idAluno) }}</td>
                    <td style="padding: 5px 4px; font-weight: bold; text-transform: uppercase;">{{ $aluno->NomeAluno }}</td>
                    <td style="padding: 5px 4px; text-align: center;">{{ $aluno->data_reserva ? date('d/m/Y', strtotime($aluno->data_reserva)) : '-' }}</td>
                    <td style="padding: 5px 4px; text-align: center; font-weight: bold;">{{ $aluno->NomeTurma ?? '-' }}</td>
                    <td style="padding: 5px 4px; text-align: center;">PRÉ-MATRICULADO</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection