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
            <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/criaracordo" method="POST" send="/maruge/public/coordenacao/criaracordo">
         <div class="cadForm" > </div>
                        <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (NOME DO ALUNO, SEXO, DATANASCIMENTO, MAC, SITUAÇÃO )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="NomeAluno">Nome do Aluno:</label>
                                    <input type="hidden" name="Acordo"  class="form-control" value="S">
                                    <input type="hidden" name="Carteira"  class="form-control" value="2">
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
                                         <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Data_venc">Melhor dia de Pagamento:</label>
                                    <select class="form-control" name="Data_venc" id="Data_venc">
                                        <option >{{$aluno->Data_venc or old('')}}</option>
                                        <option> 01 </option>
                                        <option> 02 </option>
                                        <option> 03 </option>
                                        <option> 04 </option>
                                        <option> 05 </option>
                                        <option> 06 </option>
                                        <option> 07 </option>
                                        <option> 08 </option>
                                        <option> 09 </option>
                                        <option> 10 </option>
                                        <option> 11 </option>
                                        <option> 12 </option>
                                        <option> 13 </option>
                                        <option> 14 </option>
                                        <option> 15 </option>
                                        <option> 16 </option>
                                        <option> 17 </option>
                                        <option> 18 </option>
                                        <option> 19 </option>
                                        <option> 20 </option>
                                        <option> 21 </option>
                                        <option> 22 </option>
                                        <option> 23 </option>
                                        <option> 24 </option>
                                        <option> 25 </option>
                                        <option> 26 </option>
                                        <option> 27 </option>
                                        <option> 28 </option>
                                        <option> 29 </option>
                                        <option> 30 </option>
                                        <option> 31 </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="valor_prestacao">Valor do Acordo:</label>
                                   <input type="text" name="valor_Acordo" placeholder="R$ 0,00"  class="form-control">

                                 <!--   <input name="Mensalidade"  class="form-control" value="{{ substr ($turma->Mensalidade ,0,3)}}"> -->
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
                          
                                           
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="valor_prestacao">Valor das prestações:</label>
                                   <input type="text" name="valor_prestacao" placeholder="R$ 0,00"  class="form-control">

                                 <!--   <input name="Mensalidade"  class="form-control" value="{{ substr ($turma->Mensalidade ,0,3)}}"> -->
                                </div>
                            </div>
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="quantidade_parcelas">Quant. Parcelas:</label>
                                    <select class="form-control" name="quantidade_parcelas" id="quantidade_parcelas">
                                        <option >{{$aluno->quantidade_parcelas or old('')}}</option>
                                        <option value="1"> 1 </option>
                                        <option value="2"> 2 </option>
                                        <option value="3"> 3 </option>
                                        <option value="4"> 4 </option>
                                        <option value="5"> 5 </option>
                                        <option value="6"> 6 </option>
                                        <option value="7"> 7 </option>
                                        <option value="8"> 8 </option>
                                        <option value="9"> 9 </option>
                                        <option value="10"> 10 </option>
                                        <option value="11"> 11 </option>
                                        <option value="12"> 12 </option>
                                        <option value="92"> 92 </option>
                                    </select>
                                </div>
                            </div>
                            
                            
  
                            
                            <!--FECHANDO A SEGUNDA LINHA-->                        
                        </div>
                        <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (NOME D OCARTORIO NUMERO LIVRO REISTRO)-->
                        <div class="row">
                            
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="obs_do_acordo" >Detalhes sobre o acordo:</label>
                                    <textarea  class="form-control ajuste" placeholder="Todas as informações sobre o acordo devem ser descritos neste campo." rows="10" type="text" name="obs_do_acordo" maxlength="30000"></textarea>

                                </div>
                            </div>
                            
                            
                        </div>
  
      
                  <!--Quarta Linha)-->
                  <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <br>
                                    <button type="submit" class="btn btn-success"> GERAR ACORDO</button>
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
                    
                        <!--*****************************************************************************
                        *********************************************************************************
                        FIM FORMULARIO DA GUIA DADOS DOS PAIS
                        *********************************************************************************
                        *********************************************************************************
                        -->
                  {!! csrf_field() !!}
            </form> <!--Fim do formulario-->
  
</div> <!--Fim do caminho-din-->
@endsection