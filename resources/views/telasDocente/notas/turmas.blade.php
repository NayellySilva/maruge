@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/docente/secretaria') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Lançar notas por turma</span>
    </div>

    <div class="flex flex-col gap-1">
        <h1 class="text-3xl font-semibold text-[#0a241e]">Lançar notas por turma</h1>
        <p class="text-sm text-[#5c706b]">Escolha a turma e a disciplina para lançar notas de todos os alunos.</p>
    </div>

    <nav class="flex flex-wrap gap-2" aria-label="Selecionar bimestre">
        @foreach([1, 2, 3, 4] as $opcaoBimestre)
            <a href="{{ route('docente.notas.turma', ['bim' => $opcaoBimestre]) }}"
               aria-current="{{ $bimestre === $opcaoBimestre ? 'page' : 'false' }}"
               class="rounded-lg px-4 py-2 text-sm font-semibold transition-colors {{ $bimestre === $opcaoBimestre ? 'bg-[#008a4b] text-white' : 'border border-[#e3e8e6] bg-white text-[#5c706b] hover:border-[#008a4b] hover:text-[#008a4b]' }}">
                {{ $opcaoBimestre }}º Bimestre
            </a>
        @endforeach
    </nav>

    @forelse($turmas as $turma)
        <section class="rounded-2xl border border-[#e3e8e6] bg-white p-5 shadow-2xs">
            <div class="mb-4">
                <h2 class="text-lg font-bold text-[#0a241e]">{{ $turma->NomeTurma }}</h2>
                <p class="text-xs text-[#5c706b]">Ano letivo {{ $turma->AnoLetivo }}</p>
            </div>

            @if($turma->disciplinas->isEmpty())
                <p class="text-sm italic text-[#5c706b]">Nenhuma disciplina vinculada ao seu perfil nesta turma.</p>
            @else
                <div class="flex flex-wrap gap-2">
                    @foreach($turma->disciplinas as $disciplina)
                        <a href="{{ url('/docente/lancar_turma/' . $turma->idTurmas . '/' . $disciplina->tb_disciplinas_idDisciplinas . '/' . $bimestre . 'bim') }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-[#e3e8e6] bg-[#f8faf9] px-3 py-2 text-sm font-medium text-[#0a241e] transition-colors hover:border-[#008a4b] hover:bg-[#ecfdf5] hover:text-[#008a4b]">
                            <i data-lucide="clipboard-pen" class="h-4 w-4"></i>
                            {{ $disciplina->NomeDisciplina }}
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
    @empty
        <div class="rounded-2xl border border-[#e3e8e6] bg-white p-8 text-center">
            <p class="text-sm font-semibold text-[#0a241e]">Nenhuma turma ativa vinculada ao seu perfil.</p>
            <p class="mt-1 text-xs text-[#5c706b]">Entre em contato com a coordenação para verificar suas atribuições.</p>
        </div>
    @endforelse
</div>
@endsection
