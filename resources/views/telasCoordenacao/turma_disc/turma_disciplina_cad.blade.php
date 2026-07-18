@extends('telasCoordenacao.painel')  
@section('conteudo')

<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Lotação Professor / Disciplina / Turma'}}</h1>
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
            <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/turma_disciplina_cad" method="POST" send="/maruge/public/coordenacao/turma_disciplina_cad">
                          {!! csrf_field() !!}
                <!--PRIMEIRA LINHA REFERENTE A TODOS OS CAMPOS REFERENTE A TURMA-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="NomeTurma">Nome da Turma:</label>
                            {!! csrf_field() !!}
                            <select class="form-control" name="idTurmas" >
                                <option></option>
                                @forelse($turmas as $turma)  
                                <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                @empty
                                @endforelse 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="NomeDisciplina">Nome da Disciplina:</label>
                            {!! csrf_field() !!}
                            <select class="form-control" name="idDisciplinas" >
                                <option></option>
                                @forelse($disciplinas as $disciplina)  
                                <option value="{{$disciplina->idDisciplinas}}">{{$disciplina->NomeDisciplina}}</option>
                                @empty
                                @endforelse 
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="NomeFuncionario">Nome do Professor:</label>
                            {!! csrf_field() !!}
                            <select class="form-control" name="idFuncionarios" >
                                <option></option>
                                @forelse($professores as $professore)  
                                <option value="{{$professore->idFuncionarios}}">{{$professore->NomeFuncionario}}</option>
                                @empty
                                @endforelse 
                            </select>
                        </div>
                    </div>
                </div>
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
            @forelse($turmasLocadas as $turmaLocada)
                <table>
                <tr>
                    <td >{{$turmaLocada->NomeTurma}}</td>
                </tr>
                <tr>
                    <td>
                        <textarea disabled="disabled"name="textarea" cols="100" rows="4" >
@foreach($disciplinasDoProfessor as $disciplinaDoProfessor)
@if(($disciplinaDoProfessor->tb_turmas_idTurmas) == ($turmaLocada->idTurmas))
{{$disciplinaDoProfessor->NomeDisciplina}} - {{$disciplinaDoProfessor->NomeFuncionario}}
@endif
@endforeach       </textarea>                      
                        @empty
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Desculpe</strong> Nenhuma disciplina cadastrada, para cadastras<a href="/maruge/public/coordenacao/caddisciplina" class="alert-link"> Clique aqui.</a>
                        </div>
                    </td>
                </tr>
                @endforelse
                <div>{!! $turmasLocadas->render()!!} </div>
            </table>   
            
    </div>
</div> <!--Fim do caminho-din-->
@endsection