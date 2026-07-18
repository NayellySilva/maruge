@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
	<h1 class="titulo-pagina">Financeiro</h1>
</div> 

<div class="caminho-din">
    
    
    
   
    
    <div class="rel-geral col-md-4 sombra">
        <a href="/maruge/public/coordenacao/financeiro_receber">  
                        <div class="imagem imagens-geral">
                            
			<img src="{{url('imgs/icones/Relatorio_bimestral.png')}}" alt="Receber Titulo">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Receber
			</h3>
			</div>
                        </a>
    </div>
    <div class="rel-geral col-md-4 sombra">
           <a href="/maruge/public/coordenacao/receitas_e_despesas">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/apagar.png')}}" alt="Contas a pagar">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Receitas e Despesas  
			</h3>	
			</div>
                        </a>
    </div>
    <div class="rel-geral col-md-4 sombra">
         <a href="/maruge/public/coordenacao/estatisticas">  
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/aprovado_reprovado.png')}}" alt="Estatística ">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Estatística 
			</h3>	
			</div>
                        </a>
    </div>
    <div class="rel-geral col-md-4 sombra">
         <a href="/maruge/public/coordenacao/financeiro_relatorios_2">  
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/aprovado_reprovado.png')}}" alt="Estatística ">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Relatórios 
			</h3>	
			</div>
                        </a>
    </div>



</div> <!--Fim do caminho-din-->







@endsection



