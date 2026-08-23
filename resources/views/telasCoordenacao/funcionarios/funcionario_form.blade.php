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
                            <label for="Funcao" class="text-sm font-medium text-[#0a241e]">Função:</label>
                            <div class="relative" id="dropdown-container-funcao-form">
                                @php
                                    $funcoes = ['ANALISTA DE SISTEMAS', 'AUX.DOCENTE', 'COORDENADOR (A)', 'DIGITADOR (A)', 'DIRETOR (A)', 'DOCENTE', 'MOTORISTA', 'PEDAGOGO (A)', 'PORTEIRO (A)', 'SECRETÁRIO (A)', 'SEGURANÇA', 'SERVIÇOS GERAIS', 'TELEFONISTA', 'OUTROS'];
                                    $selFuncaoForm = old('Funcao', $Funcionario->Funcao ?? '');
                                @endphp
                                <input type="hidden" id="Funcao" name="Funcao" value="{{ $selFuncaoForm }}" required>

                                <!-- Trigger Box -->
                                <div onclick="toggleMultiDropdown('dropdown-menu-funcao-form', 'chevron-funcao-form')" 
                                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                                    <span id="label-funcao-form" class="text-sm font-medium truncate {{ $selFuncaoForm ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                        {{ $selFuncaoForm ?: 'Selecione' }}
                                    </span>
                                    <div id="chevron-funcao-form" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                    </div>
                                </div>

                                <!-- Dropdown Flutuante -->
                                <div id="dropdown-menu-funcao-form" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                                    <div class="relative shrink-0">
                                        <input type="text" onkeyup="filterDropdownOptions('search-funcao-form', 'option-funcao-form')" id="search-funcao-form" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                    </div>
                                    <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                        <div onclick="selectSingleOption('', 'Selecione', 'Funcao', 'label-funcao-form', 'dropdown-menu-funcao-form', 'chevron-funcao-form', false); checkFuncaoSenhaVisibilityForm('');"
                                             class="option-funcao-form flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                            <span class="option-title font-medium text-[#95aba5]">Selecione</span>
                                        </div>
                                        @foreach($funcoes as $f)
                                            <div onclick="selectSingleOption('{{ $f }}', '{{ $f }}', 'Funcao', 'label-funcao-form', 'dropdown-menu-funcao-form', 'chevron-funcao-form', false); checkFuncaoSenhaVisibilityForm('{{ $f }}');"
                                                 class="option-funcao-form flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                                <span class="option-title font-medium">{{ $f }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $isDocOuCoordForm = in_array($selFuncaoForm, ['DOCENTE', 'COORDENADOR (A)', 'COORDENACÃO']);
                    @endphp
                    <div class="col-md-2" id="container-senha-acesso-form" style="display: {{ $isDocOuCoordForm ? 'block' : 'none' }};">
                        <div class="form-group">
                            <label for="password">Senha (8 dígitos):</label>
                            <input type="password" name="password" id="password_form" placeholder="Senha só números" maxlength="8" minlength="8" pattern="\d{8}" class="form-control">
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

<script>
window.checkFuncaoSenhaVisibilityForm = function(funcao) {
    const containerSenha = document.getElementById('container-senha-acesso-form');
    const inputPassword = document.getElementById('password_form');
    if (!containerSenha) return;

    const isDocCoord = (funcao === 'DOCENTE' || funcao === 'COORDENADOR (A)' || funcao === 'COORDENACÃO');
    if (isDocCoord) {
        containerSenha.style.display = 'block';
    } else {
        containerSenha.style.display = 'none';
        if (inputPassword) {
            inputPassword.value = '';
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const funcaoInit = document.getElementById('Funcao')?.value;
    if (funcaoInit) {
        window.checkFuncaoSenhaVisibilityForm(funcaoInit);
    }
});
</script>
@endsection