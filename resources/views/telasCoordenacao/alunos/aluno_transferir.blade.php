@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/alunos/aluno_inf') }}" class="hover:text-[#008a4b] transition-colors">Alunos</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Transferir Aluno</span>
    </div>

    <!-- Cabeçalho -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">{{ $titulo ?? 'Transferir Aluno' }}</h1>
            <p class="text-sm text-[#5c706b]">Transfira o aluno para uma nova turma ou altere sua situação de matrícula</p>
        </div>
        <a href="{{ url('/coordenacao/alunos/aluno_inf') }}" class="group border border-[#e3e8e6] bg-white text-[#0a241e] hover:bg-[#008a4b] hover:border-[#008a4b] hover:text-white font-medium px-5 py-2.5 rounded-full text-sm flex items-center gap-2 transition-all duration-200 shadow-2xs hover:shadow-md hover:-translate-y-0.5 w-max cursor-pointer">
            <i data-lucide="arrow-left" class="w-4 h-4 text-[#5c706b] group-hover:text-white group-hover:-translate-x-0.5 transition-all"></i>
            <span>Voltar para Alunos</span>
        </a>
    </div>

    <!-- Preloader e Alertas AJAX / Session -->
    <div class="preloader hidden bg-[#ecfdf5] border border-[#008a4b]/20 text-[#008a4b] p-4 rounded-xl text-sm font-medium">
        Enviando os dados...
    </div>  
    <div class="alert alert-success msg-exito hidden bg-[#ecfdf5] border border-[#008a4b]/20 text-[#008a4b] p-4 rounded-xl text-sm font-medium" role="alert"></div>
    <div class="alert alert-warning msg-erro hidden bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm font-medium" role="alert"></div>

    @if(session('success'))
        <div class="bg-[#ecfdf5] border border-[#008a4b]/20 text-[#008a4b] p-4 rounded-xl text-sm font-medium flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm font-medium flex items-center gap-2">
            <i data-lucide="alert-triangle" class="w-5 h-5 shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if((isset($errors) ? count($errors) : 0) > 0)
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm flex flex-col gap-1">
            @foreach($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Card de Formulário -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs">
        <form class="form form-search form-Nu formularios flex flex-col gap-6" action="{{ url('/coordenacao/aluno_transferir/' . $aluno->idAluno) }}" method="POST" send="{{ url('/coordenacao/aluno_transferir/' . $aluno->idAluno) }}">
            {!! csrf_field() !!}

            <!-- Seção 1: Identificação do Aluno -->
            <div class="flex flex-col gap-4">
                <h2 style="display: flex; align-items: center; gap: 14px; padding-bottom: 20px; margin-bottom: 12px;" class="text-base font-semibold text-[#0a241e] border-b border-[#e3e8e6]">
                    <div style="margin-right: 4px;" class="w-8 h-8 rounded-lg bg-[#ecfdf5] border border-[#008a4b]/20 flex items-center justify-center text-[#008a4b] shrink-0 shadow-2xs">
                        <i data-lucide="user" class="w-4.5 h-4.5"></i>
                    </div>
                    <span style="margin-left: 6px;">Dados Atuais do Aluno</span>
                </h2>

                <div style="display: flex; flex-direction: row; gap: 20px; width: 100%;" class="flex-row-aluno">
                    <!-- Nome do Aluno (50%) -->
                    <div style="flex: 1 1 50%; min-width: 0;" class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-[#0a241e]">Nome do Aluno:</label>
                        <input type="hidden" name="NomeAluno" value="{{ $aluno->NomeAluno }}">
                        <div style="display: flex; align-items: center; gap: 14px;" class="bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 h-12">
                            <i data-lucide="user" style="margin-right: 8px;" class="w-4.5 h-4.5 text-[#008a4b] shrink-0"></i>
                            <input type="text" disabled value="{{ $aluno->NomeAluno }}" class="w-full bg-transparent text-sm text-[#0a241e] font-semibold focus:outline-none truncate">
                        </div>
                    </div>

                    <!-- Turma Atual (50%) -->
                    <div style="flex: 1 1 50%; min-width: 0;" class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-[#0a241e]">Turma Atual:</label>
                        <input type="hidden" name="Ultima_Turma" value="{{ $aluno->NomeTurma ?? old('Ultima_Turma') }}">
                        <div style="display: flex; align-items: center; gap: 14px;" class="bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 h-12">
                            <i data-lucide="book-open" style="margin-right: 8px;" class="w-4.5 h-4.5 text-[#008a4b] shrink-0"></i>
                            <input type="text" disabled value="{{ $aluno->NomeTurma ?? 'Sem Turma Vinculada' }}" class="w-full bg-transparent text-sm text-[#0a241e] font-semibold focus:outline-none truncate">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seção 2: Dados da Transferência -->
            <div class="flex flex-col gap-4">
                <h2 style="display: flex; align-items: center; gap: 14px; padding-bottom: 20px; margin-bottom: 12px;" class="text-base font-semibold text-[#0a241e] border-b border-[#e3e8e6]">
                    <div style="margin-right: 4px;" class="w-8 h-8 rounded-lg bg-[#ecfdf5] border border-[#008a4b]/20 flex items-center justify-center text-[#008a4b] shrink-0 shadow-2xs">
                        <i data-lucide="arrow-right-left" class="w-4.5 h-4.5"></i>
                    </div>
                    <span style="margin-left: 6px;">Informações da Transferência</span>
                </h2>

                <!-- Linha 1: Tipo de Transferência + Transferir para a Turma -->
                <div style="display: flex; flex-direction: row; gap: 20px; width: 100%;" class="flex-row-transf-1">
                    
                    <!-- 1. Tipo de Transferência (Dropdown Customizado) -->
                    <div style="flex: 1 1 50%; min-width: 0;" class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-[#0a241e]">Tipo de Transferência:</label>
                        <div class="relative" id="dropdown-container-tipo-transf">
                            @php
                                $valTipoTransf = old('ObsAluno', 'TRANSFERÊNCIA INTERNA (TROCA DE TURMA)');
                                $tiposTransf = [
                                    'TRANSFERÊNCIA INTERNA (TROCA DE TURMA)',
                                    'TRANSFERÊNCIA EXTERNA (OUTRA ESCOLA)'
                                ];
                            @endphp
                            <input type="hidden" id="ObsAluno" name="ObsAluno" value="{{ $valTipoTransf }}">

                            <!-- Trigger Box -->
                            <div onclick="toggleMultiDropdown('dropdown-menu-tipo-transf', 'chevron-tipo-transf')" 
                                 class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-12 gap-3">
                                <span id="label-tipo-transf" class="text-sm font-medium text-[#0a241e] truncate">
                                    {{ $valTipoTransf }}
                                </span>
                                <div id="chevron-tipo-transf" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>

                            <!-- Dropdown Flutuante -->
                            <div id="dropdown-menu-tipo-transf" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                                <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 200px; overflow-y: auto;">
                                    @foreach($tiposTransf as $tipoOp)
                                        <div onclick="selectTipoTransferencia('{{ $tipoOp }}')"
                                             class="option-tipo-transf flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                            <span class="option-title font-medium">{{ $tipoOp }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Transferir para a Turma (Troca Interna) -->
                    <div style="flex: 1 1 50%; min-width: 0;" class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-[#0a241e]">Transferir para a Turma:</label>
                        <div class="relative" id="dropdown-container-turma-dest">
                            @php
                                $valTurmaDest = old('tb_turmas_idTurmas', '');
                                $turmaDestObj = $valTurmaDest ? $turmas->firstWhere('idTurmas', $valTurmaDest) : null;
                                $turmaDestNome = $turmaDestObj ? $turmaDestObj->NomeTurma : '';
                            @endphp
                            <input type="hidden" id="tb_turmas_idTurmas" name="tb_turmas_idTurmas" value="{{ $valTurmaDest }}">

                            <!-- Trigger Box -->
                            <div onclick="toggleMultiDropdown('dropdown-menu-turma-dest', 'chevron-turma-dest')" 
                                 class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-12 gap-3">
                                <span id="label-turma-dest" class="text-sm truncate {{ $turmaDestNome ? 'text-[#0a241e] font-medium' : 'text-[#95aba5]' }}">
                                    {{ $turmaDestNome ?: 'Selecione a turma de destino...' }}
                                </span>
                                <div id="chevron-turma-dest" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>

                            <!-- Dropdown Flutuante -->
                            <div id="dropdown-menu-turma-dest" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                                <div class="relative shrink-0">
                                    <input type="text" onkeyup="filterDropdownOptions('search-turma-dest', 'option-turma-dest')" id="search-turma-dest" placeholder="Pesquisar turma..." class="w-full pl-3 pr-9 py-2 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                                    <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                </div>
                                <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                    <div onclick="selectSingleOption('', 'Selecione a turma de destino...', 'tb_turmas_idTurmas', 'label-turma-dest', 'dropdown-menu-turma-dest', 'chevron-turma-dest', false)"
                                         class="option-turma-dest flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                        <span class="option-title font-medium text-[#95aba5]">Selecione a turma de destino...</span>
                                    </div>
                                    @foreach($turmas as $tItem)
                                        <div onclick="selectSingleOption('{{ $tItem->idTurmas }}', '{{ $tItem->NomeTurma }}', 'tb_turmas_idTurmas', 'label-turma-dest', 'dropdown-menu-turma-dest', 'chevron-turma-dest', false)"
                                             class="option-turma-dest flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                            <span class="option-title font-medium">{{ $tItem->NomeTurma }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Linha 2: Situação + Data de Saída -->
                <div style="display: flex; flex-direction: row; gap: 20px; width: 100%;" class="flex-row-transf-2">
                    
                    <!-- Situação do Aluno (50%) -->
                    <div style="flex: 1 1 50%; min-width: 0;" class="flex flex-col gap-1.5">
                        <label class="text-xs font-semibold text-[#0a241e]">Situação de Matrícula:</label>
                        <div class="relative" id="dropdown-container-situacao-transf">
                            @php
                                $valSitTransf = old('SituacaoAluno', 'TRANSFERIDO');
                                $situacoesTransf = ['TRANSFERIDO', 'INATIVO', 'ATIVO', 'CANCELADO', 'CONCLUÍDO'];
                            @endphp
                            <input type="hidden" id="SituacaoAluno" name="SituacaoAluno" value="{{ $valSitTransf }}">

                            <!-- Trigger Box -->
                            <div onclick="toggleMultiDropdown('dropdown-menu-situacao-transf', 'chevron-situacao-transf')" 
                                 class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-12 gap-3">
                                <span id="label-situacao-transf" class="text-sm font-medium text-[#0a241e] truncate">
                                    {{ $valSitTransf }}
                                </span>
                                <div id="chevron-situacao-transf" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                </div>
                            </div>

                            <!-- Dropdown Flutuante -->
                            <div id="dropdown-menu-situacao-transf" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                                <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 200px; overflow-y: auto;">
                                    @foreach($situacoesTransf as $sitOp)
                                        <div onclick="selectSingleOption('{{ $sitOp }}', '{{ $sitOp }}', 'SituacaoAluno', 'label-situacao-transf', 'dropdown-menu-situacao-transf', 'chevron-situacao-transf', false)"
                                             class="option-situacao-transf flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                            <span class="option-title font-medium">{{ $sitOp }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data de Saída (50%) -->
                    <div style="flex: 1 1 50%; min-width: 0;" class="flex flex-col gap-1.5">
                        <label for="DataSaida" class="text-xs font-semibold text-[#0a241e]">Data de Saída / Transferência:</label>
                        <div style="display: flex; align-items: center; gap: 14px;" class="bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 h-12 focus-within:border-[#008a4b] focus-within:ring-2 focus-within:ring-[#008a4b]/10 transition-all">
                            <i data-lucide="calendar" style="margin-right: 8px;" class="w-4.5 h-4.5 text-[#008a4b] shrink-0"></i>
                            <input type="text" name="Saida" id="DataSaida" placeholder="DD/MM/AAAA" class="mask-date w-full bg-transparent text-sm text-[#0a241e] focus:outline-none" value="{{ old('Saida') }}">
                        </div>
                    </div>

                </div>
            </div>

            <!-- Botões de Ação Interativos com Hover Avançado -->
            <div class="flex items-center gap-3 mt-4">
                <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-semibold px-7 py-3 rounded-full text-sm flex items-center gap-2.5 transition-all duration-200 shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                    <i data-lucide="check" class="w-4 h-4"></i>
                    <span>SALVAR</span>
                </button>
                <button type="reset" onclick="setTimeout(resetTransferForm, 50);" class="bg-white border border-[#e3e8e6] text-[#5c706b] hover:bg-[#f0f3f1] hover:border-[#cbd5e1] hover:text-[#0a241e] font-semibold px-7 py-3 rounded-full text-sm flex items-center gap-2.5 transition-all duration-200 shadow-2xs hover:shadow-xs hover:-translate-y-0.5 active:translate-y-0 cursor-pointer">
                    <i data-lucide="rotate-ccw" class="w-4 h-4 text-[#95aba5]"></i>
                    <span>LIMPAR</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .flex-row-aluno, .flex-row-transf-1, .flex-row-transf-2 {
        flex-direction: column !important;
    }
    .flex-row-aluno > div, .flex-row-transf-1 > div, .flex-row-transf-2 > div {
        flex: 1 1 100% !important;
        width: 100% !important;
    }
}
</style>

<script>
    function toggleMultiDropdown(menuId, chevronId) {
        const menu = document.getElementById(menuId);
        const chevron = document.getElementById(chevronId);
        const isHidden = menu.classList.contains('hidden');

        document.querySelectorAll('[id^="dropdown-menu-"]').forEach(m => m.classList.add('hidden'));
        document.querySelectorAll('[id^="chevron-"]').forEach(c => c.classList.remove('rotate-180'));

        if (isHidden) {
            menu.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        }
    }

    function filterDropdownOptions(inputId, optionClassName) {
        const query = document.getElementById(inputId).value.toLowerCase().trim();
        const options = document.querySelectorAll('.' + optionClassName);

        options.forEach(opt => {
            const text = opt.querySelector('.option-title').textContent.toLowerCase();
            if (text.includes(query)) {
                opt.style.display = 'flex';
            } else {
                opt.style.display = 'none';
            }
        });
    }

    function selectSingleOption(id, name, hiddenInputId, labelId, menuId, chevronId, isPlaceholder) {
        document.getElementById(hiddenInputId).value = id;
        const labelEl = document.getElementById(labelId);
        labelEl.textContent = name;

        if (id === '' || isPlaceholder) {
            labelEl.classList.add('text-[#95aba5]');
            labelEl.classList.remove('text-[#0a241e]', 'font-medium');
        } else {
            labelEl.classList.remove('text-[#95aba5]');
            labelEl.classList.add('text-[#0a241e]', 'font-medium');
        }

        document.getElementById(menuId).classList.add('hidden');
        document.getElementById(chevronId).classList.remove('rotate-180');
    }

    function selectTipoTransferencia(tipo) {
        selectSingleOption(tipo, tipo, 'ObsAluno', 'label-tipo-transf', 'dropdown-menu-tipo-transf', 'chevron-tipo-transf', false);
        
        if (tipo.includes('INTERNA')) {
            selectSingleOption('ATIVO', 'ATIVO', 'SituacaoAluno', 'label-situacao-transf', 'dropdown-menu-situacao-transf', 'chevron-situacao-transf', false);
        } else {
            selectSingleOption('TRANSFERIDO', 'TRANSFERIDO', 'SituacaoAluno', 'label-situacao-transf', 'dropdown-menu-situacao-transf', 'chevron-situacao-transf', false);
        }
    }

    function resetTransferForm() {
        selectTipoTransferencia('TRANSFERÊNCIA INTERNA (TROCA DE TURMA)');
        selectSingleOption('', 'Selecione a turma de destino...', 'tb_turmas_idTurmas', 'label-turma-dest', 'dropdown-menu-turma-dest', 'chevron-turma-dest', true);
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#dropdown-container-turma-dest') && 
            !e.target.closest('#dropdown-container-situacao-transf') &&
            !e.target.closest('#dropdown-container-tipo-transf')) {
            document.querySelectorAll('[id^="dropdown-menu-"]').forEach(m => m.classList.add('hidden'));
            document.querySelectorAll('[id^="chevron-"]').forEach(c => c.classList.remove('rotate-180'));
        }
    });
</script>
@endsection