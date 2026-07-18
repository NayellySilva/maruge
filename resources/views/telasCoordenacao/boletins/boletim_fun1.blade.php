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
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">    
        <!-- CSS compilada e minificada on-line do bootstrap-->
        <link href="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <button type="button"  value="Imprimir" onClick="window.print()" class="botao btn-imprimir"> Imprimir</button>
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
                    CNPJ: {{$escola->CNPJ}} -  INEP:{{$escola->NumeroInep}}
                </td>
            </tr>         
        </table>
        <div class="titulo-boletim">BOLETIM ESCOLAR <br>
            FUNDAMENTAL I  <br><strong>
            </strong>
        </div>
        <div class="inf_aluno_boletim">
            <p><strong>Matricula:  </strong> {{ $matricula->RA}}  <strong>Ano: </strong>  @foreach($anoletivo as $anoletivo)
                {{$anoletivo->AnoLetivo}}
                @endforeach</p>      
            <p> <strong>Aluno(a):</strong>{{ $aluno->NomeAluno}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Turma: </strong> {{$turma->NomeTurma}}</p>    
            <p> <strong>Filiação:</strong>{{ $Pais->NomePai}}&nbsp;/ {{ $Pais->NomeMae}}</p>    
        </div>      
  
    <center> <table class="table-striped boletim" border="1"  >
            <thead>
                <tr>
                    <th >CÓD</th>
                    <th >DISC.</th>
                    
                    <th ><center>1º BIM</center></th>
            <th ><center>2º BIM</center></td>
            <th ><center>REC.P</center></th>
            <th><center>3º BIM</center></th>
            <th ><center>4º BIM</center></th>
            <th ><center>REC.F</center></th>
            <th><center>MÉDIA</center></th>
            <th><center>RESULTADO</center></th>

            </thead>
            </tr>
            <!-- Recebendo valores na vareavel disciplinas e passando para disciplina -->
            @foreach($disciplinas as $key => $disciplina )
            <center>
                <tr>
                    <td > {{$disciplina->tb_disciplinas_idDisciplinas}} </td>
                    <td >{{substr ($disciplina->NomeDisciplina ,0,4 )}}</td>
                    <!-- Buscando notas do aluno diacordo com sua  dsiciplina -->
                    @php
                    $notasDoAluno = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
                    @endphp
                    <!-- INICIO DO FOREACH DA NOTA DA DISCILPLINA QUE TA LISTANDO-->
                    @forelse($notasDoAluno as $nota)
                    <!-- VERIFICA SE EXISTE NOTA NA DISCIPLINA QUE ESTA DENTRO DO LAÇO CORRENTE -->
                    @if (isset ($nota->AB1))
                    <!--CAMPOS DE DA TABELA DA  AB1-->
                    @if (($nota->AB1) == 0)
                    <td><center><div>-</div></center></td> 
                @elseif (($nota->AB1) < 7)
                <td><center><div class=" notaVermelha" >{{number_format($nota->AB1 ,1)}}</div></center></td> 
                @else
                <td><center><div class="  notaAzul" >{{number_format($nota->AB1 ,1)}}</div></center></td> 
                @endif
                <!-- / CAMPOS DE DA TABELA DA  AB1--> 
                <!--CAMPOS DE DA TABELA DA  AB2-->
                @if (($nota->AB2) == 0)
                <td><center><div>-</div></center></td> 
                @elseif (($nota->AB2) < 7)
                <td><center><div class=" notaVermelha" >{{number_format($nota->AB2 ,1)}}</div></center></td> 
                @else
                <td><center><div class="  notaAzul" >{{number_format($nota->AB2 ,1)}}</div></center></td> 
                @endif
                <!-- / CAMPOS DE DA TABELA DA  AB2--> 
                <!--CAMPOS DE DA TABELA DE RECUPERAÇÃO PARCIAL-->
                @if(($nota->RP) == 0)       
                <td><center><div>-</div></center></td>   
                @elseif(($nota->RP) < 7)
                <td><center><div class="  notaVermelha">{{number_format($nota->RP ,1)}}</div></center></td> 
                @else
                <td><center><div class="  notaAzul">{{number_format($nota->RP ,1)}}</div></center></td> 
                @endif
                <!-- / CAMPOS DE DA TABELA DE RECUPERAÇÃO PARCIAL-->                                  
                <!--CAMPOS DE DA TABELA DA  AB3-->
                @if (($nota->AB3) == 0)
                <td><center><div>-</div></center></td> 
                @elseif (($nota->AB3) < 7)
                <td><center><div class=" notaVermelha" >{{number_format($nota->AB3 ,1)}}</div></center></td> 
                @else
                <td><center><div class="  notaAzul" >{{number_format($nota->AB3 ,1)}}</div></center></td> 
                @endif
                <!-- / CAMPOS DE DA TABELA DA  AB4--> 
                <!--CAMPOS DE DA TABELA DA  AB4-->
                @if (($nota->AB4) == 0)
                <td><center><div>-</div></center></td> 
                @elseif (($nota->AB4) < 7)
                <td><center><div class=" notaVermelha" >{{number_format($nota->AB4 ,1)}}</div></center></td> 
                @else
                <td><center><div class="  notaAzul" >{{number_format($nota->AB4 ,1)}}</div></center></td> 
                @endif
                <!-- / CAMPOS DE DA TABELA DA  AB4-->
                <!--CAMPOS DE DA TABELA DE RECUPERAÇÃO FINAL-->
                @if(($nota->RF) == 0)       
                <td><center><div>-</div></center></td>   
                @elseif(($nota->RF) < 7)
                <td><center><div class="  notaVermelha">{{number_format($nota->RF ,1)}}</div></center></td> 
                @else
                <td><center><div class="  notaAzul">{{number_format($nota->RF ,1)}}</div></center></td> 
                @endif
                <!-- / CAMPOS DE DA TABELA DE RECUPERAÇÃO FINAL-->  
                <!--CAMPOS DE DA TABELA DE MEDIA E RESULTADO -->
                <!-- FAZENDO A MEDIAS -->
                @php 
                $mediaN = ($nota->AB1+$nota->AB2+$nota->AB3+$nota->AB4)/4; 
                $mediaRP = (($nota->RP * 2)+$nota->AB3+$nota->AB4)/4; 
                @endphp

                <!-- FAZENDO A MEDIA NORMAL SEM RECUPERAÇÕES -->
                @if(($nota->RP)== 0 && ($nota->RF)== 0) 
                
                @if(($mediaN) < 7)
                <td><center><div class="  notaVermelha">{{number_format($mediaN ,1)}}</div></center></td> 
                <td><center><div class="  notaVermelha">RECUPERAÇÃO</div></center></td> 
                @else
                <td><center><div class="  notaAzul">{{number_format($mediaN ,1)}}</div></center></td> 
                <td><center><div class="  notaAzul">APROVADO</div></center></td> 
                @endif
                <!-- / FAZENDO A MEDIA NORMAL SEM RECUPERAÇÕES -->
                <!-- FAZENDO A MEDIA COM NORA DE RECUPERAÇÃO PARCIAL -->
                @elseif(($nota->RP)!= 0 && ($nota->RF)== 0)
                @if(($mediaRP) < 7)
                <td><center><div class="  notaVermelha">{{number_format($mediaRP ,1)}}</div></center></td> 
                <td><center><div class="  notaVermelha">RECUPERAÇÃO - FINAL</div></center></td> 
                @else
                <td><center><div class="  notaAzul">{{number_format($mediaRP ,1)}}</div></center></td> 
                <td><center><div class="  notaAzul">APROVADO.REC</div></center></td> 
                @endif
                <!-- / FAZENDO A MEDIA COM NORA DE RECUPERAÇÃO PARCIAL -->                                                       
                @elseif(($nota->RF)!= 0)
                @if(($nota->RF) < 7)
                <td><center><div class="  notaVermelha">{{number_format($nota->RF ,1)}}</div></center></td> 
                <td><center><div class="  notaVermelha">REPROVADO</div></center></td> 
                @else
                <td><center><div class="  notaAzul">{{number_format($nota->RF ,1)}}</div></center></td> 
                <td><center><div class="  notaAzul">APROVADO.REC</div></center></td> 
                @endif                                                 
                @endif
                <!-- / CAMPOS DE DA TABELA DE MEDIA E RESULTADO-->                                                 
                </tr>
                @endif
                <!-- VERIFICA SE EXISTE NOTA NA DISCIPLINA QUE ESTA DENTRO DO LAÇO CORRENTE -->
                <!-- SE NÃO TIVE VALORES DENTRO DO FORELSE DO LAÇO CORRENTE -->
                @empty
                <!-- QUANDO NÃO EXISTE NOTA ELE MOSTRA CAMPSO COM TRAÇOS -->
                <td><center><div >-</div></center></td> 
                <td><center><div >-</div></center></td> 
                <td><center><div >-</div></center></td> 
                <td><center><div >-</div></center></td> 
                <td><center><div >-</div></center></td> 
                <td><center><div >-</div></center></td> 
                <td><center><div >-</div></center></td> 
                <td><center><div >-</div></center></td> 
                @endforelse 
                <!-- FIM DO FOREACHO QUE LISTA A DISCIPLINA-->
                @endforeach
        </table>


    </center>
            <br>

            
            
            
<!--  GRAFICO   -->

<!--
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Códigos de Disciplinas', '1º Bimestre', '2º Bimestre', '3º Bimestre','4º Bimestre'],
          
           @foreach($notasgraficos as $disciplina )
 ['{{ substr ($disciplina->tb_disciplinas_idDisciplinas ,0,4)}}', '{{ $disciplina->AB1}}', '{{ $disciplina->AB2}}', '{{ $disciplina->AB3}}','{{ $disciplina->AB4}}'],
 @endforeach
        ]);
        
        var options = {
          chart: {
            title: 'Grafico com Índice de Atenção',
            subtitle: 'Pontos elevados necessita de observações.',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

    <div id="columnchart_material" style="width: 1000px; height: 500px;"></div>

  

<br><br>


-->



<div class="row">
        
   <div class="col-md-6">
            <div class="inf_aluno_boletim margemAssinatura">
                 <p class="inf_aluno_boletim"><strong>Professor(a):______________________________________&nbsp;&nbsp;&nbsp;Responsável:_____________________________________</strong></p>
                 <p class="inf_aluno_boletim"><strong>Obs:__________________________________________________________________________________________________________________</strong></p>
                 <p class="inf_aluno_boletim"><strong>______________________________________________________________________________________________________________________</strong></p>
                 <p class="inf_aluno_boletim"><strong>______________________________________________________________________________________________________________________</strong></p>
             </div>
    </div>
                           
</div> 

    @empty
    @endforelse
</body>
</html>