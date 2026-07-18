@extends('telasCoordenacao.painel')  
@section('conteudo')
<!--Essa página é apenas pra exibir as informações da escola em questão-->
<div class="titulo-pagina">
</div> 
<div class="caminho-din">
    <div class="formularios">    
                {!! csrf_field() !!} 
        <table width="1000" border="5"  >      
            <tr style="">
                <td>
            <center>
                <img src="{{url('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                {{$endereco->Rua}} , {{$endereco->Numero}}<br>
                {{$endereco->Bairro}} - CEP:{{$endereco->CEP}}<br>
                {{$endereco->Cidade}} - {{$endereco->Estado}}<br>
                Tel: {{$endereco->Fone1}} / {{$endereco->Fone2}}<br>
                {{$escolas->EmailColegio}}<br>
                CNPJ: {{$escolas->CNPJ}}<br>
                INEP:{{$escolas->NumeroInep}}
            </center>
            </td>
            </tr>
            <!--Fim da Tabela-->
        </table>
    </div>
</div> <!--Fim do caminho-din-->
@endsection




