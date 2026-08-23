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
       
        <div class="imprimir_conteudo">
        <table class="timbre">
            <tr>
                <td>
                    <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                    @forelse($escolas as $escola)
                    {{$escola->Rua}} , {{$escola->Numero}}<br>
                    {{$escola->Bairro}} - CEP:{{$escola->CEP}}<br>
                    {{$escola->Cidade}} - {{$escola->Estado}}<br>
                    Tel: {{$escola->Fone1}} / {{$escola->Fone2}}<br>
                    E-mail:{{$escola->EmailColegio}}<br>
                    CNPJ: {{$escola->CNPJ}}<br>
                    INEP:{{$escola->NumeroInep}}
                    @empty
                    @endforelse
                </td>
            </tr>                  
        </table>
        <div class="relatorios-titulo"> RELATÓRIO DE FREQUÊNCIAS DA TURMA {{$turma->NomeTurma}} 
            <br>
            <p>Total de alunos: <strong>{{$alunos->count()}}</strong>  
        </div>
<table class="table table-striped fonte">
<thead>
<tr>
    
<th><center>Nº</center></th>
<th><center>RA</center></th>
<th>NOME ALUNO</th>
<th>JAN</th>
<th>FEV</th>
<th>MAR</th>
<th>ABR</th>
<th>MAI</th>
<th>JUN</th>
<th>JUL</th>
<th>AGO</th>
<th>SET</th>
<th>OUT</th>
<th>NOV</th>
<th>DEZ</th>
</tr>
</thead>   
<tr>
<th></th>
<th></th>
<th></th>
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
<th>P - F - J</th> 
</tr>
<!-- Listando todos os alunos da turma -->
 @php
            $contando = 0;
            @endphp
            @forelse($alunos as $Aluno)      
            <tr >

                @if (isset ($Aluno))
                @php
                $contando == ($contando++)
                @endphp
    
    <td><center>{{$contando }}</center></td>
    <td><center>{{$Aluno->RA}}</center></td>
    <td width=330>{{$Aluno->NomeAluno}}</td> 
<!-- Aqui é até onde vai o forelse dos alunos as Aluno mas só fecha lá em baixo -->



<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE JANEIRO-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaJan = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="01");
                    @endphp
       
 @forelse($FrequenciaJan as $Jan)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaJanP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="01");
                    @endphp
                    @php
                    $FrequenciaJanF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="01");
                    @endphp
                    @php
                    $FrequenciaJanJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="01");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Jan->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Jan->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaJanP}} - {{$FrequenciaJanF}} - {{$FrequenciaJanJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE JANEIRO-->    
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE FEVEREIRO-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaFev = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="02");
                    @endphp
       
 @forelse($FrequenciaFev as $Fev)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaFevP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="02");
                    @endphp
                    @php
                    $FrequenciaFevF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="02");
                    @endphp
                    @php
                    $FrequenciaFevJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="02");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Fev->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Fev->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaFevP}} - {{$FrequenciaFevF}} - {{$FrequenciaFevJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE FEVEREIRO-->    
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE MARÇO-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaMar = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="03");
                    @endphp
       
 @forelse($FrequenciaMar as $Mar)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaMarP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="03");
                    @endphp
                    @php
                    $FrequenciaMarF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="03");
                    @endphp
                    @php
                    $FrequenciaMarJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="03");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Mar->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Mar->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaMarP}} - {{$FrequenciaMarF}} - {{$FrequenciaMarJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE MARÇO-->    
                    
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE ABRIL-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaAbr = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="04");
                    @endphp
       
 @forelse($FrequenciaAbr as $Abr)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaAbrP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="04");
                    @endphp
                    @php
                    $FrequenciaAbrF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="04");
                    @endphp
                    @php
                    $FrequenciaAbrJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="04");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Abr->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Abr->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaAbrP}} - {{$FrequenciaAbrF}} - {{$FrequenciaAbrJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE ABRIL-->  
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE MAIO-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaMai = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="05");
                    @endphp
       
 @forelse($FrequenciaMai as $Mai)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaMaiP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="05");
                    @endphp
                    @php
                    $FrequenciaMaiF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="05");
                    @endphp
                    @php
                    $FrequenciaMaiJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="05");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Mai->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Mai->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaMaiP}} - {{$FrequenciaMaiF}} - {{$FrequenciaMaiJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE MAIO-->  
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE JUNHO-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaJun = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="06");
                    @endphp
       
 @forelse($FrequenciaJun as $Jun)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaJunP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="06");
                    @endphp
                    @php
                    $FrequenciaJunF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="06");
                    @endphp
                    @php
                    $FrequenciaJunJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="06");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Jun->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Jun->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaJunP}} - {{$FrequenciaJunF}} - {{$FrequenciaJunJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE JUNHO-->  
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE JULHO-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaJul = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="07");
                    @endphp
       
 @forelse($FrequenciaJul as $Jul)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaJulP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="07");
                    @endphp
                    @php
                    $FrequenciaJulF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="07");
                    @endphp
                    @php
                    $FrequenciaJulJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="07");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Jul->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Jul->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaJulP}} - {{$FrequenciaJulF}} - {{$FrequenciaJulJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE JULHO-->  
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE Agosto-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaAgo = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="08");
                    @endphp
       
 @forelse($FrequenciaAgo as $Ago)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaAgoP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="08");
                    @endphp
                    @php
                    $FrequenciaAgoF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="08");
                    @endphp
                    @php
                    $FrequenciaAgoJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="08");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Ago->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Ago->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaAgoP}} - {{$FrequenciaAgoF}} - {{$FrequenciaAgoJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE AGOSTO-->  
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE SET-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaSet = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="09");
                    @endphp
       
 @forelse($FrequenciaSet as $Set)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaSetP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="09");
                    @endphp
                    @php
                    $FrequenciaSetF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="09");
                    @endphp
                    @php
                    $FrequenciaSetJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="09");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Set->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Set->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaSetP}} - {{$FrequenciaSetF}} - {{$FrequenciaSetJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE SET-->  
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE OUTUBRO-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaOut = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="10");
                    @endphp
       
 @forelse($FrequenciaOut as $Out)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaOutP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="10");
                    @endphp
                    @php
                    $FrequenciaOutF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="10");
                    @endphp
                    @php
                    $FrequenciaOutJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="10");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Out->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Out->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaJunP}} - {{$FrequenciaJunF}} - {{$FrequenciaJunJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE OUTUBRO-->  
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE NOVEMBRO-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaNov = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="11");
                    @endphp
       
 @forelse($FrequenciaNov as $Nov)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaNovP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="11");
                    @endphp
                    @php
                    $FrequenciaNovF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="11");
                    @endphp
                    @php
                    $FrequenciaNovJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="11");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Nov->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Nov->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaNovP}} - {{$FrequenciaNovF}} - {{$FrequenciaNovJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE NOVEMBRO-->  
<!-- --------------------------------------------------------------------------------->
<!-- COMEÇO DE DEZEMBRO-->
<!-- Abaixo pegamos o id do aluno e vai verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaJun = \App\Models\modelCoordenacao\tb_frequencia::Busca_Frequencia_do_Aluno($Aluno->idAluno, $mes="12");
                    @endphp
       
 @forelse($FrequenciaJun as $Jun)
          <!-- Fim da Busca que verificar se exite faltas no mes de janeiro-->
                    @php
                    $FrequenciaJunP = \App\Models\modelCoordenacao\tb_frequencia::Busca_Presenca($Aluno->idAluno, $mes="12");
                    @endphp
                    @php
                    $FrequenciaJunF = \App\Models\modelCoordenacao\tb_frequencia::Busca_Falta($Aluno->idAluno, $mes="12");
                    @endphp
                    @php
                    $FrequenciaJunJ = \App\Models\modelCoordenacao\tb_frequencia::Busca_Justificado($Aluno->idAluno, $mes="12");
                    @endphp
                    <!-- Verifiva verificando se existe frequencia no meus solicitado -->
                    @if (isset ($Jun->mes))
                                <!-- exibindo se tem ou não tem frequencia-->
                                @if ($Jun->mes == 0) <!-- quando não houver frequencia-->
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @else
                    <td><center><div class="Mapa_notaAzul">{{$FrequenciaJunP}} - {{$FrequenciaJunF}} - {{$FrequenciaJunJ}} </div> </center></td> 
                    <!-- / exibindo se tem ou não tem frequencia -->
                    @endif    
                    <!-- / quando não houver frequencia -->
                    @endif
                    <!-- / Verifiva verificando se existe frequencia no meus solicitado-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
                    <!-- / --------------------------------------------------------------->    
                    <!-- / FIM DE DEZEMBRO-->  


    </tr>
    @endif <!-- Fechando o Contador -->
@empty
@endforelse
<!-- Finalizando a listagem dos alunos da turma -->




</table>
</body>
</html>