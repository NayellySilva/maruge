@extends('layouts.app')  
@section('content')
<div class="titulo-endereco">
    <a href="#">
    Carnês / Filtro por Turmas 
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="SituacaoAluno ">Localizar aluno:</label>
        <form class="form-search pesquisar" method="POST" action="/coordenacao/carne_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Aluno"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="NomeTurma">Filtrar por turma:</label>
        <form class="form-search pesquisar"method="POST" action="/coordenacao/carne_filtro">
           {!! csrf_field() !!}
            <div class="select-wrapper">
    <select class="form-control maruge-select" name="idTurmas" >
                <option></option>
                @forelse($turmas as $turma)  
                <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                @empty
                @endforelse 
            </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
            <button class="btn-filtro" type="submit" > <i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-4">
    <div class="quant-alunos">
        <h2 class="quant-alunos">Alunos Cadastrados: ({{$Alunos->total()}})</h2>
    </div> 
</div>
<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
         <th>NOME DO ALUNO</th>
        <th>RA</th>
        <th><center>TURMA</center></th>
        <th><center>GERAR CARNÊ</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($Alunos as $Aluno)  
        <center>
            <tr>
                <td>{{$Aluno->NomeAluno}}</td>
                <td>{{$Aluno->RA}}</td>
                <td><center>{{$Aluno->NomeTurma}}</td>
     
                <td> <a href="{{url("/coordenacao/criarcarne/$Aluno->idAluno")}}" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="editar"</center></td>
               
                </tr>         
                @empty
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Desculpe ! </strong> Mas nenhuma turma foi informada, por favor digite o nome do aluno ou selecione uma turma.
                </div>
                <tr>
                    <td colspan="500"> Nenhum alunos encontrado !</td>
                </tr>
                @endforelse
                </table> 
                <div>{!! $Alunos->render()!!} </div>

                </div>
                </div> <!--Fim do caminho-din-->
                @endsection