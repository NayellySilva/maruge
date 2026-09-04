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
        <div class="boletin-acompanhamento-titulo"> BOLETIM DE ACOMPANHAMENTO - FUNDAMENTAL I <br> 1º BIMESTRE - <strong>
                @foreach($anoletivo as $anoletivo)
                {{$anoletivo->AnoLetivo}}
                @endforeach
            </strong></div>
        <div class="inf_aluno">
            <p><strong>Nº MAC: </strong> {{ $aluno->NumeroMac ?? $aluno->RA ?? '-' }}</p> 
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
          
            
       
            
            <!--
           
            
             <p><strong>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) TURMA DE 3 ANOS:</strong> Ano Letivo 2021 - Modalidade. (Participação presencial três vezes por semana). <br> <br>
            <p><strong>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) TURMA DE 4 ANOS ATÉ 2º ANO:</strong> Ano Letivo 2021 - Modalidade híbrida - Decreto que traz alteração - 33.936-17/02/2021- modalidade remota. 
                Modalidade híbrida retornando em 12/04/2021<br> <br>
            <p><strong>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) TURMA DO 3º AO 9º ANO:</strong> Ano Letivo 2021 - Modalidade híbrida - Decreto que traz alteração - 33.936-17/02/2021- modalidade remota. 
                Modalidade híbrida retornando em 26/04/2021<br> <br><br>
              
              
              
              
              
            <p><li><strong>Integração em aula online (pelo aplicativo MEET):</strong> <br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (    ) Excelente    (    ) Bom       (    ) Satisfatório   </p> <br>
            
            <p><li><strong>Tarefas semanais realizadas (Recebidas em drive thru):</strong> <br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (    ) Excelente    (    ) Bom       (    ) Satisfatório   </p> <br>
            
            <p><li><strong>Ultilização do livro didático e paradidático:</strong> <br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (    ) Excelente    (    ) Bom       (    ) Satisfatório   </p> <br>
            
            <p><li><strong>Interação com a escola no Período pandêmico:</strong> <br>
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (    ) Excelente    (    ) Bom       (    ) Satisfatório   </p> <br>
            
              
     -->
            
            
        </div>
                
                
        <div class="boletim_acompanhamento"><p><strong><u>Notas:</u></strong></p></div>  

        <table class="table-striped notas_acompanhamento " border="1" align="center"  >
            <thead>
                <tr>
                    <th width="50">CÓD.</th>
                    <th>DISCIPLINAS</th>
                    <th width="80"><center>1º BIM.</center></th>
    </tr>
</thead>   
<!-- Recebendo valores na vareavel disciplinas e passando para disciplina -->
@foreach($disciplinas as $key => $disciplina )
<center>
    <tr>
        <td width="50" height="17"> {{$disciplina->tb_disciplinas_idDisciplinas}} </td>
        <td width="130">{{$disciplina->NomeDisciplina}}</td>
        @php
        $notasDoAluno = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
        @endphp
        <!-- INICIO DO FOREACH DA NOTA DA DISCILPLINA QUE TA LISTANDO-->
        @forelse($notasDoAluno as $nota)
        @if (isset ($nota->AB1))
        @if (($nota->AB1) == 0)
        <td><center><div>-</div>  
    </center>
    </td> 
    </tr> 
    </td>
    @elseif (($nota->AB1) < 7)
    <td><center><div class="notaVermelha" >                  
            {{number_format($nota->AB1 ,1)}}  
        </div>  
    </center>
    </td> 
    </tr> 
    @else
    <td><center><div class="notaAzul" >                  
            {{number_format($nota->AB1 ,1)}} 
        </div>  
    </center> </td>
    </td> 
    </tr> 
    @endif
    @endif
    @empty
    <td><center><div>-</div>  
    </center>
    </td> 
    @endforelse 
    <!-- FIM DO FOREACHO QUE LISTA A DISCIPLINA-->
    @endforeach
</table>
        
        
        
        
        
        <div class="imagem_direita">
            <img src="{{url('imgs/conquista.jpeg')}}" ><br>

        </div>            
        
      

        
        
        
<div class="boletim_acompanhamento margemAssinatura">
    <p class="boletim_acompanhamento"><strong>Professor(a):______________________________________&nbsp;&nbsp;&nbspResponsável(a):____________________________________________</strong></p>
                                           
<br><br>
   

    
    <p class="boletim_acompanhamento"><strong>Obs:____________________________________________________________________________________________________________________</strong></p>
    <p class="boletim_acompanhamento"><strong>________________________________________________________________________________________________________________________</strong></p>
    <p class="boletim_acompanhamento"><strong>________________________________________________________________________________________________________________________</strong></p>



</div>
@empty
@endforelse
</body>
</html>