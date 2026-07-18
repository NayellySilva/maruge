<html>
    <header>   
        <title>{{$titulo}}</title>
    </header>
    <body>
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{url('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{url('css/reset.css')}}">       
        @forelse($boletos as $boleto)
     <table border="0" cellpadding="0" cellspacing="0" id="tb_logo" class="">
    <tr>
        <td rowspan="2" valign="bottom" style="width:150px;" class="centralizando"><img src="{{url('imgs/mascote.png')}}"  width="80" height="40"alt="Colégio Carinho da Mamãe" title="Colégio Carinho da Mamãe"><br></td>
      <td align="center" valign="bottom" style="font-size: 12px; border:none;">Instituição</td>
      <td rowspan="2" align="right" valign="bottom" style="width:6px;"></td>
      <td rowspan="2" align="right" valign="bottom" style="font-size: 15px; font-weight:bold; width:445px;"><span class="ld">{{$boleto->codbarras}}</span></td>
      <td rowspan="2" align="right" valign="bottom" style="width:2px;"></td>
    </tr>
    <tr>
      <td id="td_banco">CCDM</td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb"> </td>
      <td style="width: 468px;"><div class="titulo">Local do Pagamento</div>
      <div class="var">Apenas no Colégio - ESCOLA DE EDUC. INF. E ENSINO FUND. CARINHO DA MAMÃE LTDA.</div></td>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">Vencimento</div>
        <div class="var">{{$boleto->Data_venc}}</div></td>
      <td class="td_2"> </td>
    </tr>
    <tr>
      <td class="td_7_sb"> </td>
      <td><div class="titulo">Aluno</div>
      <div class="var">{{$aluno->NomeAluno}}</div></td>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">Turma</div>
      <div class="var">{{$turma->NomeTurma}}</div></td>
      <td> </td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb"> </td>
      <td style="width:103px;"><div class="titulo">Data  Matrícula</div>
        <div class="var">{{$matricula->DataMatricula}}</div></td>
      <td class="td_7_cb"> </td>
      <td style="width:133px;"><div class="titulo">Ano Letivo</div>
      <div class="var">{{$boleto->Ano_Letivo}}</div></td>
      <td class="td_7_cb"> </td>
      <td style="width:62px;"><div class="titulo">Espécie Doc.</div>
      <div class="var">MS</div></td>
      <td class="td_7_cb"> </td>
      <td style="width:34px;"><div class="titulo">Acordo</div>
      <div class="var">{{$boleto->Acordo}}</div></td>
      <td class="td_7_cb"> </td>
      <td style="width:103px;"><div class="titulo">Dígito verificador</div>
      <div class="var">{{$boleto->Digito_verificador}}</div></td>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">Número da Matrícula</div>
      <div class="var">{{$boleto->RA}}</div></td>
      <td class="td_2"> </td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td class="td_7_sb"> </td>
      <td style="width:118px;"><div class="titulo">Situação do Aluno</div>
      <div class="var"> {{$matricula->SituacaoAluno}} </div></td>
      <td class="td_7_cb"> </td>
      <td style="width:55px;"><div class="titulo">Carteira</div>
      <div class="var"> {{$boleto->Carteira}}</div></td>
      <td class="td_7_cb"> </td>
      <td style="width:55px;"><div class="titulo">Espécie</div>
      <div class="var">R$</div></td>
      <td class="td_7_cb"> </td>
      <td style="width:104px;"><div class="titulo">Quantidade</div>
      <div class="var">  {{$boleto->parcelas}}</div></td>
      <td class="td_7_cb"> </td>
      <td style="width:103px;"><div class="titulo">Mês</div>
      <div class="var"> {{$boleto->Meses}}</div></td>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">Valor do Documento</div>
      <div class="var">{{$boleto->ValorPGTO}}</div></td>
      <td class="td_2"> </td>
    </tr>
  </table>
  <table class="tabelas" style="width:666px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td rowspan="5" class="td_7_sb"> </td>
      <td rowspan="5" valign="top"><div class="titulo" style="margin-bottom:5px;">Observações:</div>
        <div class="var">Juros/Mora ao Dia : R$ 1,00 após {{$boleto->Data_venc}}<br />
        Multa de 5,00 após 1 dia(s) do vencimento.</div>
          
          <br>
          
        <div class="titulo">Responsável</div>
        <div class="var" style="margin-bottom:2px; height:auto">Nome do Responsável: {{$pais->Responsavel}} <br />
        Telefones para contato Pai: {{$pais->FonePai1}} / {{$pais->FoneMae2}}  <br />
        Telefones para contato Mãe: {{$pais->FoneMae1}} / {{$pais->FoneMae2}} <br />
         <br />
         {!!DNS1D::getBarcodeHTML("$boleto->codbarras", "C128",1,39)!!}
        </div>
         
    </td>
      
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">(-) Desconto / Abatimento</div>
      <div class="var"> </div></td>
      <td class="td_2"> </td>
    </tr>
      <tr>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">(-) Outras Deduções</div>
      <div class="var"> </div></td>
      <td class="td_2"> </td>
    </tr>
    <tr>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">(+) Multa / Mora</div>
      <div class="var"> </div></td>
      <td class="td_2"> </td>
      
    </tr>
      <tr>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">(+) Outros Acréscimos</div>
      <div class="var"> </div></td>
      <td class="td_2"> </td>
    </tr>
    <tr>
      <td class="td_7_cb"> </td>
      <td class="direito"><div class="titulo">(=) Valor Cobrado</div>
      <div class="var"> </div></td>
      <td class="td_2"></td>
    </tr>

  </table>
        <br>
        <br>  <!--   
  <table class="tabelas" style="width:666px; height:65px; border-left:solid; border-left-width:2px; border-left-color:#000000;" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="td_7_sb"> </td>
      <td valign="top"><div class="titulo">Responsável</div>
        <div class="var" style="margin-bottom:2px; height:auto">Nome do Responsável: {{$pais->Responsavel}} <br />
        Telefones para contato Pai: {{$pais->FonePai1}} / {{$pais->FoneMae2}}  <br />
        Telefones para contato Mãe: {{$pais->FoneMae1}} / {{$pais->FoneMae2}}
        </div>
        </td>
      <td class="td_7_sb"> </td>
      <td class="direito" valign="top"><div class="titulo">CPF / RG</div>
          <div class="var" style="text-align:left;">CPF: {{$pais->CPFResponsavel}} <br>
         RG: {{$pais->RGResponsavel}}
          </div></td>
      <td class="td_2"> </td>
    </tr>
  </table>                    
  <table style="width:666px; border-top:solid; border-top-width:1px; border-top-color:#000000" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td >
          {!!DNS1D::getBarcodeHTML("$boleto->codbarras", "C128",1.5,40)!!}
          <br>
      </td>
      </tr>
  </table> 
  -->
        @empty
        @endforelse
        </div>
    </body>
</html>