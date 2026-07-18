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
            <div class="relatorios-titulo"> RELATÓRIO DE ALUNOS MATRICULADOS <br>
                <p>Total de alunos: <strong>{{$alunos->count()}}</strong>  
            </div>
            <table class="table table-striped fonte" >
                <thead>
                    <tr>
                <th><center>Nº</center></th>
                        <th><center>RA</center></th>
                <th>NOME ALUNO</th>
                
                <th><center>NASC.</center></th>
                <th><center>NOME DA MÃE  </center></th>
                <th><center>WHATSAPP - MÃE  </center></th>
                <th><center>NOME DO PAI </center></th>
                <th><center>WHATSAPP - PAI </center></th>
                <th><center>TURMA</center></th>
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
                <td><center>{{$aluno->DataNascimento}}</center></td>
                <td class="danger"><center>{{$aluno->NomeMae}}</center></td>
                <td class="danger"><center>{{$aluno->FoneMae1}}</center></td>
                <td class="info" ><center>{{$aluno->NomePai}}</center></td>
                <td class="info" ><center>{{$aluno->FonePai1}}</center></td>
                <td><center>{{$aluno->NomeTurma}}</center></td>
                </tr>
                @endif
                @empty
                @endforelse
               
              
               
              
            </table>
        </div>
    </body>
</html>
@endsection