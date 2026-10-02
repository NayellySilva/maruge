<html>
    <header>   
        <title>{{$titulo}}</title>
    </header>
    <body>
        <x-estilo-impressao />
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
                    <img src="{{ \App\Support\LogoColegio::src() }}" class="logo-colegio"><br>
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
        <div class="mapa-titulo"> Relatório Mensalidades - </div>
        <div class="mapa-titulo-turma"> GERAL   </div>
        <hr class="linha">   
        
        
        
        
       
</table>
</body>
</html>