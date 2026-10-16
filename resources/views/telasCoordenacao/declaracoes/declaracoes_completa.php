@extends('layouts.app')
@section('content')

<!-- Bootstrap (apenas CDN, remova se preferir o local) -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
<!-- CSS Personalizado -->
<link rel="stylesheet" href="{{ asset('css/painel.css') }}">
<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

<x-estilo-impressao arquivo="declaracao" />

<button type="button" id="imprimir_conteudo" class="btn btn-imprimir">Imprimir</button>

<div class="imprimir_conteudo">

    <!-- TIMBRE -->
    <table class="timbre">
        <tr>
            <td style="width: 300px;">
                <img src="{{ \App\Support\LogoColegio::src() }}" class="logo-colegio-lg" alt="Logo da Empresa">
            </td>
            <td>
                @forelse($escolas as $escola)
                    <strong>{{ $escola->Rua }}, {{ $escola->Numero }}</strong><br>
                    {{ $escola->Bairro }} - CEP: {{ $escola->CEP }}<br>
                    {{ $escola->Cidade }} - {{ $escola->Estado }}<br>
                    Tel: {{ $escola->Fone1 }} / {{ $escola->Fone2 }}<br>
                    E-mail: {{ $escola->EmailColegio }}<br>
                    CNPJ: {{ $escola->CNPJ }}<br>
                    INEP: {{ $escola->NumeroInep }}<br>
                    Portaria CME Nº 020/2024 // CEE: 398/2022<br>
                @empty
                    Informações indisponíveis.
                @endforelse
            </td>
        </tr>
    </table>

    <div class="titulo-declaracao">DECLARAÇÃO</div>

    <!-- TEXTO PRINCIPAL -->
    <div>
        <p>
            Declaramos para os devidos fins que <strong>{{ $aluno->NomeAluno ?? 'NOME DO ALUNO' }}</strong>,
            inscrito(a) sob o número de matrícula <strong>{{ $matricula->RA ?? '' }}</strong>,
            aluno(a) desta Unidade Escolar no ano letivo de <strong>{{ date('Y') }}</strong>,
            e:
        </p>
    </div>

    <!-- OPÇÕES DE FINALIDADE -->
    <div class="caixa">
        <p>▢ Está cursando o ______________________________________________________________</p>
        <p>▢ Cursou creche (2 e 3 anos)</p>
        <p>▢ Cursou a pré-escola (  ) 4 anos / (  ) 5 anos</p>
        <p>▢ Concluiu o Ensino Fundamental 
            <span class="opcao">(   ) 1º Ano</span>
            <span class="opcao">(   ) 2º Ano</span>
            <span class="opcao">(   ) 3º Ano</span>
            <span class="opcao">(   ) 4º Ano</span>
            <span class="opcao">(   ) 5º Ano</span>
            <span class="opcao">(   ) 6º Ano</span></p>
        <p><span class="opcao">(   ) 7º Ano</span>
            <span class="opcao">(   ) 8º Ano</span>
            <span class="opcao">(   ) 9º Ano</span></p>
        <p>▢ Solicitou nesta data sua transferência para outra Unidade Escolar com direito a matricular-se no(a) _____________________________________________. A transferência será entregue no prazo de <strong>30 dias</strong>.</p>
    </div>

    <!-- CONSIDERAÇÃO -->
    <p><strong>Tendo sido considerado:</strong></p>
    <div class="caixa">
        <p>
            <span class="opcao">▢ Aprovado(a)</span>
            <span class="opcao">▢ Reprovado(a)</span>
            <span class="opcao">▢ Evadido</span>
            <span class="opcao">▢ Não se aplica</span>
        </p>
    </div>

    <!-- FREQUÊNCIA -->
    <p><strong>Com frequência:</strong></p>
    <div class="caixa">
        <p>
            <span class="opcao">▢ Superior a 75%</span>
            <span class="opcao">▢ Inferior a 75%</span>
            <span class="opcao">▢ Sem registro nesta escola</span>
            <span class="opcao">▢ Não se aplica</span>
        </p>
    </div>

    <!-- EFEITO -->
    <p><strong>Efeito desta declaração:</strong></p>
    <div class="caixa">
        <p>
            <span class="opcao">▢ Transferência.</span>
            <span class="opcao">▢ Bolsa Família.</span>
            <span class="opcao">▢ Carteira de Estudante.</span>
        </p>
        <p>▢ Outros: _______________________________________________________________________</p>
    </div>

    <!-- FILIAÇÃO -->
    <div class="caixa dados-aluno">
        <p><strong>Filiação:</strong></p>
        <p>Pai: <strong>{{ $pais->NomePai ?? '' }}</strong></p>
        <p>Mãe: <strong>{{ $pais->NomeMae ?? '' }}</strong></p>
        <p><strong>Data de Nascimento:</strong> {{ $aluno->DataNascimento ?? '' }}</p>
    </div>

    <!-- OBSERVAÇÕES -->
    <div class="caixa">
        <p><strong>Observações:</strong></p>
        <div class="linha-obs"></div>
        <div class="linha-obs"></div>
        <div class="linha-obs"></div>
    </div>

    <!-- RODAPÉ -->
    <div class="footer">
        <p>{{ $escolas->first()->Cidade ?? 'CIDADE' }}, {{ date('d/m/Y') }}.</p>
        <p>Esta declaração só será válida com assinatura e carimbo da escola e sem rasuras.</p>
    </div>

</div>

<script>
    document.getElementById('imprimir_conteudo').onclick = function() {
        this.style.display = 'none';
        window.print();
        setTimeout(function() {
            location.reload();
        }, 1000);
    };
</script>

@endsection<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

