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
            </table>
            <div class="relatorios-titulo"> RELATÓRIO DE ENDEREÇO ALUNOS DO   {{$turma->NomeTurma}} 
                <br>
                <p>Total de alunos: <strong>{{$alunos->count()}}</strong>  
            </div>
            <table class="table table-striped fonte">
                <thead>
                    <tr>
                        <th ><center>Nº</center></th>
                        <th><center>RA</center></th>
                <th>NOME ALUNO</th>
                <th>E-mail</th>
                <th><center> Rua  </center></th>
                <th><center>Numero</center></th>
                <th><center> Bairro </center></th>
                <th><center>Referência </center></th>
                <th>Fone</th>
                
                <!--
                Eu desativei essa linha pq não precisamos da data do nascimento do aluno nesse relatorio.
                
                <th><center>NASC.</center></th>
                -->
                </tr>
                </thead>   

                @php
                $contando = 0;
                @endphp



                @forelse($alunos as $aluno)
                <tr>
                     @if (isset ($aluno))
                    @php
                    $contando == ($contando++)
                    @endphp
                    <td><center>{{$contando }}</center></td>
                    
                    <td><center>{{$aluno->RA}}</center></td>
                <td>{{$aluno->NomeAluno}}</td>
                <td><center>{{$aluno->Email}}</center></td>
                <td><center>{{$aluno->Rua}}</center></td>
                <td><center>{{$aluno->Numero}}</center></td>
                <td><center>{{$aluno->Bairro}}</center></td>
                <td><center>{{$aluno->Referencia}}</center></td>
                <td><center>{{$aluno->Fone1}}</center></td>
               

                <!--
                Eu desativei essa linha pq não precisamos da data do nascimento do aluno nesse relatorio.
                <td><center>{{$aluno->DataNascimento}}</center></td>
                -->
                </tr>
                 @endif
                @empty
                @endforelse
            </table>
    </body>
</html>
@endsection