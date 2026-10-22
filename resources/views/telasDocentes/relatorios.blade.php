@extends('telasDocente.painel')  
@section('conteudo')
<br>

<div class="titulo-pagina">
	<h1 class="titulo-pagina">Relatórios</h1>
	</div> 
	
<div class="caminho-din">
    
    <!--
    
    Foi comentado pq a ideia era coloca um relatorio bimestra das notas so do professor e suas disciplinas , 
    aqui estava indo apenas mapas de noas um meu que ja existia eu ia da continuidade no codigo
    
    

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/docente/mapas_notas_por_docente">  
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/Relatorio_bimestral.png')}}" alt="Relatórios Bimestrais">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Relatório Bim.
			</h3>	
			</div>
                            </a>
			</div>
    
    -->
    
    
    
    
			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/docente/mapas_notas">  
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
                        <a href="/maruge/public/docente/resultados">  
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/aprovado_reprovado.png')}}" alt="Nova Escola">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Resultados
			</h3>	
			</div>
                        </a>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/docente/relatorio_alunos_turmas">  
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

			

			

			
	
	
</div> <!--Fim do caminho-din-->

@endsection



