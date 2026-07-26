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
        @if(count($errors) > 0)
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
                    <input type="text" name="CPFFuncionario" id="CPFFuncionario" placeholder="CPF do Funcionário" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $funcionario->CPFFuncionario ?? old('CPFFuncionario') }}">
                </div>
                <!-- RG -->
                <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="RGFuncionario" class="text-sm font-medium text-[#0a241e]">RG do Funcionário:</label>
                    <input type="text" name="RGFuncionario" placeholder="RG" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $funcionario->RGFuncionario ?? old('RGFuncionario') }}">
                </div>
                <!-- Função -->
                <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Funcao" class="text-sm font-medium text-[#0a241e]">Função:</label>
                    <div class="w-full flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 focus-within:border-gray-400 transition-all relative">
                        <select name="Funcao" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6" required>
                            @if(isset($funcionario->Funcao))
                                <option value="{{ $funcionario->Funcao }}" selected>{{ $funcionario->Funcao }}</option>
                            @else
                                <option value="" disabled selected>Selecione</option>
                            @endif
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
                        <div class="absolute right-4 text-[#95aba5] pointer-events-none">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segunda Linha: Endereço, Nº, Cidade, CEP -->
            <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
                <!-- Endereço -->
                <div style="flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Rua" class="text-sm font-medium text-[#0a241e]">Endereço:</label>
                    <input type="text" name="Rua" placeholder="Rua / Avenida" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Rua ?? old('Rua') }}">
                </div>
                <!-- Número -->
                <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Numero" class="text-sm font-medium text-[#0a241e]">Nº:</label>
                    <input type="text" name="Numero" placeholder="Número" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Numero ?? old('Numero') }}">
                </div>
                <!-- Cidade -->
                <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Cidade" class="text-sm font-medium text-[#0a241e]">Cidade:</label>
                    <input type="text" name="Cidade" placeholder="Cidade" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Cidade ?? old('Cidade') }}">
                </div>
                <!-- CEP -->
                <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Cep" class="text-sm font-medium text-[#0a241e]">CEP:</label>
                    <input type="text" name="CEP" id="CEP" placeholder="CEP" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->CEP ?? old('CEP') }}">
                </div>
            </div>

            <!-- Terceira Linha: Bairro, Fone 1 (Fixo), Fone 2 (Celular), E-mail -->
            <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
                <!-- Bairro -->
                <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Bairro" class="text-sm font-medium text-[#0a241e]">Bairro:</label>
                    <input type="text" name="Bairro" placeholder="Bairro" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Bairro ?? old('Bairro') }}">
                </div>
                <!-- Fone 1 -->
                <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Fone1" class="text-sm font-medium text-[#0a241e]">Telefone Fixo:</label>
                    <input type="text" name="Fone1" id="Fone1" placeholder="Telefone Fixo" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Fone1 ?? old('Fone1') }}">
                </div>
                <!-- Fone 2 -->
                <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="Fone2" class="text-sm font-medium text-[#0a241e]">Telefone Celular:</label>
                    <input type="text" name="Fone2" id="Fone2" placeholder="Celular" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Fone2 ?? old('Fone2') }}">
                </div>
                <!-- E-mail -->
                <div style="flex: 2 1 35%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
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
@endsection