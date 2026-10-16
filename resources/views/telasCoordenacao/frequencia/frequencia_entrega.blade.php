<html>
    <header>   
        <title>{{$titulo}}</title>
    </header>
    <body>
        <style media="print">
            .botao {
                display: none;
            }
        </style>
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">         
        <button type="button"  value="Imprimir" onClick="window.print()" class="botao btn-imprimir"> Imprimir</button>

        <table class="timbre-horizontal">
            <tr>
                <td>
                    <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                </td>
                <td>
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
        </table>
        @empty
        @endforelse
        <div class="frequencia-titulo"> FREQUÊNCIA DE ENTREGA RESULTADOS, MÊS: {{$mes}} / TURMA - {{$turma->NomeTurma}} </div>   

        <hr class="linha">   
        <table class="table table-striped table-bordered fonte" >     
            <thead  >
                <tr>        
                    <th>Nº</th>
                    <th>RA</th>
                    <th>ALUNO</th>
                    <th>1º BIM</th>  
                    <th >2º BIM</th>  
                    <th >3º BIM</th>  
                    <th >4º BIM</th>  
                    <th width="600">ASSINATURA:</th>  

                </tr>
            </thead> 
            @php
            $contando = 0;
            @endphp
            @forelse($Alunos as $Aluno)      
            <tr >

                @if (isset ($Aluno))
                @php
                $contando == ($contando++)
                @endphp
                <td><center>{{$contando }}</center></td>
        <td>{{$Aluno->RA}}</td>
        <td>{{$Aluno->NomeAluno}}</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>

    </tr>
    @endif
    @empty
    @endforelse
</table>
</body>
</html>