<!-- TAB 1: DADOS DO ALUNO -->
<div id="dados_aluno" class="tab-panel flex flex-col gap-6">
    <!-- Linha 1: Nome, Sexo, Data de Nascimento, Nº ID, Situação -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <!-- Nome do Aluno -->
        <div style="flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="NomeAluno" class="text-sm font-medium text-[#0a241e]">Nome do Aluno:</label>
            <input type="text" name="NomeAluno" placeholder="Nome do Aluno" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $aluno->NomeAluno ?? old('NomeAluno') }}" required>
        </div>
        <!-- Sexo -->
        <div style="flex: 1 1 10%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Sexo" class="text-sm font-medium text-[#0a241e]">Sexo:</label>
            <div class="relative" id="dropdown-container-sexo">
                <input type="hidden" id="Sexo" name="Sexo" value="{{ old('Sexo', $aluno->Sexo ?? '') }}">
                @php
                    $valSexo = old('Sexo', $aluno->Sexo ?? '');
                    $textSexo = $valSexo == 'M' ? 'MASCULINO' : ($valSexo == 'F' ? 'FEMININO' : 'Selecione...');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-sexo', 'chevron-sexo')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-sexo" class="text-sm font-medium truncate {{ $valSexo ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $textSexo }}
                    </span>
                    <div id="chevron-sexo" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-sexo" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('F', 'FEMININO', 'Sexo', 'label-sexo', 'dropdown-menu-sexo', 'chevron-sexo', false)"
                         class="option-sexo flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">FEMININO</span>
                    </div>
                    <div onclick="selectSingleOption('M', 'MASCULINO', 'Sexo', 'label-sexo', 'dropdown-menu-sexo', 'chevron-sexo', false)"
                         class="option-sexo flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">MASCULINO</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Data de Nascimento -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="DataNascimento" class="text-sm font-medium text-[#0a241e]">Data de Nascimento:</label>
            <input type="date" name="DataNascimento" id="DataNascimento" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $formatDate($aluno->DataNascimento ?? old('DataNascimento')) }}">
        </div>
        <!-- Nº ID -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="NumeroMac" class="text-sm font-medium text-[#0a241e]">Nº ID:</label>
            <input type="text" name="NumeroMac" placeholder="Número do Mac" id="numeroMac" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $aluno->NumeroMac ?? old('NumeroMac') }}">
        </div>
        <!-- Situação -->
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <input type="hidden" name="Nivel" value="ALUNO">
            <label for="SituacaoAluno" class="text-sm font-medium text-[#0a241e]">Situação:</label>
            <div class="relative" id="dropdown-container-situacao-aluno">
                <input type="hidden" id="SituacaoAluno" name="SituacaoAluno" value="{{ old('SituacaoAluno', $matricula->SituacaoAluno ?? (isset($aluno) ? '' : 'ATIVO')) }}">
                @php
                    $valSit = old('SituacaoAluno', $matricula->SituacaoAluno ?? (isset($aluno) ? '' : 'ATIVO'));
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-situacao-aluno', 'chevron-situacao-aluno')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-situacao-aluno" class="text-sm font-medium truncate {{ $valSit ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valSit ?: 'Selecione...' }}
                    </span>
                    <div id="chevron-situacao-aluno" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-situacao-aluno" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('ATIVO', 'ATIVO', 'SituacaoAluno', 'label-situacao-aluno', 'dropdown-menu-situacao-aluno', 'chevron-situacao-aluno', false)"
                         class="option-situacao-aluno flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">ATIVO</span>
                    </div>
                    <div onclick="selectSingleOption('INATIVO', 'INATIVO', 'SituacaoAluno', 'label-situacao-aluno', 'dropdown-menu-situacao-aluno', 'chevron-situacao-aluno', false)"
                         class="option-situacao-aluno flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">INATIVO</span>
                    </div>
                    <div onclick="selectSingleOption('TRANSFERIDO', 'TRANSFERIDO', 'SituacaoAluno', 'label-situacao-aluno', 'dropdown-menu-situacao-aluno', 'chevron-situacao-aluno', false)"
                         class="option-situacao-aluno flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">TRANSFERIDO</span>
                    </div>
                    <div onclick="selectSingleOption('DESISTENTE', 'DESISTENTE', 'SituacaoAluno', 'label-situacao-aluno', 'dropdown-menu-situacao-aluno', 'chevron-situacao-aluno', false)"
                         class="option-situacao-aluno flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">DESISTENTE</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Linha 2: Turma, Aluno, Registro, Pasta, Foto -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <!-- Turma -->
        <div style="flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="tb_turmas_idTurmas" class="text-sm font-medium text-[#0a241e]">Turma:</label>
            <div class="relative" id="dropdown-container-turma-cad-aluno">
                <input type="hidden" id="tb_turmas_idTurmas" name="tb_turmas_idTurmas" value="{{ old('tb_turmas_idTurmas', $turma->idTurmas ?? '') }}">

                @php
                    $selectedTurmaCad = $turmas->firstWhere('idTurmas', old('tb_turmas_idTurmas', $turma->idTurmas ?? ''));
                @endphp

                <!-- Trigger Box -->
                <div onclick="toggleMultiDropdown('dropdown-menu-turma-cad-aluno', 'chevron-turma-cad-aluno')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-turma-cad-aluno" class="text-sm font-medium truncate {{ $selectedTurmaCad ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $selectedTurmaCad ? $selectedTurmaCad->NomeTurma : 'Selecione a turma...' }}
                    </span>
                    <div id="chevron-turma-cad-aluno" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Dropdown Flutuante -->
                <div id="dropdown-menu-turma-cad-aluno" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                    <!-- Campo de Busca -->
                    <div class="relative shrink-0">
                        <input type="text" onkeyup="filterDropdownOptions('search-turma-cad-aluno', 'option-turma-cad-aluno')" id="search-turma-cad-aluno" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    <!-- Lista de Opções com Rolagem -->
                    <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                        <div onclick="selectSingleOption('', 'Selecione a turma...', 'tb_turmas_idTurmas', 'label-turma-cad-aluno', 'dropdown-menu-turma-cad-aluno', 'chevron-turma-cad-aluno', false)"
                             class="option-turma-cad-aluno flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium text-[#95aba5]">Nenhuma turma</span>
                        </div>
                        @foreach($turmas as $t)
                            <div onclick="selectSingleOption('{{ $t->idTurmas }}', '{{ $t->NomeTurma }}', 'tb_turmas_idTurmas', 'label-turma-cad-aluno', 'dropdown-menu-turma-cad-aluno', 'chevron-turma-cad-aluno', false)"
                                 class="option-turma-cad-aluno flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">{{ $t->NomeTurma }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Aluno (Novato/Veterano) -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="AlunoNV" class="text-sm font-medium text-[#0a241e]">Aluno:</label>
            <div class="relative" id="dropdown-container-alunonv">
                <input type="hidden" id="AlunoNV" name="AlunoNV" value="{{ old('AlunoNV', $matricula->AlunoNV ?? '') }}">
                @php
                    $valNV = old('AlunoNV', $matricula->AlunoNV ?? '');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-alunonv', 'chevron-alunonv')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-alunonv" class="text-sm font-medium truncate {{ $valNV ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valNV ?: 'Selecione...' }}
                    </span>
                    <div id="chevron-alunonv" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-alunonv" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('NOVATO', 'NOVATO', 'AlunoNV', 'label-alunonv', 'dropdown-menu-alunonv', 'chevron-alunonv', false)"
                         class="option-alunonv flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">NOVATO</span>
                    </div>
                    <div onclick="selectSingleOption('VETERANO', 'VETERANO', 'AlunoNV', 'label-alunonv', 'dropdown-menu-alunonv', 'chevron-alunonv', false)"
                         class="option-alunonv flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">VETERANO</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Registro -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Registro" class="text-sm font-medium text-[#0a241e]">Registro:</label>
            <div class="relative" id="dropdown-container-registro">
                <input type="hidden" id="Registro" name="Registro" value="{{ old('Registro', $matricula->Registro ?? '') }}">
                @php
                    $valReg = old('Registro', $matricula->Registro ?? '');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-registro', 'chevron-registro')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-registro" class="text-sm font-medium truncate {{ $valReg ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valReg ?: 'Selecione...' }}
                    </span>
                    <div id="chevron-registro" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-registro" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('SIM', 'SIM', 'Registro', 'label-registro', 'dropdown-menu-registro', 'chevron-registro', false)"
                         class="option-registro flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">SIM</span>
                    </div>
                    <div onclick="selectSingleOption('NÃO', 'NÃO', 'Registro', 'label-registro', 'dropdown-menu-registro', 'chevron-registro', false)"
                         class="option-registro flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">NÃO</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pasta -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Pasta" class="text-sm font-medium text-[#0a241e]">Pasta:</label>
            <div class="relative" id="dropdown-container-pasta">
                <input type="hidden" id="Pasta" name="Pasta" value="{{ old('Pasta', $matricula->Pasta ?? '') }}">
                @php
                    $valPasta = old('Pasta', $matricula->Pasta ?? '');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-pasta', 'chevron-pasta')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-pasta" class="text-sm font-medium truncate {{ $valPasta ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valPasta ?: 'Selecione...' }}
                    </span>
                    <div id="chevron-pasta" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-pasta" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('SIM', 'SIM', 'Pasta', 'label-pasta', 'dropdown-menu-pasta', 'chevron-pasta', false)"
                         class="option-pasta flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">SIM</span>
                    </div>
                    <div onclick="selectSingleOption('NÃO', 'NÃO', 'Pasta', 'label-pasta', 'dropdown-menu-pasta', 'chevron-pasta', false)"
                         class="option-pasta flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">NÃO</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Foto -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Foto" class="text-sm font-medium text-[#0a241e]">Foto:</label>
            <div class="relative" id="dropdown-container-foto">
                <input type="hidden" id="Foto" name="Foto" value="{{ old('Foto', $matricula->Foto ?? '') }}">
                @php
                    $valFoto = old('Foto', $matricula->Foto ?? '');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-foto', 'chevron-foto')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-foto" class="text-sm font-medium truncate {{ $valFoto ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valFoto ?: 'Selecione...' }}
                    </span>
                    <div id="chevron-foto" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-foto" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('SIM', 'SIM', 'Foto', 'label-foto', 'dropdown-menu-foto', 'chevron-foto', false)"
                         class="option-foto flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">SIM</span>
                    </div>
                    <div onclick="selectSingleOption('NÃO', 'NÃO', 'Foto', 'label-foto', 'dropdown-menu-foto', 'chevron-foto', false)"
                         class="option-foto flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">NÃO</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Linha 3: Nome Cartório, Data Emissão, Histórico, Declaração -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <!-- Nome Cartório -->
        <div style="flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="NomeCartorio" class="text-sm font-medium text-[#0a241e]">Nome Cartório:</label>
            <input type="text" name="NomeCartorio" placeholder="Nome do Cartório" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $aluno->NomeCartorio ?? old('NomeCartorio') }}">
        </div>
        <!-- Data de Emissão -->
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="DataEmissao" class="text-sm font-medium text-[#0a241e]">Data de Emissão:</label>
            <input type="date" id="DataEmissao" name="DataEmissao" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $formatDate($aluno->DataEmissao ?? old('DataEmissao')) }}">
        </div>
        <!-- Histórico -->
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Historico" class="text-sm font-medium text-[#0a241e]">Histórico:</label>
            <div class="relative" id="dropdown-container-historico">
                <input type="hidden" id="Historico" name="Historico" value="{{ old('Historico', $matricula->Historico ?? '') }}">
                @php
                    $valHist = old('Historico', $matricula->Historico ?? '');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-historico', 'chevron-historico')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-historico" class="text-sm font-medium truncate {{ $valHist ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valHist ?: 'Selecione...' }}
                    </span>
                    <div id="chevron-historico" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-historico" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('SIM', 'SIM', 'Historico', 'label-historico', 'dropdown-menu-historico', 'chevron-historico', false)"
                         class="option-historico flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">SIM</span>
                    </div>
                    <div onclick="selectSingleOption('NÃO', 'NÃO', 'Historico', 'label-historico', 'dropdown-menu-historico', 'chevron-historico', false)"
                         class="option-historico flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">NÃO</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Declaração -->
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Declaracao" class="text-sm font-medium text-[#0a241e]">Declaração:</label>
            <div class="relative" id="dropdown-container-declaracao">
                <input type="hidden" id="Declaracao" name="Declaracao" value="{{ old('Declaracao', $matricula->Declaracao ?? '') }}">
                @php
                    $valDec = old('Declaracao', $matricula->Declaracao ?? '');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-declaracao', 'chevron-declaracao')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-declaracao" class="text-sm font-medium truncate {{ $valDec ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valDec ?: 'Selecione...' }}
                    </span>
                    <div id="chevron-declaracao" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-declaracao" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('SIM', 'SIM', 'Declaracao', 'label-declaracao', 'dropdown-menu-declaracao', 'chevron-declaracao', false)"
                         class="option-declaracao flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">SIM</span>
                    </div>
                    <div onclick="selectSingleOption('NÃO', 'NÃO', 'Declaracao', 'label-declaracao', 'dropdown-menu-declaracao', 'chevron-declaracao', false)"
                         class="option-declaracao flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">NÃO</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Linha 4: Certidão Nova, Estado Cartório, Cidade Cartório -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <!-- Número da matrícula (Registro Civil) -->
        <div style="flex: 2 1 50%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="NumeroRGNovo" class="text-sm font-medium text-[#0a241e]">Número da matrícula (Registro Civil - Certidão Nova):</label>
            <input type="text" name="NumeroRGNovo" id="NumeroRGNovo" placeholder="Número da matrícula" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $aluno->NumeroRGNovo ?? old('NumeroRGNovo') }}">
        </div>
        <!-- Estado Cartório -->
        <div style="flex:1 1 20%; min-width:140px; display:flex; flex-direction:column; gap:6px;">
            <label for="EstadoCartorio" class="text-sm font-medium text-[#0a241e]">Estado:</label>
            <div class="relative" id="dropdown-container-estadocartorio">
                <input type="hidden" id="EstadoCartorio" name="EstadoCartorio" value="{{ old('EstadoCartorio', $aluno->EstadoCartorio ?? '') }}">
                @php
                    $valEstCart = old('EstadoCartorio', $aluno->EstadoCartorio ?? '');
                    $ufs = [
                        'AC'=>'Acre (AC)','AL'=>'Alagoas (AL)','AP'=>'Amapá (AP)','AM'=>'Amazonas (AM)','BA'=>'Bahia (BA)',
                        'CE'=>'Ceará (CE)','DF'=>'Distrito Federal (DF)','ES'=>'Espírito Santo (ES)','GO'=>'Goiás (GO)',
                        'MA'=>'Maranhão (MA)','MT'=>'Mato Grosso (MT)','MS'=>'Mato Grosso do Sul (MS)','MG'=>'Minas Gerais (MG)',
                        'PA'=>'Pará (PA)','PB'=>'Paraíba (PB)','PR'=>'Paraná (PR)','PE'=>'Pernambuco (PE)','PI'=>'Piauí (PI)',
                        'RJ'=>'Rio de Janeiro (RJ)','RN'=>'Rio Grande do Norte (RN)','RS'=>'Rio Grande do Sul (RS)',
                        'RO'=>'Rondônia (RO)','RR'=>'Roraima (RR)','SC'=>'Santa Catarina (SC)','SP'=>'São Paulo (SP)',
                        'SE'=>'Sergipe (SE)','TO'=>'Tocantins (TO)'
                    ];
                    $labelEstCart = $valEstCart && isset($ufs[$valEstCart]) ? $ufs[$valEstCart] : 'Selecione o estado...';
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-estadocartorio', 'chevron-estadocartorio')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-estadocartorio" class="text-sm font-medium truncate {{ $valEstCart ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $labelEstCart }}
                    </span>
                    <div id="chevron-estadocartorio" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-estadocartorio" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                    <div class="relative shrink-0">
                        <input type="text" onkeyup="filterDropdownOptions('search-estadocartorio', 'option-estadocartorio')" id="search-estadocartorio" placeholder="Pesquisar UF..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                        <div onclick="selectSingleOption('', 'Selecione o estado...', 'EstadoCartorio', 'label-estadocartorio', 'dropdown-menu-estadocartorio', 'chevron-estadocartorio', false); loadCitiesForEstadoCartorio('');"
                             class="option-estadocartorio flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium text-[#95aba5]">Selecione o estado...</span>
                        </div>
                        @foreach($ufs as $ufCode => $ufName)
                            <div onclick="selectSingleOption('{{ $ufCode }}', '{{ $ufName }}', 'EstadoCartorio', 'label-estadocartorio', 'dropdown-menu-estadocartorio', 'chevron-estadocartorio', false); loadCitiesForEstadoCartorio('{{ $ufCode }}');"
                                 class="option-estadocartorio flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">{{ $ufName }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Cidade Cartório -->
        <div style="flex:1 1 30%; min-width:160px; display:flex; flex-direction:column; gap:6px;">
            <label for="CidadeCartorio" class="text-sm font-medium text-[#0a241e]">Cidade do Cartório:</label>
            <div class="relative" id="dropdown-container-cidadecartorio">
                <input type="hidden" id="CidadeCartorio" name="CidadeCartorio" value="{{ old('CidadeCartorio', $aluno->CidadeCartorio ?? '') }}">
                @php
                    $valCidCart = old('CidadeCartorio', $aluno->CidadeCartorio ?? '');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-cidadecartorio', 'chevron-cidadecartorio')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-cidadecartorio" class="text-sm font-medium truncate {{ $valCidCart ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valCidCart ?: 'Selecione a cidade...' }}
                    </span>
                    <div id="chevron-cidadecartorio" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-cidadecartorio" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                    <div class="relative shrink-0">
                        <input type="text" onkeyup="filterDropdownOptions('search-cidadecartorio', 'option-cidadecartorio')" id="search-cidadecartorio" placeholder="Pesquisar cidade..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    <div id="custom-cidadescartorio-list" class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                        <div class="p-2 text-xs text-[#95aba5]">Selecione um estado primeiro</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
window.loadCitiesForEstadoCartorio = function(uf, selectedCity = '') {
    const listContainer = document.getElementById('custom-cidadescartorio-list');
    const labelCidade = document.getElementById('label-cidadecartorio');
    const hiddenCidade = document.getElementById('CidadeCartorio');
    if (!listContainer) return;

    if (!uf) {
        listContainer.innerHTML = '<div class="p-2 text-xs text-[#95aba5]">Selecione um estado primeiro</div>';
        if (hiddenCidade) hiddenCidade.value = '';
        if (labelCidade) {
            labelCidade.textContent = 'Selecione a cidade...';
            labelCidade.classList.remove('text-[#0a241e]');
            labelCidade.classList.add('text-[#95aba5]');
        }
        return;
    }

    listContainer.innerHTML = '<div class="p-2 text-xs text-[#95aba5] animate-pulse">Carregando cidades...</div>';

    fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`)
        .then(res => res.json())
        .then(cities => {
            let html = `<div onclick="selectSingleOption('', 'Selecione a cidade...', 'CidadeCartorio', 'label-cidadecartorio', 'dropdown-menu-cidadecartorio', 'chevron-cidadecartorio', false)" class="option-cidadecartorio flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]"><span class="option-title font-medium text-[#95aba5]">Selecione a cidade...</span></div>`;
            
            cities.forEach(city => {
                const name = city.nome.toUpperCase();
                html += `<div onclick="selectSingleOption('${name}', '${name}', 'CidadeCartorio', 'label-cidadecartorio', 'dropdown-menu-cidadecartorio', 'chevron-cidadecartorio', false)" class="option-cidadecartorio flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]"><span class="option-title font-medium">${name}</span></div>`;
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

document.addEventListener('DOMContentLoaded', function() {
    const estadoVal = document.getElementById('EstadoCartorio')?.value;
    const cidadeVal = document.getElementById('CidadeCartorio')?.value;
    if (estadoVal) {
        window.loadCitiesForEstadoCartorio(estadoVal, cidadeVal);
    }
});
</script>

    <!-- Linha 5: CPF Aluno, Acompanhamento -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <!-- CPF Aluno -->
        <div style="flex: 1 1 50%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="CPFAluno" class="text-sm font-medium text-[#0a241e]">CPF do Aluno:</label>
            <input type="text" name="CPFAluno" placeholder="000.000.000-00" id="CPFAluno" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-cpf" value="{{ $aluno->CPFAluno ?? old('CPFAluno') }}">
        </div>
        <!-- Acompanhamento -->
        <div style="flex: 1 1 50%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Acompanhamento" class="text-sm font-medium text-[#0a241e]">Acompanhamento:</label>
            <div class="relative" id="dropdown-container-acompanhamento">
                <input type="hidden" id="Acompanhamento" name="Acompanhamento" value="{{ old('Acompanhamento', $aluno->Acompanhamento ?? 'Não') }}">
                @php
                    $valAcomp = old('Acompanhamento', $aluno->Acompanhamento ?? 'Não');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-acompanhamento', 'chevron-acompanhamento')" 
                     class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-acompanhamento" class="text-sm font-medium truncate text-[#0a241e]">
                        {{ $valAcomp == 'Escolar' ? 'Escolar - CCDM' : ($valAcomp ?: 'Não') }}
                    </span>
                    <div id="chevron-acompanhamento" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-acompanhamento" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    @foreach(['Não', 'Psicológico', 'Psicopdagógico', 'Neurológico', 'Escolar', 'Outros'] as $ac)
                        <div onclick="selectSingleOption('{{ $ac }}', '{{ $ac == 'Escolar' ? 'Escolar - CCDM' : $ac }}', 'Acompanhamento', 'label-acompanhamento', 'dropdown-menu-acompanhamento', 'chevron-acompanhamento', false)"
                             class="option-acompanhamento flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">{{ $ac == 'Escolar' ? 'Escolar - CCDM' : $ac }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
