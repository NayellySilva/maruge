@extends('layouts.app')

@section('content')
@php
    try {
        $disciplinas = \DB::table('tb_disciplinas')->orderBy('NomeDisciplina')->get();
    } catch (\Exception $e) {
        $disciplinas = collect();
    }
@endphp
<div class="flex flex-col gap-6">
    <!-- Localização-->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Disciplina</span>
    </div>
    <!-- Cabeçalho -->
    <div class="flex justify-between items-center">

        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Disciplina</h1>
            <p class="text-sm text-[#5c706b]">Disciplina cadastradas: ({{ isset($disciplinas) ? (method_exists($disciplinas, 'total') ? $disciplinas->total() : count($disciplinas)) : 0 }})</p>
        </div>
        <a href="{{ url('/coordenacao/disciplinas/disciplina_cad') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Cadastrar Disciplina</span>
        </a>
        
    </div>

    <!-- Seção da Tabela -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6] w-5 h-5">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Cód</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome Disciplina</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($disciplinas ?? [] as $disciplina)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $disciplina->idDisciplinas }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $disciplina->NomeDisciplina }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <div class="flex justify-center gap-1.5">
                                    <a href="{{ url("/coordenacao/disciplina_editar/$disciplina->idDisciplinas") }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Editar Disciplina">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ url("/coordenacao/disciplina_deletar/$disciplina->idDisciplinas") }}" onclick="return confirm('Deseja realmente excluir esta disciplina?');" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-red-600 hover:bg-red-50 transition-all" title="Excluir Disciplina">
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
                                    <span>Nenhuma disciplina cadastrada!</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Seção de Paginação -->
    @if(isset($disciplinas) && method_exists($disciplinas, 'links'))
        <div class="mt-4">
            {!! $disciplinas->links() !!}
        </div>
    @endif

</div>
@endsection
