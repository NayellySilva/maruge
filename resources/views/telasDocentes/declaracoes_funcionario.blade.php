@extends('telasDocente.painel')  
@section('conteudo')
<html>
    <header>   
        <title>{{$titulo}}</title>
    </header>
    <body>
    <button type="button" class="botao btn-imprimir" data-toggle="modal" data-target="#alerta">Imprimir</button>
   
    
    <!--<button type="button"  value="Imprimir" id="imprimir_conteudo"  class="botao btn-imprimir"> Imprimir</button> -->

    
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
                    INEP:{{$escola->NumeroInep}}
                </td>
            </tr>  
            @empty
            @endforelse       
        </table>
        <div class="declaracao-titulo"> DECLARAÇÃO </div>  
        @foreach($Funcionario as $Funcionario)
        <div class="declaracao">
            <p>Declaramos  para os devidos fins, que, <strong>{{$Funcionario->NomeFuncionario}}</strong> , portador (a) do <strong>CPF:</strong> {{$Funcionario->CPFFuncionario}}, <strong>RG:</strong> {{$Funcionario->RGFuncionario}}, desenvolve atividade de <strong>{{$Funcionario->Funcao}}</strong> junto à esta Instituição de ensino.</p>    
         </div>      
           
        @endforeach
        <p class="declaracao-data">
        {{$escola->Cidade}}, {{$dia}}.</p>
    </body>
                 </div>
<!-- Modal -->
<div class="modal fade" id="alerta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header declaracao-docente-titulo">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Observação</h4>
      </div><div class="modal-body alert-declaracao">
        Após a impressão, procure a coordenação da instituição para validar o documento.
      </div> <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="imprimir_conteudo" data-dismiss="modal">Imprimir</button>
        </html>
@endsection