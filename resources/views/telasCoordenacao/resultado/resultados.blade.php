@extends('layouts.app')

@section('content')

@php
    $turmas = $turmas ?? new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
    $currentSitRes = request()->input('SituacaoTurma', $SituacaoTurma ?? 'ATIVO');
    if (empty($currentSitRes)) {
        $currentSitRes = 'ATIVO';
    }
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Relatórios</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Resultados Acadêmicos</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Resultados Acadêmicos</h1>
            <p class="text-sm text-[#5c706b]">Turmas encontradas: ({{ $turmas->total() }})</p>
        </div>
    </div>

    <!-- Filtros de Busca e Seleção por Situação -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Localizar Turma -->
        <div class="w-full sm:w-80">
            <form method="GET" action="{{ url('/coordenacao/resultado/resultados') }}" class="w-full">
                @if(request()->input('SituacaoTurma'))
                    <input type="hidden" name="SituacaoTurma" value="{{ request()->input('SituacaoTurma') }}">
                @endif
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all focus-within:border-[#008a4b]">
                    <input type="text" name="pesquisar" placeholder="Pesquisar por nome da turma ou ano" value="{{ request()->input('pesquisar') }}" class="w-full bg-transparent text-sm focus:outline-none text-[#0a241e]">
                    <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu Dropdown de Filtro Customizado -->
        <div class="w-full sm:w-56">
            <form method="GET" action="{{ url('/coordenacao/resultado/resultados') }}" class="w-full">
                @if(request()->input('pesquisar'))
                    <input type="hidden" name="pesquisar" value="{{ request()->input('pesquisar') }}">
                @endif
                <div class="relative" id="dropdown-container-sit-resultados">
                    <input type="hidden" id="SituacaoTurma" name="SituacaoTurma" value="{{ $currentSitRes }}">

                    @php
                        $sitResMap = [
                            'ATIVO' => 'Ativo',
                            'INATIVO' => 'Inativo',
                            'TODOS' => 'Todos'
                        ];
                        $sitResLabel = $sitResMap[strtoupper($currentSitRes)] ?? 'Ativo';
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-sit-resultados', 'chevron-sit-resultados')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-sit-resultados" class="text-sm font-semibold truncate text-[#0a241e]">
                            Situação: {{ $sitResLabel }}
                        </span>
                        <div id="chevron-sit-resultados" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-sit-resultados" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                        <div onclick="selectSingleOption('ATIVO', 'Situação: Ativo', 'SituacaoTurma', 'label-sit-resultados', 'dropdown-menu-sit-resultados', 'chevron-sit-resultados', true)"
                             class="option-sit-resultados flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                            <span>Ativo</span>
                        </div>
                        <div onclick="selectSingleOption('INATIVO', 'Situação: Inativo', 'SituacaoTurma', 'label-sit-resultados', 'dropdown-menu-sit-resultados', 'chevron-sit-resultados', true)"
                             class="option-sit-resultados flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                            <span>Inativo</span>
                        </div>
                        <div onclick="selectSingleOption('TODOS', 'Situação: Todos', 'SituacaoTurma', 'label-sit-resultados', 'dropdown-menu-sit-resultados', 'chevron-sit-resultados', true)"
                             class="option-sit-resultados flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                            <span>Todos</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(request()->input('pesquisar') || (request()->input('SituacaoTurma') && request()->input('SituacaoTurma') !== 'ATIVO'))
            <a href="{{ url('/coordenacao/resultado/resultados') }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors whitespace-nowrap">
                Limpar filtros
            </a>
        @endif
    </div>

    <!-- Tabela de Turmas e Impressão de Resultados -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">CÓD</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome da Turma</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Situação</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Rec. Parcial</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Rec. Final</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Apro. 1º Sem</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Apro. 2º Sem</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($turmas as $turma)
                        @php
                            $isTurmaAtivaRes = in_array(strtoupper($turma->SituacaoTurma ?? ''), ['ATIVO', 'ATIVA']);
                        @endphp
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-mono text-[#5c706b]">{{ $turma->idTurmas }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">
                                {{ $turma->NomeTurma }}
                                @if(!empty($turma->AnoLetivo))
                                    <span class="text-xs font-normal text-[#5c706b] ml-1">({{ $turma->AnoLetivo }})</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if($isTurmaAtivaRes)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#ecfdf5] text-[#008a4b]">Ativo</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600">Inativo</span>
                                @endif
                            </td>

                            <!-- Resultado Parcial -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_parcial/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir Resultado Parcial">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> Parcial
                                </a>
                            </td>

                            <!-- Resultado Final -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_final/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir Resultado Final">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> Final
                                </a>
                            </td>

                            <!-- Aprovados 1º Semestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_aprovados_1semestre/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir Aprovados 1º Semestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 1º Sem.
                                </a>
                            </td>

                            <!-- Aprovados 2º Semestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_aprovados_2semestre/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir Aprovados 2º Semestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 2º Sem.
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="award" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhuma turma encontrada</p>
                                    <p class="text-xs text-[#5c706b]">Ajuste os filtros de busca ou cadastre novas turmas</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    @if($turmas->hasPages())
        <div class="flex justify-center mt-2">
            {{ $turmas->links() }}
        </div>
    @endif

</div>

@endsection