@extends('layouts.app')  
@section('content')
<div class="titulo-endereco">
    <a href="#">
    Secretaria / Recibos e Carnês 
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="Localizar aluno">Localizar aluno:</label>
        <form class="form-search pesquisar" method="post" action="/coordenacao/recibo_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Aluno"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="NomeTurma">Filtrar por turma:</label>
        <form class="form-search pesquisar"method="post" action="/coordenacao/recibo_filtro">
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
        <h2 class="quant-alunos">Alunos Cadastrados: ({{$Alunos->count()}})</h2>
    </div> 
</div>
<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
         <th>NOME DO ALUNO</th>
        <th>RA</th>
        <th><center>TURMA</center></th>
        <th><center>B. ACORDO</center></th>
        <th><center>B. MENS.</center></th>
        <th><center>CARNÊ</center></th>
        <th><center>MATRÍCULA</center></th>
        <th><center>ACOMPANHAMENTO</center></th>
    <th><center>CONTRATO</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($Alunos as $Aluno)  
        <center>
            <tr>
                <td>{{$Aluno->NomeAluno}}</td>
                <td>{{$Aluno->RA}}</td>
                <td><center>{{$Aluno->NomeTurma}}</td>      
                <td> <a href="{{url("/coordenacao/boleto_acordo/$Aluno->idAluno")}}" target="_blank"  ><center> <img src="{{url('imgs/icones/imprimir.png')}}"  alt="carnê"</center></td>
                <td> <a href="{{url("/coordenacao/boleto/$Aluno->idAluno")}}" target="_blank"  ><center> <img src="{{url('imgs/icones/imprimir.png')}}"  alt="carnê"</center></td>
                <td> <a href="{{url("/coordenacao/carner/$Aluno->idAluno")}}" target="_blank" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="editar"</center></td>
                <td> <a href="{{url("/coordenacao/recibo_matricula/$Aluno->idAluno")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="editar"</center></td>
                <td> <a href="{{url("/coordenacao/recibo_acompanhamento/$Aluno->idAluno")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="Recibo_acompanhamento"</center></td>
                <td> <a href="{{url("/coordenacao/contrato/$Aluno->idAluno")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="Contrato"</center></td>
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
                <div></div>

                </div>
                </div> <!--Fim do caminho-din-->
                @endsection