@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
        Financeiro / Recebimentos 
    </a>
</div>




<div class="caminho-din">


    <h4> <label for="SituacaoAluno">LOCALIZAR TÍTULO:</label></h4>
    <form  method="POST" action="/maruge/public/coordenacao/financeiro_pesq">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">  
                    <input type="texto" name="codbarras" placeholder="Por favor! Informe o código de Barras ou RA do aluno!" required="required"  class="form-control" >
                    {!! csrf_field() !!} 
                </div>     
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <button type="submit" class="btn btn-success pesquisar "> <i class="fa fa-search" aria-hidden="true"></i> BUSCAR</button> &nbsp&nbsp
                    <button type="reset" class="btn btn-default">LIMPAR</button>
                </div>     
            </div>
        </div>
    </form> 
    <br>
    <div class="linha"></div>
    <br>
    <style>
        td, table, th{
            border: 0px solid black;
            width: 80em;
            padding: 5px;
            text-align: center;

        }

        #box{
            height: 480px;
            overflow: auto;
        }
        #wrapper_body{
            /*
            border: 2px dashed blue;
            */
        }
    </style>

<!--  <table class="table table-hover"> -->
    <table>

     <!-- Recebendo valores na vareavel escolas e passando para escola<table  class="table table-striped table-bordered" style="width:97%"  >-->
    </table> 
    @forelse($Aluno as $Aluno)
    <div class="col-lg-2">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <strong> ALUNO</strong>  
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <center> <img src="{{asset('imgs/aluno.jpg')}}"><br>
                        <b> {{$Aluno->NomeAluno}}</b> <br><br>
                        <b>NASCIMENTO: </b>  {{$Aluno->DataNascimento}}<br><br>
                        <b>TURMA: </b>  {{$Aluno->NomeTurma}}<br><br>
                        <b>PAI: </b>  {{$Aluno->NomePai}}<br><br>
                        <b>MAE: </b>  {{$Aluno->NomeMae}}<br><br>
                    </center>
                    <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>    
        <!-- /.panel -->
    </div>
    @empty
    @endforelse 
    <div id="box">
        <table  class="table financeiro_tabela_receber"  >
            <thead>
                <tr>
                    <th >Mês</th>
                    <th >Código de Barras</th>
                    <th >Parcela</th>
                    <th >Ano</th>
                    <th >Valor</th>
                    <th >Carteira</th>
                    <th >Acordo</th>
                    <th >Vencimento</th>
                    <th >Pago em</th>
                    <th >Situação</th>
                    <th >Obs.</th>
                    <th >Baixar</th>
                    <th >2º Via</th>
                </tr>
            </thead> 
            <tbody>
                @forelse($Boleto as $Boleto)
                <tr>
                    <td >{{$Boleto->Meses}}</td>
                    <td >{{$Boleto->codbarras}}</td>
                    <td >{{$Boleto->parcelas}}</td>
                    <td >{{$Boleto->Ano_Letivo}}</td>
                    @if(($Boleto->Carteira == "1"))
                    <td >  {{ number_format($Boleto->tb_turmas_Mensalidade,2,",",".")}} </td>
                    @else               
                    <td class="danger">  {{ number_format($Boleto->valor_prestacao,2,",",".")}} </td>
                    @endif
                    @if(($Boleto->Carteira == "1"))
                    <td >  {{$Boleto->Carteira}} </td>
                    @else               
                    <td class="danger">  {{$Boleto->Carteira}} </td>
                    @endif
                    @if(($Boleto->Acordo == "N"))
                    <td>{{$Boleto->Acordo}}</td>
                    @else               
                    <td class="danger">  {{$Boleto->Acordo}} </td>
                    @endif
                    <td >{{$Boleto->Data_venc}}</td>
                    @if(($Boleto->data_pagamento != ""))
                    <td >{{$Boleto->data_pagamento}}</td>
                    @else               
                    <td><center><b>-</b></center></td> 
            @endif

            <!-- INDICADOR DE SITUAÇÃO DE PAGAMENTO-->
            @if(($Boleto->status_pagamento == "ABERTO"))
            <td><div class="btn btn-primary" >{{$Boleto->status_pagamento}}</div></td>     
            @elseif (($Boleto->status_pagamento == "PAGO"))
            <td><div class="btn btn-success" >{{$Boleto->status_pagamento}}</div></td> 
            @else               
            <td><div class="btn btn-warning" >{{$Boleto->status_pagamento}}</div></td> 
            @endif
            <!-- MODAL QUE É UM INDICADOR SE HÁ OU NÃO OBSERVAÇÕES DOBRE O PAGAMENTO-->
            @if(($Boleto->obs_pagamento == ""))
            <td>
                <i class="fas fa-info-circle tamanhoIconeInformacao"></i>                 
            </td>
            @else               
            <td> 
            <center>
                <a href="#">  
                    <i class="fas fa-info-circle tamanhoIconeInformacaoAtencao" data-toggle="modal" data-target="#obs_pagamento"
                       data-whatever_obs_pagamento="{{$Boleto->obs_pagamento}}"
                       data-whatever_meses="{{$Boleto->Meses}}">
                    </i>
            </center>
            </a>
            </td>
            @endif
            
            
 
            
            
           <!-- OPÇÃO PARA O PAGAMENTO-->
            @if(($Boleto->status_pagamento == "ABERTO"))
            <td>aberto
                <a href="{{url("/coordenacao/financeiro_baixar_mensalidade/$Boleto->idcarne")}}" >
                 @if(($Boleto->Carteira == "1"))<!-- verificando se a carteira é de mensalidade ou acordo -->
                    <i class="fas fa-hand-holding-usd tamanhoIconePreto" 
                       data-whatever_nomealuno="{{$Boleto->NomeAluno}}"
                       data-whatever_nometurma="{{$Boleto->NomeTurma}}"
                       data-whatever_meses="{{$Boleto->Meses}}"
                       data-whatever_codbarras="{{$Boleto->codbarras}}"
                       data-whatever_parcelas="{{$Boleto->parcelas}}"
                       data-whatever_ano_Letivo="{{$Boleto->Ano_Letivo}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_mensalidade="{{ number_format($Boleto->tb_turmas_Mensalidade,2,",",".")}}"
                       data-whatever_carteira="{{$Boleto->Carteira}}"
                       data-whatever_acordo="{{$Boleto->Acordo}}"
                       data-whatever_data_venc="{{$Boleto->Data_venc}}"
                       data-whatever_data_pagamento="{{$data}}"
                       data-whatever_obs_pagamento="{{$Boleto->obs_pagamento}}"
                       data-whatever_status="{{$Boleto->status_pagamento}}"
                       data-whatever_idcarne="{{$Boleto->idcarne}}"
                       >
                    </i>  </a>
                
                
                
                
                    @else  
            <i class="fas fa-hand-holding-usd tamanhoIconePreto" 
                       data-whatever_nomealuno="{{$Boleto->NomeAluno}}"
                       data-whatever_nometurma="{{$Boleto->NomeTurma}}"
                       data-whatever_meses="{{$Boleto->Meses}}"
                       data-whatever_codbarras="{{$Boleto->codbarras}}"
                       data-whatever_parcelas="{{$Boleto->parcelas}}"
                       data-whatever_ano_Letivo="{{$Boleto->Ano_Letivo}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_valor_prestacao="{{$Boleto->valor_prestacao}}"
                       data-whatever_carteira="{{$Boleto->Carteira}}"
                       data-whatever_acordo="{{$Boleto->Acordo}}"
                       data-whatever_data_venc="{{$Boleto->Data_venc}}"
                       data-whatever_data_pagamento="{{$data}}"
                       data-whatever_obs_pagamento="{{$Boleto->obs_pagamento}}"
                       data-whatever_status="{{$Boleto->status_pagamento}}"
                       data-whatever_idcarne="{{$Boleto->idcarne}}"
                       >
                    </i>  
                    @endif
                </a></td>     
            @elseif (($Boleto->status_pagamento == "PAGO"))
            <td>
                <i class="fas fa-hand-holding-usd tamanhoIconeVerde"></i>  
            </td> 
            @else               
            <td>
            <a href="2aberto">
                    @if(($Boleto->Carteira == "1"))
                    <i class="fas fa-hand-holding-usd tamanhoIconePreto" data-toggle="modal" data-target="#pagamento"
                       data-whatever_nomealuno="{{$Boleto->NomeAluno}}"
                       data-whatever_nometurma="{{$Boleto->NomeTurma}}"
                       data-whatever_meses="{{$Boleto->Meses}}"
                       data-whatever_codbarras="{{$Boleto->codbarras}}"
                       data-whatever_parcelas="{{$Boleto->parcelas}}"
                       data-whatever_ano_Letivo="{{$Boleto->Ano_Letivo}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_porconta="{{$Boleto->ValorPGTO}}"
                       data-whatever_mensalidade="{{ number_format($Boleto->tb_turmas_Mensalidade,2,",",".")}}"
                       data-whatever_carteira="{{$Boleto->Carteira}}"
                       data-whatever_acordo="{{$Boleto->Acordo}}"
                       data-whatever_data_venc="{{$Boleto->Data_venc}}"
                       data-whatever_data_pagamento="{{$data}}"
                       data-whatever_obs_pagamento="{{$Boleto->obs_pagamento}}"
                       data-whatever_status="{{$Boleto->status_pagamento}}"
                       data-whatever_idcarne="{{$Boleto->idcarne}}"
                       >
                    </i>  
                </a>
                @else 
                <a href="acordo aberto">
                    <i class="fas fa-hand-holding-usd tamanhoIconePreto" data-toggle="modal" data-target="#pagamentoAcordo"
                       data-whatever_nomealuno="{{$Boleto->NomeAluno}}"
                       data-whatever_nometurma="{{$Boleto->NomeTurma}}"
                       data-whatever_meses="{{$Boleto->Meses}}"
                       data-whatever_codbarras="{{$Boleto->codbarras}}"
                       data-whatever_parcelas="{{$Boleto->parcelas}}"
                       data-whatever_ano_Letivo="{{$Boleto->Ano_Letivo}}"
                       data-whatever_valor_prestacao="{{$Boleto->valor_prestacao}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_porconta="{{$Boleto->ValorPGTO}}"
                       data-whatever_carteira="{{$Boleto->Carteira}}"
                       data-whatever_acordo="{{$Boleto->Acordo}}"
                       data-whatever_data_venc="{{$Boleto->Data_venc}}"
                       data-whatever_data_pagamento="{{$data}}"
                       data-whatever_obs_pagamento="{{$Boleto->obs_pagamento}}"
                       data-whatever_status="{{$Boleto->status_pagamento}}"
                       data-whatever_idcarne="{{$Boleto->idcarne}}"
                       >
                    </i>  
                </a>
                @endif
            </td>  
            @endif
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <!-- MODAL QUE TEM O INDICADOR SE HÁ OU NÃO OPÇÃO PARA IMPRIMIR A SEGUNDA VIA   data-toggle="modal" data-target="#2via"  -->
         @if(($Boleto->status_pagamento == "ABERTO"))
            <td>             -          </td>    
            @elseif (($Boleto->status_pagamento == "PAGO"))
            <td>
                @if(($Boleto->Carteira == "1"))
                <a href="#">
                    <i class=" fas fa-print tamanhoIconeAzulImprimir" data-toggle="modal" data-target="#2via"
                       data-whatever_nomealuno="{{$Boleto->NomeAluno}}"
                       data-whatever_nometurma="{{$Boleto->NomeTurma}}"
                       data-whatever_meses="{{$Boleto->Meses}}"
                       data-whatever_codbarras="{{$Boleto->codbarras}}"
                       data-whatever_parcelas="{{$Boleto->parcelas}}"
                       data-whatever_ano_Letivo="{{$Boleto->Ano_Letivo}}"
                       data-whatever_mensalidade="{{$Boleto->tb_turmas_Mensalidade}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_carteira="{{$Boleto->Carteira}}"
                       data-whatever_acordo="{{$Boleto->Acordo}}"
                       data-whatever_data_venc="{{$Boleto->Data_venc}}"
                       data-whatever_data_pagamento="{{$Boleto->data_pagamento}}"
                       data-whatever_obs_pagamento="{{$Boleto->obs_pagamento}}"
                       data-whatever_status="{{$Boleto->status_pagamento}}"
                       >
                    </i>  
                </a>
                @else 
                <a href="#">
                    <i class=" fas fa-print tamanhoIconeAzulImprimir" data-toggle="modal" data-target="#2viaAcordo"
                       data-whatever_nomealuno="{{$Boleto->NomeAluno}}"
                       data-whatever_nometurma="{{$Boleto->NomeTurma}}"
                       data-whatever_meses="{{$Boleto->Meses}}"
                       data-whatever_codbarras="{{$Boleto->codbarras}}"
                       data-whatever_parcelas="{{$Boleto->parcelas}}"
                       data-whatever_ano_Letivo="{{$Boleto->Ano_Letivo}}"
                       data-whatever_valor_prestacao="{{$Boleto->valor_prestacao}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_carteira="{{$Boleto->Carteira}}"
                       data-whatever_acordo="{{$Boleto->Acordo}}"
                       data-whatever_data_venc="{{$Boleto->Data_venc}}"
                       data-whatever_data_pagamento="{{$Boleto->data_pagamento}}"
                       data-whatever_obs_pagamento="{{$Boleto->obs_pagamento}}"
                       data-whatever_status="{{$Boleto->status_pagamento}}"
                       >
                    </i>  
                </a>
                @endif
            </td> 
            @else   
          <td>
                @if(($Boleto->Carteira == "1"))
                <a href="{{url("/coordenacao/recibo_mensalidade/$Boleto->idcarne")}}"target="_blank">
                    
                 
   
                    
                    
                    <i class=" fas fa-print tamanhoIconeAzulImprimir" 
                       data-whatever_nomealuno="{{$Boleto->NomeAluno}}"
                       data-whatever_nometurma="{{$Boleto->NomeTurma}}"
                       data-whatever_meses="{{$Boleto->Meses}}"
                       data-whatever_codbarras="{{$Boleto->codbarras}}"
                       data-whatever_parcelas="{{$Boleto->parcelas}}"
                       data-whatever_ano_Letivo="{{$Boleto->Ano_Letivo}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_mensalidade="{{$Boleto->tb_turmas_Mensalidade}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_carteira="{{$Boleto->Carteira}}"
                       data-whatever_acordo="{{$Boleto->Acordo}}"
                       data-whatever_data_venc="{{$Boleto->Data_venc}}"
                       data-whatever_data_pagamento="{{$Boleto->data_pagamento}}"
                       data-whatever_obs_pagamento="{{$Boleto->obs_pagamento}}"
                       data-whatever_status="{{$Boleto->status_pagamento}}"
                       >
                    </i>  
                    
                    
                    
                </a>
                @else 
                <a href="#">
                    <i class=" fas fa-print tamanhoIconeAzulImprimir" data-toggle="modal" data-target="#2viaAcordo"
                       data-whatever_nomealuno="{{$Boleto->NomeAluno}}"
                       data-whatever_nometurma="{{$Boleto->NomeTurma}}"
                       data-whatever_meses="{{$Boleto->Meses}}"
                       data-whatever_codbarras="{{$Boleto->codbarras}}"
                       data-whatever_parcelas="{{$Boleto->parcelas}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_ano_Letivo="{{$Boleto->Ano_Letivo}}"
                       data-whatever_valor_prestacao="{{$Boleto->valor_prestacao}}"
                       data-whatever_valorPGTO="{{$Boleto->ValorPGTO}}"
                       data-whatever_carteira="{{$Boleto->Carteira}}"
                       data-whatever_acordo="{{$Boleto->Acordo}}"
                       data-whatever_data_venc="{{$Boleto->Data_venc}}"
                       data-whatever_data_pagamento="{{$Boleto->data_pagamento}}"
                       data-whatever_obs_pagamento="{{$Boleto->obs_pagamento}}"
                       data-whatever_status="{{$Boleto->status_pagamento}}"
                       >
                    </i>  
                </a>
                @endif
            </td>  
            @endif
            </tr>
            @empty
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4> <strong>Desculpe ! </strong> Mas nenhum boleto foi localizado.</h4>
            </div>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
</div> <!--Fim do caminho-din-->

<!-- Para Mostrar as OBSERVAÇÕES REFERENE AO O MES EM QUESTÃO -->
<div class="modal fade" id="obs_pagamento" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header modal_Observacoes-titulo ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal_Observacoes-titulo" id="meses"></h4>
            </div>
            <div class="modal-body"> 
                <div class="row ">
                    <div class="col-md-12">
                        <label>ATENÇÃO:  </label>   
                    </div>  
                </div> 
                <div class="row ">
                    <div class="col-md-12">
                        <label  id="obs_pagamento"></label>  
                    </div>  
                </div>  
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal que realiza o pagamento de carner -->               
<div class="modal fade" id="pagamento" tabindex="-2" role="dialog" aria-labelledby="exampleModalScrollableTitle">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content ">
            <div class="modal-header modal_Observacoes-titulo ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal_Observacoes-titulo">ATENÇÃO CONFIRMAR DADOS DE PAGAMENTO:</h4>
            </div>
            <div class="modal-body"> 
                <form class="alteraNota form formularios" action="/maruge/public/coordenacao/financeiro_baixar" method="POST" send="/maruge/public/coordenacao/financeiro_baixar">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}
                    <input type="hidden" name="NomeAluno"id="nomealuno">
                    <input type="hidden" name="NomeTurma" id="nometurma">
                    <input type="hidden" name="Meses" id="meses">
                    <input type="hidden" name="codbarras" id="codbarras" >
                    <input type="hidden" name="parcelas" id="parcelas">
                    <input type="hidden" name="Ano_Letivo" id="ano_letivo">
                    <input type="hidden" name="Mensalidade" id="mensalidade">
                    <input type="hidden" name="ValorPGTO" id="valorpgto">
                    <input type="hidden" name="porconta" id="porconta">
                    <input type="hidden" name="Carteira" id="carteira">
                   <input type="hidden" name="Acordo" id="acordo">
                    <input type="hidden" name="Data_venc" id="data_venc">
                    <input type="hidden" name="data_pagamento" id="data_pagamento">
                    <input type="hidden" name="idcarne" id="idcarne">
                    <div class="row ">
                        <dt class="frequencia-gabarito" id="nomealuno2"></dt><br>
                        <strong>PAGAMENTO MÊS DE:</strong> <small class="ConfirmacaoSimples"id="meses2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <strong>MENSALIDADE:</strong> R$ <small class="ConfirmacaoSimples"id="mensalidade2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <strong>ACORDO:</strong> <small class="ConfirmacaoSimples"id="acordo2"></small>
                        <br><br> <strong>TURMA:</strong> <small class="ConfirmacaoSimples"id="nometurma2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>PARCELA:</strong> <small class="ConfirmacaoSimples"id="parcelas2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>ANO:</strong> <small class="ConfirmacaoSimples"id="ano_letivo2"></small><br><br>
                        <strong>AUTENTICAÇÃO:</strong> <small class="ConfirmacaoSimples"id="codbarras2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>CARTEIRA:</strong> <small class="ConfirmacaoSimples"id="carteira2"></small>
                        <br><br><strong>VENCIMENTO:</strong> <small class="ConfirmacaoSimples"id="data_venc2"></small> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>DATA:</strong> <small class="ConfirmacaoSimples"id="data_pagamento2"></small>
                        <strong>VALOR JÁ PAGO:    </strong> R$ <small class="ConfirmacaoSimples" id="valorpgto2"></small> <br><br>
                       
                        
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">STATUS DE PAGAMENTO:</label>
                                <small class="ConfirmacaoSimples"id="status"></small>
                            </div>
                            
                            
                           </div>
                        
                        <br>
                        <br>
                   
                        
                        <div class="row">
                            
                            <div class="col-md-2">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">PAGAMENTO:</label> 
                            </div>
                            <div class="col-md-3">
                                <select class="custom-select my-1 mr-sm-2 form-control" name="status_pagamento">
                                    <option></option>
                                    <option value="PAGO">PAGO</option>
                                    <option value="PARCIAL">PARCIAL</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label  for="ValorPGTO">RECEBIDO:</label>
                            </div>                          
                            <div class="col-md-3">
                                <input type="text" name="ValorPGTO" placeholder="R$ 0,00" id="ValorPGTORecebimento" class="form-control" >
                            </div>
                        </div>
                   
                        
                        
                        
                        <br>
                        <br>
                     
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">OBSERVAÇÕES:</label>
                            <textarea class="form-control" rows="8" type="text" name="obs_pagamento" maxlength="2000" id="obs_pagamento"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" class="btn btn-success"   >BAIXAR</button>
                        </div>
                    </div>
    
                </form>
            </div>
        </div>          
    </div>
</div>
<!-- Modal que realiza o pagamento de Acordo -->               
<div class="modal fade" id="pagamentoAcordo" tabindex="-2" role="dialog" aria-labelledby="exampleModalScrollableTitle">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content ">
            <div class="modal-header modal_Observacoes-titulo ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal_Observacoes-titulo">ATENÇÃO CONFIRMAR DADOS DE PAGAMENTO:</h4>
            </div>
            <div class="modal-body"> 
                <form class="alteraNota form formularios" action="/maruge/public/coordenacao/financeiro_baixar_acordo" method="POST" send="/maruge/public/coordenacao/financeiro_baixar_acordo">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}
                    <input type="hidden" name="NomeAluno"id="nomealuno">
                    <input type="hidden" name="NomeTurma" id="nometurma">
                    <input type="hidden" name="Meses" id="meses">
                    <input type="hidden" name="codbarras" id="codbarras" >
                    <input type="hidden" name="parcelas" id="parcelas">
                    <input type="hidden" name="Ano_Letivo" id="ano_letivo">
                    <input type="hidden" name="valor_prestacao" id="valor_prestacao">
                    <input type="hidden" name="ValorPGTO" id="valorpgto">
                    <input type="hidden" name="porconta" id="porconta">
                    <input type="hidden" name="Carteira" id="carteira">
                    <input type="hidden" name="Acordo" id="acordo">
                    <input type="hidden" name="Data_venc" id="data_venc">
                    <input type="hidden" name="data_pagamento" id="data_pagamento">
                    <input type="hidden" name="idcarne" id="idcarne">
                    <div class="row ">
                        <dt class="frequencia-gabarito" id="nomealuno2"></dt><br>
                        <strong>&nbsp&nbsp; PAGAMENTO MÊS DE:</strong> <small class="ConfirmacaoSimples"id="meses2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <strong>PARCELA:</strong> R$ <small class="ConfirmacaoSimples"id="valor_prestacao2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <strong>ACORDO:</strong> <small class="ConfirmacaoSimples"id="acordo2"></small>
                        <br><br> <strong>&nbsp&nbsp;TURMA:</strong> <small class="ConfirmacaoSimples"id="nometurma2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>PARCELA:</strong> <small class="ConfirmacaoSimples"id="parcelas2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>ANO:</strong> <small class="ConfirmacaoSimples"id="ano_letivo2"></small><br><br>
                        <strong>&nbsp&nbsp;AUTENTICAÇÃO:</strong> <small class="ConfirmacaoSimples"id="codbarras2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>CARTEIRA:</strong> <small class="ConfirmacaoSimples"id="carteira2"></small>
                        <br><br><strong>&nbsp&nbsp;VENCIMENTO:</strong> <small class="ConfirmacaoSimples"id="data_venc2"></small> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>DATA:</strong> <small class="ConfirmacaoSimples"id="data_pagamento2"></small>
                        <strong>VALOR JÁ PAGO:</strong> R$ <small class="ConfirmacaoSimples" id="valorpgto2"></small> <br>  <br>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">&nbsp&nbsp;STATUS DE PAGAMENTO:</label>
                                <small class="ConfirmacaoSimples"id="status"></small>
                                
                                             </div>
                           
                        </div><br>  <br>
                        <div class="row">
                            <div class="col-md-2">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">&nbsp&nbsp;PAGAMENTO:</label> 
                            </div>
                             <div class="col-md-3">
                                <select class="custom-select my-1 mr-sm-2 form-control" name="status_pagamento">
                                    <option></option>
                                    <option value="PAGO">PAGO</option>
                                    <option value="PARCIAL">PARCIAL</option>
                                </select>
                            </div>
                          <div class="col-md-2">
                                <label  for="ValorPGTO">RECEBIDO:</label>
                            </div>                          
                            <div class="col-md-3">
                                <input type="text" name="ValorPGTO" placeholder="R$ 0,00" id="ValorPGTORecebimentoAcordo" class="form-control" >
                            </div>
                        </div>
                        
                        
                        <br><br>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">&nbsp&nbsp;OBSERVAÇÕES:</label>
                            <textarea class="form-control" rows="8" type="text" name="obs_pagamento" maxlength="2000" id="obs_pagamento"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" class="btn btn-success"   >BAIXAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>          
    </div>
</div>


<!-- MODAL 2º VIA-->
<div class="modal fade" id="2via" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header modal_Observacoes-titulo ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal_Observacoes-titulo">2º VIA COMPROVANTE DE PAGAMENTO:</h4>
            </div>
            <div class="modal-body"> 
                <form class="alteraNota form formularios" action="/maruge/public/coordenacao/financeiro_comprovante" method="POST" send="/maruge/public/coordenacao/financeiro_comprovante">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}
                    <input type="hidden" name="NomeAluno"id="nomealuno">
                    <input type="hidden" name="NomeTurma" id="nometurma">
                    <input type="hidden" name="Meses" id="meses">
                    <input type="hidden" name="codbarras" id="codbarras" >
                    <input type="hidden" name="parcelas" id="parcelas">
                    <input type="hidden" name="Ano_Letivo" id="ano_letivo">
                    <input type="hidden" name="ValorPGTO" id="valorpgto">
                    <input type="hidden" name="Mensalidade" id="mensalidade">
                    <input type="hidden" name="Carteira" id="carteira">
                    <input type="hidden" name="Acordo" id="acordo">
                    <input type="hidden" name="Data_venc" id="data_venc">
                    <input type="hidden" name="data_pagamento" id="data_pagamento">
                    <input type="hidden" name="obs_pagamento" id="obs_pagamento">
                    <input type="hidden" name="status_pagamento" id="status">
                    <div class="row ">
                        <dt class="frequencia-gabarito" id="nomealuno2"></dt><br>
                        <strong>&nbsp&nbsp;PAGAMENTO MÊS DE:</strong> <small class="ConfirmacaoSimples"id="meses2"><input type="hidden" name="ACORDO" id="acordo"></small> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <strong>MENSALIDADE:</strong> R$ <small class="ConfirmacaoSimples"id="mensalidade2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <strong>ACORDO:</strong> <small class="ConfirmacaoSimples"id="acordo2"></small>
                        <br><br>
                        <strong>&nbsp&nbsp;TURMA:</strong> <small class="ConfirmacaoSimples"id="nometurma2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>PARCELA:</strong> <small class="ConfirmacaoSimples"id="parcelas2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>ANO:</strong> <small class="ConfirmacaoSimples"id="ano_letivo2"></small><br><br>
                        <strong>&nbsp&nbsp;AUTENTICAÇÃO:</strong> <small class="ConfirmacaoSimples"id="codbarras2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>CARTEIRA:</strong> <small class="ConfirmacaoSimples"id="carteira2"></small>
                        <br><br>
                        <strong>VENCIMENTO:</strong> <small class="ConfirmacaoSimples"id="data_venc2"></small> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;        
                        <strong>DATA:</strong> <small class="ConfirmacaoSimples"id="data_pagamento2"></small> <br><br>
                        <strong>&nbsp&nbsp;STATUS DE PAGAMENTO:</strong><small class="ConfirmacaoSimples" id="status2"></small> &nbsp&nbsp&nbsp&nbsp; 
                        <strong>VALOR JÁ PAGO:</strong> R$ <small class="ConfirmacaoSimples" id="valorpgto2"></small> <br><br>
                        <strong>&nbsp&nbsp;OBS.:</strong> <small class="ConfirmacaoSimples"id="obs_pagamento2"></small><br>  <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" class="btn btn-primary">IMPRIMIR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2º VIA Acordo-->
<div class="modal fade" id="2viaAcordo" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header modal_Observacoes-titulo ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal_Observacoes-titulo">2º VIA COMPROVANTE DE PAGAMENTO:</h4>
            </div>
            <div class="modal-body"> 
                <form class="alteraNota form formularios" action="/maruge/public/coordenacao/financeiro_comprovante_acordo" method="POST" send="/maruge/public/coordenacao/financeiro_comprovante_acordo">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}
                    <input type="hidden" name="NomeAluno"id="nomealuno">
                    <input type="hidden" name="NomeTurma" id="nometurma">
                    <input type="hidden" name="Meses" id="meses">
                    <input type="hidden" name="codbarras" id="codbarras" >
                    <input type="hidden" name="parcelas" id="parcelas">
                    <input type="hidden" name="Ano_Letivo" id="ano_letivo">
                    <input type="hidden" name="ValorPGTO" id="valorpgto">
                    <input type="hidden" name="valor_prestacao" id="valor_prestacao">
                    <input type="hidden" name="Carteira" id="carteira">
                    <input type="hidden" name="Acordo" id="acordo">
                    <input type="hidden" name="Data_venc" id="data_venc">
                    <input type="hidden" name="data_pagamento" id="data_pagamento">
                    <input type="hidden" name="obs_pagamento" id="obs_pagamento">
                    <input type="hidden" name="status_pagamento" id="status">
                    <div class="row ">
                        <dt class="frequencia-gabarito" id="nomealuno2"></dt><br>
                        <strong> &nbsp&nbsp; PAGAMENTO MÊS DE:</strong> <small class="ConfirmacaoSimples"id="meses2"><input type="hidden" name="ACORDO" id="acordo"></small> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <strong> VALOR DA PARCELA:</strong> R$ <small class="ConfirmacaoSimples"id="valor_prestacao2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<br><br>
                        <strong>&nbsp&nbsp; TURMA:</strong> <small class="ConfirmacaoSimples"id="nometurma2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>&nbsp&nbsp; PARCELA:</strong> <small class="ConfirmacaoSimples"id="parcelas2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>&nbsp&nbsp; ANO:</strong> <small class="ConfirmacaoSimples"id="ano_letivo2"></small><br><br>
                        <strong>&nbsp&nbsp; AUTENTICAÇÃO:</strong> <small class="ConfirmacaoSimples"id="codbarras2"></small>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;
                        <strong>&nbsp&nbsp; CARTEIRA:</strong> <small class="ConfirmacaoSimples"id="carteira2"></small>
                        <br><br>
                        <strong>&nbsp&nbsp; VENCIMENTO:</strong> <small class="ConfirmacaoSimples"id="data_venc2"></small> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;        
                        <strong>&nbsp&nbsp; DATA:</strong> <small class="ConfirmacaoSimples"id="data_pagamento2"></small> 
                        <strong> ACORDO:</strong> <small class="ConfirmacaoSimples"id="acordo2"></small><br><br>
                        <strong>&nbsp&nbsp; STATUS DE PAGAMENTO:</strong><small class="ConfirmacaoSimples" id="status2"></small> &nbsp&nbsp&nbsp&nbsp; 
                        <strong>&nbsp&nbsp; VALOR JÁ PAGO:</strong> R$ <small class="ConfirmacaoSimples" id="valorpgto2"></small> <br><br>
                        <strong>&nbsp&nbsp;OBS.:</strong> <small class="ConfirmacaoSimples"id="obs_pagamento2"></small><br>  <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                            <button type="submit" class="btn btn-primary">IMPRIMIR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

