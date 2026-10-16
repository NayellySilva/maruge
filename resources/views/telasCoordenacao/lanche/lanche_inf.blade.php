@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Cabeçalho Principal -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-[#e3e8e6] shadow-2xs">
        <div>
            <h1 class="text-2xl font-bold text-[#0a241e]">Listagem de Lanches e Produtos</h1>
            <p class="text-sm text-[#5c706b]">Gerencie os itens da cantina escolar</p>
        </div>

        <a href="{{ url('/coordenacao/lanche_cad') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Cadastrar Lanche</span>
        </a>
    </div>

    <!-- Barra de Filtros e Busca -->
    <div class="bg-white p-4 rounded-2xl border border-[#e3e8e6] shadow-2xs flex flex-col md:flex-row items-center justify-between gap-4">
        <form class="form-search pesquisar w-full md:w-96 flex items-center gap-2" method="post" action="/coordenacao/lanche_pesq">
            {!! csrf_field() !!}
            <div class="relative w-full">
                <input type="text" name="pesquisar" placeholder="Pesquisar lanche..." class="w-full pl-10 pr-4 py-2 bg-[#f8faf9] border border-[#e3e8e6] rounded-xl text-sm focus:outline-none focus:border-[#008a4b] transition-all" value="{{ request()->input('pesquisar') }}">
                <i data-lucide="search" class="w-4 h-4 text-[#5c706b] absolute left-3 top-2.5"></i>
            </div>
            <button type="submit" class="bg-[#f8faf9] hover:bg-[#e3e8e6] border border-[#e3e8e6] text-[#0a241e] font-medium px-4 py-2 rounded-xl text-sm transition-all cursor-pointer">
                Buscar
            </button>
        </form>

        <span class="text-sm font-medium text-[#5c706b]">
            Total de itens: <strong class="text-[#0a241e]">{{ isset($lanches) && method_exists($lanches, 'total') ? $lanches->total() : count($lanches ?? []) }}</strong>
        </span>
    </div>

    <!-- Seção da Tabela -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Cód</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome do Lanche</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Valor</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($lanches ?? [] as $lanche)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $lanche->idlanche }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $lanche->NomeLanche }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-[#0a241e] text-center">
                                R$: {{ number_format((float)($lanche->ValorLanche ?? 0), 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <div class="flex justify-center gap-1.5">
                                    <a href="{{ url('/coordenacao/lanche_editar/' . $lanche->idlanche) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Editar Lanche">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ url('/coordenacao/lanche_deletar/' . $lanche->idlanche) }}" onclick="return confirm('Deseja realmente excluir este item do lanche?');" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-red-600 hover:bg-red-50 transition-all" title="Excluir Lanche">
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
                                    <span>Nenhum lanche cadastrado!</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    @if(isset($lanches) && method_exists($lanches, 'links'))
        <div class="mt-4">
            {!! $lanches->links() !!}
        </div>
    @endif

</div>
@endsection