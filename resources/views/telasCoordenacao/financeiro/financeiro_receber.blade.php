@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#"> Financeiro / Recebimentos     </a>
</div>

<div class="caminho-din">
        <h4> <label for="SituacaoAluno">LOCALIZAR TÍTULO:</label></h4>
                      
        
        
        
        <form  method="POST" action="/maruge/public/coordenacao/financeiro_pesq">
                    {!! csrf_field() !!}                      
            <div class="row">                        
                        <div class="col-md-4">
                            <div class="form-group">  
                                <label for="Código de Barras" > Código de Barras ou RA   </label>
                                    <input type="texto" name="codbarras" placeholder="Por favor! Informe o código de Barras ou RA do aluno!" required="required"  class="form-control" >
                            </div>     
                        </div> 
                
                        <!--
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Ano Letivo">Ano Letivo:</label>
                                    <select class="form-control" name="AnoLetivo" >
                                    <option></option>
                                    @forelse($AnosLetivos as $AnosLetivo)  
                                    <option value="{{$AnosLetivo->AnoLetivo}}">{{$AnosLetivo->AnoLetivo}}</option>
                                    @empty
                                    @endforelse 
                                    </select>
                            </div>
                        </div>
                
                -->
                
                <div class="col-md-3">
                            <div class="form-group">
                                <label for="Ano Letivo">Ano Letivo:</label>
                                    <select class="form-control" name="AnoLetivo" >
                                    
                                    <option>2022</option>
                                    <option>2023</option>
                       
                                    </select>
                            </div>
                        </div>
                
                        <div class="col-md-4">
                            <div class="form-group">
                                        <button type="submit" class="btn btn-success pesquisar "> <i class="fa fa-search" aria-hidden="true"></i> BUSCAR</button>&nbsp&nbsp
                                        <button type="reset" class="btn btn-default">LIMPAR</button>
                            </div>     
                        </div>
                
                
                
            </div>
        </form> 
        
        

        
        
        
           <br>
           <div class="linha"></div>
           <br>
           <!--Terceira linhas, APENAS UM AVISO DE ALERTA -->
           <div class="row">
               <div class="alert alert-info alert-dismissible" role="alert">
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                   <h4>  <strong>Por favor! </strong> Informe o código de Barras ou RA do aluno.<h4>
                           </div>
                           </div>
</div><!--Fim do caminho-din-->

                    @endsection