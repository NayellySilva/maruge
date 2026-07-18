@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">Dashboard Educacional</h1>
</div> 
<div class="caminho-din">
    <div class="rel-geral col-md-4 sombra">
        <i class="fa fa-graduation-cap rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                {{$quantAlunosCadastrados}}
            </h2>
            <h3 class="resultado-geral">
                Alunos Cadastrados
            </h3>
        </div>
    </div>
    <div class="rel-geral col-md-4 sombra">
        <i class="fa fa-check-circle rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                {{$quantMatriculasAtivas}}
            </h2>
            <h3 class="resultado-geral">
                Alunos Ativos
            </h3>	
        </div>
    </div>
    <div class="rel-geral col-md-4 sombra">
        <i class="fa fa-ban rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                {{$quantMatriculasInativas}}
            </h2>
            <h3 class="resultado-geral">
                Alunos Inativos
            </h3>
        </div>
    </div>
    <div class="rel-geral col-md-4 sombra">
        <i class="glyphicon glyphicon-blackboard rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                {{$quantTurmasAtivas}}
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
                {{$quantDisciplina}}
            </h2>
            <h3 class="resultado-geral">
                Total de Disciplinas
            </h3>
        </div>
    </div>
    <div class="rel-geral col-md-4 sombra">
        <i class="fa fa-users rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                {{$quantFuncionariosCadastrados}}
            </h2>
            <h3 class="resultado-geral">
                Total de Funcionários
            </h3>
        </div>
    </div>
    <div class="rel-geral col-md-4 sombra">
        <i class="fa fa-user rel-geral" aria-hidden="true"></i>
        <div class="texto-rel">
            <h2 class="resultado">
                {{$quantUsuarioCadastrados}}
            </h2>
            <h3 class="resultado-geral">
                Total de Usuários
            </h3>
        </div>
    </div>
</div> <!--Fim do caminho-din-->




@endsection