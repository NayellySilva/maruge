@extends('telasCoordenacao.painel')  
@section('conteudo')

<div class="titulo-endereco">
    <a href="#">
    Secretaria / Funcionários 
    </a>
</div>

<div class="col-md-5">
    <div class="form-group">
        <label for="NomeFuncionario">Localizar Funcionário:</label>
        <form class="form-search pesquisar" method="post" action="/maruge/public/coordenacao/funcionario_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Funcionario"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>

<div class="col-md-5">
    <div class="quant-alunos">
        <h2 class="quant-alunos">Funcionários Cadastrados: ({{$Funcionarios->total()}})</h2>
    </div> 
</div>

<div class="caminho-din">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>FUNCIONÁRIO</th>
                <th>FONE 1</th>
                <th><center>FONE 2</center></th>
        <th><center>FUNÇÃO</center></th>
        <th><center>VISUALIZAR</center></th>
        <th><center>EDITAR</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->

        @forelse($Funcionarios as $Funcionario)  
        <center>
            <tr>
                <td>{{$Funcionario->NomeFuncionario}}</td>
                <td>{{$Funcionario->Fone1}}</td>
                <td><center>{{$Funcionario->Fone2}}</td>
                <td><center>{{$Funcionario->Funcao}}</td>
                    <td> <a href="{{url("/coordenacao/funcionario_perfil/$Funcionario->idFuncionarios")}}" ><center> <img src="{{url('imgs/icones/visualizar.png')}}" alt="editar"</center></td>
                    <td> <a href="{{url("/coordenacao/funcionario_editar/$Funcionario->idFuncionarios")}}" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="editar"</center></td>
                    </tr>
                    @empty
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Desculpe ! </strong> Nenhum funcionario cadastrada, para cadastras<a href="/maruge/public/coordenacao/cadturma" class="alert-link"> Clique aqui.</a>
                    </div>
                    <tr>
                        <td colspan="500"> Nenhuma turma cadastrada !</td>
                    </tr>
                    @endforelse
                    </table> 
                    <div>{!! $Funcionarios->render()!!} </div>

                    </div>
                    </div> <!--Fim do caminho-din-->
                    @endsection