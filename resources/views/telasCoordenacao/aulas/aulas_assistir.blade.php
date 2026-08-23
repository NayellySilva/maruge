@extends('layouts.app')  
@section('content')
<div  class="col-md-8" titulo-pagina">
      <h1 class="titulo-pagina">{{ $titulo ?? 'Aulas da Turma:' }} {{$turmaAula->NomeTurma}}</h1>
</div> 
<div >
    <div class="col-md-1">
        <div class="form-group">
            <label for="Codigo Da Turma">Cod. Turma:{{$turmaAula->idTurmas}}</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="NomeTurma">Quantidades de Aulas: {{$Aulas->count()}}</label>
        </div>
    </div>
</div>
<div class="form form-search form-Nu formularios">
    <div  class="caminho-din">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ATIVIDADES</th>
                    <th>COMENTÁRIO</th>
                    <th><center>EDITAR</center></th>
                    <th><center>EXCLUIR</center></th>
                </tr>
            </thead>   
    </div>
</div>
@forelse($Aulas as $aula ) 
<tr>
<td width="630">
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<div class="panel panel-default">
<div class="panel-heading" role="tab" id="headingOne">
 <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{$aula->idAula}}" aria-expanded="false" aria-controls="collapseOne">
        {{$aula->data_aula = date("d/m/Y", strtotime($aula->data_aula))}} 
        <i class="fa fa-eye assistir" aria-hidden="true"></i>
        </a>
      </h4>
    </div>
    <div id="collapseOne{{$aula->idAula}}" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
          <div class="embed-responsive embed-responsive-16by9">
<iframe width="560" height="315" src="{{$aula->aula}}" frameborder="0" 
        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>
    </div>
    </div>
  </div>
  </div>
    </td>
<td>{{$aula->ObsAula}}</td>
   <td> <a href="{{url("/coordenacao/aula_editar/$aula->idAula")}}" ><center><img src="{{url('imgs/icones/editar.png')}}" alt="editar"</center></td>
   <td> <a href="{{url("/coordenacao/aula_deletar/$aula->idAula")}}"><center> <img src="{{url('imgs/icones/deletar.png')}}" alt="editar"</center></td>
</tr>  
@empty
<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Desculpe ! </strong> Nenhuma aula cadastrada<a href="/coordenacao/aula_cad" class="alert-link"> Clique aqui.</a>
</div>
<tr>
    <td colspan="500"> Nenhuma aula cadastrada !</td>
</tr>
@endforelse
</table> 
</div>
</div> <!--Fim do caminho-din-->
@endsection