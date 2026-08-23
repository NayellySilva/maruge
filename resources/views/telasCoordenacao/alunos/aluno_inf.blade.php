@extends('layouts.app')

@section('content')

@php
    if (!isset($Alunos)) {
        try {
            $Alunos = \DB::table('tb_aluno')
                ->leftJoin('tb_matriculas', 'tb_aluno.tb_matriculas_idMatriculas', '=', 'tb_matriculas.idMatriculas')
                ->leftJoin('tb_turmas', 'tb_aluno.tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                ->orderBy('NomeAluno')
                ->paginate(15);
        } catch (\Exception $e) {
            $Alunos = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
        }
    }

    if (!isset($turmas)) {
        try {
            $turmas = \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
        } catch (\Exception $e) {
            $turmas = collect();
        }
    }
@endphp

<div class="flex flex-col gap-6">
    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Alunos</span>
    </div>

    <!-- Cabeçalho -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Alunos</h1>
            <p class="text-sm text-[#5c706b]">Alunos cadastrados: ({{ $Alunos->total() }})</p>
        </div>
        <a href="{{ url('/coordenacao/alunos/aluno_cad') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Cadastrar Aluno</span>
        </a>
    </div>

    <!-- Filtros -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa -->
        <div class="w-full sm:w-80">
            <form method="GET" action="{{ url()->current() }}" class="w-full flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                <input type="text" name="pesquisar" placeholder="Pesquisar Aluno" value="{{ request()->input('pesquisar') }}" class="w-full bg-transparent text-sm focus:outline-none">
                <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                    <i data-lucide="search" class="w-4 h-4"></i>
                </button>
            </form>
        </div>

        <!-- Filtrar por Turma -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all relative">
                    <div class="select-wrapper">
    <select name="idTurmas" onchange="this.form.submit()" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select">
                        <option value="">Filtrar por Turma</option>
                        @foreach($turmas as $t)
                            <option value="{{ $t->idTurmas }}" {{ request()->input('idTurmas') == $t->idTurmas ? 'selected' : '' }}>
                                {{ $t->NomeTurma }}
                            </option>
                        @endforeach
                    </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
                    <div class="absolute right-4 text-[#95aba5] pointer-events-none">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
            </form>
        </div>

        <!-- Limpar Filtros -->
        @if(request()->input('pesquisar') || request()->input('idTurmas'))
            <a href="{{ url()->current() }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors whitespace-nowrap">
                Limpar filtros
            </a>
        @endif
    </div>

    <!-- Seção da Tabela -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome do Aluno</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">RA</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Situação</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($Alunos as $Aluno)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $Aluno->NomeAluno }}</td>
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $Aluno->RA }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">{{ $Aluno->NomeTurma ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                @if(isset($Aluno->SituacaoAluno) && strtoupper($Aluno->SituacaoAluno) !== 'INATIVO')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-[#f0fdf4] text-[#166534]">Ativo</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600">Inativo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-center">
                                <div class="flex justify-center gap-1.5">
                                    <a href="{{ url('/coordenacao/aluno_transferir/' . $Aluno->idAluno) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Transferir Aluno">
                                        <i data-lucide="arrow-right-left" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ url('/coordenacao/aluno_editar/' . $Aluno->idAluno) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Editar Aluno">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ url('/coordenacao/aluno_deletar/' . $Aluno->idAluno) }}" onclick="return confirm('Deseja realmente excluir este aluno?');" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-red-600 hover:bg-red-50 transition-all" title="Excluir Aluno">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ url('/coordenacao/aluno_ficha/' . $Aluno->idAluno) }}" class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all" title="Imprimir Ficha">
                                        <i data-lucide="printer" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="users" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhum aluno encontrado</p>
                                    <p class="text-xs text-[#5c706b]">Cadastre alunos ou ajuste os filtros de busca</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    @if($Alunos->hasPages())
        <div class="flex justify-center mt-2">
            {{ $Alunos->links() }}
        </div>
    @endif
</div>
@endsection
