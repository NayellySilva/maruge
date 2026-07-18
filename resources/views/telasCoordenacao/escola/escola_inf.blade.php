@extends('telasCoordenacao.painel')  
@section('conteudo')

<div class="titulo-endereco">Secretaria / Escola </div>


<div class="titulo-pagina">
    <h1 class="titulo-pagina">Escola Cadastrada: ( {{$escolas->count()}} )</h1>
     
</div> 

<div class="caminho-din">
   
    
<table class="table table-hover">
    <thead>
    <tr>
      <th>CÓD</th>
      <th>NOME ESCOLA</th>
      <th>ENDEREÇO</th>
      <th><center>VISUALIZAR</center></th>
      <th><center>EDITAR</center></th>
      <th><center>IMPRIMIR</center></th>
    </tr>
  </thead>   
  <!-- Recebendo valores na vareavel escolas e passando para escola-->
   @forelse($escolas as $escola)  
  <center>
      
    <tr>
      <td>{{$escola->idEscola}}</td>
      <td>{{$escola->NomeEscola}}</td>
      <td>{{$escola->Rua}} , {{$escola->Numero}}</td>
      <td><a href="{{url("/coordenacao/escola_perfil/$escola->idEscola")}}" > <center><img src="{{url('imgs/icones/visualizar.png')}}" alt="visualizar"</center></td>
      <td> <a href="{{url("/coordenacao/escola_editar/$escola->idEscola")}}" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="editar"</center></td>
      <td> <a href="{{url("/coordenacao/escola_impressao/$escola->idEscola")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="imprimir"</center></td>
    </tr>
 
  @empty
  
  <div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Desculpe</strong> Nenhuma Escola cadastrada, para cadastras<a href="/maruge/public/coordenacao/escola_cad" class="alert-link"> Clique aqui.</a>
</div>
  <tr>
      <td colspan="500"> Nenhuma escola cadastrada !</td>
  </tr>
   @endforelse
  </table>  
 </div>
</div> <!--Fim do caminho-din-->
@endsection



