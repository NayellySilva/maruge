<html>
    <header>   
        <title>{{$titulo ?? 'Resultado'}}</title>
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
        <button type="button" value="Imprimir" onclick="window.print()" class="botao btn-imprimir" style="margin: 15px;"> Imprimir</button>
        <div class="imprimir_conteudo">
            <table class="timbre">
            <tr>
                <td>
                    <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="160" height="160"><br>
                    @forelse($escolas as $escola)
                    {{ $escola->Rua ?? '' }} , {{ $escola->Numero ?? '' }}<br>
                    {{ $escola->Bairro ?? '' }} - CEP:{{ $escola->CEP ?? '' }}<br>
                    {{ $escola->Cidade ?? '' }} - {{ $escola->Estado ?? '' }}<br>
                    Tel: {{ $escola->Fone1 ?? '' }} / {{ $escola->Fone2 ?? '' }}<br>
                    E-mail:{{ $escola->EmailColegio ?? '' }}<br>
                    CNPJ: {{ $escola->CNPJ ?? '' }}<br>
                    INEP:{{ $escola->NumeroInep ?? '' }}
                </td>
            </tr>         
            @empty
            @endforelse
        </table>
        <div class="resultado-titulo"> {{ $titulo ?? '' }} - {{ $turma->AnoLetivo ?? '' }}<br>
            TURMA - {{ $turma->NomeTurma ?? '' }} 
        </div>  
        <!-- Armazenando os nomes do professores correspondentes a sua disciplina -->
        @forelse($professores as $professor)
        @if (isset ($professor->NomeFuncionario))
        <div class="row" align="center">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading ">
                        <strong> {{ $professor->NomeDisciplina }}:</strong> &nbsp;&nbsp;{{ $professor->NomeFuncionario }} 
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover fonteResultado">
                                <tbody>
                                <thead>
                                    <tr>
                                        <th>RA</th>
                                        <th>NOME ALUNO</th>
                                        <th>1º BIMESTRE</th>
                                        <th>2º BIMESTRE</th>
                                        <th>MÉDIA 1º SEMESTRE</th>
                                        <th>SITUAÇÃO</th>
                                    </tr>
                                </thead>
                                @forelse($professor->alunos ?? [] as $aluno)
                                <tr>
                                    <td>{{ $aluno->RA }}</td>
                                    <td>{{ $aluno->NomeAluno }}</td>
                                    <td>{{ $aluno->Nota_1Bimestre }}</td>
                                    <td>{{ $aluno->Nota_2Bimestre }}</td>
                                    <td>{{ $aluno->Media1Semestre }}</td>
                                    <td>
                                        @if($aluno->Media1Semestre >= 7)
                                            <span class="label label-success">APROVADO</span>
                                        @else
                                            <span class="label label-danger">RECUPERAÇÃO</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center">Nenhum aluno encontrado</td></tr>
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