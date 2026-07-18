@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Novo Funcionário'}}</h1>

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

        @if(isset($funcionario))
        <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/editar_funcionario/{{$funcionario->idFuncionario}}" method="POST">
            @else
            <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/cadfuncionario" method="POST" send="/maruge/public/coordenacao/cadfuncionario">
                @endif 
                {!! csrf_field() !!}


                <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (nome funcionário - cpf - rg - função )-->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="NomeFuncionario">Nome do Funcionário:</label>
                            <input type="texto" name="NomeFuncionario" placeholder="Nome do Funcionário"  class="form-control" value="{{$funcionario->NomeFuncionario or old('NomeFuncionario')}}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="CPFFuncionario">CPF:</label>
                            <input type="texto" name="CPFFuncionario" id="CPFFuncionario" placeholder="CPF do Funcionário" class="form-control" value="{{$Funcionario->CPFFuncionario or old('CPFFuncionario')}}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="RGFuncionario">RG do Funcionário:</label>
                            <input type="texto" name="RGFuncionario" placeholder="RG Funcionário" class="form-control" value="{{$Funcionario->RGFuncionario or old('RGFuncionario')}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Funcao">Função:</label>
                            <select class="form-control" name="Funcao"> 
                                <option >{{$Funcionario->Funcao or old('Funcao')}}</option>
                                <option>ANALISTA DE SISTEMAS</option>
                                <option>AUX.DOCENTE</option>
                                <option>COORDENADOR (A)</option>
                                <option>DIGITADOR (A)</option>
                                <option>DIRETOR (A) </option>
                                <option>DOCENTE</option>
                                <option>MOTORISTA </option>
                                <option>PEDAGOGO (A) </option>
                                <option>PORTEIRO (A) </option>
                                <option>SECRETÁRIO (A) </option>
                                <option>SEGURANÇA </option>
                                <option>SERVIÇOS GERAIS </option>
                                <option>TELEFONISTA </option>
                                <option>OUTROS </option>
                            </select>
                        </div>
                    </div>
                </div>
                <!--SEGUNDA LINHA REFERENTE AOS CAMPOS (RUA - NUMERO - CIDADE - CEP )-->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="Rua">Endereço:</label>
                            <input type="texto" name="Rua" placeholder="Endereço" class="form-control" value="{{$Funcionario->Rua or old('Rua')}}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Numero">Nº:</label>
                            <input type="texto" name="Numero" placeholder="Número" class="form-control" value="{{$Funcionario->Numero or old('Numero')}}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Cidade">Cidade:</label>
                            <input type="texto" name="Cidade" placeholder="Cidade" class="form-control" value="{{$Funcionario->Cidade or old('Cidade')}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Cep">Cep:</label>
                            <input type="texto" name="CEP" id="CEP" placeholder="CEP" class="form-control" value="{{$Funcionario->CEP or old('CEP')}}">
                        </div>
                    </div>
                </div>


                <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (BAIRRO - FIXO - CELULAR - SALÁRIO -->
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Bairro">Bairro:</label>
                            <input type="texto" name="Bairro" placeholder="Bairro" class="form-control" value="{{$Funcionario->Bairro or old('Bairro')}}">
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Fone1">Fixo:</label>
                            <input type="texto" name="Fone1" placeholder="Telefone Fixo" id="Fone1" class="form-control" value="{{$Funcionario->Fone1 or old('Fone1')}}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Fone2">Celular:</label>
                            <input type="texto" name="Fone2" placeholder="Telefone Celular" id="Fone2" class="form-control" value="{{$Funcionario->Fone2 or old('Fone2')}}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Salario">Salario:</label>
                            <input type="texto" name="Salario" placeholder="R$ 0,00" id="Salario" class="form-control" value="{{$Funcionario->CNPJ or old('CNPJ')}}">
                        </div>
                    </div>

                </div>


                <!--QUARTA LINHA REFERENTE AOS CAMPOS ( FORMAÇÃO - E-MAIL - SALVA E LIMPA )-->
                <div class="row">


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Formacao">Formação:</label>
                            <input type="texto" name="Formacao" placeholder="Formação Academica" class="form-control" value="{{$Funcionario->Formacao or old('Formacao')}}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="EmailFuncionario">E-mail:</label>
                            <input type="texto" name="EmailFuncionario" placeholder="E-mail"  class="form-control" value="{{$Funcionario->EmailFuncionario or old('EmailFuncionario')}}">
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="cadForm" >
                                <button type="submit" class="btn btn-success">SALVA</button>
                                <button type="reset" class="btn btn-default">LIMPAR</button>
                            </div>

                        </div>   

                    </div>
            </form> <!--Fim do formulario-->
    </div>
</div> <!--Fim do caminho-din-->
@endsection