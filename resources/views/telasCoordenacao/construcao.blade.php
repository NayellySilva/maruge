@extends('layouts.app')

@section('content')
<div class="titulo-endereco">
    <a href="#">
        {{ $title ?? 'Página em Construção' }}
    </a>
</div>
<div class="bg-white border border-[#e3e8e6] rounded-2xl p-8 shadow-2xs mt-6 text-center max-w-2xl mx-auto flex flex-col items-center gap-4">
    
    <h2 class="text-2xl font-bold text-[#0a241e]">{{ $title ?? 'Seção em Desenvolvimento' }}</h2>
    <p class="text-[#7fa398] max-w-md">Preparando...</p>
    <a href="/" class="mt-4 bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2 rounded-full transition-all">
        Voltar ao Início
    </a>
</div>
@endsection
