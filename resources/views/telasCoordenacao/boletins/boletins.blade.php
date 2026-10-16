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
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Boletins</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Boletins Escolares</h1>
            <p class="text-sm text-[#5c706b]">Alunos encontrados: ({{ $Alunos->total() }})</p>
        </div>
    </div>

    <!-- Filtros de Busca e Turma -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa por Aluno -->
        <div class="w-full sm:w-80">
            <form method="GET" action="{{ url('/coordenacao/boletins/boletins') }}" class="w-full">
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
            <form method="GET" action="{{ url('/coordenacao/boletins/boletins') }}" class="w-full">
                @if(request()->input('pesquisar'))
                    <input type="hidden" name="pesquisar" value="{{ request()->input('pesquisar') }}">
                @endif
                <div class="relative" id="dropdown-container-turma-boletins">
                    <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                    @php
                        $selectedTurmaBol = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-turma-boletins', 'chevron-turma-boletins')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-turma-boletins" class="text-sm font-medium truncate {{ $selectedTurmaBol ? 'text-[#0a241e] font-semibold' : 'text-[#95aba5]' }}">
                            {{ $selectedTurmaBol ? $selectedTurmaBol->NomeTurma : 'Filtrar por Turma (Ativas)' }}
                        </span>
                        <div id="chevron-turma-boletins" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-turma-boletins" class="dropdown-menu-flutuante hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" >
                        <!-- Campo de Busca -->
                        <div class="relative shrink-0">
                            <input type="text" onkeyup="filterDropdownOptions('search-turma-boletins', 'option-turma-boletins')" id="search-turma-boletins" placeholder="Pesquisar turma..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        <!-- Lista de Opções com Rolagem -->
                        <div class="dropdown-lista-opcoes custom-scroll flex flex-col gap-0.5 pr-1" >
                            <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma-boletins', 'dropdown-menu-turma-boletins', 'chevron-turma-boletins', true)"
                                 class="option-turma-boletins flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">Todas as Turmas Ativas</span>
                            </div>
                            @foreach($turmas as $t)
                                <div onclick="selectSingleOption('{{ $t->idTurmas }}', '{{ $t->NomeTurma }}', 'idTurmas', 'label-turma-boletins', 'dropdown-menu-turma-boletins', 'chevron-turma-boletins', true)"
                                     class="option-turma-boletins flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $t->NomeTurma }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if(request()->input('pesquisar') || request()->input('idTurmas'))
            <a href="{{ url('/coordenacao/boletins/boletins') }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors whitespace-nowrap">
                Limpar filtros
            </a>
        @endif
    </div>

    <!-- Tabela de Alunos e Impressão de Boletim -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome do Aluno</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nº MAC / RA</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
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
                            <td class="px-6 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/boletim/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold bg-[#008a4b] text-white hover:bg-[#00703c] transition-all shadow-2xs"
                                   title="Imprimir Boletim Escolar">
                                    <i data-lucide="printer" class="w-4 h-4"></i> Emitir Boletim
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
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