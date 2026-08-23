<!-- TAB 3: ENDEREÇO -->
<div id="endereco" class="tab-panel hidden flex flex-col gap-6">
    <!-- Linha 1: Rua, Número, Fone Fixo, CEP -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <!-- CEP -->
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="CEP" class="text-sm font-medium text-[#0a241e]">CEP:</label>
            <input type="text" name="CEP" placeholder="00000-000" id="CEP" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-cep" value="{{ $endereco->CEP ?? old('CEP') }}">
        </div>
        <!-- Rua -->
        <div style="flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Rua" class="text-sm font-medium text-[#0a241e]">Rua:</label>
            <input type="text" name="Rua" id="Rua" placeholder="Endereço Completo" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Rua ?? old('Rua') }}">
        </div>
        <!-- Número -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Numero" class="text-sm font-medium text-[#0a241e]">Nº:</label>
            <input type="text" name="Numero" placeholder="Nº" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Numero ?? old('Numero') }}">
        </div>
        <!-- Fone Fixo -->
        <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Fone1" class="text-sm font-medium text-[#0a241e]">Telefone Fixo:</label>
            <input type="text" name="Fone1" placeholder="(xx) xxxx-xxxx" id="tel-fixo" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-phone" value="{{ $endereco->Fone1 ?? old('Fone1') }}">
        </div>
        
    </div>

    <!-- Linha 2: Bairro, Referência, Estado, Cidade -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <!-- Bairro -->
        <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Bairro" class="text-sm font-medium text-[#0a241e]">Bairro:</label>
            <input type="text" name="Bairro" id="Bairro" placeholder="Bairro" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Bairro ?? old('Bairro') }}">
        </div>
        <!-- Referência -->
        <div style="flex: 2 1 35%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Referencia" class="text-sm font-medium text-[#0a241e]">Referência:</label>
            <input type="text" name="Referencia" placeholder="Ponto de Referência" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $endereco->Referencia ?? old('Referencia') }}">
        </div>
        <!-- Estado (UF) -->
        <div style="flex: 1 1 15%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Estado" class="text-sm font-medium text-[#0a241e]">Estado (UF):</label>
            <div class="select-wrapper">
    <select name="Estado" id="Estado" data-value="{{ $endereco- class="maruge-select">Estado ?? old('Estado', 'CE') }}" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6">
                    <option value="">UF</option>
                    <option value="AC">AC</option><option value="AL">AL</option><option value="AP">AP</option><option value="AM">AM</option>
                    <option value="BA">BA</option><option value="CE" {{ (old('Estado', $endereco->Estado ?? 'CE') == 'CE') ? 'selected' : '' }}>CE</option><option value="DF">DF</option><option value="ES">ES</option>
                    <option value="GO">GO</option><option value="MA">MA</option><option value="MT">MT</option><option value="MS">MS</option>
                    <option value="MG">MG</option><option value="PA">PA</option><option value="PB">PB</option><option value="PR">PR</option>
                    <option value="PE">PE</option><option value="PI">PI</option><option value="RJ">RJ</option><option value="RN">RN</option>
                    <option value="RS">RS</option><option value="RO">RO</option><option value="RR">RR</option><option value="SC">SC</option>
                    <option value="SP">SP</option><option value="SE">SE</option><option value="TO">TO</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
        <!-- Cidade -->
        <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Cidade" class="text-sm font-medium text-[#0a241e]">Cidade:</label>
            <div class="select-wrapper">
    <select name="Cidade" id="Cidade" data-value="{{ $endereco- class="maruge-select">Cidade ?? old('Cidade', 'FORTALEZA') }}" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6">
                    <option value="{{ $endereco->Cidade ?? old('Cidade', 'FORTALEZA') }}">{{ $endereco->Cidade ?? old('Cidade', 'FORTALEZA') }}</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
    </div>
</div>
