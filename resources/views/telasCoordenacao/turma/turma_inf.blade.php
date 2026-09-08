@extends('layouts.app')

@section('content')
@php
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
        <span class="font-semibold text-[#0a241e]">Turmas</span>
    </div>
    <!-- Cabeçalho -->
    <div class="flex justify-between items-center">
        
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Turmas</h1>
            <p class="text-sm text-[#5c706b]">Turmas cadastradas: ({{ isset($turmas) ? (method_exists($turmas, 'total') ? $turmas->total() : count($turmas)) : 0 }})</p>
        </div>
        <a href="{{ url('/coordenacao/turma/turma_cad') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Cadastrar Turma</span>
        </a>
        
    </div>

    <!-- Filtros -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa -->
        <div class="w-full sm:w-80">
            <form method="post" action="{{ url('/coordenacao/turma_pesq') }}" class="w-full">
                {!! csrf_field() !!}
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
            <form method="post" action="{{ url('/coordenacao/turma_filtro') }}" class="w-full">
                {!! csrf_field() !!}

                <div class="relative" id="dropdown-container-situacao">
                    <!-- Input Oculto para submissão do formulário -->
                    <input type="hidden" id="SituacaoTurma" name="SituacaoTurma" value="{{ request()->input('SituacaoTurma', '') }}">

                    <!-- Trigger Box no Estilo Visual Premium -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-situacao', 'chevron-situacao')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-situacao" class="text-sm font-medium truncate {{ request()->input('SituacaoTurma') ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            @if(request()->input('SituacaoTurma') == 'ATIVO')
                                Ativo
                            @elseif(request()->input('SituacaoTurma') == 'INATIVO')
                                Inativo
                            @else
                                Filtrar por Situação
                            @endif
                        </span>
                        <div id="chevron-situacao" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante no Estilo Visual Premium -->
                    <div id="dropdown-menu-situacao" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                        <div onclick="selectSingleOption('', 'Todos', 'SituacaoTurma', 'label-situacao', 'dropdown-menu-situacao', 'chevron-situacao', true)"
                             class="option-situacao flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">Todos</span>
                        </div>
                        <div onclick="selectSingleOption('ATIVO', 'Ativo', 'SituacaoTurma', 'label-situacao', 'dropdown-menu-situacao', 'chevron-situacao', true)"
                             class="option-situacao flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">Ativo</span>
                        </div>
                        <div onclick="selectSingleOption('INATIVO', 'Inativo', 'SituacaoTurma', 'label-situacao', 'dropdown-menu-situacao', 'chevron-situacao', true)"
                             class="option-situacao flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">Inativo</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Seção da Tabela -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6] w-10 h-10">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Cód</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome Turma</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Mensalidade</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ano</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Situação</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($turmas ?? [] as $turma)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $turma->idTurmas }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $turma->NomeTurma }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e] text-center">R$: {{ number_format((float)($turma->Mensalidade ?? 0), 2, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e] text-center">{{ $turma->AnoLetivo }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if($turma->SituacaoTurma == 'ATIVO')
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#ecfdf5] text-[#008a4b]">
                                        <i data-lucide="check" class="w-3.5 h-3.5 stroke-[3px]"></i>
                                        <span>Ativo</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-500">
                                        <i data-lucide="minus" class="w-3.5 h-3.5 stroke-[3px]"></i>
                                        <span>Inativo</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <div class="flex justify-center gap-1.5">
                                    <a href="{{ url("/coordenacao/turma_editar/$turma->idTurmas") }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Editar Turma">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ url("/coordenacao/turma_deletar/$turma->idTurmas") }}" onclick="return confirm('Deseja realmente excluir esta turma?');" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-red-600 hover:bg-red-50 transition-all" title="Excluir Turma">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-[#5c706b]">
                                <div class="flex flex-col items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-8 h-8 text-[#95aba5]"></i>
                                    <span>Nenhuma turma cadastrada!</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Seção de Paginação -->
    @if(isset($turmas) && method_exists($turmas, 'links'))
        <div class="mt-4">
            {!! $turmas->links() !!}
        </div>
    @endif
</div>
@endsection