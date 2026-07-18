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
        
        <button type="button"  value="Imprimir" id="imprimir_conteudo"  class="botao btn-imprimir"> Imprimir</button>
        <div class="imprimir_conteudo">
       
            
            
            <table class="timbre">
            <tr>
                <td>
                    <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                    @forelse($escolas as $escola)
                    {{$escola->Rua}} , {{$escola->Numero}}<br>
                    {{$escola->Bairro}} - CEP:{{$escola->CEP}}<br>
                    {{$escola->Cidade}} - {{$escola->Estado}}<br>
                    Tel: {{$escola->Fone1}} / {{$escola->Fone2}}<br>
                    E-mail:{{$escola->EmailColegio}}<br>
                    CNPJ: {{$escola->CNPJ}} - INEP:{{$escola->NumeroInep}}
                    @empty
                    @endforelse
                </td>
            </tr>         
        </table>

        <div class="formularios">    
            {!! csrf_field() !!}

            <div class="relatorios-titulo"> ALUNO(A) - {{$aluno->NomeAluno}} E-mail: {{$matricula->Email}} <br>  Nº Matrícula:{{$matricula->RA}}  </div>

            <table class="table" align="center" cellpadding="7" cellspacing="1">

                <tr>
                    <td height="28" colspan="2"><strong><font size="3">Sobre o Aluno: </font></strong><font size="3"></font></td>
                </tr>

                <tr>
                    <td height="31" colspan="2">
                        <label>Nome do Aluno(a):</label>
                        <input size="50" class="ficha" disabled="disabled" value="{{$aluno->NomeAluno}}"/>
                        Sexo:
                        <input size="1" disabled="disabled" class="ficha" value="{{$aluno->Sexo}}"/>
                        D.Nascimento:
                        <input size="9" disabled="disabled" class="ficha" value="{{$aluno->DataNascimento}}"/>
                        Nº ID:
                        <input size="7" disabled="disabled" class="ficha" value="{{$aluno->NumeroMac}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        Situação:
                        <input size="6" class="ficha" disabled="disabled" value="{{$matricula->SituacaoAluno}}"/>
                        Turma:
                        <input size="32" disabled="disabled" class="ficha" value="{{$turma->NomeTurma}}"/>
                        Aluno:
                        <input size="8" disabled="disabled" class="ficha" value="{{$matricula->AlunoNV}}"/>
                        Registro:
                        <input size="2" disabled="disabled" class="ficha" value="{{$matricula->Registro}}"/>
                        Pasta:
                        <input size="2" disabled="disabled" class="ficha" value="{{$matricula->Pasta}}"/>
                        Foto:
                        <input size="3" disabled="disabled" class="ficha" value="{{$matricula->Foto}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        Nome Cartório:
                        <input size="28" class="ficha" disabled="disabled" value="{{$aluno->NomeCartorio}}"/>
                        <!--
                        Nº Registro:
                        <input size="4" disabled="disabled" class="ficha" value="{{$aluno->NumeroRG }}"/>
                        Nº do Livro:
                        <input size="4" disabled="disabled" class="ficha" value="{{$aluno->NumeroLivro}}"/>
                        Folha:
                        <input size="2" disabled="disabled" class="ficha" value="{{$aluno->NumeroFolha}}"/>
                        !-->
                        
                        CPF Aluno:
                        <input size="12" disabled="disabled" class="ficha" value="{{$aluno->CPFAluno}}"/>
                        Histórico:
                        <input size="3" disabled="disabled" class="ficha" value="{{$matricula->Historico}}"/>
                        Declaração:
                        <input size="3" disabled="disabled" class="ficha" value="{{$matricula->Declaracao}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        Certidão de Nascimento nº:
                        <input size="40" class="ficha" disabled="disabled" value="{{$aluno->NumeroRGNovo}}"/>
                        Estado:
                        <input size="20" disabled="disabled" class="ficha" value="{{$aluno->EstadoCartorio}}"/>
                        Aluno(a) Bônus:
                        <input size="14" disabled="disabled" class="ficha" value="{{$matricula->Bonus}}%"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        Naturalidade:
                        <input size="21" disabled="disabled" class="ficha" value="{{$aluno->CidadeCartorio}}"/>
                        D. de Emissão:
                        <input size="9" disabled="disabled" class="ficha" value="{{$aluno->DataEmissao}}"/>
                        Forma PGTO:
                        <input size="7" disabled="disabled" class="ficha" value="{{$matricula->FormaPGTO}}"/>
                        Valor:
                        <input size="5" disabled="disabled" class="ficha" value="{{$matricula->ValorPGTO}}"/>
                        D. da Matrícula:
                        <input size="9" disabled="disabled" class="ficha" value="{{$matricula->DataMatricula}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                   Acompanhamento:
                        <input size="10" disabled="disabled" class="ficha" value="{{$aluno->Acompanhamento}}"/>
                    </td>
                </tr>

                <tr class="linha">
                    <td></td>
                </tr>
                <tr>
                    <td height="28" colspan="2"><strong><font size="3">Sobre os Pais: </font></strong><font size="3"></font></td>
                </tr>


                <tr>
                    <td height="31" colspan="2">
                        Filiação 1:
                        <input size="62" disabled="disabled" class="ficha" value="{{$pais->NomePai}}"/>
                        WhatsApp:
                        <input size="13" disabled="disabled" class="ficha" value="{{$pais->FonePai1}}"/>
                        Fone 2:
                        <input size="13" disabled="disabled" class="ficha" value="{{$pais->FonePai2}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        Profissão:
                        <input size="29" disabled="disabled" class="ficha" value="{{$pais->ProfPai}}"/>
                        CPF 1:
                        <input size="15" disabled="disabled" class="ficha" value="{{$pais->CPFPai}}"/>
                        RG 1:
                        <input size="15" disabled="disabled" class="ficha" value="{{$pais->RGPai}}"/>
                        Nas. 1:
                        <input size="10" disabled="disabled" class="ficha" value="{{$pais->Nas_Pai}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        Filiação 2:
                        <input size="61" disabled="disabled" class="ficha" value="{{$pais->NomeMae}}"/>
                        WhatsApp:
                        <input size="13" disabled="disabled" class="ficha" value="{{$pais->FoneMae1}}"/>
                        Fone 2:
                        <input size="13" disabled="disabled" class="ficha" value="{{$pais->FoneMae2}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        Profissão:
                        <input size="28" disabled="disabled" class="ficha" value="{{$pais->ProfMae}}"/>
                        CPF 2:
                        <input size="15" disabled="disabled" class="ficha" value="{{$pais->CPFMae}}"/>
                        RG 2:
                        <input size="15" disabled="disabled" class="ficha" value="{{$pais->RGMae}}"/>
                        Nas. 2:
                        <input size="8" disabled="disabled" class="ficha" value="{{$pais->Nas_Mae}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        Responsável:
                        <input size="45" disabled="disabled" class="ficha" value="{{$pais->Responsavel}}"/>
                        RG do Responsável:
                        <input size="15" disabled="disabled" class="ficha" value="{{$pais->RGResponsavel}}"/>
                        CPF do Responsável:
                        <input size="12" disabled="disabled" class="ficha" value="{{$pais->CPFResponsavel}}"/>
                    </td>
                </tr>
                <tr class="linha">
                    <td></td>
                </tr>
                <tr>
                    <td height="28" colspan="2"><strong><font size="3">Sobre o Endereço: </font></strong><font size="3"></font></td>
                </tr>

                <tr>
                    <td height="31" colspan="2">
                        Rua:
                        <input size="60" disabled="disabled" class="ficha" value="{{$endereco->Rua}}"/>
                        Nº:
                        <input size="5" disabled="disabled" class="ficha" value="{{$endereco->Numero}}"/>
                        Fone Fixo:
                        <input size="10" disabled="disabled" class="ficha" value="{{$endereco->Fone1}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        CEP:
                        <input size="5" disabled="disabled" class="ficha" value="{{$endereco->CEP}}"/>
                        BAIRRO:
                        <input size="30" disabled="disabled" class="ficha" value="{{$endereco->Bairro}}"/>
                        REFERÊNCIA:
                        <input size="30" disabled="disabled" class="ficha" value="{{$endereco->Referencia}}"/>
                    </td>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        CIDADE:
                        <input size="20" disabled="disabled" class="ficha" value="{{$endereco->Cidade}}"/>
                </tr>
                <tr>
                    <td height="31" colspan="2">
                        OBS:
                        <textarea  class="form-control ajuste" rows="5" type="texto" name="ObsAluno" disabled="disabled" maxlength="1000">{{$aluno->ObsAluno}}</textarea>
                    </td>
                </tr>

                

                <tr>
                    <td height="31" >________________________________________________  </td>
                    <td height="31">________________________________________________  </td>
               </tr>
                <tr>
                    <td height="31" ><label>Assinatura Pai / Mãe ou Responsável</label></td>
                    <td height="31"><label>Assinatura Funcionário (a)</label></td>
               </tr>

                
                
                
            </table>
        </div>
                    </div>
    </body>
</html>
@endsection