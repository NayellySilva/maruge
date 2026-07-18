@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
	<h1 class="titulo-pagina">Relatórios</h1>
	</div> 
	<div class="caminho-din">
			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/relatorios_bimestrais">  
                        <div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/Relatorio_bimestral.png')}}" alt="Relatórios Bimestrais">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Relatórios Bim.
			</h3>
			</div>
                        </a>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/mapas_notas">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/relatorio_notas.png')}}" alt="Mapas de Notas">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Mapas de Notas
			</h3>	
			</div>
                        </a>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/resultados">  
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/aprovado_reprovado.png')}}" alt="Relatório de Resultados">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Resultados
			</h3>	
			</div>
                        </a>
			</div>
			
                        <div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/gabaritos">  
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/gabarito.png')}}" alt="Gabaritos">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Gabaritos
			</h3>	
			</div>
                        </a>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/relatorio_alunos_matriculados">  
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/aluno_ativo.png')}}"  alt="Relatório Alunos Matriculados">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Alunos Matriculados
			</h3>	
			</div>
                        </a>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/relatorio_alunos_inativos_ou_transferidos">  
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/alunos_inativo.png')}}" alt="Relatório Alunos Inativos e Transferidos">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Alunos Inativos / Trans.
			</h3>	
			</div>
                        </a>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/relatorio_alunos_turmas">  
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/aluno_ativo.png')}}" alt="Nova Escola">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Alunos Por Turma
 			</h3>	
			</div>
                        </a>
			</div>
                        <div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/relatorio_pre_matriculados">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/alunos.png')}}" alt="Alunos Pré-Matriculados">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Alunos Pré-Matrículados
			</h3>	
                        </a>
			</div>
			</div>
</div> <!--Fim do caminho-din-->
@endsection



