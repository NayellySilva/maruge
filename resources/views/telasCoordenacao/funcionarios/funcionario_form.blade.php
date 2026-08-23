@extends('layouts.app')  
@section('content')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{ $titulo ?? 'Novo Funcionário' }}</h1>

</div> 
<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 

    <div class="formularios">    
        @if((isset($errors) ? count($errors) : 0)>0)
        @foreach($errors->all() as $error)
        {{$error}}
        @endforeach
        @endif

        @if(isset($funcionario))
        <form class="form form-search form-Nu formularios" action="/coordenacao/editar_funcionario/{{$funcionario->idFuncionario}}" method="POST">
            @else
            <form class="form form-search form-Nu formularios" action="/coordenacao/cadfuncionario" method="POST" send="/coordenacao/cadfuncionario">
                @endif 
                {!! csrf_field() !!}


                <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (nome funcionário - cpf - rg - função )-->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="NomeFuncionario">Nome do Funcionário:</label>
                            <input type="texto" name="NomeFuncionario" placeholder="Nome do Funcionário"  class="form-control" value="{{ $funcionario->NomeFuncionario ?? old('NomeFuncionario') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="CPFFuncionario">CPF:</label>
                            <input type="texto" name="CPFFuncionario" id="CPFFuncionario" placeholder="CPF do Funcionário" class="form-control" value="{{ $Funcionario->CPFFuncionario ?? old('CPFFuncionario') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="RGFuncionario">RG do Funcionário:</label>
                            <input type="texto" name="RGFuncionario" placeholder="RG Funcionário" class="form-control" value="{{ $Funcionario->RGFuncionario ?? old('RGFuncionario') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Funcao">Função:</label>
                            <div class="relative">
                                <select
                                    name="Funcao"
                                    class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all"
                                >
                                    <option value="{{ $Funcionario->Funcao ?? old('Funcao') }}">{{ $Funcionario->Funcao ?? old('Funcao') }}</option>
                                    <option>ANALISTA DE SISTEMAS</option>
                                    <option>AUX.DOCENTE</option>
                                    <option>COORDENADOR (A)</option>
                                    <option>DIGITADOR (A)</option>
                                    <option>DIRETOR (A)</option>
                                    <option>DOCENTE</option>
                                    <option>MOTORISTA</option>
                                    <option>PEDAGOGO (A)</option>
                                    <option>PORTEIRO (A)</option>
                                    <option>SECRETÁRIO (A)</option>
                                    <option>SEGURANÇA</option>
                                    <option>SERVIÇOS GERAIS</option>
                                    <option>TELEFONISTA</option>
                                    <option>OUTROS</option>
                                </select>
                                <i
                                    data-lucide="chevron-down"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!--SEGUNDA LINHA REFERENTE AOS CAMPOS (RUA - NUMERO - CIDADE - CEP )-->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="Rua">Endereço:</label>
                            <input type="texto" name="Rua" placeholder="Endereço" class="form-control" value="{{ $Funcionario->Rua ?? old('Rua') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Numero">Nº:</label>
                            <input type="texto" name="Numero" placeholder="Número" class="form-control" value="{{ $Funcionario->Numero ?? old('Numero') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Cidade">Cidade:</label>
                            <input type="texto" name="Cidade" placeholder="Cidade" class="form-control" value="{{ $Funcionario->Cidade ?? old('Cidade') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Cep">Cep:</label>
                            <input type="texto" name="CEP" id="CEP" placeholder="CEP" class="form-control" value="{{ $Funcionario->CEP ?? old('CEP') }}">
                        </div>
                    </div>
                </div>


                <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (BAIRRO - FIXO - CELULAR - SALÁRIO -->
                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Bairro">Bairro:</label>
                            <input type="texto" name="Bairro" placeholder="Bairro" class="form-control" value="{{ $Funcionario->Bairro ?? old('Bairro') }}">
                        </div>
                    </div>


                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Fone1">Fixo:</label>
                            <input type="texto" name="Fone1" placeholder="Telefone Fixo" id="Fone1" class="form-control" value="{{ $Funcionario->Fone1 ?? old('Fone1') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Fone2">Celular:</label>
                            <input type="texto" name="Fone2" placeholder="Telefone Celular" id="Fone2" class="form-control" value="{{ $Funcionario->Fone2 ?? old('Fone2') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Salario">Salario:</label>
                            <input type="texto" name="Salario" placeholder="R$ 0,00" id="Salario" class="form-control" value="{{ $Funcionario->CNPJ ?? old('CNPJ') }}">
                        </div>
                    </div>

                </div>


                <!--QUARTA LINHA REFERENTE AOS CAMPOS ( FORMAÇÃO - E-MAIL - SALVA E LIMPA )-->
                <div class="row">


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="Formacao">Formação:</label>
                            <input type="texto" name="Formacao" placeholder="Formação Academica" class="form-control" value="{{ $Funcionario->Formacao ?? old('Formacao') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="EmailFuncionario">E-mail:</label>
                            <input type="texto" name="EmailFuncionario" placeholder="E-mail"  class="form-control" value="{{ $Funcionario->EmailFuncionario ?? old('EmailFuncionario') }}">
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