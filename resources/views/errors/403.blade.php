@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6 max-w-xl mx-auto py-12 px-4">
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-8 sm:p-12 shadow-2xs text-center flex flex-col items-center gap-4">
        <div class="w-16 h-16 rounded-full bg-red-50 flex items-center justify-center text-red-500 mb-2">
            <i data-lucide="shield-alert" class="w-8 h-8"></i>
        </div>

        <span class="text-xs font-semibold tracking-wider uppercase text-red-600 bg-red-50 px-3 py-1 rounded-full">
            Erro 403
        </span>

        <h1 class="text-2xl sm:text-3xl font-bold text-[#0a241e]">Acesso não permitido</h1>

        <p class="text-[#5c706b] max-w-md text-sm sm:text-base leading-relaxed">
            Você não tem permissão para acessar esta turma/aluno.
        </p>

        <a href="{{ url('/docente') }}" class="mt-4 inline-flex items-center gap-2 bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full transition-all shadow-xs">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Voltar para o Painel</span>
        </a>
    </div>
</div>
@endsection
