@extends('telasDocente.painel')  
@section('conteudo')

<br>

<div class="titulo-pagina">
    <h1 class="titulo-pagina">Dashboard</h1>
</div> 



<div class="caminho-din">
    <div class="rel-geral col-md-4 sombra">
        <i class="fa fa-graduation-cap rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                {{$Alunos}}
            </h2>
            <h3 class="resultado-geral">
                Total de Alunos
            </h3>
        </div>
    </div> 
    <div class="rel-geral col-md-4 sombra">
        <i class="glyphicon glyphicon-blackboard rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                {{$quantTurmasDocente}}
            </h2>
            <h3 class="resultado-geral">
                Total de Turmas
            </h3>	
        </div>
    </div>
    <div class="rel-geral col-md-4 sombra">
        <i class="fa fa-book rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                {{$quantDisciplinaDocente}}
            </h2>
            <h3 class="resultado-geral">
                Total de Disciplinas
            </h3>
        </div>
    </div> 

</div> <!--Fim do caminho-din-->
@endsection