<html>
    <head>
        <title>{{$titulo}}</title>
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
        <!-- Botão de impressão (ocultado automaticamente no modo de impressão) -->
        <button type="button" value="Imprimir" onClick="window.print()" class="botao btn-imprimir"> Imprimir</button>


        @forelse($escolas as $escola)
        <table class="carner">

<!-- MÊS JANEIRO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Janeiro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Janeiro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>

<!-- MÊS FEVEREIRO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Fevereiro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Fevereiro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>
            <!-- MÊS MARÇO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Março. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Março. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>
            <!-- MÊS ABRIL-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Abril. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Abril. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>
<!-- MÊS MAIO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Maio. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Maio. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>

<!-- MÊS Junho-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Junho. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Junho. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>
            <!-- MÊS JULHO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Julho. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Julho. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>
            <!-- MÊS AGOSTO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Agosto. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Agosto. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>
<!-- MÊS SETEMBRO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Setembro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Setembro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>

<!-- MÊS OUTUBRO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Outubro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Outubro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>
            <!-- MÊS NOVEMBRO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Novembro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Novembro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>
            <!-- MÊS DEZEMBRO-->
            <tr>
                <td>
                    <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Dezembro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$_______________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
               </td>
                <td>
                     <p class="centralizando">{{$escola->NomeEscola}}<br>
                        ANO LETIVO - {{$turma->AnoLetivo}}</p><br>
                    ALUNO:{{$aluno->NomeAluno}}<br><br>
                    RA: {{$matricula->RA}} &nbsp;&nbsp;&nbsp;&nbsp; Turma:{{$turma->NomeTurma}}<br>
                    Mês: Dezembro. <br>
                    Valor: R$ {{$turma->Mensalidade}}. Após dia 30: R$________________<br>
                    Total: R$___________.  Data: ______/_______/{{$turma->AnoLetivo}}.<br><br>
                    Venctº.:  dia 10 de cada mês
                </td>
            </tr>
        </table>
        @empty
        @endforelse







    </body>
</html>