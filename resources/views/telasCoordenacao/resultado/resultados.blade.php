@extends('layouts.app')

@section('content')

@php
    // Busca paginada das turmas cadastradas
    try {
        $turmas = \DB::table('tb_turmas')
            ->orderBy('NomeTurma')
            ->paginate(15);
    } catch (\Exception $e) {
        $turmas = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
    }
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Relatórios</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Resultados</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Resultados Acadêmicos</h1>
            <p class="text-sm text-[#5c706b]">Turmas Cadastradas: ({{ $turmas->total() }})</p>
        </div>
    </div>

    <!-- Filtros de Busca e Seleção por Situação -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Localizar Turma -->
        <div class="w-full sm:w-80">
            <form method="POST" action="{{ url('/coordenacao/resultados_pesq') }}" class="w-full">
                @csrf
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                    <input type="text" name="pesquisar" placeholder="Pesquisar Turma" class="w-full bg-transparent text-sm focus:outline-none">
                    <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu Dropdown de Filtro Customizado -->
        <div class="w-full sm:w-64">
            <form method="POST" action="{{ url('/coordenacao/resultados_filtro') }}" class="w-full">
                @csrf
                <div class="relative" id="dropdown-container-sit-resultados">
                    <input type="hidden" id="SituacaoTurma" name="SituacaoTurma" value="{{ request()->input('SituacaoTurma', '') }}">

                    @php
                        $valSitRes = request()->input('SituacaoTurma', '');
                        $sitResLabel = $valSitRes ? ucfirst(strtolower($valSitRes)) : 'Filtrar por Situação';
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-sit-resultados', 'chevron-sit-resultados')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-sit-resultados" class="text-sm font-medium truncate {{ $valSitRes ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            {{ $sitResLabel }}
                        </span>
                        <div id="chevron-sit-resultados" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-sit-resultados" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                        <div onclick="selectSingleOption('', 'Todos', 'SituacaoTurma', 'label-sit-resultados', 'dropdown-menu-sit-resultados', 'chevron-sit-resultados', true)"
                             class="option-sit-resultados flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">Todos</span>
                        </div>
                        <div onclick="selectSingleOption('ATIVO', 'Ativo', 'SituacaoTurma', 'label-sit-resultados', 'dropdown-menu-sit-resultados', 'chevron-sit-resultados', true)"
                             class="option-sit-resultados flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">Ativo</span>
                        </div>
                        <div onclick="selectSingleOption('INATIVO', 'Inativo', 'SituacaoTurma', 'label-sit-resultados', 'dropdown-menu-sit-resultados', 'chevron-sit-resultados', true)"
                             class="option-sit-resultados flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">Inativo</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Turmas e Impressão de Resultados -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">CÓD</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome Turma</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Rec. Parcial</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Rec. Final</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Apro./ 1º Sem.</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Apro./ 2º Sem.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    <!-- Recebendo valores na vareavel escolas e passando para escola-->
                    @forelse($turmas as $turma)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $turma->idTurmas }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $turma->NomeTurma }}</td>

                            <!-- Resultado Parcial -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_parcial/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Imprimir Resultado Parcial">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Resultado Final -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_final/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Imprimir Resultado Final">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Aprovados 1º Semestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_aprovados_1semestre/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Imprimir Aprovados 1º Semestre">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Aprovados 2º Semestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_aprovados_2semestre/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Imprimir Aprovados 2º Semestre">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <!-- Estado sem registros -->
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="award" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhuma turma encontrada</p>
                                    <p class="text-xs text-[#5c706b]">Cadastre turmas para visualizar os relatórios de resultados</p>
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

</div> <!--Fim do caminho-din-->

@endsection