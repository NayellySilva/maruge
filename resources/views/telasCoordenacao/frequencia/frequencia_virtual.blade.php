@extends('layouts.app')

@section('content')

@php
    // Garantir que as variáveis essenciais estejam declaradas com fallback seguro
    $turma = $turma ?? null;
    $Alunos = $Alunos ?? collect();
    $ano = $ano ?? date('Y');
    $inf_dia = $inf_dia ?? date('d/m/Y');
    $titulo = $titulo ?? 'Frequência Virtual';
@endphp

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/frequencia/frequencias') }}" class="hover:text-[#008a4b] transition-colors">Frequência</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Frequência Virtual</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Frequência Virtual</h1>
            <p class="text-sm text-[#5c706b]">Turma: <strong>{{ $turma->NomeTurma ?? 'Turma' }}</strong></p>
        </div>
    </div>

    <!-- Card Principal com o Formulário de Chamada -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-6">

        <!-- Mensagens de Alerta e Feedback -->
        <div class="preloader text-sm text-[#008a4b] font-medium" style="display: none">Enviando os dados...</div>
        <div class="alert alert-success msg-exito bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl text-sm" role="alert" style="display: none"></div>
        <div class="alert alert-warning msg-erro bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-xl text-sm" role="alert" style="display: none"></div>

        @if((isset($errors) ? count($errors) : 0) > 0)
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulário de Gravação da Frequência -->
        <form action="{{ url('/coordenacao/frequencia_cad') }}" method="POST" class="flex flex-col gap-6">
            @csrf

            <!-- Seleção da Data (Dia e Mês) -->
            <div class="flex flex-wrap gap-4 items-center bg-[#f8faf9] p-4 rounded-xl border border-[#e3e8e6]">
                <!-- Seleção do Dia -->
                <div class="flex flex-col gap-1.5 w-32">
                    <label for="dia" class="text-sm font-medium text-[#0a241e]">Dia:</label>
                    <div class="relative w-full">
                        <select
                            name="dia"
                            id="dia"
                            class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                        >
                            <option value="">Selecione</option>
                            @for($d = 1; $d <= 31; $d++)
                                @php $diaStr = str_pad($d, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $diaStr }}" {{ date('d') == $diaStr ? 'selected' : '' }}>{{ $diaStr }}</option>
                            @endfor
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"></i>
                    </div>
                </div>

                <!-- Seleção do Mês -->
                <div class="flex flex-col gap-1.5 w-32">
                    <label for="mes" class="text-sm font-medium text-[#0a241e]">Mês:</label>
                    <div class="relative w-full">
                        <select
                            name="mes"
                            id="mes"
                            class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                        >
                            <option value="">Selecione</option>
                            @for($m = 1; $m <= 12; $m++)
                                @php $mesStr = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                                <option value="{{ $mesStr }}" {{ date('m') == $mesStr ? 'selected' : '' }}>{{ $mesStr }}</option>
                            @endfor
                        </select>
                        <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <!-- Tabela de Alunos com Opções de Presença/Falta -->
            <div class="border border-[#e3e8e6] rounded-xl overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <tr>
                            <th class="px-5 py-3 font-semibold text-[#5c706b]">RA</th>
                            <th class="px-5 py-3 font-semibold text-[#5c706b]">Nome do Aluno</th>
                            <th class="px-5 py-3 font-semibold text-[#5c706b] text-center">Presença / Situação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e3e8e6]">
                        @forelse($Alunos as $key => $Aluno)
                            <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                                <td class="px-5 py-3 text-[#5c706b] font-medium">{{ $Aluno->RA }}</td>
                                <td class="px-5 py-3 text-[#0a241e] font-semibold">{{ $Aluno->NomeAluno }}</td>
                                <td class="px-5 py-3 text-center">
                                    <!-- Campos Ocultos com Dados do Aluno -->
                                    <input type="hidden" name="ano[{{$key}}]" value="{{ $ano }}">
                                    <input type="hidden" name="RA[{{$key}}]" value="{{ $Aluno->RA }}">
                                    <input type="hidden" name="tb_aluno_idAluno[{{$key}}]" value="{{ $Aluno->idAluno }}">
                                    <input type="hidden" name="tb_turmas_idTurmas[{{$key}}]" value="{{ $turma->idTurmas ?? '' }}">
                                    <input type="hidden" name="inf_dia[{{$key}}]" value="{{ $inf_dia }}">

                                    <!-- Seleção de Situação (Presente, Justificado, Falta) -->
                                    <div class="inline-flex gap-4 items-center">
                                        <!-- Opção PRESENTE -->
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer text-xs font-medium text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200 hover:bg-emerald-100 transition-all">
                                            <input type="radio" name="situacao[{{$key}}]" value="PRESENTE" checked class="accent-emerald-600">
                                            <span>PRESENTE</span>
                                        </label>

                                        <!-- Opção JUSTIFICADO -->
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer text-xs font-medium text-amber-700 bg-amber-50 px-3 py-1.5 rounded-lg border border-amber-200 hover:bg-amber-100 transition-all">
                                            <input type="radio" name="situacao[{{$key}}]" value="JUSTIFICADO" class="accent-amber-600">
                                            <span>JUSTIFICADO</span>
                                        </label>

                                        <!-- Opção FALTA -->
                                        <label class="inline-flex items-center gap-1.5 cursor-pointer text-xs font-medium text-red-700 bg-red-50 px-3 py-1.5 rounded-lg border border-red-200 hover:bg-red-100 transition-all">
                                            <input type="radio" name="situacao[{{$key}}]" value="FALTA" class="accent-red-600">
                                            <span>FALTA</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-10 text-center text-sm text-[#95aba5]">
                                    Nenhum aluno encontrado para esta turma.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Botões de Ação -->
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>SALVAR FREQUÊNCIA</span>
                </button>
                <a href="{{ url('/coordenacao/frequencia/frequencias') }}" class="bg-white hover:bg-[#f8faf9] text-[#5c706b] border border-[#e3e8e6] font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Voltar</span>
                </a>
            </div>
        </form>

    </div>

</div>

@endsection