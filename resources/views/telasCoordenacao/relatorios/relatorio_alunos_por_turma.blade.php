@extends('layouts.app')

@section('content')

@php
    if (!isset($escolas) || empty($escolas) || !isset($escolas->first()->Rua)) {
        try { $escolas = \App\Models\modelCoordenacao\tb_escola::informacaoEscolar(); } catch (\Exception $e) { $escolas = collect(); }
    }
    if (!isset($turma)) {
        $idturmas = request()->route('id') ?? request()->query('idTurmas') ?? 1;
        try { $turma = \DB::table('tb_turmas')->where('idTurmas', $idturmas)->first(); } catch (\Exception $e) { $turma = null; }
    }
    if (!isset($alunos)) {
        $idTurmaSel = $turma->idTurmas ?? 1;
        try {
            $alunos = \App\Models\modelCoordenacao\tb_aluno::alunosPorTurma($idTurmaSel);
        } catch (\Exception $e) { $alunos = collect(); }
    }
@endphp

<!-- Estilos para Caixa de Diálogo de Impressão -->
<style>
    @media print {
        @page {
            size: A4 landscape;
            margin: 8mm;
        }
        body * {
            visibility: hidden !important;
        }
        #printable-report-area, #printable-report-area * {
            visibility: visible !important;
        }
        #printable-report-area {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            background: white !important;
            color: black !important;
        }
        .print-hidden {
            display: none !important;
        }
    }
</style>

<div class="flex flex-col gap-6 print-hidden">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Relatórios</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/relatorios/relatorio_alunos_turmas') }}" class="hover:text-[#008a4b] transition-colors">Alunos Por Turma</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">{{ $turma->NomeTurma ?? 'Turma' }}</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">RELATÓRIO DE ALUNOS DO {{ $turma->NomeTurma ?? '' }}</h1>
            <p class="text-sm text-[#5c706b]">Total de alunos: <strong>{{ count($alunos) }}</strong></p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ url('/coordenacao/relatorios/relatorio_alunos_turmas') }}" class="border border-[#e3e8e6] text-[#0a241e] hover:bg-[#f8faf9] font-medium px-5 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-2xs whitespace-nowrap">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Voltar às Turmas</span>
            </a>
            <button onclick="window.print()" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer whitespace-nowrap">
                <i data-lucide="printer" class="w-5 h-5"></i>
                <span>Imprimir Relatório</span>
            </button>
        </div>
    </div>

    <!-- Tabela Web com as 7 Colunas Exatas da Imagem 3 -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl overflow-hidden shadow-2xs">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase text-[#5c706b]">Nº MAC</th>
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase text-[#5c706b]">NOME ALUNO</th>
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase text-[#5c706b]">MÃE</th>
                        <th class="px-4 py-3.5 text-center text-xs font-bold uppercase text-[#5c706b]">WHATSAPP - MÃE</th>
                        <th class="px-4 py-3.5 text-left text-xs font-bold uppercase text-[#5c706b]">PAI</th>
                        <th class="px-4 py-3.5 text-center text-xs font-bold uppercase text-[#5c706b]">WHATSAPP - PAI</th>
                        <th class="px-4 py-3.5 text-center text-xs font-bold uppercase text-[#5c706b]">NASCIMENTO</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#e3e8e6]">
                    @forelse($alunos as $aluno)
                        <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                            <td class="px-4 py-3 text-xs text-[#5c706b] font-mono">{{ $aluno->NumeroMac ?? $aluno->RA ?? '-' }}</td>
                            <td class="px-4 py-3 text-xs font-bold text-[#0a241e] uppercase">{{ $aluno->NomeAluno }}</td>
                            <td class="px-4 py-3 text-xs text-[#0a241e] uppercase">{{ $aluno->NomeMae ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-xs text-[#5c706b]">{{ $aluno->FoneMae1 ?? '-' }}</td>
                            <td class="px-4 py-3 text-xs text-[#0a241e] uppercase">{{ $aluno->NomePai ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-xs text-[#5c706b]">{{ $aluno->FonePai1 ?? '-' }}</td>
                            <td class="px-4 py-3 text-center text-xs text-[#5c706b]">{{ $aluno->DataNascimento ? date('d/m/Y', strtotime($aluno->DataNascimento)) : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-[#5c706b]">
                                Nenhum aluno encontrado nesta turma.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Área de Impressão Exclusiva (Moldura da Escola + 7 Colunas da Imagem 3) -->
<div id="printable-report-area" class="hidden print:block">
    <!-- Moldura de Cabeçalho da Escola com Borda Dupla -->
    <div style="border: 3px double #333; padding: 12px 18px; text-align: center; margin-bottom: 18px; width: 94%; margin-left: auto; margin-right: auto; box-sizing: border-box;">
        <img src="{{ asset('imgs/logoempresa_transparente.png') }}" width="120" style="display: block; margin: 0 auto 8px auto;">
        @forelse($escolas as $escola)
            <div style="font-weight: bold; font-size: 12px; text-transform: uppercase; line-height: 1.4; color: #111;">
                {{ $escola->Rua ?? '' }} , {{ $escola->Numero ?? '' }}<br>
                {{ $escola->Bairro ?? '' }} - CEP:{{ $escola->CEP ?? '' }}<br>
                {{ $escola->Cidade ?? '' }} - {{ $escola->Estado ?? '' }}<br>
                Tel: {{ $escola->Fone1 ?? '' }} / {{ $escola->Fone2 ?? '' }}<br>
                E-mail:{{ $escola->EmailColegio ?? '' }}<br>
                CNPJ: {{ $escola->CNPJ ?? '' }}<br>
                INEP:{{ $escola->NumeroInep ?? '' }}
            </div>
        @empty
            <div style="font-weight: bold; font-size: 13px;">COLÉGIO MARUGE</div>
        @endforelse
    </div>

    <!-- Título e Contador Exatos da Imagem 3 -->
    <div style="text-align: center; margin-bottom: 16px;">
        <h2 style="font-size: 17px; font-weight: 800; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; color: #000;">
            RELATÓRIO DE ALUNOS DO {{ $turma->NomeTurma ?? '' }}
        </h2>
        <p style="font-size: 13px; font-weight: bold; margin: 3px 0 0 0; color: #111;">
            Total de alunos: {{ count($alunos) }}
        </p>
    </div>

    <!-- Tabela Impressa com as 7 Colunas Exatas da Imagem 3 -->
    <table style="width: 100%; border-collapse: collapse; font-size: 9.5px; font-family: Arial, sans-serif;">
        <thead>
            <tr style="border-bottom: 2px solid #000; background-color: #f8faf9;">
                <th style="padding: 6px 4px; text-align: left; font-weight: bold; width: 10%;">Nº MAC</th>
                <th style="padding: 6px 4px; text-align: left; font-weight: bold; width: 22%;">NOME ALUNO</th>
                <th style="padding: 6px 4px; text-align: left; font-weight: bold; width: 18%;">MÃE</th>
                <th style="padding: 6px 4px; text-align: center; font-weight: bold; width: 13%;">WHATSAPP - MÃE</th>
                <th style="padding: 6px 4px; text-align: left; font-weight: bold; width: 18%;">PAI</th>
                <th style="padding: 6px 4px; text-align: center; font-weight: bold; width: 13%;">WHATSAPP - PAI</th>
                <th style="padding: 6px 4px; text-align: center; font-weight: bold; width: 6%;">NASCIMENTO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alunos as $aluno)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 5px 4px; font-family: monospace;">{{ $aluno->NumeroMac ?? $aluno->RA ?? '-' }}</td>
                    <td style="padding: 5px 4px; font-weight: bold; text-transform: uppercase;">{{ $aluno->NomeAluno }}</td>
                    <td style="padding: 5px 4px; text-transform: uppercase;">{{ $aluno->NomeMae ?? '-' }}</td>
                    <td style="padding: 5px 4px; text-align: center;">{{ $aluno->FoneMae1 ?? '-' }}</td>
                    <td style="padding: 5px 4px; text-transform: uppercase;">{{ $aluno->NomePai ?? '-' }}</td>
                    <td style="padding: 5px 4px; text-align: center;">{{ $aluno->FonePai1 ?? '-' }}</td>
                    <td style="padding: 5px 4px; text-align: center;">{{ $aluno->DataNascimento ? date('d/m/Y', strtotime($aluno->DataNascimento)) : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection