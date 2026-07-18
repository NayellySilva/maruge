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
                                <b> Matriculado (a) No (a) : </b> {{$turma->NomeTurma}}.
                                            <br>
                                            <b>  RESPONSÁVEL:</b>
                                            <br>
                                            
                                            <b>  1.3-Contratante: {{$pais->Responsavel}}&nbsp; &nbsp; &nbsp; </b>   <b> CPF: </b> {{$pais->CPFResponsavel}} &nbsp; &nbsp; &nbsp; <b> RG: </b> {{$pais->RGResponsavel}} &nbsp;&nbsp; <b> Data: </b> {{$matricula->DataMatricula}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>               
                                            <b>  1.5- CONTRATADA. </b> Escola de Educação Infantil e Ensino Fundamental Carinho da Mamãe LTDA ME (Carinho da Mamãe), 
                                            pessoa jurídica de direito privado, inscrita no CNPJ sob o nº 01.123.824/0001-11, firmada na Rua Hildegarda Barbosa, 
                                            531, bairro Cajuína São Geraldo, CEP 63022-400.<br>
                                            <b> 2.0- Objeto. </b><br>
                                            2.1- Prestação de serviços educacionais à série escolar, ministrado em conformidade com currículo próprio, regimento interno, 
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
                           <p aling="justify"> <b>CONTRATO:</b> </p>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive contrato " aling="justify">
                            
                            
                            
<p aling="justify"> <b>1.3 - CONTRATADA.</b> Escola de Educação Infantil e Ensino Fundamental Carinho da Mamãe LTDA ME (Carinho da Mamãe), pessoa jurídica de direito privado, inscrita no CNPJ sob o nº 01.123.824/0001-11, firmada na Rua Hildegarda Barbosa, 531, bairro Cajuína São Geraldo, CEP 63022-400.</p>

<p aling="justify"> <b>2.0- Objeto.</b> </p>
<p aling="justify"> <b>2.1- </b> Prestação de serviços educacionais à série escolar, ministrado em conformidade com currículo próprio, regimento interno, aprovado, homologado ou arquivado pelo competente órgão de ensino, e lei n° 9.394/96, durante o ano letivo, com obediência ao calendário escolar do estabelecimento de ensino do ano letivo de 2026.</p>

<p aling="justify"> <b>3.0- Invalidade.</b> </p>
<p aling="justify"> <b>3.1- </b> Este contrato, mesmo após sua assinatura, perderá validade em consequência de anulação da Matrícula e no caso de ser(em) constatado(s) débito(s) do(a) aluno(a) relativo a ano(s) anterior(es) a 2026.</p>



<p aling="justify"> <b>DO OBJETO – SERVIÇOS PRESTADOS</b> </p>
<p aling="justify"> <b>CLÁUSULA PRIMEIRA - </b> Como serviços mencionados nesta cláusula se entendem os obrigatoriamente prestados a toda turma ou série, coletivamente, de acordo com a legislação de ensino, não incluídos os facultativos, de caráter opcional ou de grupo. Visando a prestação de serviços educacionais atinentes à série e período escolar, ministrados em conformidade com o currículo próprio, regimento escolar, em obediência ao calendário escolar do Estabelecimento de Ensino, no ano letivo de 2026.</p>

<p aling="justify"> <b>Parágrafo primeiro - </b> O aluno beneficiário estará sujeito às normas do regimento Escolar, homologado, aprovado ou arquivado pelos órgãos competentes, conforme a Lei n° 9.394/96, à disposição do(a) contratante, cujas determinações integram o presente instrumento para aplicação subsidiária e em casos omissos.</p>

<p aling="justify"> <b>Parágrafo segundo - </b> Não estão incluídos neste contrato os serviços especiais de reforço, reposição, adaptação, exames especiais, reciclagem, transporte escolar, os opcionais de uso facultativo para o(a) aluno(a), bem como uniformes, merenda, identidade estudantil e material didático individual, de arte e de uso individual obrigatório, que poderão ser objeto de ajuste à parte e, ainda, fornecimento de segundas ou seguintes via de documentos, os quais terão seus valores comunicados em circular própria, no momento adequado.</p>

<p aling="justify"> <b>Parágrafo terceiro - </b> Os serviços educacionais aqui previstos serão prestados na forma presencial, obrigatoriamente, salvo por caso fortuito ou força maior, como pandemias, terremotos, inundações e outras calamidades ou, ainda, justo motivo apresentado e aceito pela instituição de ensino, será utilizado a modalidade híbrida ou totalmente remota, desde que esteja em consonância com as normativas federais, estaduais e municipais, observando-se sempre as diretrizes da Proposta Pedagógica, de acordo com a avaliação exclusiva da Contratada, sem alteração no valor da contraprestação da Contratante.</p>

<p aling="justify"> <b>Parágrafo quarto - </b> Na modalidade virtual a distância, quando aplicada, as aulas serão ministradas em local, aplicativo ou link indicado pela Contratada, considerando o conteúdo e a técnica pedagógica que se fizerem necessárias.</p>

<p aling="justify"> <b>PREÇOS, PARCELAS, VENCIMENTOS E BONIFICAÇÕES</b> </p>
 </p>
        
        
        <p aling="justify"> <b> CLÁUSULA SEGUNDA - </b>  Pelos serviços educacionais referidos neste contrato, o(a) contratante pagará ao contratado o valor de R$ </b> {{ number_format($matricula->ValorPGTO,2,",",".")}}, referente à matrícula e <b>À QUANTIA DE: R$: </b> {{ number_format($valor_contrato,2,",",".")}},
            , dividida em {{$quantidadeParcelasContrato}} parcelas iguais, que corresponde as mensalidades, que deverão ser efetuadas mensalmentes, e passiveis de reajustes anuais na forma da lei.  </p>
        
        
        <table class="table-striped  contrato" border="1" align="center"  >
            <thead>
                    <th width="120">Nº PARCELA.</th>
                    <th width="100">CÓDIGO DE BARRAS</th>
                    <th >VALOR</th>
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
    
        
        
        
        <p aling="justify"><b>Parágrafo Primeiro - </b> O pagamento da matrícula, celebra e concretiza o presente contrato, sendo imprescindível sua quitação para tais fins. Em caso de desistência não haverá devolução do valor quitado.</p>

<p aling="justify"><b>Parágrafo Segundo - </b> A matrícula e o contrato só se efetivam com a assinatura pelas partes do respectivo instrumento contratual, podendo a escola recusá-lo, se o(a) aluno(a) não atender às exigências aplicáveis da legislação de ensino.</p>

<p aling="justify"><b>Parágrafo Terceiro - </b> Os pagamentos das matrículas e mensalidades, deverão acontecer até o dia 10 subsequente ao mês corrente ao da mensalidade, ocorrendo mediante a plataforma digital (   )Isaac Educação - (   ) Sicred, empresa prestadora de serviços, pela Contratada, de gestão e garantia de pagamentos, em valor líquido, de mensalidades e matrículas escolares da Contratante de cada aluno matriculado na Contratada.</p>

<p aling="justify"><b>Parágrafo Quarto - </b> A empresa cessionária disponibilizará meios de pagamento, tais como emissão de boletos, disponibilização de cartão de crédito e débito via link de pagamento, máquina, dentre outros, para os responsáveis legais dos Alunos via e-mail, whats app, ou aplicativos similares, e/ou mensagem texto (a depender da informação disponível);</p>

<p aling="justify"><b>Parágrafo Quinto - </b> A instituição seguirá o que determina a Lei 13.146/2015, norma que institui a Lei Brasileira de Inclusão da Pessoa com Deficiência (Estatuto da Pessoa com Deficiência), não cobrando do(a) contratante/aluno(a) nenhum valor adicional em suas mensalidades e anuidades para o cumprimento desta legislação.</p>

<p aling="justify"><b>Parágrafo Sexto - </b> O SEGURO FAMILIAR ISAAC garantirá aos responsáveis financeiros com menos de 69 anos de idade - em caso de morte, cobertura das mensalidades até o fim do ano letivo – em caso de desemprego com vínculo empregatício (CLT), 3 mensalidades cobertas – em caso de incapacidade temporária, por doença ou acidente exclusivo para profissionais liberais ou autônomos, 3 mensalidades cobertas. Carências, condições e documentações comprobatórias com a plataforma Isaac. (Não se aplica ao Sicred)</p>

<p aling="justify"><b>INADIMPLÊNCIA</b></p>

<p aling="justify"><b>CLÁUSULA TERCEIRA - </b> Em caso de atraso de pagamento dos créditos, o ISAAC poderá cobrar dos responsáveis multa de até 2% (dois por cento), mais juros de até 1% (um por cento) ao mês sobre o valor em atraso, durante o período em que a parcela estiver em aberto.</p>

<p aling="justify"><b>Parágrafo primeiro - </b> O atraso no pagamento, faculta ao contratado:
    a) Negatividade do devedor em serviço de proteção ao crédito, protesto, cobrança por serviços especializados (inclusive mensagens de texto via celular), cobrança extrajudicial, com pagamento de despesas e honorários advocatícios no importe de 10% sobre o valor do débito. (art. 389, do código civil).
    b) Promover o protesto da dívida, mediante duplicata de serviços, letras de câmbio ou outro título de crédito legalmente admitido, podendo promover a cobrança através do advogado ou de empresas especializadas;
    c) Promover a cobrança judicial através da Ação Monitória, de Execução ou outra prevista na legislação brasileira, com acréscimo de 20% sobre o valor do débito a título de honorários advocatícios. (art. 389, do código civil)</p>

<p aling="justify"><b>Parágrafo segundo - </b> O(a) contratante será responsável pelo pagamento de todas as despesas decorrentes de cobrança de débito.</p>

<p aling="justify"><b>Parágrafo terceiro - </b> As medidas mencionadas no parágrafo terceiro, poderão ser tomadas pelo contratante isolada, gradativa ou cumulativamente.</p>

<p aling="justify"><b>RESCISÃO: ATRASO SUPERIOR</b></p>

<p aling="justify"><b>CLÁUSULA QUARTA - </b> Os responsáveis poderão rescindir este contrato a qualquer tempo, mediante comunicação formal à Instituição, com antecedência mínima de 30 (trinta)dias, permanecendo responsáveis pelos valores proporcionais aos serviços educacionais já prestados até a data efetiva da recisão.</p>

<p aling="justify"><b>MATRÍCULA NÃO RENOVÁVEL</b></p>

<p aling="justify"><b>CLÁUSULA QUINTA - </b> A Contratada não renovará a matrícula para o ano letivo seguinte do(a) aluno(a) que tiver débito relativo ao ano anterior, em razão de norma prevista no regimento escolar, por motivo disciplinar ou outro que não recomende a permanência do(a) aluno(a) em virtude de prejuízo a ele, ao estabelecimento do ensino ou ao relacionamento entre esses e a Contratada.</p>

<p aling="justify"><b>CANCELAMENTO, TRANCAMENTO E TRANSFERÊNCIA</b></p>

<p aling="justify"><b>CLÁUSULA SEXTA - </b> Os pedidos de transferência, de cancelamento, desistência ou trancamento de matrícula deverão ser requeridos, por escrito, até o dia 30(trinta) do mês corrente pelo(a) contratante, no documento próprio reservado e de satisfação das obrigações escolares perante a Secretaria do Estabelecimento de Ensino.</p>

<p aling="justify"><b>Parágrafo Primeiro - </b> Por motivo disciplinar, por descumprimento da norma regimental, por incompatibilidade do(a) aluno(a) ou seu responsável com as normas da conduta escolar, ou outro motivo qualquer que não recomende ou viabilize a permanência do(a) discente no Estabelecimento de Ensino, a Contratada poderá expedir a transferência e romper o contrato.</p>

<p aling="justify"><b>Parágrafo Segundo - </b> A rescisão deste contrato, por qualquer motivo, importará no pagamento de: Todas as mensalidades vencidas e não pagas, se houver, com acréscimos da multa, juros e correção monetária; Mensalidade do mês em que ocorrer o evento, se a mensalidade já venceu.</p>

<p aling="justify"><b>DOCUMENTAÇÃO, UNIFORME E HORÁRIO DOS ALUNOS</b></p>

<p aling="justify"><b>CLÁUSULA SÉTIMA - </b> Obriga-se o(a) contratante a fornecer, no prazo estabelecido pela escola contratada, todos os documentos requeridos para efetivação da matrícula, taxas cobradas, bem como o material didático-pedagógico e de artes necessário ao aprendizado do(a) aluno(a), cuja lista lhe é entregue durante o período de matrícula ou no início do ano letivo, bem como a fazer com que o(a) aluno(a) beneficiário(a) se apresente devidamente uniformizado(a). O uniforme tem como objetivo a identificação do aluno fora do estabelecimento escolar e busca, principalmente, iniciar a ideia de responsabilidade no infantojuvenil, primando pela disciplina.</p>

<p aling="justify"><b>Parágrafo Primeiro - </b> Na hipótese de não cumprimento do disposto neste capitulo, o(a) aluno(a) não poderá participar das atividades escolares, em conformidade com o disposto no Regimento Escolar, enquanto não atender à exigência.</p>

<p aling="justify"><b>Parágrafo Segundo - </b> Os contratantes deverão respeitar os horários preestabelecidos no ato da matrícula em relação à entrada e saída dos alunos. Os pais deverão seguir rigorosamente o horário de recolher os seus filhos, evitando que as crianças continuem no estabelecimento após o término das aulas. Seguir o horário corretamente também faz parte da educação, formação e disciplina.</p>

<p aling="justify"><b>DO TRATAMENTO DE DADOS</b></p>

<p aling="justify"><b>CLÁUSULA OITAVA - </b> A contratada poderá compartilhar os dados informados na matrícula com terceiros colaboradores sempre primando pelo sigilo e proteção das informações. O compartilhamento com os colaboradores será formalizado por instrumento de compromisso da manutenção do sigilo, tudo conforme a Lei Geral de Proteção de Dados (LGPD) Nº:13.709/18.</p>

<p aling="justify"><b>Parágrafo Primeiro - </b> De acordo com o art. 7º da LGPD (Nº:13.709/18) os contratantes autorizam desde já a coleta e o tratamento dos dados informados na matrícula para atender as necessidades do contrato, entre estes o repasse das informações para o Instituto Nacional de Estudos e Pesquisa (INEP) e demais órgãos públicos fiscalizadores e reguladores da educação.</p>

<p aling="justify"><b>Parágrafo Segundo - </b> Os dados serão armazenados de forma eletrônica ou física, sempre primando pela segurança, proteção e sigilo dos mesmos, tudo conforme a LGPD (Nº:13.709/18).</p>

<p aling="justify"><b>Parágrafo Terceiro - </b> Os dados serão coletados e tratados para fins estritamente educacionais e legais, em consonância com a LGPD, o regimento escolar e as demais legislações vigentes.</p>

<p align="justify"><b>DISPOSIÇÕES GERAIS</b></p>

<p align="justify"><b>CLÁUSULA NONA - </b>A escola não se responsabilizará por objetos alheios à atividade escolar, bem como os citados na Lei 14.146/2008 (celulares, mp3, mp4, câmeras, pen drive, iPod, tablets, fones e outros similares) e quantias trazidas pelo(a) aluno(a) ao colégio, sem o prévio consentimento da Direção. Assim como os objetos de uso e cuidado pessoal, como óculos, relógio, acessórios, aparelhos ortopédicos, auditivos ou próteses em geral e brinquedos.</p>

<p align="justify"><b>CLÁUSULA DÉCIMA – </b>O Responsável declara ciência que o inadimplemento de quaisquer valores correspondentes à primeira mensalidade escolar ou débitos de qualquer natureza relativo aos anos letivos anteriores, implicará na interpretação do Colégio Carinho da Mamãe de que houve desistência para finalização da matrícula, a qual perde, automaticamente, sua validade, resolvendo-se o presente contrato de pleno direito.</p>

<p align="justify"><b>CLÁUSULA DÉCIMA PRIMEIRA - </b>O contratante autoriza a CONTRATADA, a título gratuito a uso de imagem e voz do aluno matriculado para fins comerciais e/ou em razão da relação ensino-aprendizagem e efetuados dentro ou fora de sala de aula para fins exclusivos de divulgação da Contratada.</p>

<p align="justify"><b>CLÁUSULA DÉCIMA SEGUNDA – </b>Fica vetado aos pais entrar nas dependências do Colégio para solucionar conflitos diretamente com alunos e/ou professores. Todos os conflitos deverão ser previamente comunicados à Direção, para que sejam tomadas as devidas providências.</p>

<p align="justify"><b>CLÁUSULA DÉCIMA TERCEIRA - </b>A instituição assegura que todos os alunos, inclusive alunos com deficiência, receberão atendimento respeitando os princípios de igualdade, inclusão e acessibilidade, conforme a Lei nº 13.146/2015 (Estatuto da Pessoa com Deficiência).</p>

<p align="justify"><b>Parágrafo Primeiro – </b>É de obrigação do responsável legal do discente informar, no ato da matrícula, se o estudante possui alguma deficiência e/ou se faz uso de algum medicamento, contínuo ou não, mediante a apresentação de laudo médico.</p>

<p align="justify"><b>CLÁUSULA DÉCIMA QUARTA - </b>DO COMBATE AO BULLYING E/OU CYBERBULLYING:As partes pactuam em colaborar, no âmbito cívico e legal, para prevenir e combater a intimidação sistemática (bullying) entre crianças e adolescentes. Fica estabelecido que qualquer registro inserido na rede social escolar que seja considerado inapropriado ou ofensivo pelo corpo docente da Contratada, assim como a veiculação de material de cunho pornográfico, pedófilo, ou que configure prática de bullying e/ou cyberbullying, entre outros atos ilícitos praticados pelo Contratante e/ou pelo Aluno/Beneficiário, será caracterizado como infração gravíssima, sujeitando o Contratante e/ou Aluno/Beneficiário aos procedimentos previstos no Regimento Interno, sem prejuízo das sanções previstas no Estatuto da Criança e do Adolescente e demais consequências estabelecidas na legislação brasileira vigente.</p>

<p align="justify"><b>CLÁUSULA DÉCIMA QUINTA - </b>DO COMBATE À VIOLÊNCIA CONTRA PROFESSORES E COLABORADORES:O Contratante, na qualidade de responsável legal pelo Aluno/Beneficiário, declara ciência de que a Contratada não tolerará, em hipótese alguma, a prática de atos de violência física, psicológica, verbal ou moral, dirigidos contra professores, coordenadores, diretores, funcionários ou quaisquer colaboradores da instituição de ensino, sendo tais condutas consideradas infração gravíssima, sem prejuízo da comunicação do fato às autoridades competentes.</p>

<p align="justify"><b>CLÁUSULA DÉCIMA SEXTA - </b>DA LEI GERAL DE PROTEÇÃO DE DADOS PESSOAIS (LGPD):Em cumprimento à Lei Geral de Proteção de Dados (Lei nº 13.709/2018 – LGPD), a CONTRATADA informa à CONTRATANTE que os dados pessoais coletados no contexto da contratação serão utilizados para a finalidade de viabilizar a execução do presente Contrato e serão armazenados durante a sua vigência ou por período superior, nos casos em que sua manutenção se justificar em outra hipótese legal prevista na LGPD.    </p>

<p aling="justify"><b>PARÁGRAFO 1º - </b> As Partes declaram-se cientes dos direitos, obrigações e penalidades aplicáveis constantes da LGPD e obrigam-se a adotar todas as medidas razoáveis para garantir, por si, bem como por seus colaboradores, empregados e subcontratados, que utilizem os Dados Pessoais somente na extensão autorizada pela referida lei.</p>

<p align="justify"><b>CLÁUSULA DÉCIMA SÉTIMA - </b>DO USO DE IMAGEM E VOZ:O (A) CONTRATANTE/ALUNO(A), desde o início da relação jurídica que se dá com a matrícula, com amparo na Lei nº 9.610/98 concede e autoriza a CONTRATADA, a título gratuito, o uso de imagem, voz, vídeos, áudios e trabalhos escolares realizados em razão da relação ensino-aprendizagem e efetuados dentro ou fora de sala de aula, para fins exclusivos de divulgação da CONTRATADA, podendo, para tanto, reproduzi-las junto à internet, jornais e todos demais meios de comunicação, públicas ou de comunicação interna do Colégio.</p>

<p aling="justify"><b>PARÁGRAFO 1º - </b> O CONTRATANTE autoriza o repasse dos seus dados cadastrais ao INEP – Instituto Nacional de Estudos e Pesquisas Educacionais, quando solicitados para fins estatísticos.</p>

<p align="justify"><b>CLÁUSULA DÉCIMA OITAVA - </b>Para dirimir ou esclarecer quaisquer dúvidas ou casos omissos no presente contrato, as partes elegem o foro da Cidade de Juazeiro do Norte/CE.</p>

<p align="justify">E assim, por estarem justos e contratados, assinam o presente instrumento, juntamente com duas testemunhas, a fim de que venham os efeitos legais e jurídicos, e ainda, assinado por outro(a) responsável pelo(a) aluno(a) beneficiário(a), se exigido pela Contratada.</p>
<br>
<p align="right">Juazeiro do Norte-CE, <?php echo date('d/m/Y'); ?>.</p>
        
        <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Assinaturas</title>
    <style>
        .linha-assinaturas {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        
        .linha-testemunhas {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .linha-cpf {
            display: flex;
            justify-content: space-between;
        }
        
        .campo-assinatura {
            flex: 1;
            text-align: center;
            margin: 0 20px;
        }
        
        .campo-assinatura div {
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 5px;
            min-height: 25px;
        }
    </style>
</head>
<body>
    <div class="table-responsive tabela-recibo">
        <br><br>

        <!-- Linha 1: Pai/Mãe e Funcionário -->
        <div class="linha-assinaturas">
            <div class="campo-assinatura">
                <div></div>
                Assinatura Pai / Mãe ou Responsável
            </div>
            
            <div class="campo-assinatura">
                <div></div>
                Assinatura Funcionário (a)
            </div>
        </div>
        
        <!-- Linha 2: Testemunhas -->
        <div class="linha-testemunhas">
            <div class="campo-assinatura">
                <div></div>
                Assinatura Testemunha 1
            </div>
            
            <div class="campo-assinatura">
                <div></div>
                Assinatura Testemunha 2
            </div>
        </div>
        
        <!-- Linha 3: CPFs -->
        <div class="linha-cpf">
            <div class="campo-assinatura">
                CPF 1: ________________________________________
            </div>
            
            <div class="campo-assinatura">
                CPF 2: ________________________________________
            </div>
        </div>
    </div>
</body>
</html>

                  
        <!-- </div>
                            </div>



                            <div class="table-responsive tabela-recibo">
                              
  
                                <br><br>

                                <p align="center">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;____________________________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  _____________________________________<br>
                                    Assinatura
                                    Pai / M&atilde;e ou Respons&aacute;vel &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura
                                    Funcion&aacute;rio (a)</p>
                                                     
                                

                          

                            <div class="table-responsive tabela-recibo">
                              
  
                                <br><br>

                                <p align="center">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;____________________________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  _____________________________________<br>
                                    Assinatura Testemunha 1   &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura Testemunha 2 <br>
                                CPF 1:____________________________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  CPF 2:_____________________________________
                                </p>
                                                        

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