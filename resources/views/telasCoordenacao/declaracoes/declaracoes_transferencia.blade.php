<!-- para gerar o pdf a página ão dever ter section -->
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
                    <img src="{{url('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                    @forelse($escolas as $escola)
                    {{$escola->Rua}} , {{$escola->Numero}}<br>
                    {{$escola->Bairro}} - CEP:{{$escola->CEP}}<br>
                    {{$escola->Cidade}} - {{$escola->Estado}}<br>
                    Tel: {{$escola->Fone1}} / {{$escola->Fone2}}<br>
                    E-mail:{{$escola->EmailColegio}}<br>
                    CNPJ: {{$escola->CNPJ}}<br>
                    INEP:{{$escola->NumeroInep}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    Portaria CME Nº 020/2024 // CEE - Resolução nº: 524/2026<br>
                </td>
            </tr>         
        </table>
        <div class="declaracao-titulo"> DECLARAÇÃO </div>
        <div class="declaracao">
            <p>Declaramos  para os devidos fins que , <strong>{{$aluno->NomeAluno}}</strong>, 
                cursou nesse estabelecimento de ensino, sob o número de matrícula, <strong>
                  {{$matricula->RA}},</strong> no período {{$matricula->DataMatricula}} até {{$dia}} na turma do <strong>{{$turma->NomeTurma}}</strong>, estando apto (a) a dar continuidade a série.</p>    
        </div>
        
            <p class="filiacao-titulo">Filiação:</p>
            <p class="filiacao">
                <strong>{{$pais->NomePai}}</strong><br />
                <strong>{{$pais->NomeMae}}</strong></p>
            <p class="declaracao-data">
                {{$escola->Cidade}}, {{$dia}}.</p>
            @empty
            @endforelse
 </div> 
    </body>
</html>
<!-- para gerar o pdf a página ão dever ter section -->
@endsection