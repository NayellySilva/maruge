@extends('layouts.app')
@section('content')

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/carne_inf') }}" class="hover:text-[#008a4b] transition-colors">Carnês</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Gerar Carnê</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">{{ $titulo ?? 'Gerar Carnê de Mensalidades' }}</h1>
            <p class="text-sm text-[#5c706b]">Configure os dados e selecione os meses para gerar o carnê</p>
        </div>
    </div>

    <!-- Erros de Validação -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-4 text-sm text-red-700">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário -->
    <form class="flex flex-col gap-6" action="/coordenacao/criarcarne" method="POST">
        @csrf

        <!-- Campos ocultos -->
        <input type="hidden" name="Acordo"     value="N">
        <input type="hidden" name="Carteira"   value="1">
        <input type="hidden" name="idAluno"    value="{{ $aluno->idAluno ?? '' }}">
        <input type="hidden" name="NomeAluno"  value="{{ $aluno->NomeAluno ?? '' }}">
        <input type="hidden" name="NomeTurma"  value="{{ $turma->NomeTurma ?? '' }}">
        <input type="hidden" name="RA"         value="{{ $matricula->RA ?? '' }}">
        <input type="hidden" name="Ano Letivo" value="{{ $turma->AnoLetivo ?? '' }}">
        <input type="hidden" name="idTurma"    value="{{ $turma->idTurmas ?? '' }}">

        <!-- Card: Dados do Aluno -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl shadow-2xs overflow-hidden">
            <div class="px-6 py-4 border-b border-[#e3e8e6] bg-[#f8faf9] flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4 text-[#008a4b]"></i>
                <span class="text-sm font-semibold text-[#0a241e]">Dados do Aluno</span>
            </div>
            <div class="px-6 py-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Nome -->
                <div class="lg:col-span-2 flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Nome do Aluno</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] font-medium">
                        {{ $aluno->NomeAluno ?? '-' }}
                    </div>
                </div>
                <!-- RA -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">RA</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] font-medium">
                        {{ $matricula->RA ?? '-' }}
                    </div>
                </div>
                <!-- Turma -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Turma</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] font-medium">
                        {{ $turma->NomeTurma ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Configuração do Carnê -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl shadow-2xs overflow-hidden">
            <div class="px-6 py-4 border-b border-[#e3e8e6] bg-[#f8faf9] flex items-center gap-2">
                <i data-lucide="credit-card" class="w-4 h-4 text-[#008a4b]"></i>
                <span class="text-sm font-semibold text-[#0a241e]">Configuração do Carnê</span>
            </div>
            <div class="px-6 py-6 grid grid-cols-1 sm:grid-cols-2 gap-5">

                <!-- Melhor Dia de Pagamento -->
                <div class="flex flex-col gap-1.5">
                    <label for="Data_venc" class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Melhor Dia de Pagamento</label>
                    <div class="relative" id="dropdown-container-datavenc-carne">
                        <input type="hidden" id="Data_venc_carne" name="Data_venc" value="{{ old('Data_venc', '10') }}">
                        @php $valVencCarne = old('Data_venc', '10'); @endphp
                        <div onclick="toggleMultiDropdown('dropdown-menu-datavenc-carne', 'chevron-datavenc-carne')"
                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer h-11">
                            <span id="label-datavenc-carne" class="text-sm font-medium truncate {{ $valVencCarne ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                {{ $valVencCarne ? str_pad($valVencCarne, 2, '0', STR_PAD_LEFT) : 'Selecione...' }}
                            </span>
                            <div id="chevron-datavenc-carne" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                        <div id="dropdown-menu-datavenc-carne" class="dropdown-menu-flutuante hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden">
                            <div class="dropdown-lista-opcoes custom-scroll flex flex-col gap-0.5 pr-1">
                                @for($d = 1; $d <= 31; $d++)
                                    @php $dc = str_pad($d, 2, '0', STR_PAD_LEFT); @endphp
                                    <div onclick="selectSingleOption('{{ $dc }}', '{{ $dc }}', 'Data_venc_carne', 'label-datavenc-carne', 'dropdown-menu-datavenc-carne', 'chevron-datavenc-carne', false)"
                                         class="option-datavenc-carne flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                        <span class="option-title font-medium">{{ $dc }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valor da Mensalidade -->
                <div class="flex flex-col gap-1.5">
                    <label for="Mensalidade" class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Valor da Mensalidade</label>
                    <input type="text" id="Mensalidade" name="Mensalidade"
                           placeholder="R$ 0,00"
                           value="{{ old('Mensalidade', $Mensalidade ?? '') }}"
                           class="bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] transition-all h-11">
                </div>
            </div>
        </div>

        <!-- Card: Seleção de Meses -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl shadow-2xs overflow-hidden">
            <div class="px-6 py-4 border-b border-[#e3e8e6] bg-[#f8faf9] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-[#008a4b]"></i>
                    <span class="text-sm font-semibold text-[#0a241e]">Selecionar Meses</span>
                </div>
                <!-- Selecionar Todos -->
                <label class="flex items-center gap-2 cursor-pointer text-sm text-[#5c706b] hover:text-[#008a4b] transition-colors select-none">
                    <input type="checkbox" id="cbgroup1_master" onchange="selecionando(this, 'tudo')"
                           class="w-4 h-4 accent-[#008a4b] rounded cursor-pointer">
                    <span class="font-medium">Selecionar todos</span>
                </label>
            </div>
            <div class="px-6 py-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @php
                    $mesesLista = [
                        'JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL',
                        'MAIO', 'JUNHO', 'JULHO', 'AGOSTO',
                        'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'
                    ];
                @endphp
                @foreach($mesesLista as $idx => $mes)
                    <label class="flex items-center gap-2.5 cursor-pointer p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b]/50 hover:bg-[#ecfdf5]/30 transition-all group select-none">
                        <input type="checkbox" class="tudo w-4 h-4 accent-[#008a4b] cursor-pointer rounded"
                               name="Meses[]"
                               id="checkbox{{ $idx + 1 }}"
                               value="{{ $mes }}">
                        <span class="text-xs font-semibold text-[#0a241e] group-hover:text-[#008a4b] transition-colors">{{ $mes }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Ações -->
        <div class="flex gap-3 justify-end">
            <a href="{{ url('/coordenacao/carne_inf') }}"
               class="px-5 py-2.5 rounded-full border border-[#e3e8e6] text-sm font-medium text-[#5c706b] hover:bg-[#f8faf9] transition-all">
                Cancelar
            </a>
            <button type="submit"
                    class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-2xs text-sm">
                <i data-lucide="printer" class="w-4 h-4"></i> Gerar Carnê
            </button>
        </div>

    </form>
</div>

@endsection