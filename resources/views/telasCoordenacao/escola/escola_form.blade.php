@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Nova Escola'}}</h1>

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

        @if(isset($escolas))
        <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/editar_escola/{{$escolas->idEscola}}" method="POST">
            @else
            <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/cadescola" method="POST" send="/maruge/public/coordenacao/cadescola">
                @endif 
                {!! csrf_field() !!}
                <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (NOME DA INSTITUIÇÃO - ENDEREÇO - Nº)-->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="NomeEscola">Nome da Instituição:</label>
                            <input type="texto" name="NomeEscola" placeholder="Nome da Instituição"  class="form-control" value="{{$escolas->NomeEscola or old('NomeEscola')}}">
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="Rua">Endereço:</label>
                            <input type="texto" name="Rua" placeholder="Endereço" class="form-control" value="{{$endereco->Rua or old('Rua')}}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Numero">Nº:</label>
                            <input type="texto" name="Numero" placeholder="Número" class="form-control" value="{{$endereco->Numero or old('Numero')}}">
                        </div>
                    </div>
                </div>
                <!--SEGUNDA LINHA REFERENTE AOS CAMPOS (CIDADE - BAIRRO - CEP - FIXO - CELULAR)-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Cidade">Cidade:</label>
                            <input type="texto" name="Cidade" placeholder="Cidade" class="form-control" value="{{$endereco->Cidade or old('Cidade')}}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Cep">Cep:</label>
                            <input type="texto" name="CEP" id="CEP" placeholder="CEP" class="form-control" value="{{$endereco->CEP or old('CEP')}}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Bairro">Bairro:</label>
                            <input type="texto" name="Bairro" placeholder="Bairro" class="form-control" value="{{$endereco->Bairro or old('Bairro')}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Fone1">Fixo:</label>
                            <input type="texto" name="Fone1" placeholder="Telefone Fixo" id="Fone1" class="form-control" value="{{$endereco->Fone1 or old('Fone1')}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Fone2">Celular:</label>
                            <input type="texto" name="Fone2" placeholder="Telefone Celular" id="Fone2" class="form-control" value="{{$endereco->Fone2 or old('Fone2')}}">
                        </div>
                    </div>
                </div>
                <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (ESTADO - CNPJ - E-MAIL - INEP-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Estado">Estado:</label>
                            <select class="form-control" name="Estado" id="estado"  value="" >
                                <option >{{$endereco->Estado or old('Estado')}}</option>
                                <option> ACRE </option>
                                <option> ALAGOAS</option>
                                <option> AMAPÁ</option>
                                <option> AMAZONAS</option>
                                <option> BAHIA</option>
                                <option> CEARA</option>
                                <option> DISTRITO FEDERAL</option>
                                <option> ESPÍRITO SANTO</option>
                                <option> GOIÁS</option>
                                <option> MARANHÃO</option>
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
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="EmailColegio">E-mail:</label>
                            <input type="texto" name="EmailColegio" placeholder="E-mail"  class="form-control" value="{{$escolas->EmailColegio or old('EmailColegio')}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="CNPJ">CNPJ:</label>
                            <input type="texto" name="CNPJ" placeholder="Número do CNPJ" id="CNPJ" class="form-control" value="{{$escolas->CNPJ or old('CNPJ')}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="NumeroInep">Inep:</label>
                            <input type="texto" name="NumeroInep" placeholder="Número Inep" class="form-control" value="{{$escolas->NumeroInep or old('NumeroInep')}}">
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