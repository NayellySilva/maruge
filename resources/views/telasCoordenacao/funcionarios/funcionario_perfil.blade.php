@extends('layouts.app')  
@section('content')
<button type="button"  value="Imprimir" id="imprimir_conteudo"  class="botao btn-imprimir"> Imprimir</button>
        <div class="imprimir_conteudo">
<!--Essa página é apenas pra exibir as informações da escola em questão-->
<div class="titulo-pagina">
    @forelse($Funcionario as $Funcionario) 
    <h1 class="titulo-pagina">{{$Funcionario->NomeFuncionario}}</h1>
</div> 
<div class="caminho-din">
    <div class="formularios">    
        {!! csrf_field() !!} 

        <div class="row" aling="center">

            <div class="col-lg-4">

                <div class="panel panel-default">
                    <div class="panel-heading ">
                        <strong> PERFIL</strong>  
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <center> <img src="{{asset('imgs/perfil.jpg')}}"><br>
                            <b>ENDEREÇO: </b>  {{$Funcionario->Rua}} , {{$Funcionario->Numero}}<br>
                            <b>BAIRRO: </b> {{$Funcionario->Bairro}} - CEP:{{$Funcionario->CEP}}<br>
                            <b>CIDADE: </b> {{$Funcionario->Cidade}}<br>
                            <b>FONES: </b> {{$Funcionario->Fone1}} / {{$Funcionario->Fone2}}<br>
                            <b>EMAIL: </b> {{$Funcionario->EmailFuncionario}}<br>
                            <b>CPF: </b> {{$Funcionario->CPFFuncionario}}   <b>RG: </b> {{$Funcionario->RGFuncionario}}<br>
                            <b>FUNÇÃO: </b> {{$Funcionario->Funcao}} <b>FORMAÇÃO: </b> {{$Funcionario->Formacao}}<br>
                            <b>SALÁRIO: </b> {{$Funcionario->Salario}}<br></center>
                            @empty
                            @endforelse
                            <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading ">
                    <strong> RELAÇÃO INSTITUCIONAL</strong>  
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tbody>
                            <thead>
                                <tr>        
                                    <th><center>TURMAS</center></th>
                            <th><center>DISCIPLINAS</center></th>
                            </tr>
                            </thead> 
                            @foreach($Turmas as $Turma)
                            <tr>
                                <td width="220" >{{$Turma->NomeTurma}}</td>
                                <td>
                                    @php
                                    $disciplinadoprofessor = \App\Models\modelCoordenacao\tb_funcionario::DisciplinasdoProfessor($Funcionario->idFuncionarios, $Turma->idTurmas);
                                    @endphp
                                    @forelse($disciplinadoprofessor as  $disciplina )
                                    {{$disciplina->NomeDisciplina}} /
                                    @empty
                                    @endforelse
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.row -->
    </div>

    <!--Fim da Tabela RELAÇÃO INSTITUCIONAL-->
</div>
</div> <!--Fim do caminho-din-->
        </div>
@endsection