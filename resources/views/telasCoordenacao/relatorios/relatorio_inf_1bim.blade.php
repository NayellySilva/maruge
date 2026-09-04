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
                
        <div class="boletin-acompanhamento-titulo"> BOLETIM DE ACOMPANHAMENTO - EDUCAÇÃO INFANTIL <br> 1º BIMESTRE - <strong>
                @foreach($anoletivo as $anoletivo)
                {{$anoletivo->AnoLetivo}}
                @endforeach
            </strong></div>
        <div class="inf_aluno">
            <p><strong>Nº MAC: </strong> {{ $aluno->NumeroMac ?? $aluno->RA ?? '-' }}</p> 
            <p> <strong>Aluno(a):</strong>{{ $aluno->NomeAluno}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Turma: </strong> {{$turma->NomeTurma}}</p> 
        </div>      
        
        
         <div class="boletim_acompanhamento">
            
            
           <!-- CÓDIGO DA PANDEMIA
            
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
            
              
         </div>
        
        -->
        
        
        <div class="boletim_acompanhamento">
            <p><strong>Adaptação  escolar no 1º. Bimestre</strong></p>
            <p> (    ) bom    (    ) excelente  (    ) satisfatório   (    ) insatisfatório</p>
            <p><strong>Desenvolvimento  da oralidade (falar, cantar, para a idade é considerado)</strong></p>
            <p> (    ) bom    (    ) excelente  (    ) satisfatório   (    ) insatisfatório</p>
            <p><strong>Frequência  escolar</strong></p>
            <p> (    ) bom    (    ) excelente  (    ) satisfatório   (    ) insatisfatório</p>
            <p><strong>Relacionamento com os colegas</strong></p>
            <p> (    ) bom    (    ) excelente  (    ) satisfatório   (    ) insatisfatório</p>
            <p><strong>Participação e percepção nas aulas e demais atividades.</strong></p>
            <p> (    ) bom    (    ) excelente  (    ) satisfatório   (    ) insatisfatório</p>
            <p><strong>Quanto as tarefas de casa, estão:</strong></p>
            <p> (    ) boas   (    ) excelentes (    ) satisfatórias  (    ) precisa de  ajuda familiar</p>
            <p><strong>Em relação à coordenação motora, para a idade está:</strong>
            <p> (     ) boa   (    ) excelente  (    ) satisfatória</strong></p>
            <p><strong>Quanto ao comportamento durante as explicações, no momento  das tarefas e na recreação:</strong><br>
            <p> (    ) bom    (    ) excelente  (     ) satisfatório  (    ) insatisfatório</p>
            <p><strong>Como foi o acompanhamento familiar durante o bimestre:</strong></p>
            <p> (    ) bom    (    ) excelente  (     ) satisfatório  (    ) insatisfatório</p>
        </div>
        
  
        
        
        
        <div class="boletim_acompanhamento">
            <p><strong><u>Orientação  Escolar do 1º. Bimestre </u></strong></p>
            <p> <strong>Parabéns  à família pela missão de inserir  seu  (sua) filho (a) na comunidade escolar. Seu primeiro passo quanto a formação  cultural está sendo realizado. Prossiga acompanhando fielmente a cada dia.  Saiba, é muito importante o olhar materno e paterno em cada tarefa do (a) filho  (a).</strong></p>
            <p><strong>Nota  importante – Não deixe seu (sua)  filho  (a) faltar aulas.<br>
                </strong><strong>Não  permita que venha ao colégio sem o fardamento completo. O seu exemplo é uma  imensa parcela na organização dos nossos trabalhos.</strong></p>
            <p class="boletim_acompanhamento"><strong>Professor(a):_______________________________________&nbsp;&nbsp;&nbsp;Responsável:______________________________________</strong></p>
        </div>
        <div class="boletim_acompanhamento">
            <p align="center"><strong>&ldquo;Escola e  família – Formando  cidadão consciente&rdquo;.</strong></p>
            <p align="center"><strong>Não  é permitido trazer brinquedos para a escola.</strong></p>
        </div>
        @empty
        @endforelse
    </body>
</html>