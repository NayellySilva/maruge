<!-- TAB 4: OBSERVAÇÕES -->
<div id="obs" class="tab-panel hidden flex flex-col gap-6">
    <div style="display: flex; flex-direction: column; gap: 6px; width: 100%;">
        <label for="ObsAluno" class="text-sm font-medium text-[#0a241e]">Observações do Aluno:</label>
        <textarea class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl p-4 text-sm text-[#0a241e] focus:outline-none focus:border-gray-400 transition-all min-h-[150px]" name="ObsAluno" placeholder="Observações importantes..." maxlength="1000">{{ $aluno->ObsAluno ?? old('ObsAluno') }}</textarea>
    </div>

    <!-- Botões de Ação -->
    <div class="flex gap-3 border-t border-[#f1f3f2] pt-6 mt-4">
        <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full text-sm transition-all shadow-sm cursor-pointer">
            SALVAR
        </button>
        <button type="reset" class="border border-[#e3e8e6] text-[#5c706b] hover:bg-[#f8faf9] font-medium px-6 py-2.5 rounded-full text-sm transition-all cursor-pointer">
            LIMPAR
        </button>
    </div>
</div>
