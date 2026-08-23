<!-- TAB: FINANCEIRO -->
<div id="financeiro" class="tab-panel hidden flex flex-col gap-6">
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end; flex-wrap: wrap;">
        <!-- Forma PGTO -->
        <div style="flex: 1 1 25%; min-width: 150px; display: flex; flex-direction: column; gap: 6px;">
            <label for="FormaPGTO" class="text-sm font-medium text-[#0a241e]">Forma PGTO:</label>
            <div class="relative" id="dropdown-container-formapgto">
                <input type="hidden" id="FormaPGTO" name="FormaPGTO" value="{{ old('FormaPGTO', $matricula->FormaPGTO ?? '') }}">
                @php
                    $valPgto = old('FormaPGTO', $matricula->FormaPGTO ?? '');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-formapgto', 'chevron-formapgto')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-formapgto" class="text-sm font-medium truncate {{ $valPgto ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valPgto ?: 'Selecione...' }}
                    </span>
                    <div id="chevron-formapgto" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-formapgto" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    @foreach(['CHEQUE', 'CARTÃO', 'DINHEIRO'] as $fpg)
                        <div onclick="selectSingleOption('{{ $fpg }}', '{{ $fpg }}', 'FormaPGTO', 'label-formapgto', 'dropdown-menu-formapgto', 'chevron-formapgto', false)"
                             class="option-formapgto flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">{{ $fpg }}</span>
                        </div>
                    @endforeach
                </div>
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
                <div class="relative" id="dropdown-container-validadedesconto">
                    <input type="hidden" id="ValidadeDesconto" name="ValidadeDesconto" value="{{ old('ValidadeDesconto', $matricula->ValidadeDesconto ?? 'esta_matricula') }}">
                    @php
                        $valValidade = old('ValidadeDesconto', $matricula->ValidadeDesconto ?? 'esta_matricula');
                        $validadeLabels = [
                            'esta_matricula' => 'Apenas esta matrícula',
                            'ate_vencimento' => 'Até o vencimento',
                            'ate_cancelar' => 'Até cancelar',
                            'data_especifica' => 'Data específica'
                        ];
                    @endphp
                    <div onclick="toggleMultiDropdown('dropdown-menu-validadedesconto', 'chevron-validadedesconto')" 
                         class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                        <span id="label-validadedesconto" class="text-sm font-medium truncate {{ $valValidade ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                            {{ $validadeLabels[$valValidade] ?? 'Selecione a validade...' }}
                        </span>
                        <div id="chevron-validadedesconto" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                    <div id="dropdown-menu-validadedesconto" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                        @foreach($validadeLabels as $vKey => $vText)
                            <div onclick="selectSingleOption('{{ $vKey }}', '{{ $vText }}', 'ValidadeDesconto', 'label-validadedesconto', 'dropdown-menu-validadedesconto', 'chevron-validadedesconto', false); toggleDataValidade('{{ $vKey }}');"
                                 class="option-validadedesconto flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">{{ $vText }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Calendário — exibido somente quando "Data específica" for selecionada -->
                <div id="DataValidadeWrapper" class="{{ $valValidade == 'data_especifica' ? '' : 'hidden' }} mt-2">
                    <input
                        type="date"
                        id="DataValidadeDesconto"
                        name="DataValidadeDesconto"
                        class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all"
                        value="{{ $matricula->DataValidadeDesconto ?? old('DataValidadeDesconto') }}">
                </div>
            </div>

            <script>
            function toggleDataValidade(val) {
                const wrapper = document.getElementById('DataValidadeWrapper');
                if (wrapper) {
                    if (val === 'data_especifica') {
                        wrapper.classList.remove('hidden');
                    } else {
                        wrapper.classList.add('hidden');
                    }
                }
            }
            </script>
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
