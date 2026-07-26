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

        <!-- Menu Dropdown de Filtro -->
        <div class="w-full sm:w-64">
            <form method="post" action="{{ url('/coordenacao/turma_filtro') }}" class="w-full">
                {!! csrf_field() !!}
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                    <select name="SituacaoTurma" onchange="this.form.submit()" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6">
                        <option value="" disabled selected>Filtrar por Situação</option>
                        <option value="">Todos</option>
                        <option value="ATIVO">Ativo</option>
                        <option value="INATIVO">Inativo</option>
                    </select>
                    <div class="text-[#95aba5] pointer-events-none -ml-6">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
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
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Editar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($turmas ?? [] as $turma)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $turma->idTurmas }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $turma->NomeTurma }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e] text-center">RS: {{ number_format($turma->Mensalidade, 2, ',', '.') }}</td>
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
                                <div class="flex justify-center gap-2">
                                    <a href="{{ url("/coordenacao/turma_editar/$turma->idTurmas") }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Editar Turma">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
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