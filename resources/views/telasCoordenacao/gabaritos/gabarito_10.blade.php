<html>
    <header>   
        <title>{{$titulo ?? 'Gabaritos'}}</title>
    </header>
    <body>
        @php
            if (!isset($escolas) || empty($escolas) || !isset($escolas->first()->Rua)) {
                try { $escolas = \App\Models\modelCoordenacao\tb_escola::informacaoEscolar(); } catch (\Exception $e) { $escolas = collect(); }
            }
            if (!isset($Alunos)) {
                $idTurmas = request()->route('id') ?? request()->query('idTurmas') ?? 1;
                try {
                    $Alunos = \App\Models\modelCoordenacao\tb_aluno::alunosPorTurma($idTurmas);
                    $turma = \DB::table('tb_turmas')->where('idTurmas', $idTurmas)->first();
                } catch (\Exception $e) {
                    $Alunos = collect();
                }
            }
            if (!isset($mes)) {
                $mes = date('d / m / y');
            }
        @endphp
        <style media="print">
            .botao {
                display: none;
            }
        </style>
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">       
        <button type="button"  value="Imprimir" onClick="window.print()" class="botao btn-imprimir"> Imprimir</button>
    @forelse($Alunos as $Aluno)      
        <table class="timbre-gabarito">
            <tr>
                <td>
                    <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="150" height="150"><br>
                </td>
                <td>
                    @foreach($escolas as $escola)
                        {{ $escola->Rua ?? '' }} , {{ $escola->Numero ?? '' }}<br>
                        {{ $escola->Bairro ?? '' }} - CEP:{{ $escola->CEP ?? '' }}<br>
                        {{ $escola->Cidade ?? '' }} - {{ $escola->Estado ?? '' }}<br>
                        Tel: {{ $escola->Fone1 ?? '' }} / {{ $escola->Fone2 ?? '' }}<br>
                        E-mail:{{ $escola->EmailColegio ?? '' }}<br>
                        CNPJ: {{ $escola->CNPJ ?? '' }}<br>
                        INEP:{{ $escola->NumeroInep ?? '' }}
                    @endforeach
                </td>
            </tr>         
        </table>

        <div class="cabecario-gabarito">  
            RA:  {{$Aluno->RA ?? ''}}    ALUNO: {{$Aluno->NomeAluno ?? ''}}  <br> DATA NASC. {{$Aluno->DataNascimento ?? ''}}  <br>
            DATA PROVA. {{$mes ?? ''}} <br>    TURMA: {{$turma->NomeTurma ?? ''}} <br> <br> 
            DISCIPLINA:__________________________________
        </div>
        <hr class="linha">   
        <table>
            <tr>
                <td>
                    <div class="cabecario-informacoes"> INSTRUÇÕES PARA PREENCHIMENTO:<br><br>
                    <ol>
                    <li>MARQUE APENAS UMA RESPOSTA POR QUESTÃO.</li>
                    <li>MAIS DE UMA MARCAÇÃO ANULA A RESPOSTA.</li>
                    <li>PREENCHA TODO O ESPAÇO DO QUADRO.</li>
                    <li>ASSINALE AS SUAS RESPOSTAS COM CANETA AZUL OU PRETA.</li>
                    <li>NÃO HAVERÁ SUBSTITUIÇÃO DO GABARITO.</li>
                    </ol>
                    </div>
                </td>
                <td>
                    <div class="frequencia-gabarito"> ########### CARTÃO-RESPOSTA ########### </div> <br>  
                    <img src="{{asset('imgs/icones/gabarito10.png')}}" width="200" height="200"><br>
                </td>
            </tr>         
        </table>
        <hr class="quebrada">
    @empty
        <div class="text-center p-4">Nenhum aluno encontrado para este gabarito.</div>
    @endforelse
    </body>
</html>