@extends('telasDocente.painel')  
@section('conteudo')
<br>
<div class="titulo-pagina">
    <h1 class="titulo-pagina">Secretaria </h1>
</div> 
<div class="caminho-din">
    <div class="imagens-geral col-md-4 sombra">
        <a href="{{url("/docente/funcionario_perfil/")}}">
            <div class="imagem imagens-geral">
                <img src="{{url('imgs/icones/funcionario.png')}}" alt="Perfil Funcionário">
            </div>
            <div class="texto-icones">
                <h3 class="texto-geral">
                    Perfil
                </h3>

            </div>
        </a>    
    </div>
    <div class="imagens-geral col-md-4 sombra">
        <a href="/maruge/public/docente/declaracoes">
            <div class="imagem imagens-geral">
                <img src="{{url('imgs/icones/declaracao.png')}}" alt="Declarações">
            </div>
            <div class="texto-icones">
                <h3 class="texto-geral">
                    Declarações
                </h3>	
        </a>
    </div>
</div>
<div class="imagens-geral col-md-4 sombra">
    <a href="/maruge/public/docente/notas">
    <div class="imagem imagens-geral">
        <img src="{{url('imgs/icones/lanca_notas.png')}}" alt="Nova Escola">
    </div>
    <div class="texto-icones">
        <h3 class="texto-geral">
            Lançar Notas
        </h3>	
    </a>
    </div>
</div>
</div> <!--Fim do caminho-din-->

@endsection
