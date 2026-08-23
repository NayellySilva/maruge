<html>
    <head>
        <title>{{$titulo}}</title>
        <style media="print">
            .botao {
                display: none;
            }
        </style>
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">
    </head>
    <body>
        <button type="button" value="Imprimir" onClick="window.print()" class="botao btn-imprimir"> Imprimir</button>
        <table class="timbre">
            <tr>
                <td>
                    <img src="{{url('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                    @forelse($escolas as $escola)
                    {{$escola->Rua}} , {{$escola->Numero}}<br>
                    {{$escola->Bairro}} - CEP:{{$escola->CEP}}<br>
                    {{$escola->Cidade}} - {{$escola->Estado}}<br>
                    Tel: {{$escola->Fone1}} / {{$escola->Fone2}}<br>
                    E-mail:{{$escola->EmailColegio}}<br>
                    CNPJ: {{$escola->CNPJ}} -  INEP:{{$escola->NumeroInep}}<br>
                    <strong>  Parecer 480/2014 </strong>
                </td>
            </tr>         
        </table>
        <div class="titulo-boletim">HISTÓRICO ESCOLAR<br>
        </div>
        <div class="inf_aluno_boletim">
         <p> <strong>Aluno(a):</strong>{{ $aluno->NomeAluno}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p> 
         <p><strong>Naturalidade: </strong> {{$aluno->CidadeCartorio}} <strong>Data Nascimento: </strong> {{$aluno->DataNascimento}}</p>    
         <p> <strong>Filiação:</strong>{{ $Pais->NomePai}}&nbsp;/ {{ $Pais->NomeMae}}</p>    
        </div>      
    @empty
    @endforelse 
<!-- INICIO DE CODIGO 2016 -->   
  <!-- ano grande comentado  <center class="titulo-boletim"><strong>@foreach($Ano2016 as $key => $AnoLetivo2016 )
          <td > <center> {{substr ($AnoLetivo2016->AnoLetivo ,0,7 )}}</center></td>
        @endforeach
</strong></center -->
        <table class="table-striped table-bordered mapa" >    
            <thead  >
    <tr>             
        <th width=80>ANO LETIVO / RESULTADO FINAL</th>                 
        <!-- DISCIPLINAS de 2016 -->
        @foreach($disciplinas2016 as $key => $disciplina )
        <th width=100 >  {{substr ($disciplina->NomeDisciplina ,0,4 )}}</th>
        @endforeach
    </tr>
</thead>  
    <tr>
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--********************* CODIGO ANO 2016 *************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
      <!-- Postando o nome da Turma de 2016-->
          @foreach($Ano2016 as $key => $NomeTurma)<td><center>{{substr ($AnoLetivo2016->AnoLetivo ,0,7 )}} / {{substr ($NomeTurma->NomeTurma ,0,7 )}}</center></td>@endforeach 
    <!-- pecorrendo a lista da disciplinas 2016 existente da turma e para consulta se existe nota-->
        @foreach($disciplinas2016 as $key => $disciplina )
        <!-- Buscando a nota referente a disciplina -->
                    @php
                    $notasDoAluno = \App\Models\modelCoordenacao\tb_notas_2016::busca_notas_do_aluno_2016($aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
                    @endphp
        <!-- Declarando as notas e criando um laço pra elas -->            
        @forelse($notasDoAluno as $nota)
        <!-- Verifiva se existe noda de AB4 da X disciplina -->
                    @if (isset ($nota->AB4))
                               <!-- FAZENDO A MEDIAS -->
                                                    @php 
                                                    $mediaN = ($nota->AB1+$nota->AB2+$nota->AB3+$nota->AB4)/4; 
                                                    $mediaRP = (($nota->RP * 2)+$nota->AB3+$nota->AB4)/4; 
                                                    @endphp
                                <!-- FAZENDO A MEDIA NORMAL SEM RECUPERAÇÕES -->
                                                    @if(($nota->RP)== 0 && ($nota->RF)== 0) 
                                                            @if(($mediaN) < 7)
                                                            <td><center><div class="  notaVermelha">{{number_format($mediaN ,1)}}</div></center></td> 
                                                            @else
                                                            <td><center><div class="  notaAzul">{{number_format($mediaN ,1)}}</div></center></td> 
                                                            @endif
                                        <!-- / FAZENDO A MEDIA NORMAL SEM RECUPERAÇÕES -->
                                        <!-- FAZENDO A MEDIA COM NORA DE RECUPERAÇÃO PARCIAL -->
                                                    @elseif(($nota->RP)!= 0 && ($nota->RF)== 0)
                                                            @if(($mediaRP) < 7)
                                                            <td><center><div class="  notaVermelha">{{number_format($mediaRP ,1)}}</div></center></td> 
                                                            @else
                                                            <td><center><div class="  notaAzul">{{number_format($mediaRP ,1)}}</div></center></td> 
                                                            @endif
                                        <!-- / FAZENDO A MEDIA COM NORA DE RECUPERAÇÃO PARCIAL -->                                                       
                                                    @elseif(($nota->RF)!= 0)
                                                            @if(($nota->RF) < 7)
                                                            <td><center><div class="  notaVermelha">{{number_format($nota->RF ,1)}}</div></center></td> 
                                                            @else
                                                            <td><center><div class="  notaAzul">{{number_format($nota->RF ,1)}}</div></center></td> 
                                                            @endif                                                 
                                                    @endif
                                        <!-- / CAMPOS DE DA TABELA DE MEDIA E RESULTADO-->        
           <!-- / Verifiva se existe noda de AB4 da X disciplina -->
                    @endif
                    <!-- / Declarando as notas e criando um laço pra elas (quando não existir nota)-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
    <!-- / pecorrendo a lista da disciplinas existente da turma e para consulta se existe nota-->
        @endforeach
    </tr>
</table>
    <!-- FIM CODIGO 2016 -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--********************* CODIGO ANO 2017 *************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
 <!-- INICIO DE CODIGO 2017 -->   
  <!-- ano grande comentado  <center class="titulo-boletim"><strong>@foreach($Ano2017 as $key => $AnoLetivo2017 )
          <td > <center> {{substr ($AnoLetivo2017->AnoLetivo ,0,7 )}}</center></td>
        @endforeach
</strong></center> -->
        <table class="table-striped table-bordered mapa" >    
 <thead>
    <tr>             
        <th width=80>ANO LETIVO / RESULTADO FINAL</th>                 
        <!-- DISCIPLINAS de 2017 -->
        @foreach($disciplinas2017 as $key => $disciplina )
        <th width=100 >  {{substr ($disciplina->NomeDisciplina ,0,4 )}}</th>
        @endforeach
    </tr>
</thead>  
    <tr>
      <!-- Postando o nome da Turma de 2017-->
          @foreach($Ano2017 as $key => $NomeTurma)<td><center>{{substr ($AnoLetivo2017->AnoLetivo ,0,7 )}} / {{substr ($NomeTurma->NomeTurma ,0,7 )}}</center></td>@endforeach 
     <!-- pecorrendo a lista da disciplinas 2017 existente da turma e para consulta se existe nota-->
        @foreach($disciplinas2017 as $key => $disciplina )
        <!-- Buscando a nota referente a disciplina -->
                    @php
                    $notasDoAluno = \App\Models\modelCoordenacao\tb_notas_2017::busca_notas_do_aluno_2017($aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
                    @endphp
        <!-- Declarando as notas e criando um laço pra elas -->            
        @forelse($notasDoAluno as $nota)
        <!-- Verifiva se existe noda de AB4 da X disciplina -->
                    @if (isset ($nota->AB4))
                               <!-- FAZENDO A MEDIAS -->
                                                    @php 
                                                    $mediaN = ($nota->AB1+$nota->AB2+$nota->AB3+$nota->AB4)/4; 
                                                    $mediaRP = (($nota->RP * 2)+$nota->AB3+$nota->AB4)/4; 
                                                    @endphp
                                <!-- FAZENDO A MEDIA NORMAL SEM RECUPERAÇÕES -->
                                                    @if(($nota->RP)== 0 && ($nota->RF)== 0) 
                                                            @if(($mediaN) < 7)
                                                            <td><center><div class="  notaVermelha">{{number_format($mediaN ,1)}}</div></center></td> 
                                                            @else
                                                            <td><center><div class="  notaAzul">{{number_format($mediaN ,1)}}</div></center></td> 
                                                            @endif
                                        <!-- / FAZENDO A MEDIA NORMAL SEM RECUPERAÇÕES -->
                                        <!-- FAZENDO A MEDIA COM NORA DE RECUPERAÇÃO PARCIAL -->
                                                    @elseif(($nota->RP)!= 0 && ($nota->RF)== 0)
                                                            @if(($mediaRP) < 7)
                                                            <td><center><div class="  notaVermelha">{{number_format($mediaRP ,1)}}</div></center></td> 
                                                            @else
                                                            <td><center><div class="  notaAzul">{{number_format($mediaRP ,1)}}</div></center></td> 
                                                            @endif
                                        <!-- / FAZENDO A MEDIA COM NORA DE RECUPERAÇÃO PARCIAL -->                                                       
                                                    @elseif(($nota->RF)!= 0)
                                                            @if(($nota->RF) < 7)
                                                            <td><center><div class="  notaVermelha">{{number_format($nota->RF ,1)}}</div></center></td> 
                                                            @else
                                                            <td><center><div class="  notaAzul">{{number_format($nota->RF ,1)}}</div></center></td> 
                                                            @endif                                                 
                                                    @endif
                                        <!-- / CAMPOS DE DA TABELA DE MEDIA E RESULTADO-->        
           <!-- / Verifiva se existe noda de AB4 da X disciplina -->
                    @endif
                    <!-- / Declarando as notas e criando um laço pra elas (quando não existir nota)-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
    <!-- / pecorrendo a lista da disciplinas existente da turma e para consulta se existe nota-->
        @endforeach
    </tr>
</table>
    <!-- FIM CODIGO 2017 -->   
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--********************* CODIGO ANO LETIVO ************************* -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->
    <!--***************************************************************** -->  
<!-- ano grande comentado <center class="titulo-boletim"><strong>
          <td > <center> {{$turma->AnoLetivo}} </center></td>
</strong></center> -->
        <table class="table-striped table-bordered mapa" >    
 <thead>
    <tr>             
        <th width=110>ANO LETIVO / RESULTADO FINAL</th>                 
        <!-- DISCIPLINAS de 2017 -->
        @foreach($disciplinas as $key => $disciplina )
        <th width=100 >  {{substr ($disciplina->NomeDisciplina ,0,4 )}}</th>
        @endforeach
    </tr>
</thead>  
    <tr>
      <!-- Postando o nome da Turma de 2017-->
         <td><center>{{$turma->AnoLetivo}}  / {{substr ($turma->NomeTurma ,0,7 )}}</center></td>
        @foreach($disciplinas as $key => $disciplina )
        <!-- Buscando a nota referente a disciplina -->
                    @php
                    $notasDoAluno = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
                    @endphp
        <!-- Declarando as notas e criando um laço pra elas -->            
        @forelse($notasDoAluno as $nota)
        <!-- Verifiva se existe noda de AB4 da X disciplina -->
                    @if (isset ($nota->AB4))
                               <!-- FAZENDO A MEDIAS -->
                                                    @php 
                                                    $mediaN = ($nota->AB1+$nota->AB2+$nota->AB3+$nota->AB4)/4; 
                                                    $mediaRP = (($nota->RP * 2)+$nota->AB3+$nota->AB4)/4; 
                                                    @endphp
                                <!-- FAZENDO A MEDIA NORMAL SEM RECUPERAÇÕES -->
                                                    @if(($nota->RP)== 0 && ($nota->RF)== 0) 
                                                            @if(($mediaN) < 7)
                                                            <td><center><div class="  notaVermelha">{{number_format($mediaN ,1)}}</div></center></td> 
                                                            @else
                                                            <td><center><div class="  notaAzul">{{number_format($mediaN ,1)}}</div></center></td> 
                                                            @endif
                                        <!-- / FAZENDO A MEDIA NORMAL SEM RECUPERAÇÕES -->
                                        <!-- FAZENDO A MEDIA COM NORA DE RECUPERAÇÃO PARCIAL -->
                                                    @elseif(($nota->RP)!= 0 && ($nota->RF)== 0)
                                                            @if(($mediaRP) < 7)
                                                            <td><center><div class="  notaVermelha">{{number_format($mediaRP ,1)}}</div></center></td> 
                                                            @else
                                                            <td><center><div class="  notaAzul">{{number_format($mediaRP ,1)}}</div></center></td> 
                                                            @endif
                                        <!-- / FAZENDO A MEDIA COM NORA DE RECUPERAÇÃO PARCIAL -->                                                       
                                                    @elseif(($nota->RF)!= 0)
                                                            @if(($nota->RF) < 7)
                                                            <td><center><div class="  notaVermelha">{{number_format($nota->RF ,1)}}</div></center></td> 
                                                            @else
                                                            <td><center><div class="  notaAzul">{{number_format($nota->RF ,1)}}</div></center></td> 
                                                            @endif                                                 
                                                    @endif
                                        <!-- / CAMPOS DE DA TABELA DE MEDIA E RESULTADO-->        
           <!-- / Verifiva se existe noda de AB4 da X disciplina -->
                    @endif
                    <!-- / Declarando as notas e criando um laço pra elas (quando não existir nota)-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
    <!-- / pecorrendo a lista da disciplinas existente da turma e para consulta se existe nota-->
        @endforeach
    </tr>
</table>
</body>
</html>