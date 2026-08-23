@extends('layouts.app')

@section('content')

@php
    try {
        $escolas = $escolas ?? \DB::table('tb_dados_escola')->get();
        if ($escolas->isEmpty()) {
            $escolas = \DB::table('tb_escola')->get();
        }
    } catch (\Exception $e) {
        $escolas = collect();
    }
@endphp

<!-- Titulo e Endereco da Pagina -->
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Escola</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Dados da Escola</h1>
            <p class="text-sm text-[#5c706b]">Escolas Cadastradas: ({{ $escolas->count() }})</p>
        </div>

        <!-- Botão Nova Escola -->
        <a href="{{ url('/coordenacao/escola_cad') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-5 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-2xs text-sm">
            <i data-lucide="plus" class="w-4 h-4"></i> Cadastrar Escola
        </a>
    </div>

    <!-- Tabela de Escolas Cadastradas -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">CÓD</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Nome Escola</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Endereço</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Visualizar</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Editar</th>
                        <th class="px-4 py-4 text-center text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Imprimir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    <!-- Recebendo valores na vareavel escolas e passando para escola-->
                    @forelse($escolas as $escola)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $escola->idEscola ?? $escola->id ?? 1 }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-[#0a241e]">{{ $escola->NomeEscola }}</td>
                            <td class="px-6 py-4 text-sm text-[#5c706b]">{{ $escola->Rua }}, {{ $escola->Numero }}</td>

                            <!-- Visualizar -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/escola_perfil/' . ($escola->idEscola ?? $escola->id ?? 1)) }}"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Visualizar Perfil">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Editar -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/escola_editar/' . ($escola->idEscola ?? $escola->id ?? 1)) }}"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Editar Escola">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                            </td>

                            <!-- Imprimir -->
                            <td class="px-4 py-4 text-sm text-center">
                                <a href="{{ url('/coordenacao/escola_impressao/' . ($escola->idEscola ?? $escola->id ?? 1)) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center p-2 rounded-lg text-[#5c706b] hover:text-[#008a4b] hover:bg-[#ecfdf5] transition-all"
                                   title="Imprimir Relatório da Escola">
                                    <i data-lucide="printer" class="w-4 h-4"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                        <i data-lucide="school" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-sm text-[#0a241e] font-medium">Nenhuma escola cadastrada</p>
                                    <a href="{{ url('/coordenacao/escola_cad') }}" class="text-xs text-[#008a4b] hover:underline font-semibold">
                                        Clique aqui para cadastrar a primeira escola
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div> <!--Fim do caminho-din-->

@endsection
