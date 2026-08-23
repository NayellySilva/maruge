@extends('layouts.app')  
@section('content')
<div class="titulo-endereco">
    <a href="#">
    Secretaria / Turmas 
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="SituacaoAluno ">Localizar Turma:</label>
        <form class="form-search pesquisar" method="post" action="/coordenacao/turma_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Turma"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="SituacaoTurma">Filtrar por Situação:</label>
        <form class="form-search pesquisar"method="post" action="/coordenacao/turma_filtro">
            {!! csrf_field() !!}
            <div class="relative">
                    <select
                        name="SituacaoTurma"
                        onchange="this.form.submit()"
                        class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                    >
                        <option value="" disabled selected>
                            Filtrar por Situação
                        </option>
                        <option value="">
                            Todos
                        </option>
                        <option value="ATIVO">
                            Ativo
                        </option>
                        <option value="INATIVO">
                            Inativo
                        </option>
                    </select>

                    <i
                        data-lucide="chevron-down"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                    ></i>
                </div>


            <button class="btn-filtro" type="submit" > <i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>

<div class="col-md-4">
    <div class="quant-alunos">                           
        <h2 class="quant-alunos">Turmas Cadastradas:  ({{$turmas->count()}})</h2>

    </div> 
</div>





<div class="caminho-din">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>CÓD</th>
                <th>NOME TURMA</th>

                <th><center>MENSALIDADE</center></th>
        <th><center>ANO</center></th>
        <th><center>SITUAÇÃO</center></th>
        <th><center>EDITAR</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->

        @forelse($turmas as $turma ) 
        <center>
            <tr>
                <td>{{$turma->idTurmas}}</td>
                <td>{{$turma->NomeTurma}}</td>
                <td><center>R$: {{$turma->Mensalidade}}</td>
                <td><center>{{$turma->AnoLetivo}}</td>


                    @if($turma->SituacaoTurma != "INATIVO" )
                    <td> <center> <img src="{{url('imgs/icones/ativo.png')}}" </td>
                    @else
                    <td> <center> <img src="{{url('imgs/icones/inativo.png')}}" </td>
                    @endif 
             
             
                                                 
                            <td> <a href="{{url("/coordenacao/turma_editar/$turma->idTurmas")}}" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="turma_editar"</center></td>
                                        </tr>
                                        @empty
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Desculpe ! </strong> Nenhuma turma cadastrada, para cadastras<a href="/coordenacao/turma_cad" class="alert-link"> Clique aqui.</a>
                                        </div>
                                        <tr>
                                            <td colspan="500"> Nenhuma turma cadastrada !</td>
                                        </tr>
                                        @endforelse
                                        </table> 
    
       </div>
                                        </div> <!--Fim do caminho-din-->
                                        @endsection