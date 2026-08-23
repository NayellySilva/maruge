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
        <div style="flex: 1 1 20%; min-width: 140px; display: flex; flex-direction: column; gap: 6px;">
            <label for="Estado" class="text-sm font-medium text-[#0a241e]">Estado (UF):</label>
            <div class="relative" id="dropdown-container-estado">
                <input type="hidden" id="Estado" name="Estado" value="{{ old('Estado', $endereco->Estado ?? '') }}">
                @php
                    $valEstado = old('Estado', $endereco->Estado ?? '');
                    $ufs = [
                        'AC'=>'Acre (AC)','AL'=>'Alagoas (AL)','AP'=>'Amapá (AP)','AM'=>'Amazonas (AM)','BA'=>'Bahia (BA)',
                        'CE'=>'Ceará (CE)','DF'=>'Distrito Federal (DF)','ES'=>'Espírito Santo (ES)','GO'=>'Goiás (GO)',
                        'MA'=>'Maranhão (MA)','MT'=>'Mato Grosso (MT)','MS'=>'Mato Grosso do Sul (MS)','MG'=>'Minas Gerais (MG)',
                        'PA'=>'Pará (PA)','PB'=>'Paraíba (PB)','PR'=>'Paraná (PR)','PE'=>'Pernambuco (PE)','PI'=>'Piauí (PI)',
                        'RJ'=>'Rio de Janeiro (RJ)','RN'=>'Rio Grande do Norte (RN)','RS'=>'Rio Grande do Sul (RS)',
                        'RO'=>'Rondônia (RO)','RR'=>'Roraima (RR)','SC'=>'Santa Catarina (SC)','SP'=>'São Paulo (SP)',
                        'SE'=>'Sergipe (SE)','TO'=>'Tocantins (TO)'
                    ];
                    $labelEstado = $valEstado && isset($ufs[$valEstado]) ? $ufs[$valEstado] : 'Selecione o estado...';
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-estado', 'chevron-estado')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-estado" class="text-sm font-medium truncate {{ $valEstado ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $labelEstado }}
                    </span>
                    <div id="chevron-estado" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-estado" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                    <div class="relative shrink-0">
                        <input type="text" onkeyup="filterDropdownOptions('search-estado', 'option-estado')" id="search-estado" placeholder="Pesquisar UF..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                        <div onclick="selectSingleOption('', 'Selecione o estado...', 'Estado', 'label-estado', 'dropdown-menu-estado', 'chevron-estado', false); loadCitiesForCustomEstado('');"
                             class="option-estado flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium text-[#95aba5]">Selecione o estado...</span>
                        </div>
                        @foreach($ufs as $ufCode => $ufName)
                            <div onclick="selectSingleOption('{{ $ufCode }}', '{{ $ufName }}', 'Estado', 'label-estado', 'dropdown-menu-estado', 'chevron-estado', false); loadCitiesForCustomEstado('{{ $ufCode }}');"
                                 class="option-estado flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">{{ $ufName }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Cidade -->
        <div style="flex: 1 1 25%; min-width: 160px; display: flex; flex-direction: column; gap: 6px;">
            <label for="Cidade" class="text-sm font-medium text-[#0a241e]">Cidade:</label>
            <div class="relative" id="dropdown-container-cidade">
                <input type="hidden" id="Cidade" name="Cidade" value="{{ old('Cidade', $endereco->Cidade ?? '') }}">
                @php
                    $valCidade = old('Cidade', $endereco->Cidade ?? '');
                @endphp
                <div onclick="toggleMultiDropdown('dropdown-menu-cidade', 'chevron-cidade')" 
                     class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-cidade" class="text-sm font-medium truncate {{ $valCidade ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $valCidade ?: 'Selecione a cidade...' }}
                    </span>
                    <div id="chevron-cidade" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>
                <div id="dropdown-menu-cidade" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                    <div class="relative shrink-0">
                        <input type="text" onkeyup="filterDropdownOptions('search-cidade', 'option-cidade')" id="search-cidade" placeholder="Pesquisar cidade..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                    <div id="custom-cidades-list" class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                        <div class="p-2 text-xs text-[#95aba5]">Selecione um estado primeiro</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.loadCitiesForCustomEstado = function(uf, selectedCity = '') {
    const listContainer = document.getElementById('custom-cidades-list');
    const labelCidade = document.getElementById('label-cidade');
    const hiddenCidade = document.getElementById('Cidade');
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
            let html = `<div onclick="selectSingleOption('', 'Selecione a cidade...', 'Cidade', 'label-cidade', 'dropdown-menu-cidade', 'chevron-cidade', false)" class="option-cidade flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]"><span class="option-title font-medium text-[#95aba5]">Selecione a cidade...</span></div>`;
            
            cities.forEach(city => {
                const name = city.nome.toUpperCase();
                html += `<div onclick="selectSingleOption('${name}', '${name}', 'Cidade', 'label-cidade', 'dropdown-menu-cidade', 'chevron-cidade', false)" class="option-cidade flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]"><span class="option-title font-medium">${name}</span></div>`;
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
    const estadoVal = document.getElementById('Estado')?.value;
    const cidadeVal = document.getElementById('Cidade')?.value;
    if (estadoVal) {
        window.loadCitiesForCustomEstado(estadoVal, cidadeVal);
    }
});
</script>
