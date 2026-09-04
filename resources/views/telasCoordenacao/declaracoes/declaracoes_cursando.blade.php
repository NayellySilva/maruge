<!-- Nota: Para a correta impressão/geração de PDF, este documento não deve utilizar as seções do painel principal -->
<html>
    <head>
        <title>{{$titulo}}</title>
        <style media="print">
            .botao {
                display: none;
            }
        </style>
        <!-- CSS Personalizado para o Painel -->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS para Reset de Estilos -->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">
    </head>
    <body>
        <!-- Botão de impressão (ocultado automaticamente no modo de impressão) -->
        <button type="button" value="Imprimir" onClick="window.print()" class="botao btn-imprimir"> Imprimir</button>

        <div class="imprimir_conteudo">
            <!-- Timbre e Dados da Instituição de Ensino -->
            <table class="timbre">
                <tr>
                    <td>
                        <img src="{{url('imgs/logoempresa_transparente.png')}}" width="160" height="160"><br>
                        <!-- Percorrendo os dados da escola cadastrada -->
                        @forelse($escolas as $escola)
                            {{$escola->Rua}} , {{$escola->Numero}}<br>
                            {{$escola->Bairro}} - CEP:{{$escola->CEP}}<br>
                            {{$escola->Cidade}} - {{$escola->Estado}}<br>
                            Tel: {{$escola->Fone1}} / {{$escola->Fone2}}<br>
                            E-mail:{{$escola->EmailColegio}}<br>
                            CNPJ: {{$escola->CNPJ}}<br>
                            INEP:{{$escola->NumeroInep}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            Portaria CME Nº 020/2024 // CEE - Resolução nº: 524/2026<br>
                    </td>
                </tr>
            </table>

            <!-- Título e Texto Principal da Declaração -->
            <div class="declaracao-titulo"> DECLARAÇÃO </div>
            <div class="declaracao">
                <p>Declaramos para os devidos fins que, <strong>{{$aluno->NomeAluno}}</strong>, está devidamente matriculado (a) nesse estabelecimento de ensino, sob o número de matrícula, <strong>{{ $aluno->NumeroMac ?? $matricula->RA }}</strong>, cursando o <strong>{{$turma->NomeTurma}}</strong>.</p>
            </div>

            <!-- Informações de Filiação e Data -->
            <p class="filiacao-titulo">Filiação:</p>
            <p class="filiacao">
                <strong>{{$pais->NomePai}}</strong><br />
                <strong>{{$pais->NomeMae}}</strong>
            </p>
            <p class="declaracao-data">
                {{$escola->Cidade}}, {{$dia}}.
            </p>
            @empty
            @endforelse
        </div>
    </body>
</html>