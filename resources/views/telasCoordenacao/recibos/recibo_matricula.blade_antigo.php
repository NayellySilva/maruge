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
                            <strong> RECIBO DE MATRICULCA</strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive tabela-recibo">
                                <table  width="975" class="tabela-recibo" aling="center">
                                    <tr>
                                        <th width="259" colspan="3" align="left" scope="row"> 
                                            Aluno: {{$aluno->NomeAluno}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Valor R$:{{$matricula->ValorPGTO}}&nbsp;&nbsp;&nbsp;&nbsp; Matrícula para o : {{$turma->NomeTurma}}.
                                            <br>
                                            Data: {{$matricula->DataMatricula}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forma de Pagamento: {{$matricula->DataMatricula}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                                            <br />  

                                            <div class=" table-responsive table-bordered">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            OBS: {{$aluno->ObsAluno}}    
                                                        </td>
                                                    </tr> 
                                                </table>  
                                            </div>

                                            <br><br><br><br><br>
                                            Importante - Termo de compromisso<br>
                                            Qualquer situa&ccedil;&atilde;o de inadimpl&ecirc;ncia
                                            a escola est&aacute;            autorizada a fazer cobran&ccedil;a de juros e cobran&ccedil;a
                                            judicial.<br><br><br><br>
                                            <p align="center">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;____________________________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  _____________________________________<br>
                                                Assinatura
                                                Pai / M&atilde;e ou Respons&aacute;vel &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura
                                                Funcion&aacute;rio (a)</p>
                                            <br><br>{{$pais->Responsavel}}&nbsp; &nbsp; &nbsp;CPF: {{$pais->CPFResponsavel}} &nbsp; &nbsp; &nbsp;RG:{{$pais->RGResponsavel}} </th>
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
            <div class="linha"></div>
            <br>




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
                            <strong> RECIBO DE MATRICULCA</strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive tabela-recibo">
                                <table  width="975" class="tabela-recibo" aling="center">
                                    <tr>
                                        <th width="259" colspan="3" align="left" scope="row"> 
                                            Aluno: {{$aluno->NomeAluno}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Valor R$:{{$matricula->ValorPGTO}}&nbsp;&nbsp;&nbsp;&nbsp; Matrícula para o : {{$turma->NomeTurma}}.
                                            <br>
                                            Data: {{$matricula->DataMatricula}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Forma de Pagamento: {{$matricula->DataMatricula}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                                            <br />  

                                            <div class=" table-responsive table-bordered">
                                                <table>
                                                    <tr>
                                                        <td>
                                                            OBS: {{$aluno->ObsAluno}}    
                                                        </td>
                                                    </tr> 
                                                </table>  
                                            </div>

                                            <br><br><br><br><br>
                                            Importante - Termo de compromisso<br>
                                            Qualquer situa&ccedil;&atilde;o de inadimpl&ecirc;ncia
                                            a escola est&aacute;            autorizada a fazer cobran&ccedil;a de juros e cobran&ccedil;a
                                            judicial.<br><br><br><br>
                                            <p align="center">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;____________________________________ &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;  _____________________________________<br>
                                                Assinatura
                                                Pai / M&atilde;e ou Respons&aacute;vel &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Assinatura
                                                Funcion&aacute;rio (a)</p>
                                            <br><br>{{$pais->Responsavel}}&nbsp; &nbsp; &nbsp;CPF: {{$pais->CPFResponsavel}} &nbsp; &nbsp; &nbsp;RG:{{$pais->RGResponsavel}} </th>
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
        </div>
    </body>
</html>
@endsection