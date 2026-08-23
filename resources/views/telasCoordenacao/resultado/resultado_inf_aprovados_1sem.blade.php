<html>
    <header>   
        <title>{{$titulo}}</title>
        <style media="print">
        .botao { display: none !important; }
    </style>
</header>
    <body>
@php
    if (!isset($escolas) || empty($escolas) || !isset($escolas->first()->Rua)) {
        try { $escolas = \App\Models\modelCoordenacao\tb_escola::informacaoEscolar(); } catch (\Exception $e) { $escolas = collect(); }
    }
@endphp

        <!-- CSS compilada e minificada on-line do bootstrap-->
        <link href="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">       
        <!-- favicon-->
        <link rel="stylesheet" href="{{asset('imgs/favicon.png')}}">     
        <!-- Jquery Local-->
        <script src="{{asset('css/jquery-3.0.0.js')}}" ></script> 
        <button type="button"  value="Imprimir" id="imprimir_conteudo"  onclick="window.print()" class="botao btn-imprimir"> Imprimir</button>
        <div class="imprimir_conteudo">
        <table class="timbre">
            <tr>
                <td>
                    <img src="{{url('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                    @forelse($escolas as $escola)
                    {{{ $escola->Rua ?? '' }}} , {{{ $escola->Numero ?? '' }}}<br>
                    {{{ $escola->Bairro ?? '' }}} - CEP:{{{ $escola->CEP ?? '' }}}<br>
                    {{{ $escola->Cidade ?? '' }}} - {{{ $escola->Estado ?? '' }}}<br>
                    Tel: {{{ $escola->Fone1 ?? '' }}} / {{{ $escola->Fone2 ?? '' }}}<br>
                    E-mail:{{{ $escola->EmailColegio ?? '' }}}<br>
                    CNPJ: {{{ $escola->CNPJ ?? '' }}}<br>
                    INEP:{{{ $escola->NumeroInep ?? '' }}}
                </td>
            </tr>         
            @empty
            @endforelse
        </table>
        <div class="resultado-titulo"> {{$titulo}} - {{$turma->AnoLetivo}}<br>
            TURMA - {{$turma->NomeTurma}} 
        </div>  
        <!-- Armazenando os nomes do professores correspondentes a sua disciplina -->
        @forelse($professores as $professor)
        @if (isset ($professor->NomeFuncionario))
        <div class="row" aling="center">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading ">
                        <strong> {{$professor->NomeDisciplina}}:</strong> &nbsp;&nbsp;{{$professor->NomeFuncionario}} 
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover fonteResultado">
                                <tbody>
                                <thead>
                                    <tr>
                                        <th>RA</th>
                                        <th>ALUNO</th>
                                        <th><center>1º BIM</center></th>
                                <th><center>2º BIM</center></th>
                                <th><center>MÉDIA</center></th>
                                </tr>
                                </thead>
                                <!-- Listando todos os alunos da turma -->
                                @forelse($Alunos as $Aluno)
                                <!-- Buscando a nota do aluno para verifica calcular a media -->
                                @php
                                $notasDoAluno = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($Aluno->idAluno, $professor->idDisciplinas);
                                @endphp
                                <!-- / Buscando a nota do aluno para verifica calcular a media -->
                                <!-- Laço de notas relacionada ao aluno -->
                                @forelse($notasDoAluno as $nota)
                                <!--Fazendo Média -->
                                @php 
                                $media = ($nota->AB1+$nota->AB2)/2; 
                                @endphp
                                <!-- / Fazendo Média -->
                                <!-- Se a media for menror que 7 ele ta em recuperação -->
                                @if($media>=7)
                                <tr>
                                    <td>{{$Aluno->RA}}</td>
                                    <td>{{$Aluno->NomeAluno}}</td>
              
                                <!--Nota AB1-->
                                @if (($nota->AB1) < 8)
                                    <td><center><div class="  notaAzul" >S</div></center></td> 
                                    @elseif (($nota->AB1) < 9)
                                    <td><center><div class="  notaAzul" >B</div></center></td> 
                                    @elseif (($nota->AB1) < 10)
                                    <td><center><div class="  notaAzul" >O</div></center></td> 
                                    @else
                                    <td><center><div class="  notaAzul" >E</div></center></td>     
                                @endif
                                <!-- / Nota AB1--> 
                                <!--Nota AB2-->
                                @if (($nota->AB2) < 8)
                                    <td><center><div class="  notaAzul" >S</div></center></td> 
                                    @elseif (($nota->AB2) < 9)
                                    <td><center><div class="  notaAzul" >B</div></center></td> 
                                    @elseif (($nota->AB2) < 10)
                                    <td><center><div class="  notaAzul" >O</div></center></td> 
                                    @else
                                    <td><center><div class="  notaAzul" >E</div></center></td>     
                                @endif
                                <!-- / Nota AB2--> 
                                
                                <!--Nota AB2-->
                                @if (($media) < 8)
                                    <td><center><div class="  notaAzul" >S</div></center></td> 
                                    @elseif (($media) < 9)
                                    <td><center><div class="  notaAzul" >B</div></center></td> 
                                    @elseif (($media) < 10)
                                    <td><center><div class="  notaAzul" >O</div></center></td> 
                                    @else
                                    <td><center><div class="  notaAzul" >E</div></center></td>     
                                @endif
                                <!-- / Nota AB2--> 
                   
                                @else
                                @endif
                                <!-- /Se a media for menror que 7 ele ta em recuperação -->
                                <!-- / Laço de notas relacionada ao aluno -->
                                @empty
                                @endforelse
                                <!-- / Listando todos os alunos da turma -->
                                @empty
                                @endforelse
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
        @else
        @endif
        @empty
        @endforelse
        <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
        </div>
    </body>
</html>