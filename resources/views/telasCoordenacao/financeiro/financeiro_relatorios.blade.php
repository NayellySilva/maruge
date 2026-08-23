@extends('layouts.app')

@section('content')

@php
    try {
        $turmas = $turmas ?? \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) {
        $turmas = collect();
    }
@endphp

<!-- Titulo e Endereco da Pagina -->
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Financeiro</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Relatórios</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Relatórios Financeiros</h1>
            <p class="text-sm text-[#5c706b]">Filtre pagamentos por turma, mês e situação de pagamento</p>
        </div>
    </div>

    <!-- Filtros por turma / mes / situação (Padrão do Sistema) -->
    <form method="POST" action="{{ url('/coordenacao/financeiro_pesq_relatorio') }}" class="flex flex-col sm:flex-row gap-4 items-center">
        @csrf

        <!-- Seleção de Turma -->
        <div class="w-full sm:w-56">
            <div class="relative" id="dropdown-container-turma-fin-rel">
                <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                @php
                    $selectedFinRelTurma = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                @endphp

                <!-- Trigger Box -->
                <div onclick="toggleMultiDropdown('dropdown-menu-turma-fin-rel', 'chevron-turma-fin-rel')" 
                     class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-turma-fin-rel" class="text-sm font-medium truncate {{ $selectedFinRelTurma ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $selectedFinRelTurma ? $selectedFinRelTurma->NomeTurma : 'Todas as Turmas' }}
                    </span>
                    <div id="chevron-turma-fin-rel" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Dropdown Flutuante -->
                <div id="dropdown-menu-turma-fin-rel" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                    <!-- Campo de Busca -->
                    <div class="relative shrink-0">
                        <input type="text" onkeyup="filterDropdownOptions('search-turma-fin-rel', 'option-turma-fin-rel')" id="search-turma-fin-rel" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    <!-- Lista de Opções com Rolagem -->
                    <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                        <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma-fin-rel', 'dropdown-menu-turma-fin-rel', 'chevron-turma-fin-rel', false)"
                             class="option-turma-fin-rel flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium text-[#95aba5]">Todas as Turmas</span>
                        </div>
                        @foreach($turmas as $turma)
                            <div onclick="selectSingleOption('{{ $turma->idTurmas }}', '{{ $turma->NomeTurma }}', 'idTurmas', 'label-turma-fin-rel', 'dropdown-menu-turma-fin-rel', 'chevron-turma-fin-rel', false)"
                                 class="option-turma-fin-rel flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">{{ $turma->NomeTurma }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Seleção de Mês -->
        <div class="w-full sm:w-48">
            <div class="relative" id="dropdown-container-mes-fin-rel">
                <input type="hidden" id="Meses" name="Meses" value="{{ request()->input('Meses', '') }}">
                @php
                    $valFinRelMes = request()->input('Meses', '');
                    $mesesArr = ['JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO'];
                @endphp

                <!-- Trigger Box -->
                <div onclick="toggleMultiDropdown('dropdown-menu-mes-fin-rel', 'chevron-mes-fin-rel')" 
                     class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-mes-fin-rel" class="text-sm font-medium truncate {{ $valFinRelMes ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valFinRelMes ?: 'Selecione o Mês' }}
                    </span>
                    <div id="chevron-mes-fin-rel" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Dropdown Flutuante -->
                <div id="dropdown-menu-mes-fin-rel" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                    <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                        <div onclick="selectSingleOption('', 'Selecione o Mês', 'Meses', 'label-mes-fin-rel', 'dropdown-menu-mes-fin-rel', 'chevron-mes-fin-rel', false)"
                             class="option-mes-fin-rel flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium text-[#95aba5]">Selecione o Mês</span>
                        </div>
                        @foreach($mesesArr as $mItem)
                            <div onclick="selectSingleOption('{{ $mItem }}', '{{ $mItem }}', 'Meses', 'label-mes-fin-rel', 'dropdown-menu-mes-fin-rel', 'chevron-mes-fin-rel', false)"
                                 class="option-mes-fin-rel flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">{{ $mItem }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Seleção de Situação -->
        <div class="w-full sm:w-48">
            <div class="relative" id="dropdown-container-sit-fin-rel">
                <input type="hidden" id="status_pagamento" name="status_pagamento" value="{{ request()->input('status_pagamento', '') }}">
                @php
                    $valFinRelSit = request()->input('status_pagamento', '');
                @endphp

                <!-- Trigger Box -->
                <div onclick="toggleMultiDropdown('dropdown-menu-sit-fin-rel', 'chevron-sit-fin-rel')" 
                     class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-sit-fin-rel" class="text-sm font-medium truncate {{ $valFinRelSit ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valFinRelSit ?: 'Todas as Situações' }}
                    </span>
                    <div id="chevron-sit-fin-rel" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Dropdown Flutuante -->
                <div id="dropdown-menu-sit-fin-rel" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('', 'Todas as Situações', 'status_pagamento', 'label-sit-fin-rel', 'dropdown-menu-sit-fin-rel', 'chevron-sit-fin-rel', false)"
                         class="option-sit-fin-rel flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium text-[#95aba5]">Todas as Situações</span>
                    </div>
                    @foreach(['PAGO', 'PARCIAL', 'ABERTO'] as $sItem)
                        <div onclick="selectSingleOption('{{ $sItem }}', '{{ $sItem }}', 'status_pagamento', 'label-sit-fin-rel', 'dropdown-menu-sit-fin-rel', 'chevron-sit-fin-rel', false)"
                             class="option-sit-fin-rel flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">{{ $sItem }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Botão Filtrar -->
        <div>
            <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white text-sm font-medium px-5 py-2.5 rounded-xl flex items-center justify-center gap-2 transition-all shadow-2xs">
                <i data-lucide="search" class="w-4 h-4"></i> Filtrar
            </button>
        </div>
    </form>
    <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->

    <!-- Cards de Relatórios PDF / Impressão Pronta -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="#btn-report" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-5 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                <i data-lucide="printer" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Contas a Receber</h3>
                <p class="text-xs text-[#5c706b]">Imprimir relatório geral de recebimentos</p>
            </div>
        </a>

        <a href="#btn-report" class="bg-white border border-[#e3e8e6] hover:border-red-500 rounded-2xl p-5 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                <i data-lucide="printer" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#0a241e] group-hover:text-red-600 transition-colors">Contas a Pagar</h3>
                <p class="text-xs text-[#5c706b]">Imprimir relatório de saídas e fornecedores</p>
            </div>
        </a>

        <a href="#btn-report" class="bg-white border border-[#e3e8e6] hover:border-amber-500 rounded-2xl p-5 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <i data-lucide="printer" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#0a241e] group-hover:text-amber-600 transition-colors">Contas Pendentes</h3>
                <p class="text-xs text-[#5c706b]">Imprimir títulos pendentes e em atraso</p>
            </div>
        </a>
    </div>

    <!-- Tabela de Registros Encontrados (Padrão do Sistema) -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Aluno / Responsável</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Mês</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Valor</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Situação</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                    <i data-lucide="file-spreadsheet" class="w-8 h-8"></i>
                                </div>
                                <p class="text-sm text-[#0a241e] font-medium">Selecione os filtros desejados</p>
                                <p class="text-xs text-[#5c706b]">Escolha uma turma, mês e situação para listar os registros financeiros</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>

</div> <!--Fim do caminho-din-->

@endsection
