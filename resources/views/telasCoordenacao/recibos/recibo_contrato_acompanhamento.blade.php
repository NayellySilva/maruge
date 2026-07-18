@extends('telasCoordenacao.painel')  
@section('conteudo')
<html>
    <header>   
        <title>{{$titulo}}</title>
    </header>
    <body>
        <!-- CSS compilada e minificada on-line do bootstrap-->
        <link href="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">       
        <!-- favicon-->
        <link rel="stylesheet" href="{{asset('imgs/favicon.png')}}">     
        <!-- Jquery Local-->
        <script src="{{asset('css/jquery-3.0.0.js')}}" ></script> 

        <style>
            .break { page-break-before: always; }
        </style>

        <button type="button"  value="Imprimir" id="imprimir_conteudo"  class="botao btn-imprimir"> Imprimir</button>
     
  
        
        <div class="imprimir_conteudo">
            
            
            <!--
            <table class="timbre-sem-borda">
                <tr>
                    <td>
                        <img src="{{url('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
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
                @empty
                @endforelse
            </table>

            -->
            
      
            
            
            
            
            <div class="row" aling="center">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading ">
                            <strong> CONTRATO PARA PRESTAÇÃO DE SERVIÇOS EDUCACIONAIS-{{$turma->AnoLetivo }} DAS PARTES</strong>
                        </div>
       
                   
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive contrato">
                               
                                <b>1.0- Identificação: </b><br>
                                <b> 1.1-Aluno beneficiário(a)</b>{{$aluno->NomeAluno}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Valor do Contrato R$: </b> {{ number_format($valor_contrato,2,",",".")}} &nbsp;&nbsp;<br>
                                <b> Matrículado (a) No (a) : </b> {{$turma->NomeTurma}}.
                                            <br>
                                            <b>  RESPONSÁVEL:</b>
                                            <br>
                                            
                                            <b>  1.3-Contratante: {{$pais->Responsavel}}&nbsp; &nbsp; &nbsp; </b>   <b> CPF: </b> {{$pais->CPFResponsavel}} &nbsp; &nbsp; &nbsp; <b> RG: </b> {{$pais->RGResponsavel}} &nbsp;&nbsp; <b> Data: </b> {{$matricula->DataMatricula}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>               
                                            <b>  1.5- CONTRATADA. </b> Escola de Educação Infantil e Ensino Fundamental Carinho da Mamãe LTDA ME (Carinho da Mamãe), 
                                            pessoa jurídica de direito privado, inscrita no CNPJ sob o nº 01.123.824/0001-11, firmada na Rua Hildegarda Barbosa, 
                                            531, bairro Cajuina São Geraldo, CEP 63022-400.<br>
                                            <b> 2.0- Objeto. </b><br>
                                            2.1- Prestação de serviços educacionais à série escolar, ministrado em conformidade com currículo próprio, regime interno, 
                                            aprovado, homologado ou arquivado pelo competente órgão de ensino, e lei n° 9.394/96, durante o ano letivo, com obediência 
                                            ao calendário escolar do estabelecimento de ensino do ano letivo de {{$turma->AnoLetivo }}.<br>
                                            <b> 3.0- Invalidade. </b><br>
                                            3.1- Este contrato, mesmo após sua assinatura, perderá validade em consequência de anulação da Matrícula e no caso de ser(em) constatado(s) débito(s) do(a) aluno(a) relativo a ano(s) anterior(es) a {{$turma->AnoLetivo }}.

                                
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.row -->
            </div>


            <br>
            <div class="linha"></div>
            <br>
        
           
            
            
            
            <div class="row" aling="center">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading ">
                            <strong> CONTRATO:</strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive contrato " aling="justify">
                            
                            
                            
                            
<p aling="justify"> <b> DO OBJETO – SERVIÇOS PRESTADOS  </b>  </p>
            
            
            
        <p aling="justify"> <b> CLÁUSULA PRIMEIRA - </b> Como serviços mencionados nesta cláusula se entendem os obrigatoriamente
        prestados a toda turma ou série, coletivamente, de acordo com a legislação de ensino, 
        não incluídos os facultativos, de caráter opcional ou de grupo.</p>

                            <p aling="justify"> <b>Parágrafo primeiro - </b> O aluno beneficiário estará sujeito às normas do regimento Escolar, 
                                homologado, aprovado ou arquivado pelos órgãos competente, conforme a Lei n° 9.394/96, à 
                                disposição do(a) contratante, cujas determinações integram o presente instrumento para 
                                aplicação subsidiária e em casos omissos.</p>



                            <p aling="justify"> <b> Parágrafo segundo - </b> Não estão incluídos neste contrato os serviços especiais de reforço, reposição, adaptação, 
                                exames especiais, reciclagem, transporte escolar, os opcionais de uso facultativo para o(a) aluno(a), bem como 
                                uniformes, merenda, identidade estudantil e material didático individual, de arte e de uso individual obrigatório, 
                                que poderão ser objeto de ajuste à parte e, ainda, fornecimento de segundas ou seguintes via de documentos, os quais 
                                terão seus valores comunicados em circular própria, no momento adequado.</p>
                           
                            
                            
                            
                            <p aling="justify"> <b> Parágrafo terceiro - </b> Os serviços objeto deste contrato poderão ser prestados através de tecnologias de ensino a distância, 
                                remoto e/ou até mesmo na modalidade híbrida (presencial / à distância), sempre que impossível prestá-lo de forma presencial por motivos alheios 
                                a vontade das partes ou ainda quando estas acordarem, por instrumento próprio, tal possibilidade. Ficando desde já destacada a prioridade do ensino presencial.</p>
                            
                            
                            
                            
                            <p aling="justify"> <b> Parágrafo quarto - </b> Na modalidade virtual a distância as aulas serão ministradas em local, aplicativo ou link indicado pela Contratada, 
                                considerando o conteúdo e a técnica pedagógica que se fizerem necessárias. </p>
                            
                            
                            
                            
                                                        
                            
                            
                            
                            
        
       
        
<p aling="justify"> <b> PREÇOS, PARCELAS E VENCIMENTOS </b>  </p>
        
        
        <p aling="justify"> <b> CLÁUSULA SEGUNDA - </b>  Pelos serviços educacionais referidos neste contrato, o(a) contratante pagará ao contratado o valor de R$ </b> {{ number_format($matricula->ValorPGTO,2,",",".")}}, referente à matrícula e <b>À QUANTIA DE: R$: </b> {{ number_format($valor_contrato,2,",",".")}},
            , dividida em {{$quantidadeParcelasContrato}} parcelas iguais, que corresponde as mesalidades, que deverão ser efetuadas mensalmentes, e passiveis de reajustes anuais na forma da lei.  </p>
        
        
        <table class="table-striped  contrato" border="1" align="center"  >
            <thead>
                    <th width="120">Nº PARCELA.</th>
                    <th width="100">CÓDIGO DE BARRAS</th>
                    <th width="100">VALOR</th>
            </thead>
                @forelse($valor_mensal as $boletos)
                <tr>
                    <td>{{$boletos->parcelas}}</td>
                    <td>{{$boletos->codbarras}}</td>
                    <td>R$: {{$boletos->tb_turmas_Mensalidade}}</td>
                 </tr>
                @empty
                @endforelse
                
        </table>
        
        <br>
        
                            <p aling="justify"> <b> Parágrafo Primeiro - </b>  Em razão de situação especial e individual, as partes poderão acordar por adendo, a divisão da 
                                anuidade em um número de parcelas diferentes de 12(doze), não ultrapassando este número.</p>


                            <p aling="justify"> <b> Parágrafo Segundo - </b>  O pagamento da matrícula, celebra e concretiza o presente contrato, sendo imprescindível sua quitação para tais fins,
                               tendo o caráter de sinal, arras e princípio de pagamento, razão pela qual será devolvida, em parte, em caso 
                                de desistência pelo contratante dentro dos 15 primeiros dias de aula.</p>


                            <p aling="justify"> <b>  Parágrafo Terceiro - </b> A matrícula e o contrato só se efetivam com a assinatura pelas partes do respectivo instrumento contratual, 
                                podendo a escola recusá-lo, se o(a) aluno(a) não satisfazer às exigências aplicáveis da legislação do ensino.</p>


                            <p aling="justify"> <b> Parágrafo Quarto - </b> Os pagamentos das {{$quantidadeParcelasContrato}} mensalidades restantes, deverá acontecer até o dia 10 subsequente ao mês corrente ao 
                                da mensalidade, em espécie ou cartão de crédito ou débito, no balcão da secretaria ou transferência/depósito bancário.</p>
   
   
<p aling="justify"> <b> INADIMPLÊNCIA </b> </p>
        
           
        <p aling="justify"> <b> CLÁUSULA TERCEIRA -  </b> Havendo mora no pagamento de qualquer parcela por prazo superior ao mencionado na Cláusula Segunda serão somados: </p>
                            <p aling="justify"> <b> I - </b>Sobre o valor da parcela em atraso, aplicação de multa de 2,5%;  </p>
                            <p aling="justify"> <b> II - </b>Perderá o direito de qualquer desconto dado ao pagamento realizado até o seu vencimento;  </p>
                            <p aling="justify"> <b> III - </b>Acréscimo de juros no importe de 1% a/m sobre a parcela em atraso. </p>

        
        <p aling="justify"> <b> Parágrafo primeiro – </b> O atraso no pagamento faculta ao contratado: </p>
                            <p aling="justify"> <b> a) </b> a) Negatividade do devedor em serviço de proteção ao crédito, protesto, cobrança por serviços especializados (inclusive mensagens de texto via celular), cobrança extrajudicial, com pagamento de despesas e honorários advocatícios no importe de 10% sobre o valor do débito. (art. 389, do código civil).
                            <p aling="justify"> <b> b) </b> Promover o protesto da dívida, mediante duplicata de serviços, letras de câmbio ou outro título de crédito legalmente admitido, podendo promover a cobrança através do advogado ou de empresas especializadas;
                            <p aling="justify"> <b> c) </b> Promover a cobrança judicial através da Ação Monitória, de Execução ou outra prevista na legislação brasileira, com acréscimo de 20% sobre o valor do débito a título de honorários advocatícios. (art. 389, do código civil)</p>  
        <p aling="justify"> <b> Parágrafo segundo – </b> O(a) contratante será responsável pelo pagamento de todas as despesas decorrentes de cobrança de débito.
        <p aling="justify"> <b> Parágrafo terceiro – </b> As medidas mencionadas no parágrafo terceiro poderão ser tomadas pelo contratante isolada, gradativa ou cumulativamente. </p>
       
<p aling="justify"> <b>RESCISÃO: ATRASO SUPERIOR A 120 DIAS </b>   </p>

<p aling="justify"> <b> CLÁUSULA QUARTA -</b>  Qualquer das partes pode rescindir este contrato antes do seu término, desde que esteja em dias com suas obrigações 
        consoante previsto no presente instrumento ou em lei.</p>
        
                              
<p aling="justify"> <b> MATRÍCULA NÃO RENOVÁVEL </b> </p>
       
        <p aling="justify"> <b> CLÁUSULA QUINTA - </b> Por ninguém está obrigado a contratar com quem não quer, a Contratada poderá não renovar a matrícula para o ano letivo 
        seguinte do(a) aluno(a) que tiver débito relativo ao ano anterior, em razão de norma prevista no regimento escolar, por motivo disciplinar ou outro que não recomende 
        a permanência do(a) aluno(a) em virtude de prejuízo a ele, ao estabelecimento do ensino ou ao relacionamento entre esses e a Contratada.</p>
        
        
<p aling="justify"> <b>CANCELAMENTO, TRANCAMENTO E TRANSFERÊNCIA </b> </p>              
        
        <p aling="justify"> <b> CLÁUSULA SEXTA - </b>   Os pedidos de transferência, de cancelamento, desistência ou trancamento de matrícula deverão ser requeridos, por escrito, até o dia 30(trinta) do mês corrente pelo(a) contratante, no documento próprio 
            reservado e de satisfação das obrigações escolares perante a Secretaria do Estabelecimento de Ensino.</p>

                    <p aling="justify"> <b> Parágrafo Primeiro –  </b> Por motivo disciplinar, por descumprimento da norma regimental, por incompatibilidade do(a) aluno(a) 
                        ou seu responsável com as normas da conduta escolar, ou outro motivo qualquer que não recomende ou viabilize a permanência do(a) discente no
                        Estabelecimento de Ensino, a Contratada poderá expedir a transferência e romper o contrato.</p>
        
        
<p aling="justify"> <b> DOCUMENTAÇÃO, UNIFORME E HORÁRIO DOS ALUNOS </b>  </p>       
        
                    <p aling="justify"> <b> CLÁUSULA SÉTIMA -  </b> Obriga-se o(a) contratante a fornecer, no prazo estabelecido pela escola contratada,
                    todos os documentos requeridos para efetivação da matrícula, taxas cobradas, bem como o material didático-pedagógico e de artes necessário ao 
                    aprendizado do(a) aluno(a), cuja lista lhe é entregue durante o período de matrícula ou no início do ano letivo, bem como a fazer com que o(a) aluno(a) 
                    beneficiário(a) se apresente devidamente uniformizado(a). O uniforme tem como objetivo a identificação do aluno fora do estabelecimento escolar e busca, 
                    principalmente, iniciar a ideia de responsabilidade no infantojuvenil, primando pela disciplina.</p>

                    <p aling="justify"> <b> Parágrafo Primeiro - </b>  Na hipótese de não cumprimento do disposto neste capitulo, o(a) aluno(a) não poderá participar das atividades 
                    escolares, em conformidade com o disposto no Regimento Escolar, enquanto não atender à exigência. </p>

                    <p aling="justify"> <b> Parágrafo Segundo –  </b>  Os contratantes deverão respeitar os horários preestabelecidos no ato da matrícula em relação à entrada e 
                    saída dos alunos. Os pais deverão seguir rigorosamente o horário de recolher os seus filhos, evitando que as crianças continuem no estabelecimento após o 
                    término das aulas. Seguir o horário corretamente também faz parte da educação, formação e disciplina.</p>

                    
                    
<p aling="justify"> <b> DO TRATAMENTO DE DADOS </b>  </p>       
        
                    <p aling="justify"> <b> CLÁUSULA OITAVA  -  </b> A contratada poderá compartilhar os dados informados na matrícula com terceiros colaboradores sempre primando 
                        pelo sigilo e proteção das informações. O compartilhamento com os colaboradores será formalizado por instrumento de compromisso da manutenção do sigilo, 
                        tudo conforme a Lei Geral de Proteção de Dados (LGPD).</p>

                    <p aling="justify"> <b> Parágrafo Primeiro - </b>  De acordo com o art. 7º da LGPD os contratantes autorizam desde já a coleta e o tratamento dos dados 
                        informados na matrícula para atender as necessidades do contrato, entre estes o repasse das informações para o Instituto Nacional de Estudos e Pesquisa (INEP)
                        e demais órgãos públicos fiscalizadores e reguladores da educação. </p>

                    <p aling="justify"> <b> Parágrafo Segundo –  </b>  Os dados serão armazenados de forma eletrônica ou física, sempre primando pela segurança, proteção e sigilo dos mesmos,
                        tudo conforme a LGPD.</p>
                    
                    
                    <p aling="justify"> <b> Parágrafo Terceiro –  </b>  Os dados serão coletados e tratados para fins estritamente educacionais e legais, em consonância com a LGPD, o regimento escolar
                        e as demais legislações vigentes.</p>

                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
<p aling="justify"> <b> DISPOSIÇÕES GERAIS  </b>  </p>
        
                      
        <p aling="justify"> <b> CLÁUSULA NONA  - </b> A escola não se responsabilizará por objetos alheios à atividade escolar, bem como os citados na Lei 14.146/2008 
        (celulares, mp3, mp4, câmeras, pendrive, iPod, tables, fones e outros similares) e quantias trazidas pelo(a) aluno(a) ao colégio, sem o prévio consentimento da 
        Direção. Assim como os objetos de uso e cuidado pessoal, como óculos, relógio, acessórios, aparelhos ortopédicos, auditivos ou próteses em geral e brinquedos.</p>
        
        <p aling="justify"> <b> CLÁUSULA DÉCIMA – </b> A importância em dinheiro concedida no ato da matrícula só será devolvida nos casos em que o aluno não tiver 
            frequentado prazo superior a 15 dias de aula, sendo fixada a retenção de 50% do valor da matrícula para as despesas administrativas, bem como, 
            não será possível a devolução do material escolar do(a) aluno(a) que já estiver frequentado dois meses de aula.</p>
        
        <p aling="justify"> <b> CLÁUSULA DÉCIMA PRIMEIRA - </b> O contratante autoriza, desde já, a utilização das imagens dos(as) alunos(as) matriculados(as) para fins comerciais 
        e/ou de publicidade pela Contratada. </p>
        
        
        <p aling="justify"> <b> CLÁUSULA DÉCIMA SEGUNDA – </b> Fica vetado aos pais entrar nas dependências do Colégio para solucionar conflitos diretamente com alunos
            e/ou professores. Todos os conflitos deverão ser previamente comunicados à Direção, para que sejam tomadas as devidas providências.</p>
        
        <p aling="justify"> <b> CLÁUSULA DÉCIMA TERCEIRA - </b> Os alunos portadores de necessidades especiais matriculados receberão tratamento e serviço de forma 
            igualitária, sempre primando pela inclusão.</p>
                  
                     
        <p aling="justify"> <b> CLÁUSULA DÉCIMA QUARTA - </b> Considerando que o Conselho Nacional de Educação autorizou a unificação dos anos letivos de 2020 e 2021, 
            em virtude das alterações no calendários escolar em 2020, ocasionadas pela pandemia do novo coronavírus, fica desde já avençado entre as partes que o calendário
            de 2021 poderá sofrer alterações no decorrer do ano letivo, sendo emitido aviso prévio ao Contratante.</p>
        
        
        <p aling="justify"> <b> CLÁUSULA DÉCIMA QUINTA - </b> Para dirimir ou esclarecer quaisquer dúvidas ou casos omissos no presente contrato, as partes elegem o foro da Cidade de Juazeiro do Norte/CE.</p>
     
        
        
        
        <p aling="justify"> E assim, por estarem justos e contratados, assinam o presente instrumento, juntamente com duas testemunhas, a fim de que venham os efeitos legais e jurídicos, e ainda, assinado por outro(a) responsável pelo(a) aluno(a) beneficiário(a), se exigido pela Contratada.
</p>
                  
        
                            </div>



                            <div class="table-responsive tabela-recibo">
                              
  
                                <br><br>

                                <p align="center">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;____________________________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  _____________________________________<br>
                                    Assinatura
                                    Pai / M&atilde;e ou Respons&aacute;vel &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura
                                    Funcion&aacute;rio (a)</p>
                                                        

                            </div>



                            <!-- /.table-responsive -->
                        </div>





                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.row -->
            </div>

                                
                            </div>










                        </div>
                        </body>
                        </html>
                        @endsection