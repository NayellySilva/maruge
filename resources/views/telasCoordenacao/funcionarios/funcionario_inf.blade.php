@extends('layouts.app')

@section('content')
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
            <p class="text-sm text-[#5c706b]">Funcionários cadastrados: ({{ isset($Funcionarios) ? $Funcionarios->total() : 0 }})</p>
        </div>
        <a href="{{ url('/coordenacao/funcionarios/funcionario_cad') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Cadastrar Funcionário</span>
        </a>
    </div>

    <!-- Filtros -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa -->
        <div class="w-full sm:w-80">
            <form method="POST" action="/coordenacao/funcionario_pesq" class="w-full flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                {!! csrf_field() !!}
                <input type="text" name="pesquisar" placeholder="Pesquisar Funcionário" class="w-full bg-transparent text-sm focus:outline-none">
                <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
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
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($Funcionarios ?? [] as $Funcionario)
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