<!-- Bootstrap (apenas CDN, remova se preferir o local) -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
<!-- CSS Personalizado -->
<link rel="stylesheet" href="{{ asset('css/painel.css') }}">
<link rel="stylesheet" href="{{ asset('css/reset.css') }}">

<style>
    body {
        font-family: 'Times New Roman', serif;
        font-size: 12pt;
        margin: 0;
        padding: 0;
        background: #fff;
    }
    .timbre {
        width: 100%;
        max-width: 95%;
        table-layout: fixed;
        word-break: break-word;
    }
    .timbre td {
        vertical-align: center;
        padding: 10px 20px;
        text-align: center;
        font-size: 11pt;
        line-height: 1.3;
        word-break: break-word;
    }
    .timbre img {
        display: inline-block;
        margin-bottom: 0px;
    }
    .titulo-declaracao {
        text-align: center;
        font-size: 24pt;
        font-weight: bold;
        margin: 20px 0;
        text-transform: uppercase;
    }
    .caixa {
        border: 2px solid #000;
        padding: 4px 8px;
        margin-bottom: 20px;
        border-radius: 10px;
    }
    .caixa p {
        margin: 4px 0;
    }
    .opcao {
        margin-right: 20px;
    }
    .dados-aluno table {
        width: 100%;
        border-collapse: collapse;
    }
    .dados-aluno th,
    .dados-aluno td {
        border: 1px solid #000;
        padding: 8px;
    }
    .linha-obs {
        height: 22px;
        border-bottom: 1px solid #000;
        margin-bottom: 8px;
    }
    .footer {
        text-align: center;
        margin-top: 25px;
        font-size: 10pt;
    }
    .btn-imprimir {
        margin: 10px;
    }
    @media print {
        body * {
            visibility: hidden !important;
        }
        .imprimir_conteudo, .imprimir_conteudo * {
            visibility: visible !important;
        }
        .imprimir_conteudo {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: #fff;
            z-index: 9999;
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }
        .btn-imprimir {
            display: none !important;
        }
    }
</style>

<button type="button" id="imprimir_conteudo" class="btn btn-imprimir">Imprimir</button>

<div class="imprimir_conteudo">

    <!-- TIMBRE -->
    <table class="timbre">
        <tr>
            <td style="width: 300px;">
                <img src="{{ url('imgs/logoempresa_transparente.png') }}" width="200" height="200" alt="Logo da Empresa">
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
            inscrito(a) sob o número de matrícula <strong>{{ $aluno->NumeroMac ?? $matricula->RA ?? '' }}</strong>,
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
    <p><strong>Dados adicionais do(a) aluno(a):</strong></p>
    <div class="caixa dados-aluno">
        <p><strong>Data de Nascimento:</strong> {{ $aluno->DataNascimento ?? '' }}</p>
        <p><strong>Filiação:</strong></p>
        <p>{{ $pais->NomePai ?? '' }}</p>
        <p>{{ $pais->NomeMae ?? '' }}</p>
        
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