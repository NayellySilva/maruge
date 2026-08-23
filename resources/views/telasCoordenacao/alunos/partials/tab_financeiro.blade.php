<!-- TAB: FINANCEIRO -->
<div id="financeiro" class="tab-panel hidden flex flex-col gap-6">
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end; flex-wrap: wrap;">
        <!-- Forma PGTO -->
        <div style="flex: 1 1 25%; min-width: 150px; display: flex; flex-direction: column; gap: 6px;">
            <label for="FormaPGTO" class="text-sm font-medium text-[#0a241e]">Forma PGTO:</label>
            <div class="select-wrapper">
    <select class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select" name="FormaPGTO">
                    <option value="{{ $matricula->FormaPGTO ?? old('FormaPGTO') }}">{{ $matricula->FormaPGTO ?? old('FormaPGTO') }}</option>
                    <option value="CHEQUE">CHEQUE</option>
                    <option value="CARTÃO">CARTÃO</option>
                    <option value="DINHEIRO">DINHEIRO</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
        </div>
        <!-- Valor -->
        <div style="flex: 1 1 20%; min-width: 120px; display: flex; flex-direction: column; gap: 6px;">
            <label for="ValorPGTO" class="text-sm font-medium text-[#0a241e]">Valor:</label>
            <input type="text" name="ValorPGTO" placeholder="R$ 0,00" id="ValorPGTO" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $matricula->ValorPGTO ?? old('ValorPGTO') }}">
        </div>
        <!-- Data Matrícula -->
        <div style="flex: 1 1 25%; min-width: 150px; display: flex; flex-direction: column; gap: 6px;">
            <label for="DataMatricula" class="text-sm font-medium text-[#0a241e]">Data Matrícula:</label>
            <input type="date" id="DataMatricula" name="DataMatricula" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $formatDate($matricula->DataMatricula ?? old('DataMatricula')) }}">
        </div>
        
    </div>

    <!--  Seção: Desconto da Matrícula  -->
    <div >

        <!-- Linha 1: Motivo + Percentual + Valor + Validade -->
        <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-start; flex-wrap: wrap;">

            <!-- Motivo do Desconto -->
            <div style="flex: 2 1 40%; min-width: 180px; display: flex; flex-direction: column; gap: 6px;">
                <label for="MotivoDesconto" class="text-sm font-medium text-[#0a241e]">Motivo do Desconto:</label>
                <input
                    type="text"
                    id="MotivoDesconto"
                    name="MotivoDesconto"
                    placeholder="Ex.: Bolsa, Convênio, Desconto Promocional"
                    class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all"
                    value="{{ $matricula->MotivoDesconto ?? old('MotivoDesconto') }}">
            </div>

            <!-- Percentual de Desconto -->
            <div style="flex: 1 1 15%; min-width: 120px; display: flex; flex-direction: column; gap: 6px;">
                <label for="DescontoPercentual" class="text-sm font-medium text-[#0a241e]">Percentual (%):</label>
                <input
                    type="text"
                    id="DescontoPercentual"
                    name="DescontoPercentual"
                    placeholder="0,00"
                    inputmode="decimal"
                    class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all"
                    value="{{ $matricula->DescontoPercentual ?? old('DescontoPercentual') }}">
                <span id="erro-percentual" class="text-xs text-red-500" style="min-height:1rem; display:block;"></span>
            </div>

            <!-- Valor do Desconto -->
            <div style="flex: 1 1 20%; min-width: 140px; display: flex; flex-direction: column; gap: 6px;">
                <label for="DescontoValor" class="text-sm font-medium text-[#0a241e]">Valor do Desconto (R$):</label>
                <input
                    type="text"
                    id="DescontoValor"
                    name="DescontoValor"
                    placeholder="R$ 0,00"
                    class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all"
                    value="{{ $matricula->DescontoValor ?? old('DescontoValor') }}">
                <span id="erro-valor" class="text-xs text-red-500" style="min-height:1rem; display:block;"></span>
            </div>

            <!-- Validade do Desconto -->
            <div style="flex: 1 1 20%; min-width: 160px; display: flex; flex-direction: column; gap: 6px;">
                <label for="ValidadeDesconto" class="text-sm font-medium text-[#0a241e]">Validade:</label>
                <div class="select-wrapper">
    <select
                        id="ValidadeDesconto"
                        name="ValidadeDesconto"
                        class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6 maruge-select">
                        <option value="esta_matricula"  {{ (($matricula->ValidadeDesconto ?? old('ValidadeDesconto')) == 'esta_matricula')  ? 'selected' : '' }}>Apenas esta matrícula</option>
                        <option value="ate_vencimento"  {{ (($matricula->ValidadeDesconto ?? old('ValidadeDesconto')) == 'ate_vencimento')  ? 'selected' : '' }}>Até o vencimento</option>
                        <option value="ate_cancelar"    {{ (($matricula->ValidadeDesconto ?? old('ValidadeDesconto')) == 'ate_cancelar')    ? 'selected' : '' }}>Até cancelar</option>
                        <option value="data_especifica" {{ (($matricula->ValidadeDesconto ?? old('ValidadeDesconto')) == 'data_especifica') ? 'selected' : '' }}>Data específica</option>
                    </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
                <!-- Calendário — exibido somente quando "Data específica" for selecionada -->
                <div id="DataValidadeWrapper" class="hidden">
                    <input
                        type="date"
                        id="DataValidadeDesconto"
                        name="DataValidadeDesconto"
                        class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all"
                        value="{{ $matricula->DataValidadeDesconto ?? old('DataValidadeDesconto') }}">
                </div>
            </div>
        </div>

        <!-- Resumo Financeiro em tempo real -->
        <div >
            <p class="text-xs font-semibold text-[#5c706b] uppercase tracking-wide mb-1">Resumo</p>
            <div class="flex justify-between text-sm text-[#0a241e]">
                <span>Valor da Matrícula</span>
                <span id="resumo-valor-matricula" class="font-medium">R$ 0,00</span>
            </div>
            <div class="flex justify-between text-sm" style="color: #c0392b;">
                <span>Desconto</span>
                <span id="resumo-desconto" class="font-medium">- R$ 0,00</span>
            </div>
            <div class="flex justify-between text-sm font-semibold" style="border-top: 1px solid #c8e6d4; padding-top: 8px; color: #008a4b;">
                <span>Valor Final</span>
                <span id="resumo-valor-final">R$ 0,00</span>
            </div>
        </div>
    </div>
</div>
