@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6 max-w-xl mx-auto py-10 px-4">
    <div class="flex items-center gap-2 text-sm text-[#5c706b]">
        <a href="{{ url('/docente/resultados') }}" class="hover:text-[#008a4b] transition-colors">Resultados</a>
        <span>/</span>
        <span class="font-semibold text-[#0a241e]">Recuperação</span>
    </div>

    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-8 sm:p-12 shadow-2xs text-center flex flex-col items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center text-[#008a4b] mb-2">
            <i data-lucide="info" class="w-8 h-8"></i>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-[#0a241e]">Sem Fase de Recuperação</h1>

        <p class="text-[#5c706b] max-w-md text-sm sm:text-base leading-relaxed">
            Turmas da Educação Infantil não possuem fase de recuperação parcial ou final.
        </p>

        <a href="{{ url('/docente/resultados') }}" class="mt-4 inline-flex items-center gap-2 bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full transition-all shadow-xs">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Voltar para Resultados</span>
        </a>
    </div>
</div>
@endsection