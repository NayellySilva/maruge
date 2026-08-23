@php
    try {
        $escolas = $escolas ?? \DB::table('tb_dados_escola')->first();
        $endereco = $endereco ?? $escolas;
    } catch (\Exception $e) {
        $escolas = null;
        $endereco = null;
    }
@endphp
<html>
    <head>
        <title>Relatório Geral da Escola</title>
        <style media="print">
            .botao {
                display: none;
            }
        </style>
        <!-- CSS Personalizado para o Painel -->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS para Reset de Estilos -->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">
    </head>
    <body>
        <button type="button" value="Imprimir" onClick="window.print()" class="botao btn-imprimir"> Imprimir</button>
        <div class="imprimir_conteudo">
        <table class="timbre">
            <tr>
                <td>
                    <center>
                        <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                        {{$endereco->Rua ?? ''}} , {{$endereco->Numero ?? ''}}<br>
                        {{$endereco->Bairro ?? ''}} - CEP:{{$endereco->CEP ?? ''}}<br>
                        {{$endereco->Cidade ?? ''}} - {{$endereco->Estado ?? ''}}<br>
                        Tel: {{$endereco->Fone1 ?? ''}} / {{$endereco->Fone2 ?? ''}}<br>
                        {{$escolas->EmailColegio ?? ''}}<br>
                        CNPJ: {{$escolas->CNPJ ?? ''}}<br>
                        INEP: {{$escolas->NumeroInep ?? ''}}
                    </center>
                </td>
            </tr>            
        </table>
        </div> 
        <!-- FINAL DO TIMBRE -->
        <!--inicio dos relatórios-->
        <h2 class="resultado">Alunos Cadastrados: {{$quantAlunosCadastrados ?? 0}}</h2>
        <h2 class="resultado">Alunos Ativos: {{$quantMatriculasAtivas ?? 0}}</h2>
        <h2 class="resultado">Alunos Inativos: {{$quantMatriculasInativas ?? 0}}</h2>
        <h2 class="resultado">Total de Turmas: {{$quantTurmasAtivas ?? 0}}</h2>
        <h2 class="resultado">Total de Disciplinas: {{$quantDisciplina ?? 0}}</h2>
        <h2 class="resultado">Total de Funcionários: {{$quantFuncionariosCadastrados ?? 0}}</h2>
        <h2 class="resultado">Total de Usuários: {{$quantUsuarioCadastrados ?? 0}}</h2>
    </body>
</html>
