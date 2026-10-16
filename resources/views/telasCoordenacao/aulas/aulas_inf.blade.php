@extends('layouts.app')  
@section('content')


<div  class="col-md-8" titulo-pagina">
      <h1 class="titulo-pagina">{{ $titulo ?? 'Atividades em Vídeo' }} </h1>
</div> 







<div class="col-md-4">
    <div class="quant-alunos">                           
        
         <h2 class="quant-alunos">Turmas Cadastradas:  ({{$turmas->count()}})</h2>

    </div> 
</div>




<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>CÓD</th>
                <th>NOME TURMA</th>
        <th><center>ANO</center></th>
       <th><center>QUANTIDADES DE AULAS</center></th> 
    <th><center>SITUAÇÃO</center></th>
        <th><center>ASSISTIR AULAS</center></th>
        
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($turmas as $turma ) 
                  <tr >
             <td>{{$turma->idTurmas}}</td>
             <td>{{$turma->NomeTurma}}</td>
             <td><center>{{$turma->AnoLetivo}}</td>
             
             
             <td>
             <center>
                 
                    @php
                    $quantidadesdeaulas = \App\Models\modelCoordenacao\tb_aulas::quantidadesdeaulas($turma->idTurmas);
                    @endphp
                 
                    
                    @if ($quantidadesdeaulas == 0)
                    <span class="label label-warning"> {{$quantidadesdeaulas}}</span>
                   @else ($quantidadesdeaulas =! 0 )
                   
                  <span class="label label-info"> {{$quantidadesdeaulas}}</span>
                  
                  
             
                @endif
                    
                    
                    
                
                 
                 
             </center>
             </td>
             
             
             
             
           
             @if($turma->SituacaoTurma != "INATIVO" )
             <td> <center> <img src="{{url('imgs/icones/ativo.png')}}" </td>
                 @else
                 <td> <center> <img src="{{url('imgs/icones/inativo.png')}}" </td>
                     @endif 
                     <td> <a href="{{url("/coordenacao/aula_assistir/$turma->idTurmas")}}" ><center>  <img src="{{url('imgs/icones/assistir.png')}}" alt="turma_editar"                             </center></td>
                     
                     
                     
                     </tr>
                     
                     
                     
                     
                     
                     
                     
                     
       @empty
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Desculpe ! </strong> Nenhuma turma cadastrada, para cadastras<a href="/coordenacao/turma_cad" class="alert-link"> Clique aqui.</a>
                                        </div>
                                          <tr>
                                            <td colspan="500"> Nenhuma turma cadastrada !</td>
                                        </tr>
                                        @endforelse
                                        </table> 
       
                                        </div> <!--Fim do caminho-din-->
                                        @endsection