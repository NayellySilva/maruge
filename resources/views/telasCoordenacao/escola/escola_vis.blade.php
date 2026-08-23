@extends('layouts.app')

@section('content')

@php
    try {
        $escolas = $escolas ?? \DB::table('tb_dados_escola')->first();
        $endereco = $endereco ?? $escolas;
    } catch (\Exception $e) {
        $escolas = null;
        $endereco = null;
    }
@endphp

<!--Essa página é apenas pra exibir as informações da escola em questão-->
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/escola/escola_inf') }}" class="hover:text-[#008a4b] transition-colors">Escola</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Perfil da Instituição</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Perfil da Escola</h1>
            <p class="text-sm text-[#5c706b]">Dados institucionais e informações de contato</p>
        </div>

        <!-- Botões de Ação (Voltar, Editar, Imprimir) -->
        <div class="flex items-center gap-2">
            <a href="{{ url('/coordenacao/escola_editar/' . ($escolas->idEscola ?? 1)) }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-4 py-2 rounded-full flex items-center gap-2 transition-all shadow-2xs text-sm">
                <i data-lucide="edit-3" class="w-4 h-4"></i> Editar
            </a>
            <a href="{{ url('/coordenacao/escola_impressao/' . ($escolas->idEscola ?? 1)) }}" target="_blank" class="bg-white hover:bg-[#f8faf9] text-[#5c706b] border border-[#e3e8e6] font-medium px-4 py-2 rounded-full flex items-center gap-2 transition-all text-sm">
                <i data-lucide="printer" class="w-4 h-4"></i> Imprimir
            </a>
            <a href="{{ url('/coordenacao/escola/escola_inf') }}" class="bg-white hover:bg-[#f8faf9] text-[#5c706b] border border-[#e3e8e6] font-medium px-4 py-2 rounded-full flex items-center gap-2 transition-all text-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Card de Perfil da Escola -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-8 shadow-2xs flex flex-col items-center justify-center text-center gap-6">
        <!-- Logotipo da Escola -->
        <div class="w-32 h-32 rounded-2xl bg-[#f8faf9] p-3 border border-[#e3e8e6] flex items-center justify-center">
            <img src="{{ asset('imgs/logoempresa_transparente.png') }}" alt="Logo Escola" class="max-h-full max-w-full object-contain">
        </div>

        <div class="flex flex-col gap-2">
            <h2 class="text-2xl font-bold text-[#0a241e]">{{ $escolas->NomeEscola ?? 'Nome da Instituição' }}</h2>
            <p class="text-sm text-[#5c706b]">
                {{ $endereco->Rua ?? 'Endereço não informado' }}, {{ $endereco->Numero ?? '' }}<br>
                {{ $endereco->Bairro ?? '' }} - CEP: {{ $endereco->CEP ?? '' }}<br>
                {{ $endereco->Cidade ?? '' }} - {{ $endereco->Estado ?? '' }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full max-w-2xl border-t border-[#e3e8e6] pt-6">
            <div class="bg-[#f8faf9] p-4 rounded-xl border border-[#e3e8e6]/60 flex flex-col gap-1">
                <span class="text-xs text-[#5c706b] font-medium">Telefones</span>
                <span class="text-sm font-semibold text-[#0a241e]">{{ $endereco->Fone1 ?? '—' }} / {{ $endereco->Fone2 ?? '—' }}</span>
            </div>
            <div class="bg-[#f8faf9] p-4 rounded-xl border border-[#e3e8e6]/60 flex flex-col gap-1">
                <span class="text-xs text-[#5c706b] font-medium">CNPJ</span>
                <span class="text-sm font-semibold text-[#0a241e]">{{ $escolas->CNPJ ?? '—' }}</span>
            </div>
            <div class="bg-[#f8faf9] p-4 rounded-xl border border-[#e3e8e6]/60 flex flex-col gap-1">
                <span class="text-xs text-[#5c706b] font-medium">INEP</span>
                <span class="text-sm font-semibold text-[#0a241e]">{{ $escolas->NumeroInep ?? '—' }}</span>
            </div>
        </div>
        <!--Fim da Tabela-->
    </div>

</div> <!--Fim do caminho-din-->

@endsection
