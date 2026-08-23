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
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Relatórios</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Resultados</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Resultados Acadêmicos</h1>
            <p class="text-sm text-[#5c706b]">Turmas Cadastradas: ({{ $turmas->total() }})</p>
        </div>
    </div>

    <!-- Filtros de Busca e Seleção por Situação -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Localizar Turma -->
        <div class="w-full sm:w-80">
            <form method="POST" action="{{ url('/coordenacao/resultados_pesq') }}" class="w-full">
                @csrf
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                    <input type="text" name="pesquisar" placeholder="Pesquisar Turma" class="w-full bg-transparent text-sm focus:outline-none">
                    <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu Dropdown de Filtro -->
        <div class="w-full sm:w-64">
            <form method="POST" action="{{ url('/coordenacao/resultados_filtro') }}" class="w-full">
                @csrf
                <div class="relative">
                    <select
                        name="SituacaoTurma"
                        onchange="this.form.submit()"
                        class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                    >
                        <option value="" disabled {{ !request()->has('SituacaoTurma') ? 'selected' : '' }}>
                            Filtrar por Situação
                        </option>
                        <option value="" {{ request()->input('SituacaoTurma') === '' ? 'selected' : '' }}>
                            Todos
                        </option>
                        <option value="ATIVO" {{ request()->input('SituacaoTurma') == 'ATIVO' ? 'selected' : '' }}>
                            Ativo
                        </option>
                        <option value="INATIVO" {{ request()->input('SituacaoTurma') == 'INATIVO' ? 'selected' : '' }}>
                            Inativo
                        </option>
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                    ></i>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Turmas e Impressão de Resultados -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">CÓD</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome Turma</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Rec. Parcial</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Rec. Final</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Apro./ 1º Sem.</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Apro./ 2º Sem.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    <!-- Recebendo valores na vareavel escolas e passando para escola-->
                    @forelse($turmas as $turma)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $turma->idTurmas }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $turma->NomeTurma }}</td>

                            <!-- Resultado Parcial -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_parcial/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Imprimir Resultado Parcial">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Resultado Final -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_final/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Imprimir Resultado Final">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Aprovados 1º Semestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_aprovados_1semestre/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Imprimir Aprovados 1º Semestre">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Aprovados 2º Semestre -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/resultados_aprovados_2semestre/' . $turma->idTurmas) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Imprimir Aprovados 2º Semestre">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <!-- Estado sem registros -->
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="award" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhuma turma encontrada</p>
                                    <p class="text-xs text-[#5c706b]">Cadastre turmas para visualizar os relatórios de resultados</p>
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

</div> <!--Fim do caminho-din-->

@endsection