@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo}}</h1>
</div> 
<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
 
    <div class="formularios">    
        @if(count($errors)>0)
        @foreach($errors->all()as $error)
        {{$error}}
        @endforeach
        @endif
        
        
              
        @if(isset($boleto_unico))
      

        <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/financeiro_baixar" method="POST" send="/maruge/public/coordenacao/financeiro_baixar">
            @forelse($boleto_unico as $boleto)  

            <div class="relatorios-titulo"> ALUNO(A) - {{$boleto->NomeAluno}} <br> <br> </div>
            {!! csrf_field() !!}
            <input type="hidden" name="NomeAluno"                value="{{$boleto->NomeAluno}} ">
            <input type="hidden" name="NomeTurma"                value="{{$boleto->NomeTurma}} ">
            <input type="hidden" name="Meses"                    value="{{$boleto->Meses}} ">
            <input type="hidden" name="codbarras"                value="{{$boleto->codbarras}} " >
            <input type="hidden" name="parcelas"                 value="{{$boleto->parcelas}} ">
            <input type="hidden" name="Ano_Letivo"               value="{{$boleto->Ano_Letivo}} ">
            <input type="hidden" name="tb_turmas_Mensalidade"          value="{{$boleto->tb_turmas_Mensalidade}} ">
            <input type="hidden" name="Mensalidade"          value="{{$boleto->Mensalidade}} ">
            <input type="hidden" name="ValorPGTO"            value="{{ number_format($boleto->ValorPGTO,2,",",".")}}">
            <input type="hidden" name="porconta"             value="{{ $boleto->ValorPGTO}}">
            <input type="hidden" name="Carteira"             value="{{$boleto->Carteira}} ">
            <input type="hidden" name="Acordo"               value="{{$boleto->Acordo}} ">
            <input type="hidden" name="Data_venc"            value="{{$boleto->Data_venc}} ">
            <input type="hidden" name="data_pagamento"       value="{{$data}} ">
            <input type="hidden" name="idcarne"              value="{{$boleto->idcarne}} ">


            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="Meses">PAGAMENTO MÊS DE: </label> {{$boleto->Meses}} 
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="tb_turmas_Mensalidade">MENSALIDADE: </label>R$: {{$boleto->tb_turmas_Mensalidade}} 
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="Acordo"> ACORDO: </label>{{$boleto->Acordo}}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="Carteira">CARTEIRA: </label>{{$boleto->Carteira}}  
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="NomeTurma">TURMA: </label>  {{$boleto->NomeTurma}}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="parcelas">PARCELA: </label>R$: {{$boleto->parcelas}}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="Ano_Letivo"> ANO: </label>{{$boleto->Ano_Letivo}} 
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="Data_venc"> VENCIMENTO: </label>{{$boleto->Data_venc}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="codbarras">CÓDIGO DE BARRAS: </label>   {{$boleto->codbarras}}    
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="data">DATA: </label>    {{$data}}   
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="ValorPGTO">VALOR JÁ PAGO: </label>{{$boleto->ValorPGTO}}  
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status_pagamento"> STATUS DE PAGAMENTO: </label>{{$boleto->status_pagamento}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="PAGAMENTO">PAGAMENTO:</label>
                        <select class="form-control" name="status_pagamento">
                            <option></option>
                            <option value="PAGO">PAGO</option>
                            <option value="PARCIAL">PARCIAL</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="ValorPGTO"> RECEBIDO: </label>
                        <input type="text" name="ValorPGTO" placeholder="R$ 0,00" id="ValorPGTORecebimento" class="form-control" >
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="message-text" class="col-form-label">OBSERVAÇÕES:</label>
                <textarea class="form-control" rows="8" type="text" name="obs_pagamento" maxlength="2000" id="obs_pagamento"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-success"   >BAIXAR</button>
            </div>
    </div>
</form>
@empty
@endforelse 
@else
@endif 







<!--Fim do formulario-->
</div>
<!--Fim do caminho-din-->
@endsection