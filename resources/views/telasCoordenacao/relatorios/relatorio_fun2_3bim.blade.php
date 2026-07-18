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
        <div class="boletin-acompanhamento-titulo"> BOLETIM DE ACOMPANHAMENTO - FUNDAMENTAL II <br> 3º BIMESTRE - <strong>
                @foreach($anoletivo as $anoletivo)
                {{$anoletivo->AnoLetivo}}
                @endforeach
            </strong></div>
        <div class="inf_aluno">
            <p><strong>Matricula:  </strong> {{ $matricula->RA}}</p>    
            <p> <strong>Aluno(a):</strong>{{ $aluno->NomeAluno}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Turma: </strong> {{$turma->NomeTurma}}</p>    
        </div>      
        <div class="boletim_acompanhamento_fun1">
            <p><strong>Tarefas de casa – organização – realização:</strong> (    ) Precisa Melhorar    (    ) Bom       (    ) Excelente   </p>
            <p><strong>Comportamento em sala de aula:</strong> (    ) Precisa Melhorar    (    ) Bom       (    ) Excelente   </p>
            <p><strong>Fardamento:</strong> (    ) Precisa Melhorar    (    ) Bom       (    ) Excelente   </p>
            <p><strong>Caligrafia:</strong> (    ) Precisa Melhorar    (    ) Bom       (    ) Excelente   </p>
            <p><strong>Material escolar. (organizado / vem completo ):</strong> (    ) Precisa Melhorar    (    ) Bom       (    ) Excelente   </p>
            <p><strong>Acompanhamento familiar:</strong> (    ) Precisa Melhorar    (    ) Bom       (    ) Excelente   </p>
            <p><strong>Participação em sala de aula:</strong> (    ) Precisa Melhorar    (    ) Bom       (    ) Excelente   </p>
            <p><strong>Rendimento:</strong> (    ) Precisa Melhorar    (    ) Bom       (    ) Excelente   </p>
        </div>
        <div class="boletim_acompanhamento"><p><strong><u>Notas:</u></strong></p></div>  
        <table class="table-striped notas_acompanhamento" border="1" align="center"  >
            <thead>
                <tr>
                    <th width="50">CÓD.</th>
                    <th>DISCIPLINAS</th>
                    <th width="80"><center>1º BIM.</center></th>
        <th width="80"><center>2º BIM.</center></td>
    <th width="80"><center>REC.P</center></th>
<th width="80"><center>3º BIM</center></th>

</thead>
</tr>
<!-- Recebendo valores na vareavel disciplinas e passando para disciplina -->
@foreach($disciplinas as $key => $disciplina )
<center>
    <tr>
        <td width="50" height="17"> {{$disciplina->tb_disciplinas_idDisciplinas}} </td>
        <td width="130">{{$disciplina->NomeDisciplina}}</td>
        <!-- Buscando notas do aluno diacordo com sua  dsiciplina -->
        @php
        $notasDoAluno = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
        @endphp
        <!-- INICIO DO FOREACH DA NOTA DA DISCILPLINA QUE TA LISTANDO-->
    @forelse($notasDoAluno as $nota)
        <!-- VERIFICA SE EXISTE NOTA NA DISCIPLINA QUE ESTA DENTRO DO LAÇO CORRENTE -->
        @if (isset ($nota->AB1))
       <!-- CRIANDO AS NOTAS REAIS -->
            @php 
            $nota->AB1 = ($nota->AB1+$nota->AM1)/2; 
            $nota->AB2 = ($nota->AB2+$nota->AM2)/2; 
            $nota->AB3 = ($nota->AB3+$nota->AM3)/2; 
            @endphp
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
                                        <!--CAMPOS DE DA TABELA DE RECUPERAÇÃO-->
                                                    @if(($nota->RP) == 0)       
                                                    <td><center><div>-</div></center></td>   
                                                    @elseif(($nota->RP) < 7)
                                                    <td><center><div class="  notaVermelha">{{number_format($nota->RP ,1)}}</div></center></td> 
                                                    @else
                                                    <td><center><div class="  notaAzul">{{number_format($nota->RP ,1)}}</div></center></td> 
                                                    @endif
                                        <!-- / CAMPOS DE DA TABELA DE RECUPERAÇÃO-->                                  
                                        <!--CAMPOS DE DA TABELA DA  AB3-->
                                                    @if (($nota->AB3) == 0)
                                                    <td><center><div>-</div></center></td> 
                                                    @elseif (($nota->AB3) < 7)
                                                    <td><center><div class=" notaVermelha" >{{number_format($nota->AB3 ,1)}}</div></center></td> 
                                                    @else
                                                    <td><center><div class="  notaAzul" >{{number_format($nota->AB3 ,1)}}</div></center></td> 
                                                    @endif
                                        <!-- / CAMPOS DE DA TABELA DA  AB3--> 
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
    
    @endforelse 
    <!-- FIM DO FOREACHO QUE LISTA A DISCIPLINA-->
    @endforeach
</table>
        
<div class="boletim_acompanhamento margemAssinatura">
    <p class="boletim_acompanhamento"><strong>Professor(a):_______________________________________&nbsp;&nbsp;&nbsp;Responsável:______________________________________</strong></p>
    <p class="boletim_acompanhamento"><strong>Obs:____________________________________________________________________________________________________________________</strong></p>
    <p class="boletim_acompanhamento"><strong>________________________________________________________________________________________________________________________</strong></p>
    <p class="boletim_acompanhamento"><strong>________________________________________________________________________________________________________________________</strong></p>
</div>
@empty
@endforelse
</body>
</html>