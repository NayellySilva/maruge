@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Nova Aula'}}</h1>

</div> 
<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 

    <div class="formularios">    
        @if(count($errors)>0)
        @foreach($errors->all()as $error)
        {{$error}}
        @endforeach
        @endif

        @if(isset($aula))
        <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/aula_editar/{{$aula->idAula}}" method="POST">
            @else
            <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/aula_cad" method="POST" send="/maruge/public/coordenacao/aula_cad">
                @endif 
                {!! csrf_field() !!}
                <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (nome funcionário - cpf - rg - função )-->
                
                
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="Link da Aula">Aula:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                                </div>
                                <!--
                                <input type="text" name="aula" id="aula" class="form-control" placeholder="Link da Aula" value="{{old('aula')}}">
                          -->
                          <textarea  class="form-control ajuste" rows="1" type="text" name="aula">{{$aula->aula or old('')}}</textarea>
                                </div>
                        </div>

                        
                        
                        
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="data da Aula">Data:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                              
                                <input type="date" name="data_aula" class="form-control"  value="{{$aula->data_aula or old('')}}">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="idTurma">Turma:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </div>
                                <select class="form-control" name="tb_turmas_idTurmas">
                                    
                                    
                                    @if(isset($aula))
                                   
                                    
                                    <option></option>
                                    
                                    
                                    
                                    
                                    @forelse($turmas as $turma) 
                                    <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma or old('')}}</option>
                                    @empty
                                    @endforelse 
                                    <!--Fim do laço da turma para editar-->
                                    @else 
                                    <option></option>
                                    <!-- condição para cadastrar-->
                                    @forelse($turmas as $turma)  
                                    <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                    @empty
                                    @endforelse 
                                    
                                    <option></option>
                                 
                                    
                                   
                                    @endif
                                    
                                    
                                    
                                    
                                    
                                    
                                </select>
                                
                                
                                
                                
                       
                                
                                
                                
                                
                                
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Linha de Comentário -->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="ObsAula" >Comentário da Aula</label>
                            <textarea  class="form-control ajuste" rows="8" type="text" name="ObsAula" maxlength="1000">{{$aula->ObsAula or old('')}}</textarea>

                        </div>
                    </div>
                    <!-- LINHA REFERENTE AOS CAMPOS ( SALVA E LIMPA )-->

                    <div class="col-md-12">
                        <div class="form-group">
                            <br>
                            <button type="reset" class="btn btn-default"> LIMPAR</button> 
                            <button type="submit" class="btn btn-success"> SALVAR</button>

                        </div>
                    </div>   
                </div>


            </form> <!--Fim do formulario-->
    </div>
</div> <!--Fim do caminho-din-->
@endsection