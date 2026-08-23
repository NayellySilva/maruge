@extends('layouts.app')  
@section('content')
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

            <div class="row" aling="center">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading ">
                            <strong> RECIBO DE MATRÍCULA / CONTRATO</strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive tabela-recibo">
                                <table  width="975" class="tabela-recibo" aling="center">
                                    <tr>
                                        <th width="259" colspan="3" align="left" scope="row"> 
                                            Aluno: {{$aluno->NomeAluno}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Valor R$:  {{ number_format($ValorPGTO,2,",",".")}}&nbsp;&nbsp;&nbsp;&nbsp; Matrícula para o : {{$turma->NomeTurma}}.
                                            <br>
                                            Data: {{$matricula->DataMatricula}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forma de Pagamento: {{$matricula->FormaPGTO}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                                            <b> Email:</b>{{$matricula->Email}}&nbsp;&nbsp;&nbsp;<b>Senha:</b> {{$matricula->RA}}
                                            <br /> <br/>

                                            <div class=" table-responsive table-bordered">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            OBS: {{$aluno->ObsAluno}}    
                                                        </td>
                                                    </tr> 
                                                </table>  
                                            </div>
                                            <br>
                                            Importante - Termo de compromisso<br>
                                            Carnê de pagamento pela plataforma Isaac.<br>

                                            <!--
                                            <p align="center">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;____________________________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  _____________________________________<br>
                                                Assinatura
                                                Pai / M&atilde;e ou Respons&aacute;vel &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura
                                                Funcion&aacute;rio (a)</p>
                                            <br><br>{{$pais->Responsavel}}&nbsp; &nbsp; &nbsp;CPF: {{$pais->CPFResponsavel}} &nbsp; &nbsp; &nbsp;RG:{{$pais->RGResponsavel}}
                                            -->
                                        </th>
                                    </tr>
                                </table>
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
            <strong> Apoio ao material: (  )</strong>
            <br>
            <strong> OBS: Entrega do Material Individual. (    ) Completa  (    ) Parcial ______/______/______</strong>

            <br><br><br>
            <div class="linha"></div>
            <br>

            <div class="row" aling="center">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading ">
                            <strong> TERMOS ESCOLARES:</strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive tabela-recibo">
                                <table  class="tabela-recibo" aling="center">
                                    <tr>
                                        <th colspan="3" align="left" scope="row"> 
                                            <div class=" table-responsive table-bordered">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            
                                                    <li>Faça a leitura do contrato de matrícula 2026.</li>  
                                                    <li>A quitação do ano letivo, a matrícula e 11 (onze) mensalidades.</li>    
                                                    <li>Informamos que os trabalhos realizados em sala de aula ou eventos podem ser divulgados nas redes sociais (som e imagens), se houver restrição quanto(a) ao aluno (a) comunicar no ato da matrícula.</li>    
                                                    <li>A cantina do colégio é terceirizada, por essa razão não é permitido a venda de lanche a prazo.</li>    
                                                    <li>Abertura dos Portões 06:50.
                                                    <li>Saída de Alunos: Ed. Infantil (11:00); Fundamental I (11:15); Fundamental II (12:00).                                                      
                                                    <li>O aluno que vai sozinho para casa deve ser informado na secretaria do colégio.</li>    
                                                    <li>Para as crianças da Educação infantil, é necessário receber do colégio o Cartão de Identificação.</li>    
                                                    <li>No decorrer do ano se houver alteração de endereço ou telefone, informar com urgência na secretaria do colégio.</li>    
                                                    <li>A escola não se responsabiliza por qualquer item além do material escolar.</li>                                                           
                                                    <li>Alunos que fazem uso de capacete, é necessário a identificação no capacete ficando aos cuidados do aluno na sala de aula.</li>    
                                                    <li>Alunos sob cuidados médicos não deve ser ocultado, o colégio precisa saber para ajudar e trabalhar com segurança.</li>    
                                                    <li>Casos de separação dos pais, onde aconteçam problemas sérios em relação aos contatos com a criança, deve ser comunicado previamente ao colégio.</li>    
                                                    <li>Diariamente temos um momento de oração, caso os pais não autorizem (a participaçao do(a) aluno(a)), pode nos avisar nesse momento da matrícula, pois, temos todo carinho e respeito em relação a vivência de fé de cada família.  </li>    
                                                    <li>Alunos veteranos atualizar o cadastro na plataforma do WhattsApp do Colégio através do Nº (88) 3511-3581, e novatos fazer cadastro enviando o "print" do recibo de matrícula.  </li>    
                                                    <li>Trazer garrafinha de água de casa (Diariamente).</li>
                                                    <li>Não participar das aulas se apresentar sintomas como: espirro, dor de cabeça, febre, gripe, garganta inflamada, conjutivite.</li> 
                                                    <li>Alunos com acompanhamentos clínicos (OU DA EDUCAÇÃO INCLUSIVA)os pais devem trazer para secretaria do colégio todas as informações médicas e dos demais profissionais.</li> 
                                                    <li>Oferecemos serviços: Sistema Integral até o 3º Ano, Acompanhamento Escolar e Transporte Escolar, para cada serviço há um contrato especifico e o pagamento é através de plataformas financeiras, com Exceção do transporte escolar.</li> 
                                                    <li>Fica esclarecido aos pais que para solucionar situações de conflitos com os professores e/ou alunos, não há autorização para esse contato sem antes registrar à Direção do Colégio afim de que, devidas providências sejam tomadas.</li> 
                                                    <li>Desenvolvemos Projetos como: Empreendedorismo em Ed. Fincanceira/Sócio-Emocional / Olimpíadas / Reciclagem - Responsabilidade Ambiental (RRA).</li> 
                                                    <li>Acompanhe os comunicados no grupo de WhatsApp do seu filho e siga-nos nas Redes Sociais: @colegiocarinhodamamae_oficial/ Canal do Youtube.</li> 
                                                    <li>Instale o App "Meu Isaac" para realizar pagamentos (Mensalidades).</li> 
                                                    <li>Os Professores estão em constante formação para que o trabalho da Educação Inclusiva aconteça atendendo as nescessidades do aluno, esses professores possuem apoio da Equipe Pedagógica, com o objetivo de construir a independência do Aluno.</li> 
                                                    <li>Sempre tire suas dúvidas nos atendimentos oferecidos pelo colégio.</li> 
                                                </td>
                                                    </tr> 
                                                </table>  
                                            </div>

                                    </tr>
                                </table>
                                <br><br>
<!--
                                <p align="center">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;____________________________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  _____________________________________<br>
                                    Assinatura
                                    Pai / M&atilde;e ou Respons&aacute;vel &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura
                                    Funcion&aacute;rio (a)</p>
                                <br><br>{{$pais->Responsavel}}&nbsp; &nbsp; &nbsp;CPF: {{$pais->CPFResponsavel}} &nbsp; &nbsp; &nbsp;RG:{{$pais->RGResponsavel}}
                                <!--
                                <b> Testemunhas:</b> <br><br>
Assinatura:__________________________________________		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura:__________________________________________	<br><br>
Nome completo e identidade (espécie e no, órgão emissor/UF)	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;	Nome completo e identidade (espécie e no, órgão emissor/UF)
                                -->
                            </div>

                            <!-- /.table-responsive -->
                        </div>





                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.row -->
            </div>





            <div class="row" aling="center">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading ">
                            <strong> CONSENTIMENTO DOS PAIS OU RESPONSÁVEIS PARA O USO G SUITE FOR EDUCATION PARA {{$aluno->NomeAluno}}:</strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive tabela-recibo">
                                <table   class="tabela-recibo" aling="center">
                                    <tr>
                                        <th  colspan="3" align="left" scope="row"> 
                                            <div class=" table-responsive table-bordered">
                                                <table>



                                                    <tr>
                                                        <td>
                                                            <p align="justify">Aos pais e responsáveis,</p> 

                                                            <p align="justify"> Na Instituição de Ensino Colégio Carinho da Mamãe, usamos o G Suite for Education e estamos solicitando sua permissão
                                                                para fornecer e gerenciar uma conta do G Suite for Education para seu filho. O G Suite for Education é um conjunto de ferramentas de 
                                                                produtividade para educação do Google, que inclui o Gmail, o Google Agenda, o Documentos Google, o Google Sala de Aula e outros produtos 
                                                                usados por dezenas de milhões de alunos e professores no mundo todo. Na Instituição de Ensino Colégio Carinho da Mamãe, os alunos usarão as 
                                                                contas do G Suite para fazer atividades, comunicar-se com os professores e aprender habilidades atuais de cidadania digital. 
                                                                O aviso abaixo traz respostas para dúvidas comuns sobre o que o Google pode e não pode fazer com as informações pessoais dos alunos:

                                                            </p>


                                                        </td>
                                                    </tr>





                                                    <tr>
                                                        <td>
                                                    <li>Quais informações pessoais o Google coleta?</li>
                                                    <p align="justify"> Ao criar uma conta de aluno, a Instituição de Ensino Colégio Carinho da Mamãe pode fornecer ao Google algumas informações pessoais sobre o aluno, incluindo: nome, endereço de e-mail e senha. O Google também pode coletar informações pessoais diretamente dos alunos, como número de telefone para recuperação da conta ou uma foto do perfil adicionada à conta do G Suite for Education.
                                                        Quando um aluno utiliza os serviços do Google, o Google também coleta informações com base no uso desses serviços. Isso inclui:
                                                     <br> -  informações sobre o dispositivo, como modelo do hardware, versão do sistema operacional, identificadores exclusivos do dispositivo e informações sobre a rede móvel, incluindo o número de telefone;
                                                     <br> -  informações de registro, incluindo detalhes sobre como um usuário utilizou os serviços do Google, informações de eventos do dispositivo e o endereço IP do usuário;
                                                    <br>  -  informações de localização, conforme determinadas por várias tecnologias, incluindo endereço IP, GPS e outros sensores;
                                                    <br>  - números exclusivos dos aplicativos, como o número de versão do aplicativo; e
                                                    <br>  - cookies ou tecnologias semelhantes usadas para coletar e armazenar informações sobre um navegador ou dispositivo, como idioma de preferência e outras configurações.
                                                         </p>
                                                  
                                                     
                                                     
                                                     
                                                     
                                                     
                                                     
                                                     
                                                     <li>Como o Google usa essas informações?</li>
                                                     <p align="justify">Nos Serviços principais do G Suite for Education, o Google usa as informações pessoais dos alunos para fornecer, manter e proteger os serviços. O Google não exibe anúncios nos 
                                                         Serviços principais ou usa as informações pessoais coletadas nos Serviços principais para fins publicitários.</p>
                                                   
                                                     
                                                    <li>O Google divulgará as informações pessoais do meu filho?</li>
                                                    
                                                    <P aling="Justify">
                                                        O Google não compartilhará informações pessoais com empresas, organizações e indivíduos externos ao Google, salvo em uma das seguintes circunstâncias:
                                                        Para processamento externo da Instituição de Ensino em questão e atividades pedagógicas.
                                                    </P>
                                                    
                                                    
                                                    <li>O Google usa informações pessoais de alunos para usuários de escolas de ensino fundamental e médio para segmentar anúncios?</li>
                                                    <p aling="justify">Não. Para os usuários do G Suite for Education em escolas de ensino fundamental e médio, o Google não utiliza as informações pessoais dos usuários, ou qualquer informação associada a uma conta do G Suite for Education, para segmentar anúncios, seja nos Serviços principais ou em outros Serviços adicionais acessados com uma conta do G Suite for Education.</p>
                                                    <li>Meu filho pode compartilhar informações com outras pessoas usando a conta do G Suite for Education?</li> 
                                                    <p aling="juatify"> Não. O uso dos matériais produzidos e disponibilizados nas plataformas como Google Sala de Aula e Gravações das aulas pelo meet, 
                                                        é exclussivamente de uso Educacional, sendo vetado para uso e produção de memes que venha afligir a honra de alunos, professores ou qualquer pessoa. </p>
                                                    </td>
                                                    </tr> 
                                                    
                                                    <tr>
                                                        <td>
                                                            <p aling="justify"> Leia o aviso atentamente, entre em contato se você tiver alguma dúvida e 
                                                            assine abaixo para indicar que leu e dá seu consentimento. 
                                                            Se você não der seu consentimento, não criaremos uma conta do G Suite for Education para o aluno.</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p align="justify"> Eu dou permissão para Instituição de Ensino Colégio Carinho da Mamãe criar/manter uma conta do G Suite for Education para meu filho e para o Google coletar, 
                                                                usar e divulgar informações sobre meu filho somente para os fins descritos no aviso.</p> 
                                                        </td>
                                                    </tr>
                                               
            
                                                    
                                                </table>  
                                            </div>

                                    </tr>
                                </table>
                                <br><br> <br>
                            <br>
                            <br> <br>
                            <br>
                            <br>

                                <p align="center">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;____________________________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  _____________________________________<br>
                                    Assinatura
                                    Pai / M&atilde;e ou Respons&aacute;vel &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura
                                    Funcion&aacute;rio (a)</p>
                                <br><br>{{$pais->Responsavel}}&nbsp; &nbsp; &nbsp;CPF: {{$pais->CPFResponsavel}} &nbsp; &nbsp; &nbsp;RG:{{$pais->RGResponsavel}} - Juazeiro do Norte - Ceará, {{$matricula->DataMatricula}}<br><br>

                                 <br>
                            <br>
                            <br> <br>
                            <br>
                            <br>
                                
                                <p aling="right"><b> Email Institucional:</b></p>
                                <b>Aluno:</b>  {{$aluno->NomeAluno}}&nbsp;&nbsp; <b>Turma:</b> {{$turma->NomeTurma}}.<br>
                                <b> Email:</b>{{$matricula->Email}}&nbsp;&nbsp;&nbsp;<b>Senha:</b> {{$matricula->RA}}<br><br>
                                
                                <li><b>OBS:</b> O E-mail Institucional só será liberado mediante demanda da coordenação. </li>
                                
                                
                                
                                
                            </div>










                        </div>
                        </body>
                        </html>
                        @endsection