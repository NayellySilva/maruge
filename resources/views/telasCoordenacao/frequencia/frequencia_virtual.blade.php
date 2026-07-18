@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Frequência'}} - {{ $turma->NomeTurma }}</h1>
    
</div> 

<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 

    <div class="formularios">    
        @if(count($errors)>0)
        @foreach($errors->all()as $error)
        {{$error}}
        @endforeach
        @endif
        @if(isset($aluno))
        <form action="/maruge/public/coordenacao/frequencia_editar/{{$lanche->idlanche}}" method="POST">
        @else
            <form action="/maruge/public/coordenacao/frequencia_cad" method="POST" send="/maruge/public/coordenacao/frequencia_cad">         
                @endif 
                {!! csrf_field() !!}
<hr class="linha">  
<div class="caminho-din">

    <div class="row">
                     <div class="form-group col-md-10 offset-md-10">

                                </div>
                     <div class="form-group col-md-1 offset-md-5">
                                    <label for="dia">Dia:</label>
                                    <select class="form-control" name="dia" id="dia">
                                       <!-- <option >{{$aluno->dia or old('dia')}}</option> -->
                                        <option>  </option>
                                        <option> 01 </option>
                                        <option> 02 </option>
                                        <option> 03 </option>
                                        <option> 04 </option>
                                        <option> 05 </option>
                                        <option> 06 </option>
                                        <option> 07 </option>
                                        <option> 08 </option>
                                        <option> 09 </option>
                                        <option> 10 </option>
                                        <option> 11 </option>
                                        <option> 12 </option>
                                        <option> 13 </option>
                                        <option> 14 </option>
                                        <option> 15 </option>
                                        <option> 16 </option>
                                        <option> 17 </option>
                                        <option> 18 </option>
                                        <option> 19 </option>
                                        <option> 20 </option>
                                        <option> 21 </option>
                                        <option> 22 </option>
                                        <option> 23 </option>
                                        <option> 24 </option>
                                        <option> 25 </option>
                                        <option> 26 </option>
                                        <option> 27 </option>
                                        <option> 28 </option>
                                        <option> 28 </option>
                                        <option> 30 </option>
                                        <option> 31 </option>
                                    </select>
                                </div>
    <div class="form-group col-md-1 offset-md-3">
                                    <label for="mes">Mês:</label>
                                    <select class="form-control" name="mes" id="dia">
                                      <!--  <option >{{$aluno->mes or old('mes')}}</option> -->
                                        <option>  </option>
                                        <option> 01 </option>
                                        <option> 02 </option>
                                        <option> 03 </option>
                                        <option> 04 </option>
                                        <option> 05 </option>
                                        <option> 06 </option>
                                        <option> 07 </option>
                                        <option> 08 </option>
                                        <option> 09 </option>
                                        <option> 10 </option>
                                        <option> 11 </option>
                                        <option> 12 </option>
                                    </select>
                                </div>
    
    
    </div>
    
    
</div>
	<br />
    <table class="table table-hover">
        <thead>
            <tr>
        <th>RA</th>
        <th>NOME DO ALUNO</th>
        <th><center>PRESENTE</center></th>             
        <th><center>JUSTIFICADO</center></th>
        <th><center>FALTA</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($Alunos as $key =>$Aluno)  
                <center>
            <tr>
                <td>{{$Aluno->RA}}</td>
                <td>{{$Aluno->NomeAluno}}</td>        
                <td><center>
<div class="dlk-radio btn-group">
<label class="radio-inline btn btn-success">
  
    <input type="hidden" name="ano[{{$key}}]" value="{{$ano}}">
    <input type="hidden" name="RA[{{$key}}]" value="{{$Aluno->RA}}">
    <input type="hidden" name="tb_aluno_idAluno[{{$key}}]" value="{{$Aluno->idAluno}}">
    <input type="hidden" name="tb_turmas_idTurmas[{{$key}}]" value="{{$turma->idTurmas}}">
    <input type="hidden" name="inf_dia[{{$key}}]" value="{{$inf_dia}}">
    <input type="radio" name="situacao[{{$key}}]" value="PRESENTE" checked>
    <i class="fa fa-check glyphicon glyphicon-ok"></i>
</label>
</div>
</center></td>
                <td><center>
<div class="dlk-radio btn-group">
<label class="radio-inline btn btn-warning">

    <input type="hidden" name="ano[{{$key}}]" value="{{$ano}}">
    <input type="hidden" name="RA[{{$key}}]" value="{{$Aluno->RA}}">
    <input type="hidden" name="tb_aluno_idAluno[{{$key}}]" value="{{$Aluno->idAluno}}">
    <input type="hidden" name="tb_turmas_idTurmas[{{$key}}]" value="{{$turma->idTurmas}}">
    <input type="hidden" name="inf_dia[{{$key}}]" value="{{$inf_dia}}">
    <input type="radio" name="situacao[{{$key}}]" value="JUSTIFICADO" >
    <i class="fa fa-check glyphicon glyphicon-remove"></i>
</label>
</div>
</center></td>
                <td><center>
<div class="dlk-radio btn-group">
<label class="radio-inline btn btn-danger">

    <input type="hidden" name="ano[{{$key}}]" value="{{$ano}}">
    <input type="hidden" name="RA[{{$key}}]" value="{{$Aluno->RA}}">
    <input type="hidden" name="tb_aluno_idAluno[{{$key}}]" value="{{$Aluno->idAluno}}">
    <input type="hidden" name="tb_turmas_idTurmas[{{$key}}]" value="{{$turma->idTurmas}}">
    <input type="hidden" name="inf_dia[{{$key}}]" value="{{$inf_dia}}">
    <input type="radio" name="situacao[{{$key}}]" value="FALTA" >
   <i class="fa fa-times glyphicon glyphicon-remove"></i>
</label>
</div>
</center></td>
@empty



                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Desculpe ! </strong> Mas nenhuma turma foi informada, por favor digite o nome do aluno ou selecione uma turma.
                </div>
                <tr>
                    <td colspan="500"> Nenhum alunos encontrado !</td>
                </tr>
                @endforelse
                </table> 
                <div>{!! $Alunos->render()!!} </div>
                </div>
                   <!--SEGUNDA LINHA REFERENTE AOS CAMPOS ( SALVA  )-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">SALVAR</button>
                        </div>
                    </div>   
                </div>   
            </form> <!--Fim do formulario-->
    </div>
</div> <!--Fim do caminho-din-->
@endsection