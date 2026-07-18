@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
    Secretaria / Rematricular 
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="SituacaoAluno ">Localizar aluno:</label>
        <form class="form-search pesquisar" method="post" action="/maruge/public/coordenacao/aluno_pesq_rematricula">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Aluno"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>

<div class="col-md-4">
    <div class="quant-alunos">
        <h2 class="quant-alunos">Alunos Inativo: ({{$Alunos->total()}})</h2>
    </div> 
</div>
<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
        <th>RA</th>
        <th>NOME DO ALUNO</th>
        <th><center>ULTIMA TURMA</center></th>
        
        <th><center>ACESSO</center></th>
        <th><center>REMATRÍCULA</center></th>
        
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($Alunos as $Aluno)  
        <center>
            <tr>
                <td>{{$Aluno->RA}}</td>
                <td>{{$Aluno->NomeAluno}}</td>
                 <td><center>{{$Aluno->NomeTurma}}</td>
                  @if($Aluno->SituacaoAluno != "ATIVO" )
                  <td> <center> <img src="{{url('imgs/icones/inativo.png')}}" </td>
                  @else
                  <td> <center> <img src="{{url('imgs/icones/ativo.png')}}" </td>
                  @endif      
                <td> <a href="{{url("/coordenacao/aluno_editar/$Aluno->idAluno")}}" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="editar"</center></td>
                </tr>         
                @empty
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Desculpe ! </strong> Mas nenhuma aluno foi localizado com essas caracteristicas.
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