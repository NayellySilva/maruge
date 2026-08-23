@extends('layouts.app')

@section('content')

@php
    // Busca inicial de alunos com paginação e associação da turma
    try {
        $Alunos = \DB::table('tb_alunos')
            ->leftJoin('tb_turmas', 'tb_alunos.tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
            ->select('tb_alunos.*', 'tb_turmas.NomeTurma')
            ->orderBy('NomeAluno')
            ->paginate(15);
    } catch (\Exception $e) {
        $Alunos = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
    }

    // Listagem de turmas para o filtro
    try {
        $turmas = \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) {
        $turmas = collect();
    }
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Lançar Notas</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Lançamento de Notas</h1>
            <p class="text-sm text-[#5c706b]">Alunos cadastrados: ({{ $Alunos->total() }})</p>
        </div>
    </div>

    <!-- Filtros de Busca e Turma -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa por Nome ou RA do Aluno -->
        <div class="w-full sm:w-80">
            <form method="POST" action="{{ url('/coordenacao/notas_pesq') }}" class="w-full">
                @csrf
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                    <input type="text" name="pesquisar" placeholder="Pesquisar Aluno" class="w-full bg-transparent text-sm focus:outline-none">
                    <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu Dropdown de Filtro Customizado -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                <div class="relative" id="dropdown-container-turma-notas">
                    <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                    @php
                        $selectedTurmaNotas = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-turma-notas', 'chevron-turma-notas')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-turma-notas" class="text-sm font-medium truncate {{ $selectedTurmaNotas ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            {{ $selectedTurmaNotas ? $selectedTurmaNotas->NomeTurma : 'Filtrar por Turma' }}
                        </span>
                        <div id="chevron-turma-notas" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-turma-notas" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                        <!-- Campo de Busca -->
                        <div class="relative shrink-[#0]">
                            <input type="text" onkeyup="filterDropdownOptions('search-turma-notas', 'option-turma-notas')" id="search-turma-notas" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        <!-- Lista de Opções com Rolagem -->
                        <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                            <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma-notas', 'dropdown-menu-turma-notas', 'chevron-turma-notas', true)"
                                 class="option-turma-notas flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">Todas as Turmas</span>
                            </div>
                            @foreach($turmas as $t)
                                <div onclick="selectSingleOption('{{ $t->idTurmas }}', '{{ $t->NomeTurma }}', 'idTurmas', 'label-turma-notas', 'dropdown-menu-turma-notas', 'chevron-turma-notas', true)"
                                     class="option-turma-notas flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $t->NomeTurma }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Alunos com colunas individuais por Bimestre e Recuperação -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome do Aluno</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">RA</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">1º Bim.</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">2º Bim.</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">3º Bim.</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">4º Bim.</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Rec.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    <!-- Laço exibindo os alunos -->
                    @forelse($Alunos as $Aluno)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $Aluno->NomeAluno }}</td>
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $Aluno->RA }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">{{ $Aluno->NomeTurma ?? '-' }}</td>

                            <!-- Coluna 1º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/lancamentos_notas_1bim/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Lançar 1º Bimestre">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Coluna 2º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/lancamentos_notas_2bim/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Lançar 2º Bimestre">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Coluna 3º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/lancamentos_notas_3bim/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Lançar 3º Bimestre">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Coluna 4º Bimestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/lancamentos_notas_4bim/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Lançar 4º Bimestre">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Coluna Recuperação -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/lancamentos_notas_rec/' . $Aluno->idAluno) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-red-600 hover:bg-red-50 transition-all"
                                   title="Lançar Recuperação">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <!-- Estado sem registros -->
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="book-open" class="w-8 h-8"></i>
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