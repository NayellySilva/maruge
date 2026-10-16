@extends('layouts.app')

@section('content')

@php
    $Alunos = $Alunos ?? new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);

    // Listagem de turmas para o filtro (apenas ativas)
    if (!isset($turmas) || $turmas->isEmpty()) {
        try {
            $turmas = \App\Models\modelCoordenacao\tb_turma::turmasAtivas();
        } catch (\Exception $e) {
            $turmas = collect();
        }
    }
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Relatórios</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Relatórios Bimestrais</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Relatórios Bimestrais</h1>
            <p class="text-sm text-[#5c706b]">Alunos encontrados: ({{ $Alunos->total() }})</p>
        </div>
    </div>

    <!-- Filtros de Busca e Seleção de Turma -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa por Aluno -->
        <div class="w-full sm:w-80">
            <form method="GET" action="{{ url('/coordenacao/relatorios/relatorios_bimestrais') }}" class="w-full">
                @if(request()->input('idTurmas'))
                    <input type="hidden" name="idTurmas" value="{{ request()->input('idTurmas') }}">
                @endif
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all focus-within:border-[#008a4b]">
                    <input type="text" name="pesquisar" placeholder="Pesquisar por aluno, RA ou MAC" value="{{ request()->input('pesquisar') }}" class="w-full bg-transparent text-sm focus:outline-none text-[#0a241e]">
                    <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu Dropdown de Filtro Customizado -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url('/coordenacao/relatorios/relatorios_bimestrais') }}" class="w-full">
                @if(request()->input('pesquisar'))
                    <input type="hidden" name="pesquisar" value="{{ request()->input('pesquisar') }}">
                @endif
                <div class="relative" id="dropdown-container-turma-relatorios-bimestrais">
                    <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                    @php
                        $selectedTurmaBim = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-turma-relatorios-bimestrais', 'chevron-turma-relatorios-bimestrais')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-turma-relatorios-bimestrais" class="text-sm font-medium truncate {{ $selectedTurmaBim ? 'text-[#0a241e] font-semibold' : 'text-[#95aba5]' }}">
                            {{ $selectedTurmaBim ? $selectedTurmaBim->NomeTurma : 'Filtrar por Turma (Ativas)' }}
                        </span>
                        <div id="chevron-turma-relatorios-bimestrais" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-turma-relatorios-bimestrais" class="dropdown-menu-flutuante hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" >
                        <!-- Campo de Busca -->
                        <div class="relative shrink-0">
                            <input type="text" onkeyup="filterDropdownOptions('search-turma-relatorios-bimestrais', 'option-turma-relatorios-bimestrais')" id="search-turma-relatorios-bimestrais" placeholder="Pesquisar turma..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        <!-- Lista de Opções com Rolagem -->
                        <div class="dropdown-lista-opcoes custom-scroll flex flex-col gap-0.5 pr-1" >
                            <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma-relatorios-bimestrais', 'dropdown-menu-turma-relatorios-bimestrais', 'chevron-turma-relatorios-bimestrais', true)"
                                 class="option-turma-relatorios-bimestrais flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">Todas as Turmas Ativas</span>
                            </div>
                            @foreach($turmas as $t)
                                <div onclick="selectSingleOption('{{ $t->idTurmas }}', '{{ $t->NomeTurma }}', 'idTurmas', 'label-turma-relatorios-bimestrais', 'dropdown-menu-turma-relatorios-bimestrais', 'chevron-turma-relatorios-bimestrais', true)"
                                     class="option-turma-relatorios-bimestrais flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $t->NomeTurma }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(request()->input('pesquisar') || request()->input('idTurmas'))
            <a href="{{ url('/coordenacao/relatorios/relatorios_bimestrais') }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors whitespace-nowrap">
                Limpar filtros
            </a>
        @endif
    </div>

    <!-- Tabela de Alunos e Impressão de Relatórios Bimestrais -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome do Aluno</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nº MAC / RA</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">1º Bim.</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">2º Bim.</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">3º Bim.</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">4º Bim.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($Alunos as $Aluno)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $Aluno->NomeAluno }}</td>
                            <td class="px-6 py-4 text-sm font-mono text-[#5c706b]">{{ $Aluno->NumeroMac ?? $Aluno->RA ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#ecfdf5] text-[#008a4b]">
                                    {{ $Aluno->NomeTurma ?? '-' }}
                                </span>
                            </td>

                            <!-- Impressão 1º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/boletim_acompanhamento_1bim/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir 1º Bimestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 1º Bim
                                </a>
                            </td>

                            <!-- Impressão 2º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/boletim_acompanhamento_2bim/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir 2º Bimestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 2º Bim
                                </a>
                            </td>

                            <!-- Impressão 3º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/boletim_acompanhamento_3bim/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir 3º Bimestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 3º Bim
                                </a>
                            </td>

                            <!-- Impressão 4º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/boletim_acompanhamento_4bim/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-[#008a4b] bg-[#ecfdf5] hover:bg-[#008a4b] hover:text-white transition-all border border-[#008a4b]/20"
                                   title="Imprimir 4º Bimestre">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> 4º Bim
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="file-text" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhum aluno encontrado</p>
                                    <p class="text-xs text-[#5c706b]">Cadastre alunos ou ajuste os filtros de busca</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    @if($Alunos->hasPages())
        <div class="flex justify-center mt-2">
            {{ $Alunos->links() }}
        </div>
    @endif

</div>

@endsection