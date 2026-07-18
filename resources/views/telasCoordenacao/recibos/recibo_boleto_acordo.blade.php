<html>
    @forelse($cabecarios as $cabecario)
    
   <header>   
        <title>{{$titulo}} de  {{$cabecario->NomeAluno}}</title>
    </header>
    <body>
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{url('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{url('css/reset.css')}}">      
        <table class="cabecario_boleto">
            <tr>
                <td>
            <center><img src="{{url('imgs/mascote.png')}}"  width="100" height="80"alt="Colégio Carinho da Mamãe" title="Colégio Carinho da Mamãe"></center>
                </td>
                <td>
                   <b>ALUNO:</b>{{$cabecario->NomeAluno}}<b> <br> 
                       RA:</b>{{$cabecario->RA}}&nbsp;&nbsp;&nbsp;&nbsp; <b> Acordo:</b>{{$cabecario->Acordo}}
                       &nbsp;&nbsp;&nbsp;&nbsp; <b> Carteira:</b>{{$cabecario->Carteira}}&nbsp;&nbsp;&nbsp;&nbsp; <b> Valor do Acordo:</b> R$:&nbsp;    {{ number_format($cabecario->valor_Acordo,2,",",".")}}
                       <br>
                       <b>ANO LETIVO</b> -{{$cabecario->Ano_Letivo}}<b>&nbsp;&nbsp;&nbsp;&nbsp; Turma:</b> {{$cabecario->NomeTurma}} <b>&nbsp;&nbsp;&nbsp;&nbsp; Prestação:</b>  {{ number_format($cabecario->valor_prestacao,2,",",".")}} <br>
                    <div class="var1" style="margin-bottom:2px; height:auto">
           <br>
        <b>Responsável:</b>{{$cabecario->Responsavel}} &nbsp;&nbsp;&nbsp;&nbsp;<b>CPF:</b> {{$cabecario->CPFResponsavel}}  &nbsp;&nbsp; / &nbsp;&nbsp; <b>RG: </b>{{$cabecario->RGResponsavel}}<br />
        <b>Pai: </b>{{$cabecario->FonePai1}} / {{$cabecario->FonePai2}}  <br />
        <b>Mãe:</b>{{$cabecario->FoneMae1}} / {{$cabecario->FoneMae2}}
        
        <b></b>
        </div>
               </td>
         </tr>
         <tr>
            
             <td colspan="2">
                 <b> OBSERVAÇÃO:</b><br><br>
                  {{$cabecario->obs_do_acordo}}
                 <br><br>
             </td>
         </tr>
        </table>
         @empty
        @endforelse
        @forelse($boletos as $boleto)
    <table class="caixa_boleto" >
            <tr>
                <td>
                    {!!DNS1D::getBarcodeHTML("$boleto->codbarras", "C128",1,39)!!}
                    Cód. Barra - {{$boleto->codbarras}}
                </td>
                <td style="width:100px;">                 
                    TOTAL: &nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp; )<br>
                    PARCIAL: (&nbsp;&nbsp;&nbsp;&nbsp; )<br>
                </td>
                <td style="width:70px;"><div class="titulo">Vencimento:</div>
        <div class="var">{{$boleto->Data_venc}}</div></td>
               
                <td style="width:50px;"><div class="titulo">Parcela:</div>
      <div class="var">  {{$boleto->parcelas}}</div></td>
               
                <td style="width:70px;"><div class="titulo">Mês:</div>
      <div class="var"> {{$boleto->Meses}}</div></td>
         </tr>
        </table>
         @empty
        @endforelse
        </div>
    </body>
</html>