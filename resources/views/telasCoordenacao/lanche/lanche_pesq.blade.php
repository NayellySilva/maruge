@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
    Secretaria / Lanche
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="SituacaoAluno ">Localizar Lanche:</label>
        <form class="form-search pesquisar" method="post" action="/maruge/public/coordenacao/lanche_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar lanche"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-4">
    <div class="quant-alunos">                           
        <h2 class="quant-alunos">Lanches Cadastradas:  ({{$lanches->count()}})</h2>
    </div> 
</div>


<div class="caminho-din">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>CÓD</th>
                <th>NOME LANCHE</th>
                <th><center>VALOR</center></th>     
        <th><center>EDITAR</center></th>
    <th><center>EXCLUIR</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->

       @forelse($lanches as $lanche ) 
        <center>
            <tr>
                <td>{{$lanche->idlanche}}</td>
                <td>{{$lanche->NomeLanche}}</td>
                <td><center>R$: {{$lanche->ValorLanche}}</td>                                     
                <td> <a href="{{url("/coordenacao/lanche_editar/$lanche->idlanche")}}" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="lanche_editar"</center></td>
                <td> <a href="{{url("/coordenacao/lanche_delete/$lanche->idlanche")}}" ><center> <img src="{{url('imgs/icones/deletar.png')}}" alt="lanche excluir"</center></td>
           
             </tr>
        @empty
               <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Desculpe ! </strong> Nenhum Lanche cadastraoa, para cadastrar<a href="/maruge/public/coordenacao/lanche_cad" class="alert-link"> Clique aqui.</a>
               </div>
                <tr>
                <td colspan="500"> Nenhuma lanche cadastrado !</td>
                </tr>
                @endforelse
                </table> 
               
                    </div>
                                        </div> <!--Fim do caminho-din-->
                                        @endsection