@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
    Relatórios / Resultados
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="Localizar Turma">Localizar Turma:</label>
        <form class="form-search pesquisar" method="post" action="/maruge/public/coordenacao/resultados_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Turma"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="Filtrar Turma">Filtrar por Situação:</label>
        <form class="form-search pesquisar"method="post" action="/maruge/public/coordenacao/resultados_filtro">
            {!! csrf_field() !!}
            <select class="form-control" name="SituacaoTurma" >
                <option></option>

                <option>ATIVO</option>
                <option>INATIVO</option>

            </select>


            <button class="btn-filtro" type="submit" > <i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>

<div class="col-md-4">
    <div class="quant-alunos">                           
        <h2 class="quant-alunos">Turmas Cadastradas:  ({{$turmas->total()}})</h2>

    </div> 
</div>





<div class="caminho-din">

    <table class="table table-hover">
<thead>
        <tr>
        <th>CÓD</th>
        <th>NOME TURMA</th>
        <th><center>REC. PARCIAL</center></th>
        <th><center>REC. FINAL</center></th>
        <th><center>APRO./ 1º SEM.</center></th>
        <th><center>APRO./ 2º SEM. </center></th>
        
        </tr>
    </thead>  
        <!-- Recebendo valores na vareavel escolas e passando para escola-->

        @forelse($turmas as $turma ) 
        <center>
            <tr>
                <td>{{$turma->idTurmas}}</td>
                <td>{{$turma->NomeTurma}}</td>
                <td> <a href="{{url("/coordenacao/resultados_parcial/$turma->idTurmas")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="resultado parcial"</center></td>
                <td> <a href="{{url("/coordenacao/resultados_final/$turma->idTurmas")}}"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="resultado final"</center></td>
                <td> <a href="{{url("/coordenacao/resultados_aprovados_1semestre/$turma->idTurmas")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="aprovados 1 semestre"</center></td>
                <td> <a href="{{url("/coordenacao/resultados_aprovados_2semestre/$turma->idTurmas")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="aprovados 2 semestre"</center></td>
  
                    </tr>
                                        
                                        
                                        
                                        
                                        
                                        
                                        @empty
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Desculpe ! </strong> Nenhuma turma cadastrada, para cadastras<a href="/maruge/public/coordenacao/turma_cad" class="alert-link"> Clique aqui.</a>
                                        </div>
                                        <tr>
                                            <td colspan="500"> Nenhuma turma cadastrada !</td>
                                        </tr>
                                        @endforelse
                                        </table> 
                                        <div>{!! $turmas->render()!!} </div>



                                        </div>
                                        </div> <!--Fim do caminho-din-->
                                        @endsection