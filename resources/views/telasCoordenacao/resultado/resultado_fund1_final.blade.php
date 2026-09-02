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
                                <th><center>RP</center></th>
                                <th><center>3º BIM</center></th>
                                <th><center>4º BIM</center></th>
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


                                <!--Fazendo Média COMUM-->
                                @php 
                                if (isset($nota->RB1) && $nota->RB1 > 0 && $nota->RB1 > $nota->AB1) { $nota->AB1 = $nota->RB1; }
                                if (isset($nota->RB2) && $nota->RB2 > 0 && $nota->RB2 > $nota->AB2) { $nota->AB2 = $nota->RB2; }
                                if (isset($nota->RB3) && $nota->RB3 > 0 && $nota->RB3 > $nota->AB3) { $nota->AB3 = $nota->RB3; }
                                if (isset($nota->RB4) && $nota->RB4 > 0 && $nota->RB4 > $nota->AB4) { $nota->AB4 = $nota->RB4; }
                                $media = ($nota->AB1+$nota->AB2+$nota->AB3+$nota->AB4)/4; 
                                @endphp
                                <!-- / Fazendo Média COMUM -->

                                @if(($nota->RP)== 0 ) 
                                <!-- Se a media menor a 7 -->
                                @if($media<7)
                                <tr>
                                    <td>{{$Aluno->RA}}</td>
                                    <td>{{$Aluno->NomeAluno}}</td>
                                       
                                <!-- cor da nota AB1-->
                                @if($nota->AB1 < 7)
                                <td><center><div class=" notaVermelha" >{{number_format($nota->AB1 ,1)}}</div></center></td> 
                                @else
                                <td><center><div class=" notaAzul" >{{number_format($nota->AB1 ,1)}}</div></center></td> 
                                @endif
                                <!-- /Cor da nota AB1 -->
                                <!-- cor da nota AB2-->
                                @if($nota->AB2 < 7)
                                <td><center><div class=" notaVermelha" >{{number_format($nota->AB2 ,1)}}</div></center></td> 
                                @else
                                <td><center><div class=" notaAzul" >{{number_format($nota->AB2 ,1)}}</div></center></td> 
                                @endif
                                <!-- /Cor da nota AB2 -->
                                <td><center>-</center></td>
                                <!-- cor da nota AB3-->
                                @if($nota->AB3 < 7)
                                <td><center><div class=" notaVermelha" >{{number_format($nota->AB3 ,1)}}</div></center></td> 
                                @else
                                <td><center><div class=" notaAzul" >{{number_format($nota->AB3 ,1)}}</div></center></td> 
                                @endif
                                <!-- /Cor da nota AB3 -->
                                <!-- cor da nota AB4-->
                                @if($nota->AB4 < 7)
                                <td><center><div class=" notaVermelha" >{{number_format($nota->AB4 ,1)}}</div></center></td> 
                                @else
                                <td><center><div class=" notaAzul" >{{number_format($nota->AB4 ,1)}}</div></center></td> 
                                @endif
                                <!-- /Cor da nota AB4 -->
                                <td><center><div class=" notaVermelha" >{{number_format($media ,1)}}</div></center></td> 
                                @else
                                @endif
                                <!-- /Se a media menor a 7 -->
                                @else
                                <!-- Se a media de recuperação  menor a 7 -->
                                <!--Fazendo Média de recuperação-->
                                @php 
                                $mediaRP = (($nota->RP * 2)+$nota->AB3+$nota->AB4)/4; 
                                @endphp
                                <!-- / Fazendo Média recuperação -->
                                @if($mediaRP<7)
                                <tr>
                                    <td>{{$Aluno->RA}}</td>
                                    <td>{{$Aluno->NomeAluno}}</td>
       
                                <!-- cor da nota AB1-->
                                @if($nota->AB1 < 7)
                                <td><center><div class=" notaVermelha" >{{number_format($nota->AB1 ,1)}}</div></center></td> 
                                @else
                                <td><center><div class=" notaAzul" >{{number_format($nota->AB1 ,1)}}</div></center></td> 
                                @endif
                                <!-- /Cor da nota AB1 -->
                                <!-- cor da nota AB2-->
                                @if($nota->AB2 < 7)
                                <td><center><div class=" notaVermelha" >{{number_format($nota->AB2 ,1)}}</div></center></td> 
                                @else
                                <td><center><div class=" notaAzul" >{{number_format($nota->AB2 ,1)}}</div></center></td> 
                                @endif
                                <!-- /Cor da nota AB2 -->
                                <!-- cor da nota RP-->
                                @if($nota->RP < 7)
                                    <td><center><div class=" notaVermelha" >{{number_format($nota->RP ,1)}}</div></center></td> 
                                @else
                                <td><center><div class=" notaAzul" >{{number_format($nota->RP ,1)}}</div></center></td> 
                                @endif
                                <!-- /Cor da nota RP -->
                                <!-- cor da nota AB3-->
                                @if($nota->AB3 < 7)
                                <td><center><div class=" notaVermelha" >{{number_format($nota->AB3 ,1)}}</div></center></td> 
                                @else
                                <td><center><div class=" notaAzul" >{{number_format($nota->AB3 ,1)}}</div></center></td> 
                                @endif
                                <!-- /Cor da nota AB3 -->
                                <!-- cor da nota AB4-->
                                @if($nota->AB4 < 7)
                                <td><center><div class=" notaVermelha" >{{number_format($nota->AB4 ,1)}}</div></center></td> 
                                @else
                                <td><center><div class=" notaAzul" >{{number_format($nota->AB4 ,1)}}</div></center></td> 
                                @endif
                                <!-- /Cor da nota AB4 -->
                                <td><center><div class=" notaVermelha" >{{number_format($mediaRP ,1)}}</div></center></td> 
                                @else
                                @endif
                                <!-- / Se a media de recuperação menor a 7 -->
                                @endif
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