@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
    Secretaria / Turmas Disciplinas 
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="pesquisaProfessor">Filtrar por professor: </label>
        <form class="form-search pesquisar" method="post" action="/maruge/public/coordenacao/turma_disciplina_pesq">
            {!! csrf_field() !!}
           <select class="form-control" name="idFuncionarios" >
                <option></option>
                @forelse($professores as $professore)  
                <option value="{{$professore->idFuncionarios}}">{{$professore->NomeFuncionario}}</option>
                @empty
                @endforelse 
            </select>
                 
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
       
        
        </form>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="NomeTurma">Filtrar por turma:</label>
        <form class="form-search pesquisar"method="post" action="/maruge/public/coordenacao/turma_disciplina_filtro">
           {!! csrf_field() !!}
            <select class="form-control" name="idTurmas" >
                <option></option>
                @forelse($turmas as $turma)  
                <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                @empty
                @endforelse 
            </select>
            <button class="btn-filtro" type="submit" > <i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-4">
    <div class="quant-alunos">
        <h2 class="quant-alunos">Vínculos Cadastrados: ({{$disciplinasDoProfessor->total()}})</h2>
    </div> 
</div>
<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>NOME DA TURMA</th>
                <th>DISCIPLINA</th>
                <th><center>PROFESSOR</center></th>
        <th><center>EXCLUIR</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($disciplinasDoProfessor as $disciplinaDoProfessor)  
        <center>
            <tr>
                <td>{{$disciplinaDoProfessor->NomeTurma}}</td>
                <td>{{$disciplinaDoProfessor->NomeDisciplina}}</td>
                <td><center>{{$disciplinaDoProfessor->NomeFuncionario}}</td>
                <td> <a href="{{url("/coordenacao/turma_disciplina/deletar/$disciplinaDoProfessor->idTurmas_Disciplinas")}}" ><center> <img src="{{url('imgs/icones/deletar.png')}}" alt="editar"</center></td>
                </tr>
                @empty
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Desculpe ! </strong> Mas nenhum vinculo foi encontrado. Para realizar uma nova vinculação <a href="/maruge/public/coordenacao/turma_disciplina_cad" class="alert-link"> Clique aqui.</a>
                </div>
                <tr>
                    <td colspan="500"> Nenhum vinculo encontrado !</td>
                </tr>
                @endforelse
                </table> 
                <div>{!! $disciplinasDoProfessor->render()!!} </div>

                </div>
                </div> <!--Fim do caminho-din-->
                @endsection