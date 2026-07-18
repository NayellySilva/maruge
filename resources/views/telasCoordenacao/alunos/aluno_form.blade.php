@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Nova Matricula'}}</h1>

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
        <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/editar_aluno/{{$aluno->idAluno}}" method="POST">
            @else
            <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/cadaluno" method="POST" send="/maruge/public/coordenacao/cadaluno">
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
                                    <input type="texto" name="NomeAluno" placeholder="Nome do Aluno"  class="form-control" value="{{$aluno->NomeAluno or old('NomeAluno')}}">
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
                                    <input type="date" name="DataNascimento" placeholder="Data de Nascimento" class="form-control" value="{{$aluno->DataNascimento or old('DataNascimento')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="NumeroMac">Nº Mac:</label>
                                    <input type="texto" name="NumeroMac" placeholder="Número do Mac" class="form-control" value="{{$aluno->NumeroMac or old('NumeroMac')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="SituacaoAluno ">Situação:</label>
                                    <select class="form-control" name="SituacaoAluno">
                                        <option >{{$aluno->SituacaoAluno or old('SituacaoAluno')}}</option>
                                        <option> ATIVO </option>
                                        <option> INATIVO </option>
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
                                    <select class="form-control" name="NomeTurma">
                                        <option></option>
                                        @forelse($turmas as $turma)  
                                        <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                        @empty
                                        @endforelse 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="AlunoNV">Aluno:</label>
                                    <select class="form-control" name="AlunoNV">
                                        <option >{{$aluno->AlunoNV or old('AlunoNV')}}</option>
                                        <option> NOVATO </option>
                                        <option> VETERANO </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Registro">Registro:</label>
                                    <select class="form-control" name="Registro">
                                        <option >{{$aluno->Registro or old('Registro')}}</option>
                                        <option>SIM</option>
                                        <option>NÃO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Pasta">Pasta:</label>
                                    <select class="form-control" name="Pasta">
                                        <option >{{$aluno->Pasta or old('Pasta')}}</option>
                                        <option> SIM </option>
                                        <option> NÃO </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Foto">Foto:</label>
                                    <select class="form-control" name="Foto">
                                        <option >{{$aluno->Foto or old('Foto')}}</option>
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
                                    <input type="texto" name="NomeCartorio" placeholder="Nome do Cartório" class="form-control" value="{{$aluno->NomeCartorio or old('NomeCartorio')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="NumeroRG">Nº Registro:</label>
                                    <input type="texto" name="NumeroRG" placeholder="Numero do Registro" class="form-control" value="{{$endereco->NumeroRG or old('NumeroRG')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="NumeroLivro">Nº do Livro:</label>
                                    <input type="texto" name="NumeroLivro" placeholder="Número do Livro" class="form-control" value="{{$endereco->NumeroLivro or old('NumeroLivro')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="NumeroFolha">Folha:</label>
                                    <input type="texto" name="NumeroFolha" placeholder="Número da Folha"  class="form-control" value="{{$escolas->NumeroFolha or old('NumeroFolha')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="DataEmissao">Data de Emissão:</label>
                                    <input type="date" name="DataEmissao" class="form-control"  value="{{$endereco->DataEmissao or old('DataEmissao')}}">
                                </div>
                            </div>
                        </div>
                        <!--QUARTA LINHA REFERENTE AOS CAMPOS (NUMERO DE MATRICULA ESTADO CIDADE)-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="NumeroRGNovo">Número da matrícula (Registro Civil - Certidão Nova):</label>
                                    <input type="texto" name="NumeroRGNovo" id="NumeroRGNovo" placeholder="Número da matrícula (Registro Civil - Certidão Nova)" class="form-control" value="{{$endereco->NumeroRGNovo or old('NumeroRGNovo')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="EstadoCartorio">Estado:</label>
                                    <select class="form-control" name="EstadoCartorio" >
                                        <option >{{$endereco->EstadoCartorio or old('EstadoCartorio')}}</option>
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
                                    <input type="texto" name="CidadeCartorio" placeholder="Cidade do Cartório" class="form-control" value="{{$endereco->CidadeCartorio or old('CidadeCartorio')}}">
                                </div>
                            </div>
                            <!-- FECHANDO A QUARTA LINHA-->
                        </div>
                        <!--QUINTA LINHA REFERENTE AOS CAMPOS (VALOR E DATA DA MATRICULA)-->
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FormaPGTO ">Forma PGTO :</label>
                                    <select class="form-control" name="FormaPGTO">
                                        <option >{{$aluno->Foto or old('FormaPGTO')}}</option>
                                        <option> CHEQUE </option>
                                        <option> CARTÃO </option>
                                        <option> DINHEIRO </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="ValorPGTO">Valor:</label>
                                    <input type="texto" name="ValorPGTO" placeholder="R$ 0,00" id="ValorPGTO" class="form-control" value="{{$endereco->ValorPGTO or old('ValorPGTO')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="DataMatricula">Data Matricula:</label>
                                    <input type="date" name="DataMatricula" placeholder="Data Matricula" class="form-control" value="{{$aluno->DataMatricula or old('DataMatricula')}}">
                                </div>
                            </div>
                            <!--FECHANDO A QUINTA LINHA-->



                            <!-- LINHA REFERENTE AOS CAMPOS ( SALVA E LIMPA )-->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <br>
                                    <button type="reset" class="btn btn-default"> LIMPAR</button> 
                                    <button type="submit" class="btn btn-success"> SALVA</button>

                                </div>
                            </div>   





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
                                    <input type="texto" name="NomePai" placeholder="Nome do Pai"  class="form-control" value="{{$aluno->NomePai or old('NomePai')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FonePai1">Fone 1:</label>
                                    <input type="text" name="FonePai1" placeholder="(xx) x-xxxx-xxxx" id="FonePai1" class="form-control" value="{{$aluno->FonePai1 or old('FonePai1')}}">
                                </div>                       
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FonePai2">Fone 2:</label>
                                    <input type="text" name="FonePai2" placeholder="(xx) x-xxxx-xxxx" id="FonePai2" class="form-control" value="{{$aluno->FonePai2 or old('FonePai2')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ProfPai ">Profissão:</label>
                                    <input type="texto" name="ProfPai " placeholder="Profissão do Pai" class="form-control" value="{{$aluno->ProfPai or old('ProfPai')}}">
                                </div>
                            </div>
                            <!--FECHANDO A PRIMEIRA LINHA-->
                        </div>
                        <!--SEGUNDA LINHA REFERENTE AOS CAMPOS ( CPF E RG DO PAI)-->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="CPFPai">CPF do Pai:</label>
                                    <input type="texto" name="CPFPai" placeholder="CPF do Pai"  id="CPFPai" class="form-control" value="{{$aluno->CPFPai or old('CPFPai')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="RGPai">RG do Pai:</label>
                                    <input type="text" name="RGPai"  class="form-control" placeholder="RG do Pai" value="{{$aluno->RGPai or old ('RGPai')}}">
                                </div>                       
                            </div>
                            <!--FECHANDO A SEGUNDA LINHA-->
                        </div>    
                        <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (NOME DA MAE, TELEFONES E PROFISSÃO DA MÃE )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="NomeMae">Nome da Mãe:</label>
                                    <input type="texto" name="NomeMae" placeholder="Nome da Mãe"  class="form-control" value="{{$aluno->NomeMae or old('NomeMae')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FoneMae1">Fone 1:</label>
                                    <input type="text" name="FoneMae1" placeholder="(xx) x-xxxx-xxxx" id="FoneMae1" class="form-control" value="{{$aluno->FoneMae1 or old('FoneMae1')}}">
                                </div>                       
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="FoneMae2">Fone 2:</label>
                                    <input type="text" name="FoneMae2" placeholder="(xx) x-xxxx-xxxx" id="FoneMae2" class="form-control" value="{{$aluno->FonePai2 or old('FoneMae2')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="ProfMae">Profissão:</label>
                                    <input type="texto" name="ProfMae" placeholder="Profissão da Mãe" class="form-control" value="{{$aluno->ProfMae or old('ProfMae')}}">
                                </div>
                            </div>
                            <!--FECHANDO A TERCEIRA LINHA-->
                        </div>
                        <!--QUARTA LINHA REFERENTE AOS CAMPOS ( CPF E RG DO MAE)-->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="CPFMae">CPF da Mãe:</label>
                                    <input type="texto" name="CPFMae" placeholder="CPF da Mãe"  id="CPFMae" class="form-control" value="{{$aluno->CPFMae or old('CPFMae')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="RGMae">RG da Mãe:</label>
                                    <input type="text" name="RGMae"  class="form-control" placeholder="RG da Mãe" value="{{$aluno->RGMae or old ('RGMae')}}">
                                </div>                       
                            </div>
                            <!--FECHANDO A QUARTA LINHA-->
                        </div>                          
                        <!--QUINTA LINHA REFERENTE AOS CAMPOS ( AO RESPONSAVEL )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="Responsavel">Responsável:</label>
                                    <input type="texto" name="Responsavel " placeholder="Nome do Responsável"   class="form-control" value="{{$aluno->Responsavel or old('Responsavel')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="RGResponsavel">RG do Responsável:</label>
                                    <input type="text" name="RGResponsavel"  class="form-control" placeholder="RG do Responsável" value="{{$aluno->RGResponsavel or old ('RGResponsavel')}}">
                                </div>                       
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="CPFResponsavel">CPF do Responsável:</label>
                                    <input type="text" name="CPFResponsavel"  class="form-control" id="CPFResponsavel" placeholder="CPF do Responsável" value="{{$aluno->CPFResponsavel or old ('CPFResponsavel')}}">
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
                                    <input type="texto" name="Rua" placeholder="Rua"  class="form-control" value="{{$aluno->Rua or old('Rua')}}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Numero">Nº:</label>
                                    <input type="text" name="Numero" class="form-control" value="{{$aluno->Numero or old('Numero')}}">
                                </div>                       
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Fone1">Fone Fixo:</label>
                                    <input type="text" name="Fone1" placeholder="(xx) x-xxxx-xxxx" id="tel-fixo" class="form-control" value="{{$aluno->Fone1 or old('Fone1')}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="CEP">CEP:</label>
                                    <input type="texto" name="CEP" placeholder="CEP" class="form-control" id="CEP" value="{{$aluno->CEP or old('CEP')}}">
                                </div>
                            </div>
                            <!--FECHANDO A PRIMEIRA LINHA-->
                        </div>
                        <!--SEGUNDA LINHA REFERENTE AOS CAMPOS ( BAIRRO , REFERENCIA)-->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Bairro">BAIRRO:</label>
                                    <input type="texto" name="Bairro" placeholder="Bairro" class="form-control" value="{{$aluno->Bairro or old('Bairro')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Referencia">REFERÊNCIA:</label>
                                    <input type="text" name="Referencia"  class="form-control" value="{{$aluno->Referencia or old ('Referencia')}}">
                                </div>                       
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="Cidade">CIDADE:</label>
                                    <input type="text" name="Cidade"  class="form-control" value="{{$aluno->Cidade or old ('Cidade')}}">
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
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="ObsAluno" >Obs:</label>
                                    <textarea class="form-control ajuste" rows="8" type="texto" name="ObsAluno"  
                                              maxlength="1000" value="{{$aluno->ObsAluno or old('ObsAluno')}}">
                                    </textarea>
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