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
        <div class="relatorios-titulo"> RELATÓRIO DE ALUNOS INATIVOS / TRANSFERIDOS <br>
            <p>Total de alunos: <strong>{{$alunos->count()}}</strong>  
        </div>
        <table class="table table-striped fonte" >
            <thead>
                <tr>
                    <th><center>RA</center></th>
        <th>NOME ALUNO</th>

<th><center>SAÍDA.</center></th>
<th><center>FONE MÃE</center></th>
<th><center>FONE PAI</center></th>
<th><center>TURMA</center></th>
<th><center>STATUS</center></th>
</tr>
</thead>            
@forelse($alunos as $aluno)
<tr>
    <td> <center>  {{$aluno->RA}} </center>   </td>
    <td>{{$aluno->NomeAluno}}</td>
    <td> <center>
        @if($aluno->Saida != '')
        {{$aluno->Saida}}
        @else
        {{$aluno->AnoLetivo}}
        @endif   
</center>
   </td>
   <td> <center>  {{$aluno->FoneMae1}} </center>  </td>
        <td><center>{{$aluno->FonePai1}}</center></td>
    <td><center>{{$aluno->NomeTurma}}<center></td>
    <td> <center>
    
    @if($aluno->Ultima_Turma != '')
        TRANSFERIDO
        @else
        EVADIDO
        @endif  
    </center>
    </td>
</tr>
@empty
@endforelse
</table>
        </div>
</body>
</html>
@endsection