@extends('layouts.app')

@section('content')
@php
    $currentSituacao = request()->input('situacao', $situacao ?? 'ATIVO');
    if (empty($currentSituacao)) {
        $currentSituacao = 'ATIVO';
    }
@endphp

<div class="space-y-6">

    <!-- Cabeçalho Principal -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-[#e3e8e6] shadow-2xs">
        <div>
            <h1 class="text-2xl font-bold text-[#0a241e]">Listagem de Usuários</h1>
            <p class="text-sm text-[#5c706b]">Gerencie os acessos e permissões dos usuários do sistema</p>
        </div>

        <a href="{{ url('/coordenacao/cadusuario') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Cadastrar Usuário</span>
        </a>
    </div>

    <!-- Barra de Filtros e Busca -->
    <div class="bg-white p-4 rounded-2xl border border-[#e3e8e6] shadow-2xs flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex flex-col sm:flex-row flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Pesquisa -->
            <form class="form-search pesquisar w-full sm:w-80 flex items-center gap-2" method="GET" action="{{ url('/coordenacao/usuario_inf') }}">
                @if(request()->input('situacao'))
                    <input type="hidden" name="situacao" value="{{ request()->input('situacao') }}">
                @endif
                <div class="relative w-full">
                    <input type="text" name="pesquisar" placeholder="Pesquisar por nome ou CPF..." class="w-full pl-10 pr-4 py-2.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-xl text-sm focus:outline-none focus:border-[#008a4b] transition-all" value="{{ request()->input('pesquisar') }}">
                    <i data-lucide="search" class="w-4 h-4 text-[#5c706b] absolute left-3 top-3"></i>
                </div>
                <button type="submit" class="bg-[#f8faf9] hover:bg-[#e3e8e6] border border-[#e3e8e6] text-[#0a241e] font-medium px-4 py-2.5 rounded-xl text-sm transition-all cursor-pointer">
                    Buscar
                </button>
            </form>

            <!-- Filtrar por Situação (Padrão: Ativos) -->
            <div class="w-full sm:w-56">
                <form method="GET" action="{{ url('/coordenacao/usuario_inf') }}" class="w-full">
                    @if(request()->input('pesquisar'))
                        <input type="hidden" name="pesquisar" value="{{ request()->input('pesquisar') }}">
                    @endif
                    <div class="relative" id="dropdown-container-situacao-usuario">
                        <input type="hidden" id="situacao-usuario" name="situacao" value="{{ $currentSituacao }}">

                        @php
                            $labelSituacaoMap = [
                                'ATIVO' => 'Ativo',
                                'INATIVO' => 'Inativo',
                                'TODOS' => 'Todos'
                            ];
                            $labelSituacaoTexto = $labelSituacaoMap[strtoupper($currentSituacao)] ?? 'Ativo';
                        @endphp

                        <!-- Trigger Box -->
                        <div onclick="toggleMultiDropdown('dropdown-menu-situacao-usuario', 'chevron-situacao-usuario')" 
                             class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                            <span id="label-situacao-usuario" class="text-sm font-semibold truncate text-[#0a241e]">
                                Situação: {{ $labelSituacaoTexto }}
                            </span>
                            <div id="chevron-situacao-usuario" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>

                        <!-- Dropdown Flutuante -->
                        <div id="dropdown-menu-situacao-usuario" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                            <div onclick="selectSingleOption('ATIVO', 'Situação: Ativo', 'situacao-usuario', 'label-situacao-usuario', 'dropdown-menu-situacao-usuario', 'chevron-situacao-usuario', true)"
                                 class="flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                                <span>Ativo (Padrão)</span>
                            </div>
                            <div onclick="selectSingleOption('INATIVO', 'Situação: Inativo', 'situacao-usuario', 'label-situacao-usuario', 'dropdown-menu-situacao-usuario', 'chevron-situacao-usuario', true)"
                                 class="flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                                <span>Inativo</span>
                            </div>
                            <div onclick="selectSingleOption('TODOS', 'Situação: Todos', 'situacao-usuario', 'label-situacao-usuario', 'dropdown-menu-situacao-usuario', 'chevron-situacao-usuario', true)"
                                 class="flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e] font-medium">
                                <span>Todos</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Limpar Filtros -->
            @if(request()->input('pesquisar') || (request()->input('situacao') && request()->input('situacao') !== 'ATIVO'))
                <a href="{{ url('/coordenacao/usuario_inf') }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors whitespace-nowrap">
                    Limpar filtros
                </a>
            @endif
        </div>

        <span class="text-sm font-medium text-[#5c706b]">
            Usuários encontrados: <strong class="text-[#0a241e]">{{ isset($Usuarios) && method_exists($Usuarios, 'total') ? $Usuarios->total() : count($Usuarios ?? []) }}</strong>
        </span>
    </div>

    <!-- Seção da Tabela -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome do Usuário</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nível</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Situação</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($Usuarios ?? [] as $Usuario)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">
                                {{ $Usuario->NomeFuncionario ?? $Usuario->usuario ?? $Usuario->login ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#f0fdf4] text-[#166534]">
                                    {{ $Usuario->Nivel ?? 'COORDENACAO' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if(strtoupper($Usuario->Situacao ?? '') !== 'INATIVO')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#ecfdf5] text-[#008a4b]">Ativo</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600">Inativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <div class="flex justify-center gap-1.5">
                                    <a href="{{ url('/coordenacao/usuario_editar/' . $Usuario->idUsuario) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Editar Usuário">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ url('/coordenacao/usuario_deletar/' . $Usuario->idUsuario) }}" onclick="return confirm('Deseja realmente excluir este usuário?');" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-red-600 hover:bg-red-50 transition-all" title="Excluir Usuário">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-[#5c706b]">
                                <div class="flex flex-col items-center gap-2">
                                    <i data-lucide="alert-circle" class="w-8 h-8 text-[#95aba5]"></i>
                                    <span>Nenhum usuário cadastrado!</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    @if(isset($Usuarios) && method_exists($Usuarios, 'links'))
        <div class="mt-4">
            {!! $Usuarios->links() !!}
        </div>
    @endif

</div>
@endsection