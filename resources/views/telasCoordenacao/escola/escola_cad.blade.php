@extends('layouts.app')

@section('content')

@php
    try {
        $escolas = $escolas ?? \DB::table('tb_dados_escola')->first();
        $endereco = $endereco ?? $escolas;
    } catch (\Exception $e) {
        $escolas = null;
        $endereco = null;
    }
@endphp

<!-- Titulo e Endereco da Pagina -->
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/escola/escola_inf') }}" class="hover:text-[#008a4b] transition-colors">Escola</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">{{ $titulo ?? 'Cadastrar / Editar Escola' }}</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">{{ $titulo ?? 'Cadastrar / Editar Escola' }}</h1>
            <p class="text-sm text-[#5c706b]">Preencha os dados institucionais e de endereço da escola</p>
        </div>
    </div>

    <!-- Card de Formulário -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs">

        @if((isset($errors) ? count($errors) : 0) > 0)
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($escolas->idEscola))
            <form class="flex flex-col gap-6" action="{{ url('/coordenacao/escola_editar/' . $escolas->idEscola) }}" method="POST">
        @else
            <form class="flex flex-col gap-6" action="{{ url('/coordenacao/escola_cad') }}" method="POST">
        @endif
            @csrf

            <!-- PRIMEIRA LINHA REFERENTE AOS CAMPOS (NOME DA INSTITUIÇÃO - ENDEREÇO - Nº) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-5 flex flex-col gap-1.5">
                    <label for="NomeEscola" class="text-xs font-semibold text-[#0a241e]">Nome da Instituição:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="NomeEscola" placeholder="Nome da Instituição" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $escolas->NomeEscola ?? old('NomeEscola') }}">
                    </div>
                </div>

                <div class="md:col-span-5 flex flex-col gap-1.5">
                    <label for="Rua" class="text-xs font-semibold text-[#0a241e]">Endereço:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="Rua" id="Rua" placeholder="Endereço" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $endereco->Rua ?? old('Rua') }}">
                    </div>
                </div>

                <div class="md:col-span-2 flex flex-col gap-1.5">
                    <label for="Numero" class="text-xs font-semibold text-[#0a241e]">Nº:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="Numero" id="Numero" placeholder="Número" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $endereco->Numero ?? old('Numero') }}">
                    </div>
                </div>
            </div>

            <!-- SEGUNDA LINHA REFERENTE AOS CAMPOS (CIDADE - BAIRRO - CEP - FIXO - CELULAR) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-3 flex flex-col gap-1.5">
                    <label for="Cidade" class="text-xs font-semibold text-[#0a241e]">Cidade:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="Cidade" id="Cidade" placeholder="Cidade" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $endereco->Cidade ?? old('Cidade') }}">
                    </div>
                </div>

                <div class="md:col-span-2 flex flex-col gap-1.5">
                    <label for="CEP" class="text-xs font-semibold text-[#0a241e]">CEP:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="CEP" id="CEP" placeholder="00000-000" class="mask-cep w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $endereco->CEP ?? old('CEP') }}">
                    </div>
                </div>

                <div class="md:col-span-3 flex flex-col gap-1.5">
                    <label for="Bairro" class="text-xs font-semibold text-[#0a241e]">Bairro:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="Bairro" id="Bairro" placeholder="Bairro" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $endereco->Bairro ?? old('Bairro') }}">
                    </div>
                </div>

                <div class="md:col-span-2 flex flex-col gap-1.5">
                    <label for="Fone1" class="text-xs font-semibold text-[#0a241e]">Fixo:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="Fone1" id="Fone1" placeholder="Telefone Fixo" class="mask-phone w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $endereco->Fone1 ?? old('Fone1') }}">
                    </div>
                </div>

                <div class="md:col-span-2 flex flex-col gap-1.5">
                    <label for="Fone2" class="text-xs font-semibold text-[#0a241e]">Celular:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="Fone2" id="Fone2" placeholder="Telefone Celular" class="mask-phone w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $endereco->Fone2 ?? old('Fone2') }}">
                    </div>
                </div>
            </div>

            <!-- TERCEIRA LINHA REFERENTE AOS CAMPOS (ESTADO - CNPJ - E-MAIL - INEP) -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-3 flex flex-col gap-1.5">
                    <label for="Estado" class="text-xs font-semibold text-[#0a241e]">Estado:</label>
                    <div class="select-wrapper">
    <select name="Estado" id="Estado" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select">
                            <option value="{{ $endereco->Estado ?? old('Estado') }}">{{ $endereco->Estado ?? 'Selecione o Estado' }}</option>
                            <option value="AC">ACRE</option>
                            <option value="AL">ALAGOAS</option>
                            <option value="AP">AMAPÁ</option>
                            <option value="AM">AMAZONAS</option>
                            <option value="BA">BAHIA</option>
                            <option value="CE">CEARÁ</option>
                            <option value="DF">DISTRITO FEDERAL</option>
                            <option value="ES">ESPÍRITO SANTO</option>
                            <option value="GO">GOIÁS</option>
                            <option value="MA">MARANHÃO</option>
                            <option value="MT">MATO GROSSO</option>
                            <option value="MS">MATO GROSSO DO SUL</option>
                            <option value="MG">MINAS GERAIS</option>
                            <option value="PA">PARÁ</option>
                            <option value="PB">PARAÍBA</option>
                            <option value="PR">PARANÁ</option>
                            <option value="PE">PERNAMBUCO</option>
                            <option value="PI">PIAUÍ</option>
                            <option value="RJ">RIO DE JANEIRO</option>
                            <option value="RN">RIO GRANDE DO NORTE</option>
                            <option value="RS">RIO GRANDE DO SUL</option>
                            <option value="RO">RONDÔNIA</option>
                            <option value="RR">RORAIMA</option>
                            <option value="SC">SANTA CATARINA</option>
                            <option value="SP">SÃO PAULO</option>
                            <option value="SE">SERGIPE</option>
                            <option value="TO">TOCANTINS</option>
                        </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
                </div>

                <div class="md:col-span-3 flex flex-col gap-1.5">
                    <label for="CNPJ" class="text-xs font-semibold text-[#0a241e]">CNPJ:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="CNPJ" id="CNPJ" placeholder="00.000.000/0000-00" class="mask-cnpj w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $escolas->CNPJ ?? old('CNPJ') }}">
                    </div>
                </div>

                <div class="md:col-span-4 flex flex-col gap-1.5">
                    <label for="EmailColegio" class="text-xs font-semibold text-[#0a241e]">E-mail Colegial:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="email" name="EmailColegio" placeholder="E-mail da Instituição" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $escolas->EmailColegio ?? old('EmailColegio') }}">
                    </div>
                </div>

                <div class="md:col-span-2 flex flex-col gap-1.5">
                    <label for="NumeroInep" class="text-xs font-semibold text-[#0a241e]">Nº INEP:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-3.5 py-2.5">
                        <input type="text" name="NumeroInep" placeholder="Código INEP" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ $escolas->NumeroInep ?? old('NumeroInep') }}">
                    </div>
                </div>
            </div>

            <!-- SEGUNDA LINHA REFERENTE AOS CAMPOS ( SALVA E LIMPA ) -->
            <div class="flex items-center gap-3 pt-4 border-t border-[#e3e8e6]">
                <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm text-sm">
                    <i data-lucide="save" class="w-4 h-4"></i> SALVAR
                </button>
                <button type="reset" class="bg-white hover:bg-[#f8faf9] text-[#5c706b] border border-[#e3e8e6] font-medium px-5 py-2.5 rounded-full transition-all text-sm">
                    LIMPAR
                </button>
                <a href="{{ url('/coordenacao/escola/escola_inf') }}" class="bg-white hover:bg-[#f8faf9] text-[#5c706b] border border-[#e3e8e6] font-medium px-5 py-2.5 rounded-full flex items-center gap-2 transition-all text-sm ml-auto">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> VOLTAR
                </a>
            </div>

        </form> <!--Fim do formulario-->
    </div>

</div> <!--Fim do caminho-din-->

@endsection