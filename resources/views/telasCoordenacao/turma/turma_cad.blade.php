@extends('layouts.app')

@section('content')
@php
    // Garante que a variável esteja definida para evitar erros em PHP 8.x
    $turma = $turma ?? null;
@endphp

<div class="flex flex-col gap-6 w-full">
    <!-- Localização-->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao/turma/turma_inf') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/turma/turma_inf') }}" class="hover:text-[#008a4b] transition-colors">Turmas</a>
        <span class="mx-2">/</span>
        <span class="text-[#0a241e] font-medium">{{ isset($turma) ? 'Editar Turma' : 'Nova Turma' }}</span>
    </div>

    <!-- Card Principal-->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs w-full">
        
        <!-- Cabeçalho do Card -->
        <div class="mb-6 border-b border-[#f1f3f2] pb-6">
            <h1 class="text-2xl font-semibold text-[#0a241e]">{{ isset($turma) ? 'Editar Cadastro da Turma' : 'Cadastrar Nova Turma' }}</h1>
            <p class="text-sm text-[#5c706b] mt-1">Preencha os campos abaixo com as informações básicas da turma.</p>
        </div>

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
        <form method="POST" action="{{ isset($turma) ? url("/coordenacao/editar_turma/{$turma->idTurmas}") : url("/coordenacao/cadturma") }}" class="flex flex-col gap-6">
            {!! csrf_field() !!}

            <!-- Primeira Linha: Campos da Turma  -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                
                <!-- Nome da Turma -->
                <div class="md:col-span-5 flex flex-col gap-1.5">
                    <label for="NomeTurma" class="text-sm font-medium text-[#0a241e]">Nome da Turma:</label>
                    <input type="text" id="NomeTurma" name="NomeTurma" placeholder="Nome da Turma" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] placeholder-[#95aba5] focus:outline-none focus:border-gray-400 transition-all" value="{{ $turma?->NomeTurma ?? old('NomeTurma') }}" required>
                </div>

                <!-- Valor da Mensalidade  -->
                <div class="md:col-span-3 flex flex-col gap-1.5">
                    <label for="Mensalidade" class="text-sm font-medium text-[#0a241e]">Valor da Mensalidade:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 focus-within:border-gray-400 transition-all">
                        <span class="text-sm text-[#5c706b] font-medium mr-1.5 select-none">R$</span>
                        <input type="text" id="Mensalidade" name="Mensalidade" placeholder="0,00" class="w-full bg-transparent text-sm text-[#0a241e] placeholder-[#95aba5] focus:outline-none" value="{{ $turma?->Mensalidade ?? old('Mensalidade') }}" required>
                    </div>
                </div>

                <!-- Situação -->
                <div class="md:col-span-2 flex flex-col gap-1.5">
                    <label for="SituacaoTurma" class="text-sm font-medium text-[#0a241e]">Situação:</label>
                    <div class="relative" id="dropdown-container-situacao-cad">
                        <!-- Input Oculto para envio no formulário -->
                        <input type="hidden" id="SituacaoTurma" name="SituacaoTurma" value="{{ old('SituacaoTurma', $turma->SituacaoTurma ?? '') }}" required>

                        <!-- Trigger Box no MESMO Estilo Visual de turma_inf -->
                        <div onclick="toggleMultiDropdown('dropdown-menu-situacao-cad', 'chevron-situacao-cad')" 
                             class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                            <span id="label-situacao-cad" class="text-sm font-medium truncate {{ old('SituacaoTurma', $turma->SituacaoTurma ?? '') ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                @php
                                    $valSituacao = old('SituacaoTurma', $turma->SituacaoTurma ?? '');
                                @endphp
                                @if($valSituacao == 'ATIVO')
                                    ATIVO
                                @elseif($valSituacao == 'INATIVO')
                                    INATIVO
                                @else
                                    Selecione
                                @endif
                            </span>
                            <div id="chevron-situacao-cad" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>

                        <!-- Dropdown Flutuante no MESMO Estilo Visual de turma_inf -->
                        <div id="dropdown-menu-situacao-cad" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                            <div onclick="selectSingleOption('ATIVO', 'ATIVO', 'SituacaoTurma', 'label-situacao-cad', 'dropdown-menu-situacao-cad', 'chevron-situacao-cad', false)"
                                 class="option-situacao-cad flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">ATIVO</span>
                            </div>
                            <div onclick="selectSingleOption('INATIVO', 'INATIVO', 'SituacaoTurma', 'label-situacao-cad', 'dropdown-menu-situacao-cad', 'chevron-situacao-cad', false)"
                                 class="option-situacao-cad flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">INATIVO</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ano Letivo -->
                <div class="md:col-span-2 flex flex-col gap-1.5">
                    <label for="AnoLetivo" class="text-sm font-medium text-[#0a241e]">Ano Letivo:</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 focus-within:border-gray-400 transition-all">
                        <input type="number" id="AnoLetivo" name="AnoLetivo" value="{{ old('AnoLetivo', $turma->AnoLetivo ?? date('Y')) }}" placeholder="Ex: {{ date('Y') }}" min="2000" max="2100" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" required>
                    </div>
                </div>
            </div>

            <!-- Segunda Linha: Botões de Ação  -->
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