@extends('layouts.app')  
@section('content')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{ $titulo ?? 'Transferir Aluno' }}</h1>
</div> 
<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
    <div class="formularios">    
        @if((isset($errors) ? count($errors) : 0)>0)
        @foreach($errors->all() as $error)
        {{$error}}
        @endforeach
        @endif
        <form class="form form-search form-Nu formularios" action="/coordenacao/aluno_transferir/{{$aluno->idAluno}}" method="POST">
                  <div class="row"> 
                        <!--PRIMEIRA LINHA REPRESENTANDO TODOS OS CAMPOS NECESSARIOS PARA CADASTRAR UM NOVO USUARIO-->
                                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="NomeUsuario">Nome do Aluno:</label>
                            <input  type="hidden" class="form-control" name="NomeAluno" value="{{$aluno->NomeAluno}}"> 
                            <input  class="form-control" name="NomeAluno" disabled="disabled" value="{{$aluno->NomeAluno}}">       
                        </div>
                    </div>
                      {!! csrf_field() !!}               
                    <div class="col-md-3">
                        <div class="form-group">
                               <label for="idTurma">Turma Atual:</label>
                                    <div class="select-wrapper">
    <select class="form-control maruge-select" name="Ultima_Turma">       
                                         <option value="{{ $aluno->NomeTurma ?? 'Turma Atual' }}">{{ $aluno->NomeTurma ?? 'Turma Atual' }}</option>
                                    </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
                        </div>
                    </div>             
                    <div class="col-md-3">
                        <div class="form-group">
                               <label for="idTurma">Transferir para a turma:</label>
                                    <div class="select-wrapper">
    <select class="form-control maruge-select" name="tb_turmas_idTurmas">
                                        <option></option>
                                        @forelse($turmas as $turma)  
                                        <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                        @empty
                                        @endforelse 
                                       
                                    </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="SituacaoAluno ">Situação:</label>
                                    <div class="select-wrapper">
    <select class="form-control maruge-select" name="SituacaoAluno">
                                     <option> INATIVO </option>
                                    </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
                        </div>
                    </div>
                   <div class="col-md-2">
                                <div class="form-group">
                                    <label for="DataNascimento">Data de Saída:</label>
                                    <input type="text" name="Saida"  id="DataSaida" class="form-control">
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
    </div>
</div> <!--Fim do caminho-din-->
@endsection