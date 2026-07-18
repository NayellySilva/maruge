<html> 
    <header>   
        <title> </title>
    </header>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style media="print">        .botao {            display: none;        }    </style>
    <button type="button"  value="Imprimir" onClick="window.print()" class="botao btn-imprimir"> Imprimir</button>
    <body >
        <!-- CSS compilada e minificada on-line do bootstrap-->
        <link href="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">       
        <!-- favicon-->
        <link rel="stylesheet" href="{{asset('imgs/favicon.png')}}">     
        <!-- Jquery Local-->
        <script src="{{asset('css/jquery-3.0.0.js')}}" ></script> 
        <div class="imprimir_conteudo">
           <br>
            <table>
                @forelse($boleto_unico as $boleto)  
                <tr>
                    <td>
                        <strong>ALUNO(A): {{$boleto->NomeAluno}}</strong> <br>
                        <strong>TURMA: {{$boleto->NomeTurma}}</strong><br>
                        <strong>MÊS: {{$boleto->Meses}}</strong><br>
                        <strong>ANO LETIVO:{{$boleto->Ano_Letivo}}</strong> <br>
                        <strong>VALOR DA MENSALIDADE:R$:{{$boleto->tb_turmas_Mensalidade}}</strong><br>
                        <strong>PARCELA:{{$boleto->parcelas}}</strong><br>
                        <strong>VALOR PAGO:R$:{{ number_format($boleto->ValorPGTO,2,",",".")}}</strong> <br>
                        <strong>FORMA DE PAGAMENTO:{{$boleto->forma_pgto}}</strong> <br>
                        <strong>STATUS DE PAGAMENTO:{{$boleto->status_pagamento}}</strong> <br>
                        <strong>VENCIMENTO: {{$boleto->Data_venc}}</strong><br>
                        <strong>PAGO EM:{{$boleto->data_pagamento}}</strong><br>
                        <strong>CARTEIRA:{{$boleto->Carteira}}</strong><br>
                        <strong>ACORDO: {{$boleto->Acordo}}</strong><br>
                        <strong>CODIGO DE BARRAS:{{$boleto->codbarras}}</strong><br><br><br>
                    @php 
                    $Falta = ($boleto->tb_turmas_Mensalidade - $boleto->ValorPGTO)
                    @endphp
                        <strong>DEDUÇÃO: R$:  {{ number_format($Falta,2,",",".")}}</strong> <br>
                        <br><br><br>
                        <strong>
                        OBS:----------------------<br>
                        <br>
                        <br>{{$boleto->obs_pagamento}}
                        
                        <br>
                        -------------------------------<br>
                <center> EDUCANDO COM AMOR E QUALIDADE! </center>
                        <br>
                        </strong>
                        <br>
                      </td>
                </tr>   
                @empty
                @endforelse 
            </table>     
    </body>
</html>