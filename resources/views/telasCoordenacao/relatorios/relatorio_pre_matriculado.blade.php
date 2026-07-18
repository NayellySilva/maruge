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
                    CNPJ: {{$escola->CNPJ}}<br>
                    INEP:{{$escola->NumeroInep}}
                    @empty
                    @endforelse
                </td>
            </tr>     

 <div class="caminho-din">
    
    <table class="table table-hover">
        <thead>
            <tr> <h2 class="quant-alunos">Alunos Pré-Matrículados: ({{$Alunos->count()}})</h2></tr>
            <tr>
                <th>NOME DO ALUNO</th>
                <th>RA</th>
                <th><center>TURMA</center></th>
        <th><center>DATA</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel $Alunos e passando para $Aluno-->
        @forelse($Alunos as $Aluno)  
        <center>
            <tr>
                <td>{{$Aluno->NomeAluno}}</td>
                <td>{{$Aluno->RA}}</td>
                <td><center>{{$Aluno->NomeTurma}}</td>
                <td><center>{{$Aluno->data_reserva}}</td>
                        </tr>         
                        @empty
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Desculpe ! </strong> Mas nenhuma aluno foi encontrado.
                        </div>
                        <tr>
                            <td colspan="500"> Nenhum alunos encontrado !</td>
                        </tr>
                        @endforelse
                        </table> 
                        </div>
                        </div> <!--Fim do caminho-din-->
                 
            
            
            
            
            
            
            
</body>
</html>
@endsection