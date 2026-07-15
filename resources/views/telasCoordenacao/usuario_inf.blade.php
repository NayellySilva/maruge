@extends('layouts.app')  
@section('content')
<div class="titulo-endereco">
    <a href="#">
    Secretaria / Usuários 
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="localizarusuario">Localizar usuário:</label>
        <form class="form-search pesquisar" method="post" action="/maruge/public/coordenacao/usuario_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Usuário"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-4">
    <div class="quant-alunos">
        <h2 class="quant-alunos">Usuários Cadastrados: ({{$Usuarios->total()}})</h2>
    </div> 
</div>
<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>NOME DO USUÁRIO</th>
                <th>NIVEL</th>
                <th><center>SITUAÇÃO</center></th>
        
        <th><center>EDITAR</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($Usuarios as $Usuario)  
        <center>
            <tr>
                <td>{{$Usuario->NomeFuncionario}}</td>
                <td>{{$Usuario->Nivel}}</td>
                
                
                  @if($Usuario->Situacao != "INATIVO" )
                  <td> <center> <img src="{{url('imgs/icones/ativo.png')}}" </td>
                  @else
                  <td> <center> <img src="{{url('imgs/icones/inativo.png')}}" </td>
                  @endif    
                
                
                
                <td> <a href="{{url("/coordenacao/usuario_editar/$Usuario->idUsuario")}}" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="editar"</center></td>
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
                <div>{!!$Usuarios->render()!!} </div>
                </div>
                </div> <!--Fim do caminho-din-->
                @endsection