@extends('layouts.app')

@section('content')
@php
    $disciplinasDoProfessor = $disciplinasDoProfessor ?? collect();
    $professores = $professores ?? collect();
    $turmas = $turmas ?? collect();
@endphp
<div class="flex flex-col gap-6">
    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Lotação de Professor</span>
    </div>

    <!-- Cabeçalho -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Lotação de Professor</h1>
            <p class="text-sm text-[#5c706b]">Vínculos cadastrados: ({{ isset($disciplinasDoProfessor) ? count($disciplinasDoProfessor) : 0 }})</p>
        </div>
        <a href="{{ url('/coordenacao/turma_disc/turma_disciplina_cad') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Cadastrar Lotação</span>
        </a>
    </div>

    <!-- Filtros -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Filtrar por Professor -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                @if(request()->input('idTurmas'))
                    <input type="hidden" name="idTurmas" value="{{ request()->input('idTurmas') }}">
                @endif
                <div class="relative" id="dropdown-container-professor">
                    <input type="hidden" id="idFuncionarios" name="idFuncionarios" value="{{ request()->input('idFuncionarios', '') }}">

                    @php
                        $selectedProf = $professores->firstWhere('idFuncionarios', request()->input('idFuncionarios'));
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-professor', 'chevron-professor')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-professor" class="text-sm font-medium truncate {{ $selectedProf ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            {{ $selectedProf ? $selectedProf->NomeFuncionario : 'Filtrar por Professor' }}
                        </span>
                        <div id="chevron-professor" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-professor" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                        <!-- Campo de Busca -->
                        <div class="relative shrink-0">
                            <input type="text" onkeyup="filterDropdownOptions('search-professor', 'option-professor')" id="search-professor" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        <!-- Lista de Opções com Rolagem -->
                        <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                            <div onclick="selectSingleOption('', 'Todos os Professores', 'idFuncionarios', 'label-professor', 'dropdown-menu-professor', 'chevron-professor', true)"
                                 class="option-professor flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">Todos os Professores</span>
                            </div>
                            @foreach($professores as $prof)
                                <div onclick="selectSingleOption('{{ $prof->idFuncionarios }}', '{{ $prof->NomeFuncionario }}', 'idFuncionarios', 'label-professor', 'dropdown-menu-professor', 'chevron-professor', true)"
                                     class="option-professor flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $prof->NomeFuncionario }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Filtrar por Turma -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                @if(request()->input('idFuncionarios'))
                    <input type="hidden" name="idFuncionarios" value="{{ request()->input('idFuncionarios') }}">
                @endif
                <div class="relative" id="dropdown-container-turma">
                    <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                    @php
                        $selectedTurma = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-turma', 'chevron-turma')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-turma" class="text-sm font-medium truncate {{ $selectedTurma ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            {{ $selectedTurma ? $selectedTurma->NomeTurma : 'Filtrar por Turma' }}
                        </span>
                        <div id="chevron-turma" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-turma" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                        <!-- Campo de Busca -->
                        <div class="relative shrink-0">
                            <input type="text" onkeyup="filterDropdownOptions('search-turma', 'option-turma')" id="search-turma" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        <!-- Lista de Opções com Rolagem -->
                        <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                            <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma', 'dropdown-menu-turma', 'chevron-turma', true)"
                                 class="option-turma flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">Todas as Turmas</span>
                            </div>
                            @foreach($turmas as $t)
                                <div onclick="selectSingleOption('{{ $t->idTurmas }}', '{{ $t->NomeTurma }}', 'idTurmas', 'label-turma', 'dropdown-menu-turma', 'chevron-turma', true)"
                                     class="option-turma flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $t->NomeTurma }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Limpar Filtros -->
        @if(request()->input('idFuncionarios') || request()->input('idTurmas'))
            <a href="{{ url()->current() }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors">
                Limpar filtros
            </a>
        @endif
    </div>

    <!-- Seção da Tabela -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6] w-10 h-10">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Disciplina</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Professor</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($disciplinasDoProfessor ?? [] as $vinculo)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ data_get($vinculo, 'NomeTurma', '-') }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">{{ data_get($vinculo, 'NomeDisciplina', '-') }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">{{ data_get($vinculo, 'NomeFuncionario', '-') }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <div class="flex justify-center gap-1.5">
                                    @php
                                        $editParams = http_build_query([
                                            'idTurmas' => data_get($vinculo, 'tb_turmas_idTurmas'),
                                            'idDisciplinas' => data_get($vinculo, 'tb_disciplinas_idDisciplinas'),
                                            'idFuncionarios' => data_get($vinculo, 'tb_funcionarios_idFuncionarios')
                                        ]);
                                    @endphp
                                    <a href="{{ url('/coordenacao/turma_disc/turma_disciplina_cad?' . $editParams) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Editar Lotação">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ url('/coordenacao/turma_disciplina/deletar/' . ($vinculo->idTurmas_Disciplinas ?? $vinculo->tb_turmas_idTurmas)) }}" onclick="return confirm('Deseja realmente remover este vínculo?');" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-red-600 hover:bg-red-50 transition-all group" title="Remover Vínculo">
                                        <i data-lucide="trash-2" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="alert-circle" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhum vínculo encontrado</p>
                                    <p class="text-xs text-[#5c706b]">Adicione uma nova Lotação para começar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    @if(isset($disciplinasDoProfessor) && method_exists($disciplinasDoProfessor, 'links'))
        <div class="flex justify-center mt-6">
            {{ $disciplinasDoProfessor->links() }}
        </div>
    @endif
</div>
@endsection
