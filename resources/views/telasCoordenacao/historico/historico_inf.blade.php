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
                    CNPJ: {{$escola->CNPJ}} -  INEP:{{$escola->NumeroInep}}
                </td>
            </tr>         
        </table>
        
        
        <table width="330" border="1" class="legenda">
  <tr>
    <td><b>SIGLAS</b></td>
    <td><b>DESCRIÇÃO</b></td>
    <td><b>NOTA</b></td>
  </tr>
  <tr>
    <td><CENTER><b>E</b></CENTER></td>
    <td>EXCELENTE </td>
    <td><CENTER>10</td>
  </tr>
  <tr>
    <td><CENTER><b>O</b></CENTER></td>
    <td>ÓTIMO </td>
    <td><CENTER>9</td>
  </tr>
  <tr>
    <td><b><center>B</center></b></td>
    <td>BOM</td>
    <td><CENTER>8</td>
  </tr>
  <tr>
    <td><b><center>S</center></b></td>
    <td>SATISFATÓRIO </td>
    <td><CENTER>7</td>
  </tr>
</table>
               
        <div class="titulo-boletim">BOLETIM ESCOLAR <br>
            INFANTIL  <br><strong>
                @foreach($anoletivo as $anoletivo)
                {{$anoletivo->AnoLetivo}}
                @endforeach
            </strong>
        </div>
        <div class="inf_aluno_boletim">
            <p><strong>Matricula:  </strong> {{ $matricula->RA}}</p>    
            <p> <strong>Aluno(a):</strong>{{ $aluno->NomeAluno}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Turma: </strong> {{$turma->NomeTurma}}</p>    
            <p> <strong>Filiação:</strong>{{ $Pais->NomePai}}&nbsp;/ {{ $Pais->NomeMae}}</p>    
        </div>      
    <center class="titulo-boletim"><strong>BOLETIM</strong></center>
    <center>

        <table class="table-striped boletim" border="1"  style="font-size: 14px"  >
            <thead>
                <tr>
                    <th>CÓD</th>
                    <th>DISCIPLINAS</th>
                    <th>1º BIM</th>
            <th>2º BIM</th>
            <th>3º BIM</th>
            <th>4º BIM</th>
            <th>MÉDIA</th>
            <th>RESULTADO</th>
            </thead>
            </tr>
            <!-- Recebendo valores na vareavel disciplinas e passando para disciplina -->
            @foreach($disciplinas as $key => $disciplina )
            <center>
                <tr>
                    <td width="50" height="17" style="align-items: center" > {{$disciplina->tb_disciplinas_idDisciplinas}} </td>
                    <td width="130">{{$disciplina->NomeDisciplina}}</td>
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
                @elseif (($nota->AB1) < 8)
                <td><center><div class="  notaAzulBoletim" >S</div></center></td> 
                @elseif (($nota->AB1) < 9)
                <td><center><div class="  notaAzulBoletim" >B</div></center></td> 
                @elseif (($nota->AB1) < 10)
                <td><center><div class="  notaAzulBoletim" >O</div></center></td> 
                @else
                <td><center><div class="  notaAzulBoletim" >E</div></center></td>     
            @endif
            <!-- / CAMPOS DE DA TABELA DA  AB1--> 
            <!--CAMPOS DE DA TABELA DA  AB2-->
            @if (($nota->AB2) == 0)
                <td><center><div>-</div></center></td> 
                @elseif (($nota->AB2) < 8)
                <td><center><div class="  notaAzulBoletim" >S</div></center></td> 
                @elseif (($nota->AB2) < 9)
                <td><center><div class="  notaAzulBoletim" >B</div></center></td> 
                @elseif (($nota->AB2) < 10)
                <td><center><div class="  notaAzulBoletim" >O</div></center></td> 
                @else
                <td><center><div class="  notaAzulBoletim" >E</div></center></td>     
            @endif
            <!-- / CAMPOS DE DA TABELA DA  AB2--> 
            <!--CAMPOS DE DA TABELA DA  AB3-->
            @if (($nota->AB3) == 0)
                <td><center><div>-</div></center></td> 
                @elseif (($nota->AB3) < 8)
                <td><center><div class="  notaAzulBoletim" >S</div></center></td> 
                @elseif (($nota->AB3) < 9)
                <td><center><div class="  notaAzulBoletim" >B</div></center></td> 
                @elseif (($nota->AB3) < 10)
                <td><center><div class="  notaAzulBoletim" >O</div></center></td> 
                @else
                <td><center><div class="  notaAzulBoletim" >E</div></center></td>     
            @endif
            <!-- / CAMPOS DE DA TABELA DA  AB3--> 
            <!--CAMPOS DE DA TABELA DA  AB4-->
            @if (($nota->AB4) == 0)
                <td><center><div>-</div></center></td> 
                @elseif (($nota->AB4) < 8)
                <td><center><div class="  notaAzulBoletim" >S</div></center></td> 
                @elseif (($nota->AB4) < 9)
                <td><center><div class="  notaAzulBoletim" >B</div></center></td> 
                @elseif (($nota->AB4) < 10)
                <td><center><div class="  notaAzulBoletim" >O</div></center></td> 
                @else
                <td><center><div class="  notaAzulBoletim" >E</div></center></td>     
            @endif
            <!-- / CAMPOS DE DA TABELA DA  AB4--> 
            <!-- FAZENDO A MEDIAS -->
                @php 
                $media = ($nota->AB1+$nota->AB2+$nota->AB3+$nota->AB4)/4; 
                @endphp
            <!--CAMPOS DE DA TABELA MEDIA-->
            @if (($media) == 0)
                <td><center><div>-</div></center></td> 
                @elseif (($media) < 8)
                <td><center><div class="  notaAzulBoletim" >S</div></center></td> 
                @elseif (($media) < 9)
                <td><center><div class="  notaAzulBoletim" >B</div></center></td> 
                @elseif (($media) < 10)
                <td><center><div class="  notaAzulBoletim" >O</div></center></td> 
                @else
                <td><center><div class="  notaAzulBoletim" >E</div></center></td>     
            @endif
            <!-- / CAMPOS DE DA TABELA MEDIA--> 
            <!--CAMPOS DE DA TABELA RESULTADO-->
            @if (($media) < 6)
                <td><center><div class="  notaVermelhaBoletim" >REPROVADO</div></center></td> 
                @else
                <td><center><div class="  notaAzulBoletim" >APROVADO</div></center></td>     
            @endif
            <!-- / CAMPOS DE DA TABELA RESULTADO-->    
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
                @endforelse 
                <!-- FIM DO FOREACHO QUE LISTA A DISCIPLINA-->
                @endforeach
        </table>
    </center>
    <div class="inf_aluno_boletim margemAssinatura">
        <p class="inf_aluno_boletim"><strong>Professor(a):_______________________________________&nbsp;&nbsp;&nbsp;Responsável:______________________________________</strong></p>
        <p class="inf_aluno_boletim"><strong>Obs:____________________________________________________________________________________________________________________</strong></p>
        <p class="inf_aluno_boletim"><strong>________________________________________________________________________________________________________________________</strong></p>
        <p class="inf_aluno_boletim"><strong>________________________________________________________________________________________________________________________</strong></p>
    </div>
    @empty
    @endforelse
</body>
</html>