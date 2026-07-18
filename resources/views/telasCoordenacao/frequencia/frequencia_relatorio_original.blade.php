@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
    Secretaria / Frequência 
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="SituacaoAluno ">Localizar Turma:</label>
        <form class="form-search pesquisar" method="post" action="/maruge/public/coordenacao/frequencias_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Turma"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="NomeTurma">Filtrar por turma:</label>
        <form class="form-search pesquisar"method="post" action="/maruge/public/coordenacao/frequencias_filtro">
            {!! csrf_field() !!}
            <select class="form-control" name="idTurmas" >
                <option></option>
                @forelse($turmasSelecte as $turmaSelecte)  
                <option value="{{$turmaSelecte->idTurmas}}">{{$turmaSelecte->NomeTurma}}</option>
                @empty
                @endforelse 
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
        <th><center>JANEIRO</center></th>
        <th><center>FEVEREIRO</center></th>
        <th><center>MARCO</center></th>
        <th><center>ABRIL</center></th>
        <th><center>MAIO</center></th>
        <th><center>JUNHO</center></th>
        <th><center>JULHO</center></th>
        <th><center>AGOSTO</center></th>
        <th><center>SETEMBRO</center></th>
        <th><center>OUTUBRO</center></th>
        <th><center>NOVEMBRO</center></th>
        <th><center>DEZEMBRO</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->

        @forelse($frequencias as $frequencia) 
        <center>
            <tr>
                <td>{{$frequencia->dia}}</td>
                <td>{{$frequencia->mes}}</td>
                <td><center><a href="{{url("/coordenacao/frequencia_virtual/$turma->idTurmas")}}"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia Virtual"</center></td>
                <td><center><a href="{{url("/coordenacao/frequencia_mensal/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia Mensal"</center></td>
                <td><center><a href="{{url("/coordenacao/frequencia_edfisica/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia Ed.Física"</center></td>
                <td><center><a href="{{url("/coordenacao/frequencia_entrega/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia de entrega de resultado"</center></td> 
                <td><center><a href="{{url("/coordenacao/frequencia_relatorio/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia de entrega de resultado"</center></td> 
                <td><center><a href="{{url("/coordenacao/frequencia_relatorio/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia de entrega de resultado"</center></td> 
                <td><center><a href="{{url("/coordenacao/frequencia_relatorio/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia de entrega de resultado"</center></td> 
                <td><center><a href="{{url("/coordenacao/frequencia_relatorio/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia de entrega de resultado"</center></td> 
                <td><center><a href="{{url("/coordenacao/frequencia_relatorio/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia de entrega de resultado"</center></td> 
                <td><center><a href="{{url("/coordenacao/frequencia_relatorio/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia de entrega de resultado"</center></td> 
                <td><center><a href="{{url("/coordenacao/frequencia_relatorio/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia de entrega de resultado"</center></td> 
                <td><center><a href="{{url("/coordenacao/frequencia_relatorio/$turma->idTurmas")}}"target="_blank"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="frequencia de entrega de resultado"</center></td> 
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