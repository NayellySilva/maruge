@extends('telasDocente.painel')  
@section('conteudo')
<div class="col-md-4">
    <div class="quant-alunos">                           
        <h2 class="quant-alunos">Lista de Alunos por Turma</h2>
    </div> 
</div>
<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>CÓD</th>
                <th>NOME TURMA</th>
                <th><center>RELATÓRIO</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($turmas as $turma ) 
        <center>
            <tr>
                <td>{{$turma->idTurmas}}</td>
                <td>{{$turma->NomeTurma}}</td>
                <td> <a href="{{url("/docente/relatorio_alunos_turmas/$turma->idTurmas")}}"><center> <img src="{{asset('imgs/icones/imprimir.png')}}" alt="vizualizar alunos de turma"</center></td>
            </tr>
            @empty
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Desculpe ! </strong> Nenhuma turma cadastrada.
            </div>
            <tr>
                <td colspan="500"> Nenhuma turma cadastrada !</td>
            </tr>
            @endforelse
    </table> 
 
</div>
</div> <!--Fim do caminho-din-->
@endsection