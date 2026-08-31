@extends('layouts.app')

@section('content')
<style>
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scroll::-webkit-scrollbar-track {
        background: #f8faf9;
        border-radius: 8px;
    }
    .custom-scroll::-webkit-scrollbar-thumb {
        background: #008a4b;
        border-radius: 8px;
    }
    .custom-scroll::-webkit-scrollbar-thumb:hover {
        background: #00703c;
    }
</style>
@php
    try {
        $turmas = \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) {
        $turmas = collect();
    }

    try {
        $disciplinas = \DB::table('tb_disciplinas')->orderBy('NomeDisciplina')->get();
    } catch (\Exception $e) {
        $disciplinas = collect();
    }

    try {
        $professores = \DB::table('tb_funcionarios')->orderBy('NomeFuncionario')->get();
    } catch (\Exception $e) {
        $professores = collect();
    }
@endphp

<div class="flex flex-col gap-6 w-full">
    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/turma_disc/turma_disciplina_inf') }}" class="hover:text-[#008a4b] transition-colors">Lotação de Professor</a>
        <span class="mx-2">/</span>
        <span class="text-[#0a241e] font-medium">Cadastrar Lotação</span>
    </div>

    <!-- Card Principal -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs w-full">
        
        <!-- Cabeçalho do Card -->
        <div class="mb-6 border-b border-[#f1f3f2] pb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-[#0a241e]">Cadastrar Nova Lotação</h1>
                <p class="text-sm text-[#5c706b] mt-1">Selecione os campos abaixo para associar disciplinas e professores às turmas correspondentes.</p>
            </div>
            <a href="{{ url('/coordenacao/turma_disc/turma_disciplina_inf') }}" class="border border-[#e3e8e6] text-[#0a241e] hover:bg-[#f8faf9] font-medium px-5 py-2.5 rounded-full text-sm flex items-center gap-2 transition-all shadow-2xs whitespace-nowrap">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Ver Lotações Existentes</span>
            </a>
        </div>

        <!-- Alertas e Preloader (Requeridos pelo JS do painel) -->
        <div class="preloader" style="display: none"> Enviando os dados...</div>  
        <div class="alert alert-success msg-exito bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6 text-sm" role="alert" style="display: none"></div>
        <div class="alert alert-warning msg-erro bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-xl mb-6 text-sm" role="alert" style="display: none"></div> 

        <!-- Alert de Mensagens de Sessão -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl mb-6 text-sm flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl mb-6 text-sm flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-5 h-5 text-red-600 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Formulário -->
        <form class="form form-search form-Nu formularios flex flex-col gap-6" method="POST" action="{{ url('/coordenacao/turma_disciplina_cad') }}" send="{{ url('/coordenacao/turma_disciplina_cad') }}">
            {!! csrf_field() !!}

            <!-- Primeira Linha: Todos os Dropdowns com Estilo Customizado Padronizado -->
            <div style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: flex-start;">
                
                <!-- 1. Nome da Turma (Multi-select Customizado) -->
                @php
                    $selectedTurmas = (array) old('idTurmas', isset($selTurma) && $selTurma ? [$selTurma] : []);
                    $checkedTurmaNames = [];
                    foreach($turmas as $t) {
                        if (in_array($t->idTurmas, $selectedTurmas)) {
                            $checkedTurmaNames[] = $t->NomeTurma;
                        }
                    }
                    if (count($checkedTurmaNames) === 0) {
                        $labelTurmasText = 'Selecione a turma...';
                        $labelTurmasClass = 'text-[#95aba5]';
                    } elseif (count($checkedTurmaNames) === 1) {
                        $labelTurmasText = $checkedTurmaNames[0];
                        $labelTurmasClass = 'text-[#0a241e] font-semibold';
                    } else {
                        $labelTurmasText = count($checkedTurmaNames) . ' selecionada(s)';
                        $labelTurmasClass = 'text-[#0a241e] font-semibold';
                    }
                @endphp
                <div style="flex: 1 1 33%; min-width: 0;" class="relative flex flex-col gap-1.5" id="dropdown-container-turmas">
                    <label class="text-sm font-medium text-[#0a241e]">Nome da Turma:</label>
                    
                    <div onclick="toggleMultiDropdown('dropdown-menu-turmas', 'chevron-turmas')" 
                         class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-2xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs">
                        <span id="label-turmas" class="text-sm {{ $labelTurmasClass }} truncate">{{ $labelTurmasText }}</span>
                        <div id="chevron-turmas" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <div id="dropdown-menu-turmas" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-2xl shadow-xl z-50 p-3 flex flex-col gap-2 max-h-72 overflow-hidden" style="max-height: 280px;">
                        <div class="relative shrink-0">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" onkeyup="filterDropdownOptions('search-turmas', 'option-turma')" id="search-turmas" placeholder="Pesquisar..." class="w-full pl-9 pr-3 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-xl text-xs focus:outline-none focus:border-[#008a4b]">
                        </div>

                        <div class="flex justify-between items-center px-1 text-[11px] text-[#008a4b] font-medium border-b border-[#f1f3f2] pb-1.5 shrink-0">
                            <button type="button" onclick="checkAllInDropdown('checkbox-turma', true, 'label-turmas', 'Selecione a turma...')" class="hover:underline cursor-pointer">Marcar todas</button>
                            <button type="button" onclick="checkAllInDropdown('checkbox-turma', false, 'label-turmas', 'Selecione a turma...')" class="text-[#5c706b] hover:underline cursor-pointer">Limpar</button>
                        </div>

                        <div class="overflow-y-auto custom-scroll flex flex-col gap-1 pr-1 grow min-h-0">
                            @foreach($turmas as $turma)
                                @php
                                    $isTurmaChecked = in_array($turma->idTurmas, $selectedTurmas);
                                @endphp
                                <label class="option-turma flex items-center gap-2.5 p-2 hover:bg-[#ecfdf5] rounded-xl transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <input type="checkbox" name="idTurmas[]" value="{{ $turma->idTurmas }}" data-name="{{ $turma->NomeTurma }}" {{ $isTurmaChecked ? 'checked' : '' }} onchange="updateDropdownLabel('checkbox-turma', 'label-turmas', 'Selecione a turma...')" class="checkbox-turma rounded border-gray-300 text-[#008a4b] focus:ring-[#008a4b] w-4 h-4 shrink-0">
                                    <span class="option-title font-medium">{{ $turma->NomeTurma }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 2. Nome da Disciplina (Multi-select Customizado) -->
                @php
                    $selectedDisciplinas = (array) old('idDisciplinas', isset($selDisciplina) && $selDisciplina ? [$selDisciplina] : []);
                    $checkedDiscNames = [];
                    foreach($disciplinas as $d) {
                        if (in_array($d->idDisciplinas, $selectedDisciplinas)) {
                            $checkedDiscNames[] = $d->NomeDisciplina;
                        }
                    }
                    if (count($checkedDiscNames) === 0) {
                        $labelDiscText = 'Selecione a disciplina...';
                        $labelDiscClass = 'text-[#95aba5]';
                    } elseif (count($checkedDiscNames) === 1) {
                        $labelDiscText = $checkedDiscNames[0];
                        $labelDiscClass = 'text-[#0a241e] font-semibold';
                    } else {
                        $labelDiscText = count($checkedDiscNames) . ' selecionada(s)';
                        $labelDiscClass = 'text-[#0a241e] font-semibold';
                    }
                @endphp
                <div style="flex: 1 1 33%; min-width: 0;" class="relative flex flex-col gap-1.5" id="dropdown-container-disciplinas">
                    <label class="text-sm font-medium text-[#0a241e]">Nome da Disciplina:</label>
                    
                    <div onclick="toggleMultiDropdown('dropdown-menu-disciplinas', 'chevron-disciplinas')" 
                         class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-2xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs">
                        <span id="label-disciplinas" class="text-sm {{ $labelDiscClass }} truncate">{{ $labelDiscText }}</span>
                        <div id="chevron-disciplinas" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <div id="dropdown-menu-disciplinas" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-2xl shadow-xl z-50 p-3 flex flex-col gap-2 max-h-72 overflow-hidden" style="max-height: 280px;">
                        <div class="relative shrink-0">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" onkeyup="filterDropdownOptions('search-disciplinas', 'option-disciplina')" id="search-disciplinas" placeholder="Pesquisar..." class="w-full pl-9 pr-3 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-xl text-xs focus:outline-none focus:border-[#008a4b]">
                        </div>

                        <div class="flex justify-between items-center px-1 text-[11px] text-[#008a4b] font-medium border-b border-[#f1f3f2] pb-1.5 shrink-0">
                            <button type="button" onclick="checkAllInDropdown('checkbox-disciplina', true, 'label-disciplinas', 'Selecione a disciplina...')" class="hover:underline cursor-pointer">Marcar todas</button>
                            <button type="button" onclick="checkAllInDropdown('checkbox-disciplina', false, 'label-disciplinas', 'Selecione a disciplina...')" class="text-[#5c706b] hover:underline cursor-pointer">Limpar</button>
                        </div>

                        <div class="overflow-y-auto custom-scroll flex flex-col gap-1 pr-1 grow min-h-0">
                            @foreach($disciplinas as $disciplina)
                                @php
                                    $isDiscChecked = in_array($disciplina->idDisciplinas, $selectedDisciplinas);
                                @endphp
                                <label class="option-disciplina flex items-center gap-2.5 p-2 hover:bg-[#ecfdf5] rounded-xl transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <input type="checkbox" name="idDisciplinas[]" value="{{ $disciplina->idDisciplinas }}" data-name="{{ $disciplina->NomeDisciplina }}" {{ $isDiscChecked ? 'checked' : '' }} onchange="updateDropdownLabel('checkbox-disciplina', 'label-disciplinas', 'Selecione a disciplina...')" class="checkbox-disciplina rounded border-gray-300 text-[#008a4b] focus:ring-[#008a4b] w-4 h-4 shrink-0">
                                    <span class="option-title font-medium">{{ $disciplina->NomeDisciplina }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- 3. Nome do Professor (Single-select Customizado no MESMO Estilo) -->
                @php
                    $selectedProfId = old('idFuncionarios', $selProfessor ?? '');
                    $selectedProfObj = $selectedProfId ? $professores->firstWhere('idFuncionarios', $selectedProfId) : null;
                    $selectedProfName = $selectedProfObj ? $selectedProfObj->NomeFuncionario : '';
                @endphp
                <div style="flex: 1 1 34%; min-width: 0;" class="relative flex flex-col gap-1.5" id="dropdown-container-professor">
                    <label class="text-sm font-medium text-[#0a241e]">Nome do Professor:</label>
                    
                    <!-- Input Oculto para submissão do formulário -->
                    <input type="hidden" id="idFuncionarios" name="idFuncionarios" value="{{ $selectedProfId }}" required>

                    <!-- Trigger Box no MESMO Estilo Visual -->
                    <div onclick="toggleMultiDropdown('dropdown-menu-professor', 'chevron-professor')" 
                         class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-2xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs">
                        <span id="label-professor" class="text-sm {{ $selectedProfName ? 'text-[#0a241e] font-semibold' : 'text-[#95aba5]' }} truncate">
                            {{ $selectedProfName ?: 'Selecione o professor...' }}
                        </span>
                        <div id="chevron-professor" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>

                    <!-- Dropdown Flutuante no MESMO Estilo Visual -->
                    <div id="dropdown-menu-professor" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-2xl shadow-xl z-50 p-3 flex flex-col gap-2 max-h-72 overflow-hidden" style="max-height: 280px;">
                        <!-- Campo de Busca -->
                        <div class="relative shrink-0">
                            <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="text" onkeyup="filterDropdownOptions('search-professor', 'option-professor')" id="search-professor" placeholder="Pesquisar..." class="w-full pl-9 pr-3 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-xl text-xs focus:outline-none focus:border-[#008a4b]">
                        </div>

                        <!-- Lista de Professores com Rolagem Interna -->
                        <div class="overflow-y-auto custom-scroll flex flex-col gap-1 pr-1 grow min-h-0">
                            @foreach($professores as $professore)
                                <div onclick="selectSingleOption('{{ $professore->idFuncionarios }}', '{{ $professore->NomeFuncionario }}', 'idFuncionarios', 'label-professor', 'dropdown-menu-professor', 'chevron-professor')"
                                     class="option-professor flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-xl transition-colors cursor-pointer text-xs text-[#0a241e]">
                                    <span class="option-title font-medium">{{ $professore->NomeFuncionario }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <!-- Segunda Linha: Botões de Ação -->
            <div class="flex gap-3 mt-4">
                <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full text-sm transition-all shadow-sm cursor-pointer">
                    SALVAR
                </button>
                <button type="reset" onclick="setTimeout(resetAllDropdowns, 50);" class="border border-[#e3e8e6] text-[#5c706b] hover:bg-[#f8faf9] font-medium px-6 py-2.5 rounded-full text-sm transition-all cursor-pointer">
                    LIMPAR
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleMultiDropdown(menuId, chevronId) {
        const menu = document.getElementById(menuId);
        const chevron = document.getElementById(chevronId);
        const isHidden = menu.classList.contains('hidden');

        // Fecha todos os outros dropdowns abertos
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

    function checkAllInDropdown(checkboxClass, state, labelId, defaultText) {
        const checkboxes = document.querySelectorAll('.' + checkboxClass);
        checkboxes.forEach(cb => {
            const parentLabel = cb.closest('label');
            if (parentLabel && parentLabel.style.display !== 'none') {
                cb.checked = state;
            }
        });
        updateDropdownLabel(checkboxClass, labelId, defaultText);
    }

    function updateDropdownLabel(checkboxClass, labelId, defaultText) {
        const checked = Array.from(document.querySelectorAll('.' + checkboxClass + ':checked'));
        const labelEl = document.getElementById(labelId);

        if (checked.length === 0) {
            labelEl.textContent = defaultText;
            labelEl.classList.add('text-[#95aba5]');
            labelEl.classList.remove('text-[#0a241e]', 'font-semibold');
        } else if (checked.length === 1) {
            labelEl.textContent = checked[0].getAttribute('data-name');
            labelEl.classList.remove('text-[#95aba5]');
            labelEl.classList.add('text-[#0a241e]', 'font-semibold');
        } else {
            labelEl.textContent = checked.length + ' selecionada(s)';
            labelEl.classList.remove('text-[#95aba5]');
            labelEl.classList.add('text-[#0a241e]', 'font-semibold');
        }
    }

    function selectSingleOption(id, name, hiddenInputId, labelId, menuId, chevronId) {
        document.getElementById(hiddenInputId).value = id;
        const labelEl = document.getElementById(labelId);
        labelEl.textContent = name;
        labelEl.classList.remove('text-[#95aba5]');
        labelEl.classList.add('text-[#0a241e]', 'font-semibold');

        document.getElementById(menuId).classList.add('hidden');
        document.getElementById(chevronId).classList.remove('rotate-180');
    }

    function resetAllDropdowns() {
        checkAllInDropdown('checkbox-turma', false, 'label-turmas', 'Selecione a turma...');
        checkAllInDropdown('checkbox-disciplina', false, 'label-disciplinas', 'Selecione a disciplina...');
        
        document.getElementById('idFuncionarios').value = '';
        const profLabel = document.getElementById('label-professor');
        profLabel.textContent = 'Selecione o professor...';
        profLabel.classList.add('text-[#95aba5]');
        profLabel.classList.remove('text-[#0a241e]', 'font-semibold');
    }

    // Fecha os dropdowns ao clicar fora do componente
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#dropdown-container-turmas') && 
            !e.target.closest('#dropdown-container-disciplinas') &&
            !e.target.closest('#dropdown-container-professor')) {
            document.querySelectorAll('[id^="dropdown-menu-"]').forEach(m => m.classList.add('hidden'));
            document.querySelectorAll('[id^="chevron-"]').forEach(c => c.classList.remove('rotate-180'));
        }
    });

    function initDropdownLabelsNow() {
        updateDropdownLabel('checkbox-turma', 'label-turmas', 'Selecione a turma...');
        updateDropdownLabel('checkbox-disciplina', 'label-disciplinas', 'Selecione a disciplina...');
    }

    initDropdownLabelsNow();

    document.addEventListener('DOMContentLoaded', initDropdownLabelsNow);
</script>

@endsection