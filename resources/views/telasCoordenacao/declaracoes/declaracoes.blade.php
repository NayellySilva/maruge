@extends('layouts.app')

@section('content')

@php
    // Busca inicial de alunos com paginação e associação da turma
    try {
        $Alunos = \DB::table('tb_alunos')
            ->leftJoin('tb_turmas', 'tb_alunos.tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
            ->select('tb_alunos.*', 'tb_turmas.NomeTurma')
            ->orderBy('NomeAluno')
            ->paginate(15);
    } catch (\Exception $e) {
        $Alunos = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
    }

    // Listagem de turmas para o filtro
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
        <span class="font-semibold text-[#0a241e]">Declarações</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Declarações</h1>
            <p class="text-sm text-[#5c706b]">Alunos cadastrados: ({{ $Alunos->total() }})</p>
        </div>
    </div>

    <!-- Filtros de Busca e Turma -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Barra de Pesquisa por Nome/RA do Aluno -->
        <div class="w-full sm:w-80">
            <form method="POST" action="{{ url('/coordenacao/declaracoes_pesq') }}" class="w-full">
                @csrf
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all">
                    <input type="text" name="pesquisar" placeholder="Pesquisar Aluno" class="w-full bg-transparent text-sm focus:outline-none">
                    <button type="submit" class="text-[#5c706b] hover:text-[#008a4b] ml-2">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu Dropdown de Filtro -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                <div class="relative">
                    <select
                        name="idTurmas"
                        onchange="this.form.submit()"
                        class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                    >
                        <option value="" disabled {{ !request()->has('idTurmas') ? 'selected' : '' }}>
                            Filtrar por Turma
                        </option>
                        <option value="" {{ request()->input('idTurmas') === '' ? 'selected' : '' }}>
                            Todas as Turmas
                        </option>
                        @foreach($turmas as $t)
                            <option value="{{ $t->idTurmas }}" {{ request()->input('idTurmas') == $t->idTurmas ? 'selected' : '' }}>
                                {{ $t->NomeTurma }}
                            </option>
                        @endforeach
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                    ></i>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Alunos e Ações para Emissão de Declarações -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome do Aluno</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">RA</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Emitir Declarações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    <!-- Laço com os alunos encontrados -->
                    @forelse($Alunos as $Aluno)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $Aluno->NomeAluno }}</td>
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $Aluno->RA }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">{{ $Aluno->NomeTurma ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <!-- Botões para cada modalidade de declaração -->
                                <div class="flex flex-wrap justify-center gap-1.5">
                                    <a href="{{ url('/coordenacao/declaracoes_cursando/' . $Aluno->idAluno) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors"
                                       title="Declaração Cursando">
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i> Cursando
                                    </a>

                                    <a href="{{ url('/coordenacao/declaracoes_transferencia/' . $Aluno->idAluno) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors"
                                       title="Declaração Transferência">
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i> Transferência
                                    </a>

                                    <a href="{{ url('/coordenacao/declaracoes_apto/' . $Aluno->idAluno) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors"
                                       title="Declaração Apto">
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i> Apto
                                    </a>

                                    <a href="{{ url('/coordenacao/declaracoes_quitacao/' . $Aluno->idAluno) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-amber-50 text-amber-700 hover:bg-amber-100 transition-colors"
                                       title="Declaração Quitação">
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i> Quitação
                                    </a>

                                    <a href="{{ url('/coordenacao/declaracoes_inapto/' . $Aluno->idAluno) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors"
                                       title="Declaração Inapto">
                                        <i data-lucide="printer" class="w-3.5 h-3.5"></i> Inapto
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <!-- Estado quando nenhum aluno é retornado -->
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="file-text" class="w-8 h-8"></i>
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