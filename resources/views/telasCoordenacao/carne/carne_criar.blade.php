@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo}}</h1>
</div> 
<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-advertencia" role="alert" style="display: none"></div> 
    <div class="alert alert-danger msg-erro" role="alert" style="display: none"></div> 
    <div class="formularios">    
        @if(count($errors)>0)
        @foreach($errors->all()as $error)
        {{$error}}
        @endforeach
        @endif
            <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/criarcarne" method="POST" send="/maruge/public/coordenacao/criarcarne">
         <div class="cadForm" > </div>
                        <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (NOME DO ALUNO, SEXO, DATANASCIMENTO, MAC, SITUAÇÃO )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="NomeAluno">Nome do Aluno:</label>
                                    <input type="hidden" name="Acordo"  class="form-control" value="N">
                                    <input type="hidden" name="Carteira"  class="form-control" value="1">
                                    <input type="hidden" name="idAluno"  class="form-control" value="{{$aluno->idAluno or old('NomeAluno')}}">
                                    <input type="hidden" name="NomeAluno" placeholder="Nome do Aluno"  class="form-control" value="{{$aluno->NomeAluno or old('NomeAluno')}}">
                                    <input disabled="disabled" name="NomeAluno" placeholder="Nome do Aluno"  class="form-control" value="{{$aluno->NomeAluno or old('NomeAluno')}}">
                                </div>
                            </div>
                            <div class="col-md-2">       
                                <div class="form-group">
                                <label for="NomeTurma">Turma:</label>
                                <input type="hidden" name="NomeTurma" class="form-control" value="{{$turma->NomeTurma}}">
                                <input disabled="disabled" name="NomeTurma" class="form-control" value="{{$turma->NomeTurma}}">
                                   </div>
                            </div> 
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Data_venc">Melhor dia de Pagamento:</label>
                                    <select class="form-control" name="Data_venc" id="Data_venc">
                                       <!-- <option >{{$aluno->Data_venc or old('')}}</option>-->        
                                        <option> 10 </option>
                                    </select>
                                </div>
                            </div>
                            
                            
                            
                            <!--FECHANDO A PRIMEIRA LINHA-->
                        </div>
                        <!--SEGUNDA LINHA REFERENTE AOS CAMPOS (TURMA-ALUNO-REGISTRO-PASTA-FOTO)-->
                        <div class="row">
                            <div class="col-md-2">       
                                <div class="form-group">
                                    <label for="RA">RA:</label>
                                    <input type="hidden" name="RA"   class="form-control" value="{{$matricula->RA or old('RA')}}">
                                    <input disabled="disabled" name="RA"  class="form-control" value="{{$matricula->RA or old('RA')}}">
                                </div>
                            </div> 
                            <div class="col-md-2">       
                                <div class="form-group">
                                <label for="AnoLetivo">Ano Letivo:</label>
                                <input type="hidden" name="Ano Letivo"  class="form-control" value="{{$turma->AnoLetivo}}">
                                 <input disabled="disabled" name="Ano Letivo"  class="form-control" value="{{$turma->AnoLetivo}}">
                                </div>
                            </div>
                           <div class="col-md-2">       
                                <div class="form-group">
                                <label for="idTurma">Turma:</label>
                                <input type="hidden" name="idTurma"  class="form-control" value="{{$turma->idTurmas}}">
                                <input disabled="disabled" name="idTurma"  class="form-control" value="{{$turma->idTurmas}}">
                                </div>
                            </div> 
                          
                            
                            
                            
                <!--
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Mensalidade">Valor:</label>
                                    <input type="hidden" name="Mensalidade"  class="form-control" value="{{$Mensalidade}}">
                                    <input disabled="disabled" name="Mensalidade"  class="form-control" value="{{$Mensalidade}}">
                                </div>
                            </div>
                            
                    -->        
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Mensalidade">Valor:</label>
                                    <select class="form-control" name="Mensalidade" id="Data_venc">
                                              
                                       <option >{{$Mensalidade or old('Mensalidade')}}</option>
                                        <option> 1.150 </option>
                                        <option> 500,00 </option>
                                        <option> 950,00 </option>
                                        <option> 700,00 </option>
                                        
                                        
                                        
                                        
                                    </select>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            <!--FECHANDO A SEGUNDA LINHA-->                        
                        </div>
                        <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (NOME D OCARTORIO NUMERO LIVRO REISTRO)-->
                        <div class="row">
                        </div>
           <!--PARTE DO MESES)-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="MesesPGTO">Selecione todos os meses:</label> 
                            <input type="checkbox" id="cbgroup1_master" onchange="selecionando(this, 'tudo')">
                        </div>
                    </div>
                </div>
                <div class="linha"></div>
                <!--PRIMEIRA LINHA)-->
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox1" value="JANEIRO"> JANEIRO
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox2" value="FEVEREIRO"> FEVEREIRO
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox3" value="MARÇO"> MARÇO
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox4" value="ABRIL"> ABRIL
                        </div>
                    </div>
                </div>
                <!--Segunda Linha)-->
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox5" value="MAIO"> MAIO
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox6" value="JUNHO"> JUNHO
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox7" value="JULHO"> JULHO
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox8" value="AGOSTO"> AGOSTO
                        </div>
                    </div>
                </div>
                <!--Terceira Linha)-->
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox9" value="SETEMBRO"> SETEMBRO
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox10" value="OUTUBRO"> OUTUBRO
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox11" value="NOVEMBRO"> NOVEMBRO
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Meses[]" id="checkbox12" value="DEZEMBRO"> DEZEMBRO
                        </div>
                    </div>
                </div>
                <div class="linha">
                </div> 
                  <!--Quarta Linha)-->
                  <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <br>
                                    <button type="submit" class="btn btn-success"> GERAR CARNÊ</button>
                                </div>
                            </div>  
                                          <!--FECHANDO A quarta LINHA-->
                        </div> 
                    
                                    <!--fim botão que gerar carnêr Linha-->  
                        <!--*****************************************************************************
                        *********************************************************************************
                        FIM FORMULARIO DA GUIA NOVO CARNÊ
                        *********************************************************************************
                        *********************************************************************************
                        -->
</div>
                            <!--FECHANDO A QUINTA LINHA-->
                        </div>
                        <!--*****************************************************************************
                        *********************************************************************************
                        FIM FORMULARIO DA GUIA DADOS DOS PAIS
                        *********************************************************************************
                        *********************************************************************************
                        -->
                  {!! csrf_field() !!}
            </form> <!--Fim do formulario-->
    </div>
</div> <!--Fim do caminho-din-->
@endsection