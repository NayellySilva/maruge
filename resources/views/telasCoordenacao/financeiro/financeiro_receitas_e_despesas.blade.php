@extends('layouts.app')

@section('content')

<!-- Titulo e Endereco da Pagina -->
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Financeiro</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Receitas e Despesas</span>
    </div>

    <!-- Cabeçalho Principal e Botões de Cadastrar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Receitas e Despesas</h1>
            <p class="text-sm text-[#5c706b]">Controle de fluxo de caixa da instituição</p>
        </div>

        <!-- Botões de Cadastrar (Cadastrar Receita, Categoria e Despesa) -->
        <div class="flex items-center gap-2.5">
            <button type="button"
                    data-toggle="modal"
                    data-target="#modal_receita"
                    style="background-color: #008a4b; color: #ffffff;"
                    class="hover:opacity-90 text-xs font-semibold px-4 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-2xs">
                <i data-lucide="plus" class="w-4 h-4"></i> RECEITA
            </button>
            <button type="button"
                    data-toggle="modal"
                    data-target="#modal_categoria"
                    style="background-color: #d97706; color: #ffffff;"
                    class="hover:opacity-90 text-xs font-semibold px-4 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-2xs">
                <i data-lucide="plus" class="w-4 h-4"></i> CATEGORIA
            </button>
            <button type="button"
                    data-toggle="modal"
                    data-target="#modal_despesa"
                    style="background-color: #dc2626; color: #ffffff;"
                    class="hover:opacity-90 text-xs font-semibold px-4 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-2xs">
                <i data-lucide="plus" class="w-4 h-4"></i> DESPESA
            </button>
        </div>
        <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
    </div>

    <!-- Filtros de Busca (Padrão do Sistema) -->
    <form method="POST" action="{{ url('/coordenacao/financeiro_contas_pagar_pesq') }}" class="flex flex-col sm:flex-row gap-4 items-center">
        @csrf

        <!-- Descrição / Título -->
        <div class="w-full sm:w-80">
            <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                <input type="text" name="codbarras" placeholder="Pesquisar Descrição" class="w-full bg-transparent text-sm focus:outline-none">
                <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        <!-- Exibir -->
        <div class="w-full sm:w-48">
            <div class="relative">
                <select
                    name="exibir"
                    class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                >
                    <option value="">Exibir: Todas</option>
                    <option value="Receitas">Receitas</option>
                    <option value="Despesas">Despesas</option>
                    <option value="Previsto">Previsto</option>
                    <option value="Realizado">Realizado</option>
                </select>
                <i
                    data-lucide="chevron-down"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                ></i>
            </div>
        </div>

        <!-- Categoria -->
        <div class="w-full sm:w-48">
            <div class="relative">
                <select
                    name="categoria"
                    class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                >
                    <option value="">Categoria: Todas</option>
                    <option value="Mensalidades">Mensalidades</option>
                    <option value="Material">Material Didático</option>
                    <option value="Servicos">Serviços Tercerizados</option>
                    <option value="Manutencao">Manutenção</option>
                </select>
                <i
                    data-lucide="chevron-down"
                    class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                ></i>
            </div>
        </div>
    </form>

    <!-- Tabela de Registros de Receitas e Despesas (Padrão do Sistema) -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">CÓD</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Descrição</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Categoria</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Tipo</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Vencimento</th>
                        <th class="px-4 py-4 text-right text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Valor</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    <!-- Estado limpo inicial -->
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                    <i data-lucide="dollar-sign" class="w-8 h-8"></i>
                                </div>
                                <p class="text-sm text-[#0a241e] font-medium">Nenhum lançamento localizado</p>
                                <p class="text-xs text-[#5c706b]">Utilize a barra de pesquisa acima para filtrar ou cadastre um novo lançamento</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>
    <!-- /.panel -->

</div> <!--Fim do caminho-din-->

<!-- Modais de Cadastro (Receita, Categoria, Despesa) -->
<div id="modal_receita" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" style="display:none">
    <div class="modal-dialog">
        <div class="modal-content rounded-2xl p-6 bg-white shadow-xl">
            <div class="modal-header border-b border-[#e3e8e6] pb-3 flex justify-between items-center">
                <h4 class="modal-title font-bold text-[#0a241e] flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-[#008a4b]"></i> Nova Receita
                </h4>
                <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="{{ url('/coordenacao/financeiro_criar_receita') }}" class="flex flex-col gap-4 mt-4">
                @csrf
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-[#0a241e]">Descrição:</label>
                    <input type="text" name="descricao" required placeholder="Ex: Mensalidade Aluno X" class="w-full border border-[#e3e8e6] rounded-xl px-3.5 py-2 text-sm">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-[#0a241e]">Valor (R$):</label>
                    <input type="text" name="valor" required placeholder="0,00" class="w-full border border-[#e3e8e6] rounded-xl px-3.5 py-2 text-sm">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-[#0a241e]">Data de Vencimento:</label>
                    <input type="date" name="data_vencimento" required class="w-full border border-[#e3e8e6] rounded-xl px-3.5 py-2 text-sm">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-dismiss="modal" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium">Cancelar</button>
                    <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white px-5 py-2 rounded-xl text-sm font-medium">Salvar Receita</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal_categoria" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" style="display:none">
    <div class="modal-dialog">
        <div class="modal-content rounded-2xl p-6 bg-white shadow-xl">
            <div class="modal-header border-b border-[#e3e8e6] pb-3 flex justify-between items-center">
                <h4 class="modal-title font-bold text-[#0a241e] flex items-center gap-2">
                    <i data-lucide="tag" class="w-5 h-5 text-amber-500"></i> Nova Categoria
                </h4>
                <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="{{ url('/coordenacao/financeiro_criar_categoria') }}" class="flex flex-col gap-4 mt-4">
                @csrf
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-[#0a241e]">Nome da Categoria:</label>
                    <input type="text" name="nome_categoria" required placeholder="Ex: Manutenção de Equipamentos" class="w-full border border-[#e3e8e6] rounded-xl px-3.5 py-2 text-sm">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-dismiss="modal" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium">Cancelar</button>
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-5 py-2 rounded-xl text-sm font-medium">Salvar Categoria</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal_despesa" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true" style="display:none">
    <div class="modal-dialog">
        <div class="modal-content rounded-2xl p-6 bg-white shadow-xl">
            <div class="modal-header border-b border-[#e3e8e6] pb-3 flex justify-between items-center">
                <h4 class="modal-title font-bold text-[#0a241e] flex items-center gap-2">
                    <i data-lucide="minus-circle" class="w-5 h-5 text-red-600"></i> Nova Despesa
                </h4>
                <button type="button" class="close text-gray-400 hover:text-gray-600" data-dismiss="modal">&times;</button>
            </div>
            <form method="POST" action="{{ url('/coordenacao/financeiro_criar_despesa') }}" class="flex flex-col gap-4 mt-4">
                @csrf
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-[#0a241e]">Descrição da Despesa:</label>
                    <input type="text" name="descricao" required placeholder="Ex: Conta de Luz / Água" class="w-full border border-[#e3e8e6] rounded-xl px-3.5 py-2 text-sm">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-[#0a241e]">Valor (R$):</label>
                    <input type="text" name="valor" required placeholder="0,00" class="w-full border border-[#e3e8e6] rounded-xl px-3.5 py-2 text-sm">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-[#0a241e]">Data de Vencimento:</label>
                    <input type="date" name="data_vencimento" required class="w-full border border-[#e3e8e6] rounded-xl px-3.5 py-2 text-sm">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-dismiss="modal" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-medium">Cancelar</button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl text-sm font-medium">Salvar Despesa</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection