@extends('layouts.app')  
@section('content')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{ $titulo ?? 'Nova Escola' }}</h1>

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

        @if(isset($escolas))
        <form class="form form-search form-Nu formularios" action="/coordenacao/editar_escola/{{$escolas->idEscola}}" method="POST">
            @else
            <form class="form form-search form-Nu formularios" action="/coordenacao/cadescola" method="POST" send="/coordenacao/cadescola">
                @endif 
                {!! csrf_field() !!}
                <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (NOME DA INSTITUIÇÃO - ENDEREÇO - Nº)-->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="NomeEscola">Nome da Instituição:</label>
                            <input type="texto" name="NomeEscola" placeholder="Nome da Instituição"  class="form-control" value="{{ $escolas->NomeEscola ?? old('NomeEscola') }}">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="Rua">Endereço:</label>
                            <input type="texto" name="Rua" placeholder="Endereço" class="form-control" value="{{ $endereco->Rua ?? old('Rua') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Numero">Nº:</label>
                            <input type="texto" name="Numero" placeholder="Número" class="form-control" value="{{ $endereco->Numero ?? old('Numero') }}">
                        </div>
                    </div>
                </div>
                <!--SEGUNDA LINHA REFERENTE AOS CAMPOS (CIDADE - BAIRRO - CEP - FIXO - CELULAR)-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Cidade">Cidade:</label>
                            <input type="texto" name="Cidade" placeholder="Cidade" class="form-control" value="{{ $endereco->Cidade ?? old('Cidade') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Cep">Cep:</label>
                            <input type="texto" name="CEP" id="CEP" placeholder="CEP" class="form-control" value="{{ $endereco->CEP ?? old('CEP') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Bairro">Bairro:</label>
                            <input type="texto" name="Bairro" placeholder="Bairro" class="form-control" value="{{ $endereco->Bairro ?? old('Bairro') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Fone1">Fixo:</label>
                            <input type="texto" name="Fone1" placeholder="Telefone Fixo" id="Fone1" class="form-control" value="{{ $endereco->Fone1 ?? old('Fone1') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Fone2">Celular:</label>
                            <input type="texto" name="Fone2" placeholder="Telefone Celular" id="Fone2" class="form-control" value="{{ $endereco->Fone2 ?? old('Fone2') }}">
                        </div>
                    </div>
                </div>
                <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (ESTADO - CNPJ - E-MAIL - INEP-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Estado">Estado:</label>
                            <div class="relative">
                                <select name="Estado" id="estado" class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all">
                                    <option value="{{ $endereco->Estado ?? old('Estado') }}">{{ $endereco->Estado ?? old('Estado') }}</option>
                                    <option>ACRE</option>
                                    <option>ALAGOAS</option>
                                    <option>AMAPÁ</option>
                                    <option>AMAZONAS</option>
                                    <option>BAHIA</option>
                                    <option>CEARA</option>
                                    <option>DISTRITO FEDERAL</option>
                                    <option>ESPÍRITO SANTO</option>
                                    <option>GOIÁS</option>
                                    <option>MARANHÃO</option>
                                <option> MATO GROSSO</option>
                                <option> MATO GROSSO DO SUL</option>
                                <option> MINAS GERAIS</option>
                                <option> PARÁ</option>
                                <option> PARAÍBA</option>
                                <option> PARANÁ</option>
                                <option> PERNAMBUCO</option>
                                <option> PIAUÍ</option>
                                <option> RIO DE JANEIRO</option>
                                <option> RIO GRANDE DO NORTE</option>
                                <option> RIO GRANDE DO SUL</option>
                                <option> RONDÔNIA</option>
                                <option> RORAIMA</option>
                                <option> SANTA CATARINA</option>
                                <option> SÃO PAULO</option>
                                <option> SERGIPE</option>
                                <option> TOCANTINS</option>
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"></i>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="EmailColegio">E-mail:</label>
                            <input type="texto" name="EmailColegio" placeholder="E-mail"  class="form-control" value="{{ $escolas->EmailColegio ?? old('EmailColegio') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="CNPJ">CNPJ:</label>
                            <input type="texto" name="CNPJ" placeholder="Número do CNPJ" id="CNPJ" class="form-control" value="{{ $escolas->CNPJ ?? old('CNPJ') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="NumeroInep">Inep:</label>
                            <input type="texto" name="NumeroInep" placeholder="Número Inep" class="form-control" value="{{ $escolas->NumeroInep ?? old('NumeroInep') }}">
                        </div>
                    </div>
                </div>
                <!--TERCEIRA LINHA REFERENTE AOS CAMPOS ( SALVA E LIMPA )-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">SALVA</button>
                            <button type="reset" class="btn btn-default">LIMPAR</button>
                        </div>

                    </div>   

                </div>
            </form> <!--Fim do formulario-->
    </div>
</div> <!--Fim do caminho-din-->
@endsection