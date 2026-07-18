<html>
    <header>   
        <title>{{$titulo}}</title>
    </header>
    <body>
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
                    <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="150" height="150" ><br>
                </td>
                <td>
                    @forelse($escolas as $escola)
                    {{$escola->Rua}} , {{$escola->Numero}}<br>
                    {{$escola->Bairro}} - CEP:{{$escola->CEP}}<br>
                    {{$escola->Cidade}} - {{$escola->Estado}}<br>
                    Tel: {{$escola->Fone1}} / {{$escola->Fone2}}<br>
                    E-mail:{{$escola->EmailColegio}}<br>
                    CNPJ: {{$escola->CNPJ}}<br>
                    INEP:{{$escola->NumeroInep}}
                </td>
            </tr>         
        </table>
        @empty
        @endforelse
    <div class="cabecario-gabarito">  
   RA:  {{$Aluno->RA}}    ALUNO: {{$Aluno->NomeAluno}}  <br> DATA NASC. {{$Aluno->DataNascimento}}  <br>
   DATA PROVA. {{$mes}} <br>    TURMA: {{$turma->NomeTurma}} <br> <br> 
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
                    <img src="{{asset('imgs/icones/gabarito10.png')}}" width="200" height="200" ><br>
                </td>
            </tr>         
        </table>
        -----------------------------------------------------------------------------------------------------------------------------------------------------------
            @empty
            @endforelse
    </body>
</html>