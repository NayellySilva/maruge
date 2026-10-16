@extends('layouts.app')

@section('content')

@php
    // Filtros vindos da tela (GET ou POST)
    $pesquisar = trim((string) request()->input('pesquisar', ''));
    $idTurmaFiltro = request()->input('idTurmas');
    $somenteAtivos = true; // carnê: focado em alunos ativos

    try {
        $Alunos = \DB::table('tb_aluno')
            ->leftJoin('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
            ->leftJoin('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
            ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_aluno.NumeroMac', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
            ->when($somenteAtivos, fn ($q) => $q->whereIn('tb_matriculas.SituacaoAluno', ['ATIVO', 'MATRICULADO']))
            ->when($idTurmaFiltro, fn ($q) => $q->where('tb_aluno.tb_turmas_idTurmas', $idTurmaFiltro))
            ->when($pesquisar !== '', function ($q) use ($pesquisar) {
                $like = '%' . $pesquisar . '%';
                $q->where(function ($w) use ($like) {
                    $w->where('tb_aluno.NomeAluno', 'LIKE', $like)
                      ->orWhere('tb_matriculas.RA', 'LIKE', $like)
                      ->orWhere('tb_aluno.NumeroMac', 'LIKE', $like);
                });
            })
            ->orderBy('tb_aluno.NomeAluno')
            ->paginate(15)
            ->appends(request()->query());
    } catch (\Exception $e) {
        $Alunos = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
    }

    // Turmas ativas para o dropdown
    try {
        $turmas = \App\Models\modelCoordenacao\tb_turma::turmasAtivas();
    } catch (\Exception $e) {
        $turmas = collect();
    }
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Gerar Carnês</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Carnês de Mensalidades</h1>
            <p class="text-sm text-[#5c706b]">Selecione um aluno para configurar e gerar o carnê escolar ({{ $Alunos->total() }} alunos)</p>
        </div>
    </div>

    <!-- Filtros de Busca e Seleção de Turma -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa por Aluno -->
        <div class="w-full sm:w-80">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                @if(request()->filled('idTurmas'))
                    <input type="hidden" name="idTurmas" value="{{ request('idTurmas') }}">
                @endif
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                    <input type="text" name="pesquisar" value="{{ $pesquisar }}" placeholder="Pesquisar Aluno (nome ou RA)" class="w-full bg-transparent text-sm focus:outline-none">
                    <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu Dropdown de Seleção de Turma -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                @if($pesquisar !== '')
                    <input type="hidden" name="pesquisar" value="{{ $pesquisar }}">
                @endif
                <div class="relative" id="dropdown-container-turma-carne">
                    <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                    @php
                        $selectedTurma = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-turma-carne', 'chevron-turma-carne')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-turma-carne" class="text-sm font-medium truncate {{ $selectedTurma ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            {{ $selectedTurma ? $selectedTurma->NomeTurma : 'Filtrar por Turma' }}
                        </span>
                        <div id="chevron-turma-carne" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-turma-carne" class="dropdown-menu-flutuante hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden">
                        <!-- Campo de Busca -->
                        <div class="relative shrink-0">
                            <input type="text" onkeyup="filterDropdownOptions('search-turma-carne', 'option-turma-carne')" id="search-turma-carne" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        <!-- Lista de Opções -->
                        <div class="dropdown-lista-opcoes custom-scroll flex flex-col gap-0.5 pr-1">
                            <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma-carne', 'dropdown-menu-turma-carne', 'chevron-turma-carne', true)"
                                 class="option-turma-carne flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">Todas as Turmas</span>
                            </div>
                            @foreach($turmas as $turma)
                                <div onclick="selectSingleOption('{{ $turma->idTurmas }}', '{{ $turma->NomeTurma }}', 'idTurmas', 'label-turma-carne', 'dropdown-menu-turma-carne', 'chevron-turma-carne', true)"
                                     class="option-turma-carne flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $turma->NomeTurma }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Alunos -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome do Aluno</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">RA / MAC</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($Alunos as $Aluno)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $Aluno->NomeAluno }}</td>
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $Aluno->RA ?? ($Aluno->NumeroMac ?? '-') }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">{{ $Aluno->NomeTurma ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/criarcarne/' . $Aluno->idAluno) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium bg-[#008a4b] text-white hover:bg-[#00703c] transition-colors shadow-2xs">
                                    <i data-lucide="receipt" class="w-3.5 h-3.5"></i>
                                    Gerar Carnê
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="receipt" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhum aluno encontrado</p>
                                    <p class="text-xs text-[#5c706b]">Ajuste os filtros de busca ou verifique os alunos ativos</p>
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