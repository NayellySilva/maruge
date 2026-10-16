@extends('layouts.app')

@section('content')
@php
    $currentSituacao = request()->input('situacao', $situacao ?? 'ATIVO');
    if (empty($currentSituacao)) {
        $currentSituacao = 'ATIVO';
    }
@endphp

<div class="flex flex-col gap-6">
    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Funcionários</span>
    </div>

    <!-- Cabeçalho -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Funcionários</h1>
            <p class="text-sm text-[#5c706b]">Funcionários encontrados: ({{ isset($Funcionarios) ? $Funcionarios->total() : 0 }})</p>
        </div>
        <a href="{{ url('/coordenacao/funcionarios/funcionario_cad') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Cadastrar Funcionário</span>
        </a>
    </div>

    <!-- Filtros -->
    <div class="flex flex-col sm:flex-row flex-wrap gap-4 items-center">
        <!-- Barra de Pesquisa -->
        <div class="w-full sm:w-80">
            <form method="GET" action="{{ url('/coordenacao/funcionario_inf') }}" class="w-full flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                @if(request()->input('situacao'))
                    <input type="hidden" name="situacao" value="{{ request()->input('situacao') }}">
                @endif
                <input type="text" name="pesquisar" placeholder="Pesquisar por nome, CPF ou função" value="{{ request()->input('pesquisar') }}" class="w-full bg-transparent text-sm focus:outline-none">
                <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
            </form>
        </div>

        <!-- Filtrar por Situação (Padrão: Ativos) -->
        <div class="w-full sm:w-56">
            <form method="GET" action="{{ url('/coordenacao/funcionario_inf') }}" class="w-full">
                @if(request()->input('pesquisar'))
                    <input type="hidden" name="pesquisar" value="{{ request()->input('pesquisar') }}">
                @endif
                <div class="relative" id="dropdown-container-situacao-funcionario">
                    <input type="hidden" id="situacao" name="situacao" value="{{ $currentSituacao }}">

                    @php
                        $labelSituacaoMap = [
                            'ATIVO' => 'Ativo',
                            'INATIVO' => 'Inativo',
                            'TODOS' => 'Todos'
                        ];
                        $labelSituacaoTexto = $labelSituacaoMap[strtoupper($currentSituacao)] ?? 'Ativo';
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-situacao-funcionario', 'chevron-situacao-funcionario')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-situacao-funcionario" class="text-sm font-semibold truncate text-[#0a241e]">
                            Situação: {{ $labelSituacaoTexto }}
                        </span>
                        <div id="chevron-situacao-funcionario" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-situacao-funcionario" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                        <div onclick="selectSingleOption('ATIVO', 'Situação: Ativo', 'situacao', 'label-situacao-funcionario', 'dropdown-menu-situacao-funcionario', 'chevron-situacao-funcionario', true)"
                             class="flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                            <span>Ativo (Padrão)</span>
                        </div>
                        <div onclick="selectSingleOption('INATIVO', 'Situação: Inativo', 'situacao', 'label-situacao-funcionario', 'dropdown-menu-situacao-funcionario', 'chevron-situacao-funcionario', true)"
                             class="flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                            <span>Inativo</span>
                        </div>
                        <div onclick="selectSingleOption('TODOS', 'Situação: Todos', 'situacao', 'label-situacao-funcionario', 'dropdown-menu-situacao-funcionario', 'chevron-situacao-funcionario', true)"
                             class="flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                            <span>Todos</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Limpar Filtros -->
        @if(request()->input('pesquisar') || (request()->input('situacao') && request()->input('situacao') !== 'ATIVO'))
            <a href="{{ url('/coordenacao/funcionario_inf') }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors whitespace-nowrap">
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
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Funcionário</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Fone 1</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Fone 2</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Função</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Situação</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($Funcionarios ?? [] as $Funcionario)
                        @php
                            $isSaiu = str_contains(strtoupper($Funcionario->NomeFuncionario), 'SAIU');
                            $isUserInativo = strtoupper($Funcionario->SituacaoUsuario ?? '') === 'INATIVO';
                            $isAtivo = strtoupper($Funcionario->SituacaoFuncionario ?? 'ATIVO') !== 'INATIVO' && !$isSaiu && !$isUserInativo;
                        @endphp
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $Funcionario->NomeFuncionario }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">{{ $Funcionario->Fone1 }}</td>
                            <td class="px-6 py-4 text-sm text-[#5c706b] text-center">{{ $Funcionario->Fone2 ?: '-' }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#f0fdf4] text-[#166534]">
                                    {{ $Funcionario->Funcao }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if($isAtivo)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#ecfdf5] text-[#008a4b]">Ativo</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600">Inativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <div class="flex justify-center gap-1.5">
                                    <a href="{{ url('/coordenacao/funcionario_perfil/' . $Funcionario->idFuncionarios) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Visualizar Funcionário">
                                        <i data-lucide="eye" class="w-4.5 h-4.5"></i>
                                    </a>
                                    <a href="{{ url('/coordenacao/funcionario_editar/' . $Funcionario->idFuncionarios) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Editar Funcionário">
                                        <i data-lucide="pencil" class="w-4.5 h-4.5"></i>
                                    </a>
                                    <a href="{{ url('/coordenacao/funcionario_deletar/' . $Funcionario->idFuncionarios) }}" onclick="return confirm('Deseja realmente excluir este funcionário?');" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-red-600 hover:bg-red-50 transition-all" title="Excluir Funcionário">
                                        <i data-lucide="trash-2" class="w-4.5 h-4.5"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="alert-circle" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhum funcionário cadastrado</p>
                                    <p class="text-xs text-[#5c706b]">Cadastre funcionários para começar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    @if(isset($Funcionarios) && method_exists($Funcionarios, 'links'))
        <div class="flex justify-center mt-6">
            {{ $Funcionarios->links() }}
        </div>
    @endif
</div>
@endsection