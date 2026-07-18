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
                        <strong>ALUNO(A):</strong> {{$boleto->NomeAluno}} <br>
                        <strong>TURMA:</strong> {{$boleto->NomeTurma}}<br>
                        <strong>MÊS:</strong> {{$boleto->Meses}}<br>
                        <strong>ANO LETIVO:</strong> {{$boleto->Ano_Letivo}}<br>
                        <strong>VALOR DA MENSALIDADE:R$:</strong>{{$boleto->tb_turmas_Mensalidade}}<br>
                        <strong>PARCELA:</strong>{{$boleto->parcelas}}<br>
                        <strong>VALOR PAGO:</strong>R$:{{ number_format($boleto->ValorPGTO,2,",",".")}} <br>
                        <strong>STATUS DE PAGAMENTO:</strong> {{$boleto->status_pagamento}}<br>
                        <strong>VENCIMENTO:</strong> {{$boleto->Data_venc}}<br>
                        <strong>PAGO EM:</strong>{{$boleto->data_pagamento}}<br>
                        <strong>CARTEIRA:</strong>{{$boleto->Carteira}}<br>
                        <strong>ACORDO:</strong> {{$boleto->Acordo}}<br>
                        <strong>CODIGO DE BARRAS:</strong>{{$boleto->codbarras}}<br><br><br>
                         
                        
                        
                    @php 
                    $Falta = ($boleto->tb_turmas_Mensalidade - $boleto->ValorPGTO)
                    @endphp
                        
                        
                        
                        <strong>DEDUÇÃO:</strong> R$:  {{ number_format($Falta,2,",",".")}} <br>
                        
                      
                        
                        

                        
                        
                        
                        <br><br><br>
                        OBS:----------------------<br>
                        <br>
                        <br>{{$boleto->obs_pagamento}}
                        
                        <br>
                        -------------------------------<br>
                <center> EDUCANDO COM AMOR E QUALIDADE! </center>
                        <br>
                        
                        <br>
                      </td>
                </tr>   
                @empty
                @endforelse 
            </table>


       
    </body>
</html>