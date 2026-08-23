@extends('layouts.app')

@section('content')

@php
    try {
        $turmas = $turmas ?? \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) {
        $turmas = collect();
    }
@endphp

<!-- Titulo e Endereco da Pagina -->
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Financeiro</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Relatórios</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Relatórios Financeiros</h1>
            <p class="text-sm text-[#5c706b]">Filtre pagamentos por turma, mês e situação de pagamento</p>
        </div>
    </div>

    <!-- Filtros por turma / mes / situação (Padrão do Sistema) -->
    <form method="POST" action="{{ url('/coordenacao/financeiro_pesq_relatorio') }}" class="flex flex-col sm:flex-row gap-4 items-center">
        @csrf

        <!-- Seleção de Turma -->
        <div class="w-full sm:w-56">
            <div class="relative">
                <select
                    name="idTurmas"
                    class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                >
                    <option value="">Todas as Turmas</option>
                    @forelse($turmas as $turma)
                        <option value="{{ $turma->idTurmas }}">{{ $turma->NomeTurma }}</option>
                    @empty
                    @endforelse
                </select>
                <i
                    data-lucide="chevron-down"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                ></i>
            </div>
        </div>

        <!-- Seleção de Mês -->
        <div class="w-full sm:w-48">
            <div class="relative">
                <select
                    name="Meses"
                    required
                    class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                >
                    <option value="">Selecione o Mês</option>
                    <option value="JANEIRO">JANEIRO</option>
                    <option value="FEVEREIRO">FEVEREIRO</option>
                    <option value="MARÇO">MARÇO</option>
                    <option value="ABRIL">ABRIL</option>
                    <option value="MAIO">MAIO</option>
                    <option value="JUNHO">JUNHO</option>
                    <option value="JULHO">JULHO</option>
                    <option value="AGOSTO">AGOSTO</option>
                    <option value="SETEMBRO">SETEMBRO</option>
                    <option value="OUTUBRO">OUTUBRO</option>
                    <option value="NOVEMBRO">NOVEMBRO</option>
                    <option value="DEZEMBRO">DEZEMBRO</option>
                </select>
                <i
                    data-lucide="chevron-down"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                ></i>
            </div>
        </div>

        <!-- Seleção de Situação -->
        <div class="w-full sm:w-48">
            <div class="relative">
                <select
                    name="status_pagamento"
                    required
                    class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                >
                    <option value="">Todas as Situações</option>
                    <option value="PAGO">PAGO</option>
                    <option value="PARCIAL">PARCIAL</option>
                    <option value="ABERTO">ABERTO</option>
                </select>
                <i
                    data-lucide="chevron-down"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                ></i>
            </div>
        </div>

        <!-- Botão Filtrar -->
        <div>
            <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white text-sm font-medium px-5 py-2.5 rounded-xl flex items-center justify-center gap-2 transition-all shadow-2xs">
                <i data-lucide="search" class="w-4 h-4"></i> Filtrar
            </button>
        </div>
    </form>
    <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->

    <!-- Cards de Relatórios PDF / Impressão Pronta -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="#btn-report" class="bg-white border border-[#e3e8e6] hover:border-[#008a4b] rounded-2xl p-5 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                <i data-lucide="printer" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">Contas a Receber</h3>
                <p class="text-xs text-[#5c706b]">Imprimir relatório geral de recebimentos</p>
            </div>
        </a>

        <a href="#btn-report" class="bg-white border border-[#e3e8e6] hover:border-red-500 rounded-2xl p-5 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center shrink-0">
                <i data-lucide="printer" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#0a241e] group-hover:text-red-600 transition-colors">Contas a Pagar</h3>
                <p class="text-xs text-[#5c706b]">Imprimir relatório de saídas e fornecedores</p>
            </div>
        </a>

        <a href="#btn-report" class="bg-white border border-[#e3e8e6] hover:border-amber-500 rounded-2xl p-5 shadow-2xs flex items-center gap-4 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <i data-lucide="printer" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-[#0a241e] group-hover:text-amber-600 transition-colors">Contas Pendentes</h3>
                <p class="text-xs text-[#5c706b]">Imprimir títulos pendentes e em atraso</p>
            </div>
        </a>
    </div>

    <!-- Tabela de Registros Encontrados (Padrão do Sistema) -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Aluno / Responsável</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Mês</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Valor</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Situação</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                    <i data-lucide="file-spreadsheet" class="w-8 h-8"></i>
                                </div>
                                <p class="text-sm text-[#0a241e] font-medium">Selecione os filtros desejados</p>
                                <p class="text-xs text-[#5c706b]">Escolha uma turma, mês e situação para listar os registros financeiros</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>

</div> <!--Fim do caminho-din-->

@endsection
