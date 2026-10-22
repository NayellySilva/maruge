@extends('telasDocente.painel')  
@section('conteudo')
<div class="col-md-4">
    <div class="quant-alunos">                           
        <h2 class="quant-alunos">Mapas de Notas</h2>

    </div> 
</div>
<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>CÓD</th>
                <th>NOME TURMA</th>
                <th><center>1º BIM</center></th>
        <th><center>2º BIM</center></th>
        <th><center>3º BIM</center></th>
        <th><center>4º BIM</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($turmas as $turma ) 
        <center>
            <tr>
                <td>{{$turma->idTurmas}}</td>
                <td>{{$turma->NomeTurma}}</td>
                <td> <a href="{{url("/docente/mapa_1bim/$turma->idTurmas")}}"target="_blank" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="1º Bimestre"</center></td>
                <td> <a href="{{url("/docente/mapa_2bim/$turma->idTurmas")}}"target="_blank" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="2º Bimestre"</center></td>
                <td> <a href="{{url("/docente/mapa_3bim/$turma->idTurmas")}}"target="_blank" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="3º Bimestre"</center></td>
                <td> <a href="{{url("/docente/mapa_4bim/$turma->idTurmas")}}"target="_blank" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="4º Bimestre"</center></td>
            </tr>
            @empty
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Desculpe ! </strong> Nenhuma turma cadastrada, para cadastras<a href="/maruge/public/docente/turma_cad" class="alert-link"> Clique aqui.</a>
            </div>
            <tr>
                <td colspan="500"> Nenhuma turma cadastrada !</td>
            </tr>
            @endforelse
    </table> 
   
</div>
</div> <!--Fim do caminho-din-->
@endsection