@extends('layouts.app')  
@section('content')
<div class="titulo-endereco">
    <a href="#">
        Secretaria / Alunos Pré-Matrículados
    </a>
</div>

<div class="col-md-5">
    <div class="quant-alunos">
        
        <h2 class="quant-alunos">Alunos Pré-Matrículados: ({{$Alunos->count()}})</h2>
    </div> 
</div>

<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>NOME DO ALUNO</th>
                <th>RA</th>
                <th><center>TURMA</center></th>
        <th><center>DATA</center></th>
        <th><center>EXCLUIR</center></th>
        <th><center>MATRÍCULAR</center></th>

        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel $Alunos e passando para $Aluno-->
        @forelse($Alunos as $Aluno)  
        <center>
            <tr>
                <td>{{$Aluno->NomeAluno}}</td>
                <td>{{$Aluno->RA}}</td>
                <td><center>{{$Aluno->NomeTurma}}</td>
                <td><center>{{$Aluno->data_reserva}}</td>
                <td><a href="{{url("/coordenacao/aluno_pre_matriculado_deletar/$Aluno->idReservas")}}" > <center> <img src="{{url('imgs/icones/deletar.png')}}" </td>
                        <td> <a href="{{url("/coordenacao/aluno_editar/$Aluno->idAluno")}}" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="editar"</center></td>
                        </tr>         
                        @empty
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Desculpe ! </strong> Mas nenhuma aluno foi encontrado.
                        </div>
                        <tr>
                            <td colspan="500"> Nenhum alunos encontrado !</td>
                        </tr>
                        @endforelse
                        </table> 
                        </div>
                        </div> <!--Fim do caminho-din-->
                        @endsection