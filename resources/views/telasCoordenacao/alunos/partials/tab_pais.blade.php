<!-- TAB 2: DADOS DOS PAIS -->
<div id="dados_pais" class="tab-panel hidden flex flex-col gap-6">
    <!-- Pai: Nome, WhatsApp, Fone 2, Profissão -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <div style="flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="NomePai" class="text-sm font-medium text-[#0a241e]">Nome do Pai:</label>
            <input type="text" name="NomePai" placeholder="Nome do Pai" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $pais->NomePai ?? old('NomePai') }}">
        </div>
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="FonePai1" class="text-sm font-medium text-[#0a241e]">WhatsApp do Pai:</label>
            <input type="text" name="FonePai1" placeholder="(xx) x-xxxx-xxxx" id="FonePai1" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-phone" value="{{ $pais->FonePai1 ?? old('FonePai1') }}">
        </div>
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="FonePai2" class="text-sm font-medium text-[#0a241e]">Fone 2 do Pai:</label>
            <input type="text" name="FonePai2" placeholder="(xx) x-xxxx-xxxx" id="FonePai2" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-phone" value="{{ $pais->FonePai2 ?? old('FonePai2') }}">
        </div>
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="ProfPai" class="text-sm font-medium text-[#0a241e]">Profissão do Pai:</label>
            <input type="text" name="ProfPai" placeholder="Profissão" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $pais->ProfPai ?? old('ProfPai') }}">
        </div>
    </div>

    <!-- Pai: CPF, RG, Nascimento -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <div style="flex: 1 1 35%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="CPFPai" class="text-sm font-medium text-[#0a241e]">CPF do Pai:</label>
            <input type="text" name="CPFPai" placeholder="000.000.000-00" id="CPFPai" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-cpf" value="{{ $pais->CPFPai ?? old('CPFPai') }}">
        </div>
        <div style="flex: 1 1 35%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="RGPai" class="text-sm font-medium text-[#0a241e]">RG do Pai:</label>
            <input type="text" name="RGPai" placeholder="RG do Pai" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $pais->RGPai ?? old('RGPai') }}">
        </div>
        <div style="flex: 1 1 30%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Nas_Pai" class="text-sm font-medium text-[#0a241e]">Data de Nascimento do Pai:</label>
            <input type="date" name="Nas_Pai" id="DataNascimentoPai" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $formatDate($pais->Nas_Pai ?? old('Nas_Pai')) }}">
        </div>
    </div>

    <!-- Mãe: Nome, WhatsApp, Fone 2, Profissão -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end; border-t border-[#f1f3f2] pt-6 mt-2;">
        <div style="flex: 2 1 40%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="NomeMae" class="text-sm font-medium text-[#0a241e]">Nome da Mãe:</label>
            <input type="text" name="NomeMae" placeholder="Nome da Mãe" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $pais->NomeMae ?? old('NomeMae') }}">
        </div>
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="FoneMae1" class="text-sm font-medium text-[#0a241e]">WhatsApp da Mãe:</label>
            <input type="text" name="FoneMae1" placeholder="(xx) x-xxxx-xxxx" id="FoneMae1" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-phone" value="{{ $pais->FoneMae1 ?? old('FoneMae1') }}">
        </div>
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="FoneMae2" class="text-sm font-medium text-[#0a241e]">Fone 2 da Mãe:</label>
            <input type="text" name="FoneMae2" placeholder="(xx) x-xxxx-xxxx" id="FoneMae2" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-phone" value="{{ $pais->FoneMae2 ?? old('FoneMae2') }}">
        </div>
        <div style="flex: 1 1 20%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="ProfMae" class="text-sm font-medium text-[#0a241e]">Profissão da Mãe:</label>
            <input type="text" name="ProfMae" placeholder="Profissão" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $pais->ProfMae ?? old('ProfMae') }}">
        </div>
    </div>

    <!-- Mãe: CPF, RG, Nascimento -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end;">
        <div style="flex: 1 1 35%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="CPFMae" class="text-sm font-medium text-[#0a241e]">CPF da Mãe:</label>
            <input type="text" name="CPFMae" placeholder="000.000.000-00" id="CPFMae" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-cpf" value="{{ $pais->CPFMae ?? old('CPFMae') }}">
        </div>
        <div style="flex: 1 1 35%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="RGMae" class="text-sm font-medium text-[#0a241e]">RG da Mãe:</label>
            <input type="text" name="RGMae" placeholder="RG da Mãe" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $pais->RGMae ?? old('RGMae') }}">
        </div>
        <div style="flex: 1 1 30%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Nas_Mae" class="text-sm font-medium text-[#0a241e]">Data de Nascimento da Mãe:</label>
            <input type="date" name="Nas_Mae" id="DataNascimentoMae" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $formatDate($pais->Nas_Mae ?? old('Nas_Mae')) }}">
        </div>
    </div>

    <!-- Responsável: Nome, RG, CPF -->
    <div style="display: flex; flex-direction: row; gap: 16px; width: 100%; align-items: flex-end; border-t border-[#f1f3f2] pt-6 mt-2;">
        <div style="flex: 2 1 50%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="Responsavel" class="text-sm font-medium text-[#0a241e]">Responsável:</label>
            <input type="text" name="Responsavel" placeholder="Nome do Responsável" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $pais->Responsavel ?? old('Responsavel') }}">
        </div>
        <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="RGResponsavel" class="text-sm font-medium text-[#0a241e]">RG do Responsável:</label>
            <input type="text" name="RGResponsavel" placeholder="RG" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all" value="{{ $pais->RGResponsavel ?? old('RGResponsavel') }}">
        </div>
        <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
            <label for="CPFResponsavel" class="text-sm font-medium text-[#0a241e]">CPF do Responsável:</label>
            <input type="text" name="CPFResponsavel" placeholder="000.000.000-00" id="CPFResponsavel" class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all mask-cpf" value="{{ $pais->CPFResponsavel ?? old('CPFResponsavel') }}">
        </div>
    </div>
</div>
