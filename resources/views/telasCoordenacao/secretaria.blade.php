@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
	<h1 class="titulo-pagina">Secretaria</h1>
	</div> 
	<div class="caminho-din">
			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/escola_inf">                             
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/escola.png')}}" alt="Informações da Escola">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Escola
			</h3>	
                        </a> 
			</div>
			</div>
                        <div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/disciplina_inf">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/disciplinas.png')}}" alt="Informações das Disciplinas">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Disciplinas
			</h3>	
                        </a>
			</div>
			</div>
			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/turma_inf">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/turma.png')}}" alt="Informações das turmas">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Turmas
			</h3>
                        </a>
			</div>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/aluno_inf">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/alunos.png')}}" alt="Informações dos alunos">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Alunos
			</h3>	
                        </a>
			</div>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/funcionario_inf">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/funcionario.png')}}" alt="Funcionários">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Funcionários
			</h3>	
                        </a>
			</div>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/usuario_inf">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/usuario.png')}}" alt="Usuário">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Usuários
			</h3>	
                        </a>
			</div>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/turma_disciplina_inf">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/turmas_disciplina.png')}}" alt="Turma">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Turmas / Disciplinas
			</h3>	
                            </a>
			</div>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/declaracoes">
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
                        <a href="/maruge/public/coordenacao/frequencias">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/frequenia.png')}}" alt="Frequencias">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Frequência
			</h3>	
                        </a>
			</div>
			</div>

			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/recibos">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/carne.png')}}" alt="Recibos">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Recibos / Carnês
			</h3>	
                        </a>
			</div>
			</div>

			
                        <div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/notas">    
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/lanca_notas.png')}}" alt="Notas">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Lançar Notas
			</h3>	
                        </a>
			</div>
			</div>
    
			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/boletins">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/boletim.png')}}" alt="boletim">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Boletins
			</h3>	
                        </a>
			</div>
			</div>
            
			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/historico">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/historico.png')}}" alt="boletim">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Histórico
			</h3>	
                        </a>
			</div>
			</div>
    
    
    
			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/aluno_rematricula">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/rematricula.png')}}" alt="Lista de Alunos para rematricular">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Rematrícula
			</h3>	
                        </a>
			</div>
			</div>
            
			<div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/aluno_pre_matricula_lista">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/pre-matricula.png')}}" alt="Lista de Alunos para rematricular">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Pré-Matrícula
			</h3>	
                        </a>
			</div>
			</div>
                        <div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/aluno_pre_matriculado">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/reserva.png')}}" alt="Alunos Pré-Matriculados">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Pré-Matrículados
			</h3>	
                        </a>
			</div>
			</div>
                        <div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/lanche_inf">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/lanche.png')}}" alt="Produto">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Lanche
			</h3>	
                        </a>    
			</div>
			</div>
                        <div class="imagens-geral col-md-4 sombra">
                        <a href="/maruge/public/coordenacao/aulas_inf">
			<div class="imagem imagens-geral">
			<img src="{{url('imgs/icones/aulas.png')}}" alt="Aulas">
			</div>
			<div class="texto-icones">
			<h3 class="texto-geral">
			Aulas
			</h3>	
                        </a>    
			</div>
			</div>
	
	
</div> <!--Fim do caminho-din-->

@endsection



