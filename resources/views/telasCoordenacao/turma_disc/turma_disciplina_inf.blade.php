@extends('layouts.app')

@section('content')
@php
    $professores = collect();
    $turmas = collect();

    try {
        $disciplinasDoProfessor = \DB::table('tb_turmas_disciplinas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) {
        $disciplinasDoProfessor = collect();
    }
@endphp
<div class="flex flex-col gap-6">
    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Lotação de Professor</span>
    </div>

    <!-- Cabeçalho -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Lotação de Professor</h1>
            <p class="text-sm text-[#5c706b]">Vínculos cadastrados: ({{ isset($disciplinasDoProfessor) ? count($disciplinasDoProfessor) : 0 }})</p>
        </div>
        <a href="{{ url('/coordenacao/turma_disc/turma_disciplina_cad') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
            <i data-lucide="plus" class="w-5 h-5"></i>
            <span>Cadastrar Lotação</span>
        </a>
    </div>

    <!-- Filtros -->
    <div class="flex flex-col sm:flex-row gap-4 items-center">
        <!-- Filtrar por Professor -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all relative">
                    @if(request()->input('idTurmas'))
                        <input type="hidden" name="idTurmas" value="{{ request()->input('idTurmas') }}">
                    @endif
                    <select name="idFuncionarios" onchange="this.form.submit()" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6">
                        <option value="">Filtrar por Professor</option>
                        @foreach($professores as $prof)
                            <option value="{{ $prof->idFuncionarios }}" {{ request()->input('idFuncionarios') == $prof->idFuncionarios ? 'selected' : '' }}>
                                {{ $prof->NomeFuncionario }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 text-[#95aba5] pointer-events-none">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
            </form>
        </div>

        <!-- Filtrar por Turma -->
        <div class="w-full sm:w-64">
            <form method="GET" action="{{ url()->current() }}" class="w-full">
                <div class="flex items-center bg-white border border-[#e3e8e6] rounded-xl px-4 py-2.5 transition-all relative">
                    @if(request()->input('idFuncionarios'))
                        <input type="hidden" name="idFuncionarios" value="{{ request()->input('idFuncionarios') }}">
                    @endif
                    <select name="idTurmas" onchange="this.form.submit()" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6">
                        <option value="">Filtrar por Turma</option>
                        @foreach($turmas as $t)
                            <option value="{{ $t->idTurmas }}" {{ request()->input('idTurmas') == $t->idTurmas ? 'selected' : '' }}>
                                {{ $t->NomeTurma }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute right-4 text-[#95aba5] pointer-events-none">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
            </form>
        </div>

        <!-- Limpar Filtros -->
        @if(request()->input('idFuncionarios') || request()->input('idTurmas'))
            <a href="{{ url()->current() }}" class="text-sm font-medium text-[#008a4b] hover:text-[#00703c] transition-colors">
                Limpar filtros
            </a>
        @endif
    </div>

    <!-- Seção da Tabela -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6] w-10 h-10">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Turma</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Disciplina</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Professor</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($disciplinasDoProfessor ?? [] as $vinculo)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $vinculo->NomeTurma }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">{{ $vinculo->NomeDisciplina }}</td>
                            <td class="px-6 py-4 text-sm text-[#0a241e]">{{ $vinculo->NomeFuncionario }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <div class="flex justify-center">
                                    <a href="{{ url('/coordenacao/turma_disciplina/deletar/' . $vinculo->idTurmas_Disciplinas) }}" class="text-[#e3503e] hover:text-[#c73927] p-2 rounded-lg hover:bg-red-50 transition-all group" title="Remover Vínculo">
                                        <i data-lucide="trash-2" class="w-4 h-4 group-hover:scale-110 transition-transform"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="alert-circle" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhum vínculo encontrado</p>
                                    <p class="text-xs text-[#5c706b]">Adicione uma nova Lotação para começar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginação -->
    @if(isset($disciplinasDoProfessor) && method_exists($disciplinasDoProfessor, 'links'))
        <div class="flex justify-center mt-6">
            {{ $disciplinasDoProfessor->links() }}
        </div>
    @endif
</div>
@endsection
