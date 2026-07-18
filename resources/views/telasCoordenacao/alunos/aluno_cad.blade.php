@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Nova Matrícula'}}</h1>

</div> 
<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 

    <div class="formularios">    
        @if(count($errors)>0)
        @foreach($errors->all()as $error)
        {{$error}}
        @endforeach
        @endif

        @if(isset($aluno))
        <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/aluno_editar/{{$aluno->idAluno}}" method="POST">
            @else
            <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/aluno_cad" method="POST" send="/maruge/public/coordenacao/aluno_cad">
                @endif 
                {!! csrf_field() !!}
                <!-- GUIA DE NAVEGAÇÃO -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#dados_aluno" aria-controls="dados_aluno" role="tab" data-toggle="tab">DADOS DO ALUNO</a></li>
                    <li role="presentation"><a href="#dados_pais" aria-controls="dados_pais" role="tab" data-toggle="tab">DADOS DOS PAIS</a></li>
                    <li role="presentation"><a href="#endereco" aria-controls="endereco" role="tab" data-toggle="tab">ENDEREÇO</a></li>
                    <li role="presentation"><a href="#obs" aria-controls="obs" role="tab" data-toggle="tab">OBSERVAÇÕES</a></li>
                </ul>
                <!-- TODAS AS GUIAS DE FORMULARIOS -->
                <div class="tab-content">
                    <!--*****************************************************************************
                    *********************************************************************************
                    FORMULARIO DA DADOS ALUNOS
                    *********************************************************************************
                    *********************************************************************************
                    -->                    
                    <div role="tabpanel" class="tab-pane active" id="dados_aluno"> 
                        <div class="cadForm" > </div>
                        <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (NOME DO ALUNO, SEXO, DATANASCIMENTO, MAC, SITUAÇÃO )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="NomeAluno">Nome do Aluno:</label>
                                    <input type="text" name="NomeAluno" placeholder="Nome do Aluno"  class="form-control" value="{{$aluno->NomeAluno or old('NomeAluno')}}">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="Sexo">Sexo:</label>
                                    <select class="form-control" name="Sexo" id="Sexo">
                                        <option >{{$aluno->Sexo or old('Sexo')}}</option>
                                        <option> F </option>
                                        <option> M </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="DataNascimento">Data de Nascimento:</label>
                                    <input type="text" name="DataNascimento" placeholder="Data de Nascimento" id="DataNascimento" class="form-control" value="{{$aluno->DataNascimento or old('DataNascimento')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="NumeroMac">Nº ID:</label>
                                    <input type="text" name="NumeroMac" placeholder="Número do Mac" class="form-control" id="numeroMac" value="{{$aluno->NumeroMac or old('NumeroMac')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="hidden" name="Nivel" value="ALUNO">
                                    <label for="SituacaoAluno ">Situação:</label>
                                    <select class="form-control" name="SituacaoAluno">
                                        @if(isset($matricula->SituacaoAluno))
                                        <option >{{$matricula->SituacaoAluno or old('SituacaoAluno')}}</option>
                                        <option>  </option>
                                        <option> ATIVO </option>
                                        <option> INATIVO </option>
                                        <option> TRANSFERIDO </option>
                                        <option> DESISTENTE </option>
                                        @else
                                         <option> ATIVO </option>
                                        <option> INATIVO </option>
                                        <option> TRANSFERIDO </option>
                                        <option> DESISTENTE </option>
                                        @endif

                                    </select>
                                </div>
                            </div>
                            <!--FECHANDO A PRIMEIRA LINHA-->
                        </div>
                        <!--SEGUNDA LINHA REFERENTE AOS CAMPOS (TURMA-ALUNO-REGISTRO-PASTA-FOTO)-->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="idTurma">Turma:</label>

                                    <select class="form-control" name="tb_turmas_idTurmas">
                                        @if(isset($aluno))
                                        <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma or old('')}}</option>
                                        <option></option>
                                        @forelse($turmas as $turma) 
                                        <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma or old('')}}</option>
                                        @empty
                                        @endforelse 
                                        <!--Fim do laço da turma para editar-->
                                        @else 
                                        <option></option>
                                        <!-- condição para cadastrar-->
                                        @forelse($turmas as $turma)  
                                        <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                        @empty
                                        @endforelse 
                                        @endif
                                    </select>



                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="AlunoNV">Aluno:</label>
                                    <select class="form-control" name="AlunoNV">
                                        <option >{{$matricula->AlunoNV or old('AlunoNV')}}</option>
                                        <option> NOVATO </option>
                                        <option> VETERANO </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Registro">Registro:</label>
                                    <select class="form-control" name="Registro">
                                        <option >{{$matricula->Registro or old('Registro')}}</option>
                                        <option>SIM</option>
                                        <option>NÃO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Pasta">Pasta:</label>
                                    <select class="form-control" name="Pasta">
                                        <option >{{$matricula->Pasta or old('Pasta')}}</option>
                                        <option> SIM </option>
                                        <option> NÃO </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Foto">Foto:</label>
                                    <select class="form-control" name="Foto">
                                        <option >{{$matricula->Foto or old('Foto')}}</option>
                                        <option> SIM </option>
                                        <option> NÃO </option>
                                    </select>
                                </div>
                            </div>
                            <!--FECHANDO A SEGUNDA LINHA-->
                        </div>
                        
                        <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (NOME D OCARTORIO NUMERO LIVRO REISTRO)-->
                       
                          
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="NomeCartorio">Nome Cartório:</label>
                                    <input type="text" name="NomeCartorio" placeholder="Nome do Cartório" class="form-control" value="{{$aluno->NomeCartorio or old('NomeCartorio')}}">
                                </div>
                            </div>
                            
                          
                            <!--
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="NumeroRG">Nº Registro:</label>
                                    <input type="text" name="NumeroRG" placeholder="Numero do Registro" class="form-control" value="{{$aluno->NumeroRG or old('NumeroRG')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="NumeroLivro">Nº do Livro:</label>
                                    <input type="text" name="NumeroLivro" placeholder="Número do Livro" class="form-control" value="{{$aluno->NumeroLivro or old('NumeroLivro')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="NumeroFolha">Folha:</label>
                                    <input type="text" name="NumeroFolha" placeholder="Número da Folha"  class="form-control" value="{{$aluno->NumeroFolha or old('NumeroFolha')}}">
                                </div>
                            </div>
                            !-->
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="DataEmissao">Data de Emissão:</label>
                                    <input type="text" id="DataEmissao" name="DataEmissao" class="form-control"  value="{{$aluno->DataEmissao or old('DataEmissao')}}">
                                </div>
                            </div>
                               <!--Adicionando campo de entrega - Declaração/Histórico)-->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Historico">Histórico:</label>
                                    <select class="form-control" name="Historico">
                                        <option >{{$matricula->Historico or old('Historico')}}</option>
                                        <option> SIM </option>
                                        <option> NÃO </option>
                                    </select>
                                                                   
                                </div>
                            
                            
                            </div>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Declaracao">Declaração:</label>
                                    <select class="form-control" name="Declaracao">
                                              
                                        <option >{{$matricula->Declaracao or old('Declaracao')}}</option>
                                      
                                            <option> SIM </option>
                                        <option> NÃO </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                           
                        <!--QUARTA LINHA REFERENTE AOS CAMPOS (NUMERO DE MATRICULA ESTADO CIDADE)-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="NumeroRGNovo">Número da matrícula (Registro Civil - Certidão Nova):</label>
                                    <input type="text" name="NumeroRGNovo" id="NumeroRGNovo" placeholder="Número da matrícula (Registro Civil - Certidão Nova)" class="form-control" value="{{$aluno->NumeroRGNovo or old('NumeroRGNovo')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="EstadoCartorio">Estado:</label>
                                    <select class="form-control" name="EstadoCartorio" >
                                        <option >{{$aluno->EstadoCartorio or old('EstadoCartorio')}}</option>
                                        <option> ACRE </option>
                                        <option> ALAGOAS</option>
                                        <option> AMAPÁ</option>
                                        <option> AMAZONAS</option>
                                        <option> BAHIA</option>
                                        <option> CEARA</option>
                                        <option> DISTRITO FEDERAL</option>
                                        <option> ESPÍRITO SANTO</option>
                                        <option> GOIÁS</option>
                                        <option> MARANHÃO</option>
                                        <option> MATO GROSSO</option>
                                        <option> MATO GROSSO DO SUL</option>
                                        <option> MINAS GERAIS</option>
                                        <option> PARÁ</option>
                                        <option> PARAÍBA</option>
                                        <option> PARANÁ</option>
                                        <option> PERNAMBUCO</option>
                                        <option> PIAUÍ</option>
                                        <option> RIO DE JANEIRO</option>
                                        <option> RIO GRANDE DO NORTE</option>
                                        <option> RIO GRANDE DO SUL</option>
                                        <option> RONDÔNIA</option>
                                        <option> RORAIMA</option>
                                        <option> SANTA CATARINA</option>
                                        <option> SÃO PAULO</option>
                                        <option> SERGIPE</option>
                                        <option> TOCANTINS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="CidadeCartorio">Cidade:</label>
                                    <input type="text" name="CidadeCartorio" placeholder="Cidade do Cartório" class="form-control" value="{{$aluno->CidadeCartorio or old('CidadeCartorio')}}">
                                </div>
                            </div>
                            <!-- FECHANDO A QUARTA LINHA-->
                        </div>
                        <!--QUINTA LINHA REFERENTE AOS CAMPOS (VALOR E DATA DA MATRICULA)-->
                        <div class="row">
                            <div class="col-md-2">       
                                <div class="form-group">
                                    <label for="CPFAluno">CPF do Aluno:</label>
                                    <input type="text" name="CPFAluno" placeholder="CPF do Aluno"  id="CPFAluno" class="form-control" value="{{$aluno->CPFAluno or old('CPFAluno')}}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FormaPGTO ">Forma PGTO :</label>
                                    <select class="form-control" name="FormaPGTO">
                                        <option >{{$matricula->FormaPGTO or old('FormaPGTO')}}</option>
                                        <option> CHEQUE </option>
                                        <option> CARTÃO </option>
                                        <option> DINHEIRO </option>
                                    </select>
                                </div>



                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ValorPGTO">Valor:</label>
                                    <input type="text" name="ValorPGTO" placeholder="R$ 0,00" id="ValorPGTO" class="form-control" value="{{$matricula->ValorPGTO or old('ValorPGTO')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="DataMatricula">Data Matrícula:</label>
                                    <input type="text" id="DataMatricula" name="DataMatricula" placeholder="Data Matricula" class="form-control" value="{{$matricula->DataMatricula or old('DataMatricula')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="desconto">Aluno(a) Bônus:</label>

                                    <select class="form-control" name="Bonus">
                                        <option value="{{$matricula->Bonus or old('Bonus')}}">{{$matricula->Bonus or old('Bonus')}}% de Desconto</option><br>
                                        <option ></option>
                                        <option value="3">3 % de Desconto</option>
                                        <option value="5">5 % de Desconto</option>
                                        <option value="6">6 % de Desconto</option>
                                        <option value="7">7 % de Desconto</option>
                                        <option value="8">8 % de Desconto</option>
                                        <option value="9">9 % de Desconto</option>
                                        <option value="10">10% de Desconto</option>
                                        <option value="11">11% de Desconto</option>
                                        <option value="12">12% de Desconto</option>
                                        <option value="13">13% de Desconto</option>
                                        <option value="14">14% de Desconto</option>
                                        <option value="15">15% de Desconto</option>
                                        <option value="16">16% de Desconto</option>
                                        <option value="17">17% de Desconto</option>
                                        <option value="18">18% de Desconto</option>
                                        <option value="19">19% de Desconto</option>
                                        <option value="20">20% de Desconto</option>
                                        <option value="21">21% de Desconto</option>
                                        <option value="22">22% de Desconto</option>
                                        <option value="23">23% de Desconto</option>
                                        <option value="25">25% de Desconto</option>
                                        <option value="30">30% de Desconto </option>
                                        <option value="35">35% de Desconto </option>
                                        <option value="36">36% de Desconto </option>
                                        <option value="37">37% de Desconto </option>
                                        <option value="38">38% de Desconto </option>
                                        <option value="39">39% de Desconto </option>
                                        <option value="40">40% de Desconto</option>
                                        <option value="41">41% de Desconto</option>
                                        <option value="42">42% de Desconto</option>
                                        <option value="43">43% de Desconto</option>
                                        <option value="44">44% de Desconto</option>
                                        <option value="45">45% de Desconto</option>
                                        <option value="46">46% de Desconto</option>
                                        <option value="47">47% de Desconto</option>
                                        <option value="48">48% de Desconto</option>
                                        <option value="49">49% de Desconto</option>
                                        <option value="50">50% de Desconto</option>
                                        <option value="55">55% de Desconto</option>
                                        <option value="60">60% de Desconto </option>
                                        <option value="65">65% de Desconto </option>
                                        <option value="70">70% de Desconto</option>
                                        <option value="71">71% de Desconto</option>
                                        <option value="72">72% de Desconto</option>
                                        <option value="73">73% de Desconto</option>
                                        <option value="74">74% de Desconto</option>
                                        <option value="75">75% de Desconto</option>
                                        <option value="80">80% de Desconto</option>
                                        <option value="85">85% de Desconto</option>
                                        <option value="90">90% de Desconto </option>
                                        <option value="95">95% de Desconto </option>
                                        <option value="100">100% de Desconto </option>
                                        
                                    </select>                               
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Acompanhamento">Acompanhamento:</label>

                                    <select class="form-control" name="Acompanhamento">
                                        <option value="{{$aluno->Acompanhamento or old('Acompanhamento')}}">{{$aluno->Acompanhamento or old('Acompanhamento')}}  </option><br>
                                        <option value="Não">NÃO </option>
                                        <option value="Psicológico">Psicológico </option>
                                        <option value="Psicopdagógico">Psicopdagógico</option>
                                        <option value="Neurológico">Neurológico</option>
                                        <option value="Escolar">Escolar - CCDM</option>
                                        <option value="Outros">Outros</option>
                                        
                                    </select>                               
                                </div>
                            </div>
                            <!--FECHANDO A QUINTA LINHA-->









                        </div>
                        <!--*****************************************************************************
                        *********************************************************************************
                        FIM FORMULARIO DA GUIA DADOS DO ALUNO
                        *********************************************************************************
                        *********************************************************************************
                        -->
                    </div>
                    <!--*****************************************************************************
                    *********************************************************************************
                    FORMULARIO DADOS PAIS
                    *********************************************************************************
                    *********************************************************************************
                    -->                    
                    <div role="tabpanel" class="tab-pane" id="dados_pais"> 
                        <div class="cadForm" > </div>       
                        <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (NOME DA MAE, TELEFONES E PROFISSÃO DO PAI )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="NomePai">Nome do Pai:</label>
                                    <input type="text" name="NomePai" placeholder="Nome do Pai"  class="form-control" value="{{$pais->NomePai or old('NomePai')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FonePai1">WhatsApp:</label>
                                    <input type="text" name="FonePai1" placeholder="(xx) x-xxxx-xxxx" id="FonePai1" class="form-control" value="{{$pais->FonePai1 or old('FonePai1')}}">
                                </div>                       
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FonePai2">Fone 2:</label>
                                    <input type="text" name="FonePai2" placeholder="(xx) x-xxxx-xxxx" id="FonePai2" class="form-control" value="{{$pais->FonePai2 or old('FonePai2')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ProfPai ">Profissão:</label>
                                    <input type="text" name="ProfPai" placeholder="Profissão do Pai" class="form-control" value="{{$pais->ProfPai or old('ProfPai')}}">
                                </div>
                            </div>
                            <!--FECHANDO A PRIMEIRA LINHA-->
                        </div>
                        <!--SEGUNDA LINHA REFERENTE AOS CAMPOS ( CPF E RG DO PAI)-->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="CPFPai">CPF do Pai:</label>
                                    <input type="text" name="CPFPai" placeholder="CPF do Pai"  id="CPFPai" class="form-control" value="{{$pais->CPFPai or old('CPFPai')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="RGPai">RG do Pai:</label>
                                    <input type="text" name="RGPai"  class="form-control" placeholder="RG do Pai" value="{{$pais->RGPai or old ('RGPai')}}">
                                </div>                       
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="DataNascimentoPai">Data de Nascimento do Pai:</label>
                                    <input type="text" name="Nas_Pai" placeholder="Nascimento do Pai" id="DataNascimentoPai" class="form-control" value="{{$pais->Nas_Pai or old('Nas_Pai')}}">
                                </div>                      
                            </div>
                            <!--FECHANDO A SEGUNDA LINHA-->
                        </div>    
                        <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (NOME DA MAE, TELEFONES E PROFISSÃO DA MÃE )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="NomeMae">Nome da Mãe:</label>
                                    <input type="text" name="NomeMae" placeholder="Nome da Mãe"  class="form-control" value="{{$pais->NomeMae or old('NomeMae')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FoneMae1">WhatsApp:</label>
                                    <input type="text" name="FoneMae1" placeholder="(xx) x-xxxx-xxxx" id="FoneMae1" class="form-control" value="{{$pais->FoneMae1 or old('FoneMae1')}}">
                                </div>                       
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FoneMae2">Fone 2:</label>
                                    <input type="text" name="FoneMae2" placeholder="(xx) x-xxxx-xxxx" id="FoneMae2" class="form-control" value="{{$pais->FonePai2 or old('FoneMae2')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ProfMae">Profissão:</label>
                                    <input type="text" name="ProfMae" placeholder="Profissão da Mãe" class="form-control" value="{{$pais->ProfMae or old('ProfMae')}}">
                                </div>
                            </div>
                            <!--FECHANDO A TERCEIRA LINHA-->
                        </div>
                        <!--QUARTA LINHA REFERENTE AOS CAMPOS ( CPF E RG DO MAE)-->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="CPFMae">CPF da Mãe:</label>
                                    <input type="text" name="CPFMae" placeholder="CPF da Mãe"  id="CPFMae" class="form-control" value="{{$pais->CPFMae or old('CPFMae')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="RGMae">RG da Mãe:</label>
                                    <input type="text" name="RGMae"  class="form-control" placeholder="RG da Mãe" value="{{$pais->RGMae or old ('RGMae')}}">
                                </div>                       
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="DataNascimentoMae">Data de Nascimento da Mãe:</label>
                                    <input type="text" name="Nas_Mae" placeholder="Nascimento da Mãe" id="DataNascimentoMae" class="form-control" value="{{$pais->Nas_Mae or old('Nas_Mae')}}">
                                </div>                      
                            </div>
                            <!--FECHANDO A QUARTA LINHA-->
                        </div>                          
                        <!--QUINTA LINHA REFERENTE AOS CAMPOS ( AO RESPONSAVEL )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="Responsavel">Responsável:</label>
                                    <input type="text" name="Responsavel" placeholder="Nome do Responsável"   class="form-control" value="{{$pais->Responsavel or old('Responsavel')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="RGResponsavel">RG do Responsável:</label>
                                    <input type="text" name="RGResponsavel"  class="form-control" placeholder="RG do Responsável" value="{{$pais->RGResponsavel or old ('RGResponsavel')}}">
                                </div>                       
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="CPFResponsavel">CPF do Responsável:</label>
                                    <input type="text" name="CPFResponsavel"  class="form-control" id="CPFResponsavel" placeholder="CPF do Responsável" value="{{$pais->CPFResponsavel or old ('CPFResponsavel')}}">
                                </div>                       
                            </div>
                            <!--FECHANDO A QUINTA LINHA-->
                        </div>
                        <!--*****************************************************************************
                        *********************************************************************************
                        FIM FORMULARIO DA GUIA DADOS DOS PAIS
                        *********************************************************************************
                        *********************************************************************************
                        -->
                    </div>
                    <!--*****************************************************************************
                    *********************************************************************************
                    FORMULARIO DADOS ENDERECO
                    *********************************************************************************
                    *********************************************************************************
                    -->
                    <div role="tabpanel" class="tab-pane" id="endereco"> 
                        <div class="cadForm" > </div>  
                        <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS ( )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="Rua">Rua:</label>
                                    <input type="text" name="Rua" placeholder="Rua"  class="form-control" value="{{$endereco->Rua or old('Rua')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Numero">Nº:</label>
                                    <input type="text" name="Numero" class="form-control" value="{{$endereco->Numero or old('Numero')}}">
                                </div>                       
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Fone1">Fone Fixo:</label>
                                    <input type="text" name="Fone1" placeholder="(xx) x-xxxx-xxxx" id="tel-fixo" class="form-control" value="{{$endereco->Fone1 or old('Fone1')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="CEP">CEP:</label>
                                    <input type="text" name="CEP" placeholder="CEP" class="form-control" id="CEP" value="{{$endereco->CEP or old('CEP')}}">
                                </div>
                            </div>
                            <!--FECHANDO A PRIMEIRA LINHA-->
                        </div>
                        <!--SEGUNDA LINHA REFERENTE AOS CAMPOS ( BAIRRO , REFERENCIA)-->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Bairro">BAIRRO:</label>
                                    <input type="text" name="Bairro" placeholder="Bairro" class="form-control" value="{{$endereco->Bairro or old('Bairro')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Referencia">REFERÊNCIA:</label>
                                    <input type="text" name="Referencia"  class="form-control" value="{{$endereco->Referencia or old ('Referencia')}}">
                                </div>                       
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Cidade">CIDADE:</label>
                                    <input type="text" name="Cidade"  class="form-control" value="{{$endereco->Cidade or old ('Cidade')}}">
                                </div>                       
                            </div>
                            <!--FECHANDO A SEGUNDA LINHA-->
                        </div>                    
                        <!--*****************************************************************************
                        *********************************************************************************
                        FIM FORMULARIO DA GUIA DADOS DO ENDEREÇO
                        *********************************************************************************
                        *********************************************************************************
                        -->
                    </div>
                    <!--*****************************************************************************
                        *********************************************************************************
                        FORMULARIO DA GUIA OBSERVAÇÕES
                        *********************************************************************************
                        *********************************************************************************
                    -->
                    <div role="tabpanel" class="tab-pane" id="obs"> 
                        <div class="cadForm" ></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ObsAluno" >Obs:</label>
                                    <textarea  class="form-control ajuste" rows="8" type="text" name="ObsAluno" maxlength="1000">{{$aluno->ObsAluno or old('')}}</textarea>

                                </div>
                            </div>
                            
                            
                            <!-- LINHA REFERENTE AOS CAMPOS ( SALVA E LIMPA )-->

                            <div class="col-md-12">
                                <div class="form-group">
                                    <br>
                                    <button type="reset" class="btn btn-default"> LIMPAR</button> 
                                    <button type="submit" class="btn btn-success"> SALVAR</button>

                                </div>
                            </div>   
                        </div>
                        
                        
                        
                        
                        <!--*****************************************************************************
                        *********************************************************************************
                        FIM FORMULARIO DA AGUI DE OBSERVAÇÕES
                        *********************************************************************************
                        *********************************************************************************
                        -->
                    </div>
                </div>
            </form> <!--Fim do formulario-->



    </div>
</div> <!--Fim do caminho-din-->
@endsection