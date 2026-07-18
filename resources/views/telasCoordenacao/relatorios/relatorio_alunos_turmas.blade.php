@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
    Relatórios / Relatórios Alunos por Turmas
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="SituacaoAluno ">Localizar Turma:</label>
        <form class="form-search pesquisar" method="post" action="/maruge/public/coordenacao/relatorio_pesquisar_turmas">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Turma"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>


<div class="col-md-3">
    <div class="form-group">
        <label for="NomeTurma">Filtrar por Ano Letivo:</label>
        <form class="form-search pesquisar"method="post" action="/maruge/public/coordenacao/relatorio_filtro_turmas_anoletivo">
           {!! csrf_field() !!}
            <select class="form-control" name="AnoLetivo" >
                <option></option>
                @forelse($turmas_Inativas as $turmas_Inativas)  
                <option value="{{$turmas_Inativas->AnoLetivo}}">{{$turmas_Inativas->AnoLetivo}}</option>
                @empty
                @endforelse 
            </select>
            <button class="btn-filtro" type="submit" > <i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>

<div class="col-md-4">
    <div class="quant-alunos">                           
        <h2 class="quant-alunos">Turmas Encontradas:  ({{$turmas->count()}})</h2>
    </div> 
</div>
<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>CÓD</th>
                <th>NOME TURMA</th>
                <th><center>ANO LETIVO</center></th>
                <th><center>Pais/WhatsApp</center></th>
                <th><center>Endereço</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($turmas as $turma ) 
        <center>
            <tr>
                <td>{{$turma->idTurmas}}</td>
                <td>{{$turma->NomeTurma}}</td>
                <td><center>{{$turma->AnoLetivo}}</center></td>
                <td> <a href="{{url("/coordenacao/relatorio_alunos_turmas/$turma->idTurmas")}}"><center> <img src="{{asset('imgs/icones/imprimir.png')}}" alt="vizualizar alunos de turma"</center></td>
                <td> <a href="{{url("/coordenacao/relatorio_alunos_turmas_endereco/$turma->idTurmas")}}"><center> <img src="{{asset('imgs/icones/imprimir.png')}}" alt="vizualizar alunos de turma"</center></td>
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
   
</div>
</div> <!--Fim do caminho-din-->
@endsection