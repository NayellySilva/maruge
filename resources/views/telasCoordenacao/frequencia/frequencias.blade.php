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

    // Listagem completa de turmas para o filtro do dropdown
    try {
        $turmasSelecte = \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) {
        $turmasSelecte = collect();
    }
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Frequência</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Frequência por Turma</h1>
            <p class="text-sm text-[#5c706b]">Turmas encontradas: ({{ $turmas->total() }})</p>
        </div>
    </div>

    <!-- Filtros de Busca e Seleção de Turma -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa por Nome da Turma -->
        <div class="w-full sm:w-80">
            <form method="POST" action="{{ url('/coordenacao/frequencias_pesq') }}" class="w-full">
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
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                <div class="relative" id="dropdown-container-turma-frequencia">
                    <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                    @php
                        $selectedTurmaFreq = $turmasSelecte->firstWhere('idTurmas', request()->input('idTurmas'));
                    @endphp

                    <!-- Trigger Box -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-turma-frequencia', 'chevron-turma-frequencia')" 
                         class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-turma-frequencia" class="text-sm font-medium truncate {{ $selectedTurmaFreq ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            {{ $selectedTurmaFreq ? $selectedTurmaFreq->NomeTurma : 'Filtrar por Turma' }}
                        </span>
                        <div id="chevron-turma-frequencia" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante -->
                    <div id="dropdown-menu-turma-frequencia" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                        <!-- Campo de Busca -->
                        <div class="relative shrink-0">
                            <input type="text" onkeyup="filterDropdownOptions('search-turma-frequencia', 'option-turma-frequencia')" id="search-turma-frequencia" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        </div>

                        <!-- Lista de Opções com Rolagem -->
                        <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                            <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma-frequencia', 'dropdown-menu-turma-frequencia', 'chevron-turma-frequencia', true)"
                                 class="option-turma-frequencia flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">Todas as Turmas</span>
                            </div>
                            @foreach($turmasSelecte as $t)
                                <div onclick="selectSingleOption('{{ $t->idTurmas }}', '{{ $t->NomeTurma }}', 'idTurmas', 'label-turma-frequencia', 'dropdown-menu-turma-frequencia', 'chevron-turma-frequencia', true)"
                                     class="option-turma-frequencia flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $t->NomeTurma }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Turmas e Documentos de Frequência -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Cód</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome da Turma</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Opções de Frequência</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    <!-- Exibição dos registros das turmas -->
                    @forelse($turmas as $turma)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $turma->idTurmas }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-[#0a241e]">{{ $turma->NomeTurma }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <!-- Botões para cada modalidade de frequência -->
                                <div class="flex flex-wrap justify-center gap-1.5">
                                    <a href="{{ url('/coordenacao/frequencia_virtual/' . $turma->idTurmas) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors"
                                       title="Frequência Virtual">
                                        <i data-lucide="monitor" class="w-3.5 h-3.5"></i> Virtual
                                    </a>

                                    <a href="{{ url('/coordenacao/frequencia_mensal/' . $turma->idTurmas) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors"
                                       title="Frequência Mensal (Manual)">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5"></i> Manual
                                    </a>

                                    <a href="{{ url('/coordenacao/frequencia_edfisica/' . $turma->idTurmas) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors"
                                       title="Frequência de Ed. Física">
                                        <i data-lucide="activity" class="w-3.5 h-3.5"></i> Ed. Física
                                    </a>

                                    <a href="{{ url('/coordenacao/frequencia_entrega/' . $turma->idTurmas) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 hover:bg-amber-100 transition-colors"
                                       title="Frequência de Reuniões / Entrega de Resultado">
                                        <i data-lucide="users" class="w-3.5 h-3.5"></i> Reuniões
                                    </a>

                                    <a href="{{ url('/coordenacao/frequencia_relatorio/' . $turma->idTurmas) }}"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors"
                                       title="Relatório de Frequência">
                                        <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Relatório
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <!-- Estado exibido quando nenhuma turma é encontrada -->
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="book-open" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhuma turma encontrada</p>
                                    <p class="text-xs text-[#5c706b]">Cadastre turmas ou ajuste os filtros de busca</p>
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