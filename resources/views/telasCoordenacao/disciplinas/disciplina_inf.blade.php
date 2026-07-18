@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
    Secretaria / Disciplinas 
    </a>
</div>

<div class="titulo-pagina">
    <h1 class="titulo-pagina">Disciplinas Cadastradas: ({{$disciplinas->total()}})</h1>

</div> 
<div class="caminho-din">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>CÓD</th>
                <th>NOME DISCIPLINA</th>
                <th><center>EDITAR</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($disciplinas as $disciplina)  
        <center>
            <tr>
                <td>{{$disciplina->idDisciplinas}}</td>
                <td>{{$disciplina->NomeDisciplina}}</td>
                <td> <a href="{{url("/coordenacao/disciplina_editar/$disciplina->idDisciplinas")}}" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="editar"</center></td>
            </tr>
            @empty
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Desculpe</strong> Nenhuma disciplina cadastrada, para cadastras<a href="/maruge/public/coordenacao/disciplina_cad" class="alert-link"> Clique aqui.</a>
            </div>
            <tr>
                <td colspan="500"> Nenhuma disciplina cadastrada !</td>
            </tr>
            @endforelse
    </table> 
    
    <div>{!! $disciplinas->render()!!} </div>
    
</div>
</div> <!--Fim do caminho-din-->
@endsection



