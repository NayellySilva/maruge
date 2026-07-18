@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Lançamento de Notas Educação Infantil'}}</h1>
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

        <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/notas_cad" method="POST" send="/maruge/public/coordenacao/notas_cad">
            {!! csrf_field() !!}
            <!--PRIMEIRA LINHA REFERENTE A TODOS OS CAMPOS REFERENTE A TURMA-->
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="NomeTurma">Aluno: {{$aluno->NomeAluno}}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="NomeTurma">RA: {{$matricula->RA}}</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="NomeTurma">Turma: {{$turma->NomeTurma}}</label>
                    </div>
                </div>
                <div class="caminho-din">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>CÓD. DISC. </th>
                                <th>DISCIPLINAS</th>
                                <th><center>1º BIMESTRE</center></th>
                        <th><center>SALVAR</center></th>
                        <th><center>EDITAR</center></th>
                        </tr>
                        </thead>   
                        <!-- Recebendo valores na vareavel disciplinas e passando para disciplina -->
                         @foreach($disciplinas as $key => $disciplina)
                        <center>
                            <tr>
                                <td> {{$disciplina->tb_disciplinas_idDisciplinas}} </td>
                                <td>{{$disciplina->NomeDisciplina}}</td>
                             
                                
                                <td><center><div class="col-md-4 col-md-offset-4" >                                  
                                <input type="text" name="AB1[{{$key}}]"placeholder="0.00"  class="form-control " >
                                <input type="hidden" name="tb_disciplinas_idDisciplinas[{{$key}}]" value="{{$disciplina->tb_disciplinas_idDisciplinas}}">
                                
                                <input type="hidden" name="tb_usuario_idUsuario[{{$key}}]" value="{{auth()->guard('guardLogin')->user()->idUsuario}}">
                                <input type="hidden" name="tb_turmas_idTurmas[{{$key}}]" value="{{$turma->idTurmas}}">
                                <input type="hidden" name="tb_aluno_idAluno[{{$key}}]" value="{{$aluno->idAluno}}">
                                <input type="hidden" name="RA[{{$key}}]" value="{{$matricula->RA}}">
                                    </div>  
                                        </center>
                                        </td>
                                        <td><center><button type="submit" class="btn btn-success">SALVAR</button></td>
                                            <td><center> <img src="{{url('imgs/icones/editar.png')}}" alt="editar"</center></td>
                                            </tr> 
                                           
                                            
                                           
                                            @endforeach
                                            </table> 
                                            </div>
                                            </div> <!--Fim do caminho-din-->
                                            <!--SEGUNDA LINHA REFERENTE AOS CAMPOS ( SALVA E LIMPA )-->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-success">SALVAR</button>
                                                        <button type="reset" class="btn btn-default">LIMPAR</button>
                                                    </div>
                                                </div>   
                                            </div>       
                                            </form> <!--Fim do formulario-->
                                            </div>
                                            </div> <!--Fim do caminho-din-->
                                            @endsection