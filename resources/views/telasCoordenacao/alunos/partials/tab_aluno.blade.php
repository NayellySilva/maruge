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
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="Sexo" id="Sexo">
                    <option value="{{ $aluno->Sexo ?? old('Sexo') }}">{{ $aluno->Sexo ?? old('Sexo') }}</option>
                    <option value="F">FEMININO</option>
                    <option value="M">MASCULINO</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
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
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="SituacaoAluno">
                    @if(isset($matricula->SituacaoAluno))
                        <option value="{{ $matricula->SituacaoAluno }}">{{ $matricula->SituacaoAluno }}</option>
                        <option value=""></option>
                    @endif
                    <option value="ATIVO">ATIVO</option>
                    <option value="INATIVO">INATIVO</option>
                    <option value="TRANSFERIDO">TRANSFERIDO</option>
                    <option value="DESISTENTE">DESISTENTE</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
    </div>

    <!-- Linha 2: Turma, Aluno, Registro, Pasta, Foto -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <!-- Turma -->
        <div style="flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="tb_turmas_idTurmas" class="text-sm font-medium text-[#0a241e]">Turma:</label>
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="tb_turmas_idTurmas">
                    <option value=""></option>
                    @foreach($turmas as $t) 
                        <option value="{{ $t->idTurmas }}" {{ (($turma->idTurmas ?? null) == $t->idTurmas) ? 'selected' : '' }}>
                            {{ $t->NomeTurma }}
                        </option>
                    @endforeach
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
        <!-- Aluno (Novato/Veterano) -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="AlunoNV" class="text-sm font-medium text-[#0a241e]">Aluno:</label>
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="AlunoNV">
                    <option value="{{ $matricula->AlunoNV ?? old('AlunoNV') }}">{{ $matricula->AlunoNV ?? old('AlunoNV') }}</option>
                    <option value="NOVATO">NOVATO</option>
                    <option value="VETERANO">VETERANO</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
        <!-- Registro -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Registro" class="text-sm font-medium text-[#0a241e]">Registro:</label>
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="Registro">
                    <option value="SIM" {{ (old('Registro', $matricula->Registro ?? 'NÃO') == 'SIM') ? 'selected' : '' }}>SIM</option>
                    <option value="NÃO" {{ (old('Registro', $matricula->Registro ?? 'NÃO') == 'NÃO') ? 'selected' : '' }}>NÃO</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
        <!-- Pasta -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Pasta" class="text-sm font-medium text-[#0a241e]">Pasta:</label>
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="Pasta">
                    <option value="SIM" {{ (old('Pasta', $matricula->Pasta ?? 'NÃO') == 'SIM') ? 'selected' : '' }}>SIM</option>
                    <option value="NÃO" {{ (old('Pasta', $matricula->Pasta ?? 'NÃO') == 'NÃO') ? 'selected' : '' }}>NÃO</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
        <!-- Foto -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Foto" class="text-sm font-medium text-[#0a241e]">Foto:</label>
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="Foto">
                    <option value="SIM" {{ (old('Foto', $matricula->Foto ?? 'NÃO') == 'SIM') ? 'selected' : '' }}>SIM</option>
                    <option value="NÃO" {{ (old('Foto', $matricula->Foto ?? 'NÃO') == 'NÃO') ? 'selected' : '' }}>NÃO</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
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
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="Historico">
                    <option value="{{ $matricula->Historico ?? old('Historico') }}">{{ $matricula->Historico ?? old('Historico') }}</option>
                    <option value="SIM">SIM</option>
                    <option value="NÃO">NÃO</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
        <!-- Declaração -->
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Declaracao" class="text-sm font-medium text-[#0a241e]">Declaração:</label>
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="Declaracao">
                    <option value="{{ $matricula->Declaracao ?? old('Declaracao') }}">{{ $matricula->Declaracao ?? old('Declaracao') }}</option>
                    <option value="SIM">SIM</option>
                    <option value="NÃO">NÃO</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
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
        <!-- Estado -->
        <div style="flex:1 1 20%; min-width:0; display:flex; flex-direction:column; gap:6px;">
            <label for="EstadoCartorio" class="text-sm font-medium text-[#0a241e]">Estado:</label>
            <div class="select-wrapper">
    <select
                    name="EstadoCartorio"
                    id="EstadoCartorio"
                    data-value="{{ $aluno- class="maruge-select">EstadoCartorio ?? old('EstadoCartorio', 'CE') }}"
                    class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6">
                    <option value="">Selecione o estado...</option>
                    <option value="AC">Acre (AC)</option><option value="AL">Alagoas (AL)</option><option value="AP">Amapá (AP)</option>
                    <option value="AM">Amazonas (AM)</option><option value="BA">Bahia (BA)</option><option value="CE" {{ (old('EstadoCartorio', $aluno->EstadoCartorio ?? 'CE') == 'CE') ? 'selected' : '' }}>Ceará (CE)</option>
                    <option value="DF">Distrito Federal (DF)</option><option value="ES">Espírito Santo (ES)</option><option value="GO">Goiás (GO)</option>
                    <option value="MA">Maranhão (MA)</option><option value="MT">Mato Grosso (MT)</option><option value="MS">Mato Grosso do Sul (MS)</option>
                    <option value="MG">Minas Gerais (MG)</option><option value="PA">Pará (PA)</option><option value="PB">Paraíba (PB)</option>
                    <option value="PR">Paraná (PR)</option><option value="PE">Pernambuco (PE)</option><option value="PI">Piauí (PI)</option>
                    <option value="RJ">Rio de Janeiro (RJ)</option><option value="RN">Rio Grande do Norte (RN)</option><option value="RS">Rio Grande do Sul (RS)</option>
                    <option value="RO">Rondônia (RO)</option><option value="RR">Roraima (RR)</option><option value="SC">Santa Catarina (SC)</option>
                    <option value="SP">São Paulo (SP)</option><option value="SE">Sergipe (SE)</option><option value="TO">Tocantins (TO)</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
        <!-- Cidade -->
        <div style="flex:1 1 30%; min-width:0; display:flex; flex-direction:column; gap:6px;">
            <label for="CidadeCartorio" class="text-sm font-medium text-[#0a241e]">Cidade do Cartório:</label>
            <div class="select-wrapper">
    <select
                    id="CidadeCartorio"
                    name="CidadeCartorio"
                    data-value="{{ $aluno- class="maruge-select">CidadeCartorio ?? old('CidadeCartorio') }}"
                    class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6">
                    <option value="">Selecione a cidade...</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
    </div>

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
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="Acompanhamento">
                    <option value="{{ $aluno->Acompanhamento ?? old('Acompanhamento') }}">{{ $aluno->Acompanhamento ?? old('Acompanhamento') }}</option>
                    <option value="Não">NÃO</option>
                    <option value="Psicológico">Psicológico</option>
                    <option value="Psicopdagógico">Psicopdagógico</option>
                    <option value="Neurológico">Neurológico</option>
                    <option value="Escolar">Escolar - CCDM</option>
                    <option value="Outros">Outros</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
    </div>
</div>
