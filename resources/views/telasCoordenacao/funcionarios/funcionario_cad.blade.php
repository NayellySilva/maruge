@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6 w-full">
    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/funcionarios/funcionario_inf') }}" class="hover:text-[#008a4b] transition-colors">Funcionários</a>
        <span class="mx-2">/</span>
        <span class="text-[#0a241e] font-medium">{{ isset($funcionario) ? 'Editar Funcionário' : 'Cadastrar Funcionário' }}</span>
    </div>

    <!-- Card Principal -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs w-full">
        
        <!-- Cabeçalho do Card -->
        <div class="mb-6 border-b border-[#f1f3f2] pb-6">
            <h1 class="text-2xl font-semibold text-[#0a241e]">{{ isset($funcionario) ? 'Editar Funcionário' : 'Cadastrar Novo Funcionário' }}</h1>
            <p class="text-sm text-[#5c706b] mt-1">Preencha as informações necessárias abaixo para cadastrar ou atualizar o funcionário no sistema.</p>
        </div>

        <!-- Alertas e Preloader (Requeridos pelo JS do painel) -->
        <div class="preloader" style="display: none"> Enviando os dados...</div>  
        <div class="alert alert-success msg-exito bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6 text-sm" role="alert" style="display: none"></div>
        <div class="alert alert-warning msg-erro bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-xl mb-6 text-sm" role="alert" style="display: none"></div> 

        <!-- Alert de Erros de Validação -->
        @if((isset($errors) ? count($errors) : 0) > 0)
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm flex gap-3 items-start">
                <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                <div>
                    <strong class="font-semibold block mb-1">Por favor, corrija os erros abaixo:</strong>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Formulário -->
        @if(isset($funcionario))
            <form class="form form-search form-Nu formularios flex flex-col gap-6" action="{{ url('/coordenacao/funcionario_editar/' . ($funcionario->idFuncionarios ?? $funcionario->idFuncionario ?? '')) }}" method="POST" send="{{ url('/coordenacao/funcionario_editar/' . ($funcionario->idFuncionarios ?? $funcionario->idFuncionario ?? '')) }}">
        @else
            <form class="form form-search form-Nu formularios flex flex-col gap-6" action="{{ url('/coordenacao/funcionario_cad') }}" method="POST" send="{{ url('/coordenacao/funcionario_cad') }}">
        @endif
            {!! csrf_field() !!}

            <!-- Primeira Linha: Nome, CPF, RG, Função -->
            <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
                <!-- Nome -->
                <div style="flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="NomeFuncionario" class="text-sm font-medium text-[#0a241e]">Nome do Funcionário:</label>
                    <input type="text" name="NomeFuncionario" placeholder="Nome do Funcionário" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $funcionario->NomeFuncionario ?? old('NomeFuncionario') }}" required>
                </div>
                <!-- CPF -->
                <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="CPFFuncionario" class="text-sm font-medium text-[#0a241e]">CPF:</label>
                    <input type="text" name="CPFFuncionario" id="CPFFuncionario" placeholder="CPF do Funcionário" class="mask-cpf w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $funcionario->CPFFuncionario ?? old('CPFFuncionario') }}">
                </div>
                <!-- RG -->
                <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="RGFuncionario" class="text-sm font-medium text-[#0a241e]">RG do Funcionário:</label>
                    <input type="text" name="RGFuncionario" placeholder="RG" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $funcionario->RGFuncionario ?? old('RGFuncionario') }}">
                </div>
                <!-- Função -->
                <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Funcao" class="text-sm font-medium text-[#0a241e]">Função:</label>
                    <div class="relative" id="dropdown-container-funcao">
                        @php
                            $funcoes = ['ANALISTA DE SISTEMAS', 'AUX.DOCENTE', 'COORDENADOR (A)', 'DIGITADOR (A)', 'DIRETOR (A)', 'DOCENTE', 'MOTORISTA', 'PEDAGOGO (A)', 'PORTEIRO (A)', 'SECRETÁRIO (A)', 'SEGURANÇA', 'SERVIÇOS GERAIS', 'TELEFONISTA', 'OUTROS'];
                            $selFuncao = old('Funcao', $funcionario->Funcao ?? '');
                        @endphp
                        <input type="hidden" id="Funcao" name="Funcao" value="{{ $selFuncao }}" required>

                        <!-- Trigger Box -->
                        <div onclick="toggleMultiDropdown('dropdown-menu-funcao', 'chevron-funcao')" 
                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                            <span id="label-funcao" class="text-sm font-medium truncate {{ $selFuncao ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                {{ $selFuncao ?: 'Selecione' }}
                            </span>
                            <div id="chevron-funcao" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>

                        <!-- Dropdown Flutuante -->
                        <div id="dropdown-menu-funcao" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                            <!-- Campo de Busca -->
                            <div class="relative shrink-0">
                                <input type="text" onkeyup="filterDropdownOptions('search-funcao', 'option-funcao')" id="search-funcao" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                                <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            </div>

                            <!-- Lista de Opções -->
                            <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                <div onclick="selectSingleOption('', 'Selecione', 'Funcao', 'label-funcao', 'dropdown-menu-funcao', 'chevron-funcao', false); checkFuncaoSenhaVisibility('');"
                                     class="option-funcao flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium text-[#95aba5]">Selecione</span>
                                </div>
                                @foreach($funcoes as $f)
                                    <div onclick="selectSingleOption('{{ $f }}', '{{ $f }}', 'Funcao', 'label-funcao', 'dropdown-menu-funcao', 'chevron-funcao', false); checkFuncaoSenhaVisibility('{{ $f }}');"
                                         class="option-funcao flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                        <span class="option-title font-medium">{{ $f }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Senha de Acesso (Exibida dinamicamente APENAS para Docente ou Coordenador) -->
                @php
                    $isDocOuCoord = in_array($selFuncao, ['DOCENTE', 'COORDENADOR (A)', 'COORDENACÃO']);
                @endphp
                <div id="container-senha-acesso" style="flex: 1 1 20%; min-width: 0; display: {{ $isDocOuCoord ? 'flex' : 'none' }}; flex-direction: column; gap: 6px;">
                    <label for="password" class="text-sm font-medium text-[#0a241e]">Senha de Acesso (8 dígitos):</label>
                    <input type="password" name="password" id="password" placeholder="Senha só números" maxlength="8" minlength="8" pattern="\d{8}" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all">
                </div>
            </div>

            <!-- Segunda Linha: CEP, Endereço, Nº, Bairro -->
            <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
                <!-- CEP -->
                <div style="flex: 1 1 18%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="CEP" class="text-sm font-medium text-[#0a241e]">CEP:</label>
                    <input type="text" name="CEP" id="CEP" placeholder="00000-000" class="mask-cep w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->CEP ?? old('CEP') }}">
                </div>
                <!-- Endereço -->
                <div style="flex: 2 1 37%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Rua" class="text-sm font-medium text-[#0a241e]">Endereço:</label>
                    <input type="text" name="Rua" id="Rua" placeholder="Rua / Avenida" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Rua ?? old('Rua') }}">
                </div>
                <!-- Número -->
                <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Numero" class="text-sm font-medium text-[#0a241e]">Nº:</label>
                    <input type="text" name="Numero" id="Numero" placeholder="Número" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Numero ?? old('Numero') }}">
                </div>
                <!-- Bairro -->
                <div style="flex: 1 1 30%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Bairro" class="text-sm font-medium text-[#0a241e]">Bairro:</label>
                    <input type="text" name="Bairro" id="Bairro" placeholder="Bairro" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Bairro ?? old('Bairro') }}">
                </div>
            </div>

            <!-- Terceira Linha: Estado, Cidade, Fixo, Celular, E-mail -->
            <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
                <!-- Estado -->
                <div style="flex: 1 1 18%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Estado" class="text-sm font-medium text-[#0a241e]">Estado:</label>
                    <div class="relative" id="dropdown-container-estado-func">
                        @php
                            $valUF = old('Estado', $endereco->Estado ?? '');
                            $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                        @endphp
                        <input type="hidden" id="Estado" name="Estado" value="{{ $valUF }}">

                        <!-- Trigger Box -->
                        <div onclick="toggleMultiDropdown('dropdown-menu-estado-func', 'chevron-estado-func')" 
                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                            <span id="label-estado-func" class="text-sm font-medium truncate {{ $valUF ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                {{ $valUF ?: 'Estado' }}
                            </span>
                            <div id="chevron-estado-func" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>

                        <!-- Dropdown Flutuante -->
                        <div id="dropdown-menu-estado-func" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                            <div class="relative shrink-0">
                                <input type="text" onkeyup="filterDropdownOptions('search-estado-func', 'option-estado-func')" id="search-estado-func" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                                <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            </div>
                            <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                <div onclick="selectSingleOption('', 'Estado', 'Estado', 'label-estado-func', 'dropdown-menu-estado-func', 'chevron-estado-func', false); window.loadCitiesForEstadoFunc('');"
                                     class="option-estado-func flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium text-[#95aba5]">Estado</span>
                                </div>
                                @foreach($ufs as $ufItem)
                                    <div onclick="selectSingleOption('{{ $ufItem }}', '{{ $ufItem }}', 'Estado', 'label-estado-func', 'dropdown-menu-estado-func', 'chevron-estado-func', false); window.loadCitiesForEstadoFunc('{{ $ufItem }}');"
                                         class="option-estado-func flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                        <span class="option-title font-medium">{{ $ufItem }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cidade -->
                <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Cidade" class="text-sm font-medium text-[#0a241e]">Cidade:</label>
                    <div class="relative" id="dropdown-container-cidade-func">
                        @php
                            $valCidade = old('Cidade', $endereco->Cidade ?? '');
                        @endphp
                        <input type="hidden" id="Cidade" name="Cidade" value="{{ $valCidade }}">

                        <!-- Trigger Box -->
                        <div onclick="toggleMultiDropdown('dropdown-menu-cidade-func', 'chevron-cidade-func')" 
                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                            <span id="label-cidade-func" class="text-sm font-medium truncate {{ $valCidade ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                {{ $valCidade ?: 'Cidade' }}
                            </span>
                            <div id="chevron-cidade-func" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>

                        <!-- Dropdown Flutuante -->
                        <div id="dropdown-menu-cidade-func" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                            <div class="relative shrink-0">
                                <input type="text" onkeyup="filterDropdownOptions('search-cidade-func', 'option-cidade-func')" id="search-cidade-func" placeholder="Pesquisar cidade..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                                <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                            </div>
                            <div id="custom-cidades-list-func" class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                <div class="p-2 text-xs text-[#95aba5]">Selecione um estado primeiro</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fone 1 -->
                <div style="flex: 1 1 18%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Fone1" class="text-sm font-medium text-[#0a241e]">Telefone Fixo:</label>
                    <input type="text" name="Fone1" id="Fone1" placeholder="Fixo" class="mask-phone w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Fone1 ?? old('Fone1') }}">
                </div>
                <!-- Fone 2 -->
                <div style="flex: 1 1 18%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Fone2" class="text-sm font-medium text-[#0a241e]">Celular:</label>
                    <input type="text" name="Fone2" id="Fone2" placeholder="Celular" class="mask-phone w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Fone2 ?? old('Fone2') }}">
                </div>
                <!-- E-mail -->
                <div style="flex: 1 1 21%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="EmailFuncionario" class="text-sm font-medium text-[#0a241e]">E-mail:</label>
                    <input type="email" name="EmailFuncionario" placeholder="exemplo@email.com" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->EmailFuncionario ?? old('EmailFuncionario') }}">
                </div>
            </div>

            <!-- Quarta Linha: Formação, Salário -->
            <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
                <!-- Formação -->
                <div style="flex: 3 1 75%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Formacao" class="text-sm font-medium text-[#0a241e]">Formação:</label>
                    <input type="text" name="Formacao" placeholder="Formação Acadêmica" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $funcionario->Formacao ?? old('Formacao') }}">
                </div>
                <!-- Salário -->
                <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Salario" class="text-sm font-medium text-[#0a241e]">Salário:</label>
                    <input type="text" name="Salario" id="Salario" placeholder="R$ 0,00" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $funcionario->Salario ?? old('Salario') }}">
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex gap-3 mt-4">
                <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full text-sm transition-all shadow-sm cursor-pointer">
                    SALVAR
                </button>
                <button type="reset" class="border border-[#e3e8e6] text-[#5c706b] hover:bg-[#f8faf9] font-medium px-6 py-2.5 rounded-full text-sm transition-all cursor-pointer">
                    LIMPAR
                </button>
            </div>
        </form>
    </div>
</div>

<script>
window.loadCitiesForEstadoFunc = function(uf, selectedCity = '') {
    const listContainer = document.getElementById('custom-cidades-list-func');
    const labelCidade = document.getElementById('label-cidade-func');
    const hiddenCidade = document.getElementById('Cidade');
    if (!listContainer) return;

    if (!uf) {
        listContainer.innerHTML = '<div class="p-2 text-xs text-[#95aba5]">Selecione um estado primeiro</div>';
        if (hiddenCidade) hiddenCidade.value = '';
        if (labelCidade) {
            labelCidade.textContent = 'Cidade';
            labelCidade.classList.remove('text-[#0a241e]');
            labelCidade.classList.add('text-[#95aba5]');
        }
        return;
    }

    listContainer.innerHTML = '<div class="p-2 text-xs text-[#95aba5] animate-pulse">Carregando cidades...</div>';

    fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`)
        .then(res => res.json())
        .then(cities => {
            let html = `<div onclick="selectSingleOption('', 'Cidade', 'Cidade', 'label-cidade-func', 'dropdown-menu-cidade-func', 'chevron-cidade-func', false)" class="option-cidade-func flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]"><span class="option-title font-medium text-[#95aba5]">Cidade</span></div>`;
            
            cities.forEach(city => {
                const name = city.nome.toUpperCase();
                html += `<div onclick="selectSingleOption('${name}', '${name}', 'Cidade', 'label-cidade-func', 'dropdown-menu-cidade-func', 'chevron-cidade-func', false)" class="option-cidade-func flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]"><span class="option-title font-medium">${name}</span></div>`;
            });
            listContainer.innerHTML = html;

            if (selectedCity) {
                if (hiddenCidade) hiddenCidade.value = selectedCity;
                if (labelCidade) {
                    labelCidade.textContent = selectedCity;
                    labelCidade.classList.remove('text-[#95aba5]');
                    labelCidade.classList.add('text-[#0a241e]');
                }
            }
        })
        .catch(() => {
            listContainer.innerHTML = '<div class="p-2 text-xs text-red-500">Erro ao carregar cidades</div>';
        });
};

window.checkFuncaoSenhaVisibility = function(funcao) {
    const containerSenha = document.getElementById('container-senha-acesso');
    const inputPassword = document.getElementById('password');
    if (!containerSenha) return;

    const isDocCoord = (funcao === 'DOCENTE' || funcao === 'COORDENADOR (A)' || funcao === 'COORDENACÃO');
    if (isDocCoord) {
        containerSenha.style.display = 'flex';
    } else {
        containerSenha.style.display = 'none';
        if (inputPassword) {
            inputPassword.value = '';
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const estadoInit = document.getElementById('Estado')?.value;
    const cidadeInit = document.getElementById('Cidade')?.value;
    const funcaoInit = document.getElementById('Funcao')?.value;

    if (funcaoInit) {
        window.checkFuncaoSenhaVisibility(funcaoInit);
    }
    if (estadoInit) {
        window.loadCitiesForEstadoFunc(estadoInit, cidadeInit);
    }
});
</script>
@endsection