@extends('layouts.app')

@section('content')

@php
    $turmas = $turmas ?? new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
    $currentSit = request()->input('SituacaoTurma', $SituacaoTurma ?? 'ATIVO');
    if (empty($currentSit)) {
        $currentSit = 'ATIVO';
    }
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Relatórios</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Mapas de Notas</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-semibold text-[#0a241e]">Mapas de Notas por Turma</h1>
            <p class="text-sm text-[#5c706b]">Turmas encontradas: ({{ $turmas->total() }})</p>
        </div>
    </div>

    <!-- Filtros de Pesquisa e Seleção de Turma -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Campo de Pesquisa -->
        <div class="w-full sm:w-80">
            <form method="GET" action="{{ url('/coordenacao/mapas_notas') }}" class="w-full">
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

        <!-- Menu Dropdown de Filtro por Situação -->
        <div class="w-full sm:w-56">
            <form method="GET" action="{{ url('/coordenacao/mapas_notas') }}" class="w-full">
                @if(request()->input('pesquisar'))
                    <input type="hidden" name="pesquisar" value="{{ request()->input('pesquisar') }}">
                @endif
                <div class="relative" id="dropdown-container-sit-mapas">
                    <input type="hidden" id="SituacaoTurma" name="SituacaoTurma" value="{{ $currentSit }}">

                    @php
                        $sitMapasMap = [
                            'ATIVO' => 'Ativo',
                            'INATIVO' => 'Inativo',
                            'TODOS' => 'Todos'
                        ];
                        $sitMapasLabel = $sitMapasMap[strtoupper($currentSit)] ?? 'Ativo';
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-sit-mapas', 'chevron-sit-mapas')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-sit-mapas" class="text-sm font-semibold truncate text-[#0a241e]">
                            Situação: {{ $sitMapasLabel }}
                        </span>
                        <div id="chevron-sit-mapas" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-sit-mapas" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                        <div onclick="selectSingleOption('ATIVO', 'Situação: Ativo', 'SituacaoTurma', 'label-sit-mapas', 'dropdown-menu-sit-mapas', 'chevron-sit-mapas', true)"
                             class="option-sit-mapas flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                            <span>Ativo</span>
                        </div>
                        <div onclick="selectSingleOption('INATIVO', 'Situação: Inativo', 'SituacaoTurma', 'label-sit-mapas', 'dropdown-menu-sit-mapas', 'chevron-sit-mapas', true)"
                             class="option-sit-mapas flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                            <span>Inativo</span>
                        </div>
                        <div onclick="selectSingleOption('TODOS', 'Situação: Todos', 'SituacaoTurma', 'label-sit-mapas', 'dropdown-menu-sit-mapas', 'chevron-sit-mapas', true)"
                             class="option-sit-mapas flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                            <span>Todos</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(request()->input('pesquisar') || (request()->input('SituacaoTurma') && request()->input('SituacaoTurma') !== 'ATIVO'))
            <a href="{{ url('/coordenacao/mapas_notas') }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors whitespace-nowrap">
                Limpar filtros
            </a>
        @endif
    </div>

    <!-- Tabela de Turmas e Impressão de Mapas de Notas -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">CÓD</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome da Turma</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Situação</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">1º BIM</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">2º BIM</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">3º BIM</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">4º BIM</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">GLOBAL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($turmas as $turma)
                        @php
                            $isTurmaAtiva = in_array(strtoupper($turma->SituacaoTurma ?? ''), ['ATIVO', 'ATIVA']);
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
                                @if($isTurmaAtiva)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#ecfdf5] text-[#008a4b]">Ativo</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600">Inativo</span>
                                @endif
                            </td>

                            <!-- Mapa 1º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/mapa_1bim/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir Mapa 1º Bimestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 1º Bim
                                </a>
                            </td>

                            <!-- Mapa 2º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/mapa_2bim/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir Mapa 2º Bimestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 2º Bim
                                </a>
                            </td>

                            <!-- Mapa 3º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/mapa_3bim/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir Mapa 3º Bimestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 3º Bim
                                </a>
                            </td>

                            <!-- Mapa 4º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/mapa_4bim/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir Mapa 4º Bimestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 4º Bim
                                </a>
                            </td>

                            <!-- Mapa Global -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/mapa_global/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#e6f4ed] hover:bg-[#00703c] hover:text-white transition-all border border-[#008a4b]/30 font-semibold"
                                   title="Imprimir Mapa Global">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> Global
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="map" class="w-8 h-8"></i>
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