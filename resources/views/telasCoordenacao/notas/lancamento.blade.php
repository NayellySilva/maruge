@extends('layouts.app')

@section('content')
@php
    $isRecuperacao = $bimestre === 'rec';
    $bimestreNumero = $isRecuperacao ? null : (int) str_replace('bim', '', $bimestre);
    $notaCampo = $isRecuperacao ? null : 'AB' . $bimestreNumero;
    $recuperacaoCampo = $isRecuperacao ? null : 'RB' . $bimestreNumero;
    $mensalCampo = (!$isRecuperacao && $nivel === 'fund2') ? 'AM' . $bimestreNumero : null;
    $action = $isRecuperacao
        ? url('/coordenacao/salva_nota_rp_rf')
        : url('/coordenacao/salva_nota_' . $bimestre . '_' . ($nivel === 'fund1' ? 'fun1' : ($nivel === 'fund2' ? 'fun2' : 'inf')));
    $tituloBimestre = $isRecuperacao ? 'Recuperação e resultado final' : $bimestreNumero . 'º bimestre';
@endphp

<div class="flex flex-col gap-6">
    <div class="flex flex-wrap items-center gap-2 text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao/notas/notas') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span>/</span>
        <span class="font-semibold text-[#0a241e]">Lançamento de notas</span>
    </div>

    <div class="flex flex-col gap-1">
        <h1 class="text-2xl sm:text-3xl font-semibold text-[#0a241e]">{{ $titulo }}</h1>
        <p class="text-sm text-[#5c706b]">{{ $aluno->NomeAluno }} · RA {{ $matricula->RA }} · {{ $turma->NomeTurma }}</p>
    </div>

    <form action="{{ $action }}" method="POST" class="flex flex-col gap-5" data-note-form>
        @csrf
        <input type="hidden" name="nivel" value="{{ $nivel }}">
        <div class="flex items-center justify-between gap-4 rounded-xl border border-[#d8e5df] bg-[#ecfdf5] px-4 py-3 text-sm text-[#0a5c3a]">
            <div class="flex items-center gap-3">
                <i data-lucide="clipboard-pen-line" class="h-5 w-5 shrink-0"></i>
                <span>Lançamento referente a <strong>{{ $tituloBimestre }}</strong></span>
            </div>
            <span class="hidden sm:inline text-xs text-[#5c706b]">Notas de 0 a 10</span>
        </div>

        <div class="overflow-hidden rounded-2xl border border-[#e3e8e6] bg-white shadow-2xs">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] border-collapse">
                    <thead class="bg-[#f8faf9] text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">
                        <tr class="border-b border-[#e3e8e6]">
                            <th class="px-5 py-4">Cód.</th>
                            <th class="px-5 py-4">Disciplina</th>
                            @if($isRecuperacao)
                                <th class="px-5 py-4 text-center">Recuperação parcial</th>
                                <th class="px-5 py-4 text-center">Resultado final</th>
                            @else
                                @if($mensalCampo)
                                    <th class="px-5 py-4 text-center">Avaliação mensal</th>
                                @endif
                                <th class="px-5 py-4 text-center">{{ $bimestreNumero }}º bimestre</th>
                                <th class="px-5 py-4 text-center">Recuperação</th>
                                <th class="px-5 py-4 text-center">Média final</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e3e8e6]">
                        @foreach($disciplinas as $key => $disciplina)
                            @php
                                $notas = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
                                $nota = $notas->first();
                                $base = $nota && $notaCampo ? (float) ($nota->{$notaCampo} ?? 0) : 0;
                                $rec = $nota && $recuperacaoCampo ? (float) ($nota->{$recuperacaoCampo} ?? 0) : 0;
                                $mensal = $nota && $mensalCampo ? (float) ($nota->{$mensalCampo} ?? 0) : 0;
                                $notaService = app(\App\Services\NotaBimestralService::class);
                                $avaliacoes = [$mensalCampo ? $mensal : null, $base];
                                $mediaParcial = $notaService->calcularMediaParcial($avaliacoes);
                                $mediaFinal = $notaService->calcularMediaFinalComRecuperacao($avaliacoes, $rec > 0 ? $rec : null);
                                $rp = $nota ? (float) ($nota->RP ?? 0) : 0;
                                $rf = $nota ? (float) ($nota->RF ?? 0) : 0;
                            @endphp
                            <tr class="hover:bg-[#f8faf9]/60 transition-colors">
                                <td class="px-5 py-3 text-sm text-[#5c706b]">{{ $disciplina->tb_disciplinas_idDisciplinas }}</td>
                                <td class="px-5 py-3 text-sm font-semibold text-[#0a241e]">{{ $disciplina->NomeDisciplina }}</td>

                                <input type="hidden" name="tb_disciplinas_idDisciplinas[{{ $key }}]" value="{{ $disciplina->tb_disciplinas_idDisciplinas }}">
                                <input type="hidden" name="tb_usuario_idUsuario[{{ $key }}]" value="{{ data_get(auth()->guard('guardLogin')->user(), 'idUsuario', 1) }}">
                                <input type="hidden" name="tb_turmas_idTurmas[{{ $key }}]" value="{{ $turma->idTurmas }}">
                                <input type="hidden" name="tb_aluno_idAluno[{{ $key }}]" value="{{ $aluno->idAluno }}">
                                <input type="hidden" name="RA[{{ $key }}]" value="{{ $matricula->RA }}">

                                @if($isRecuperacao)
                                    <td class="px-5 py-3">
                                        <input type="number" name="RP[{{ $key }}]" value="{{ $rp > 0 ? $rp : '' }}" min="0" max="10" step="0.1" placeholder="0,0" class="w-28 mx-auto rounded-lg border border-[#d8e5df] px-3 py-2 text-center text-sm text-[#0a241e] outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10">
                                    </td>
                                    <td class="px-5 py-3">
                                        <input type="number" name="RF[{{ $key }}]" value="{{ $rf > 0 ? $rf : '' }}" min="0" max="10" step="0.1" placeholder="0,0" class="w-28 mx-auto rounded-lg border border-[#d8e5df] px-3 py-2 text-center text-sm text-[#0a241e] outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10">
                                    </td>
                                @else
                                    @if($mensalCampo)
                                        <td class="px-5 py-3">
                                            <input type="number" name="{{ $mensalCampo }}[{{ $key }}]" value="{{ $mensal > 0 ? $mensal : '' }}" min="0" max="10" step="0.1" placeholder="0,0" class="w-28 mx-auto rounded-lg border border-[#d8e5df] px-3 py-2 text-center text-sm text-[#0a241e] outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10">
                                        </td>
                                    @endif
                                    <td class="px-5 py-3">
                                        <input type="number" name="{{ $notaCampo }}[{{ $key }}]" value="{{ $base > 0 ? $base : '' }}" min="0" max="10" step="0.1" placeholder="0,0" class="w-28 mx-auto rounded-lg border border-[#d8e5df] px-3 py-2 text-center text-sm text-[#0a241e] outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10" data-base-note>
                                    </td>
                                    <td class="px-5 py-3">
                                        <input type="number" name="{{ $recuperacaoCampo }}[{{ $key }}]" value="{{ $rec > 0 ? $rec : '' }}" min="0" max="10" step="0.1" placeholder="{{ $mediaParcial !== null && $mediaParcial < 7 ? 'Necessária' : 'Opcional' }}" class="w-28 mx-auto rounded-lg border border-[#d8e5df] px-3 py-2 text-center text-sm text-[#0a241e] outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10" data-recovery-note>
                                    </td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="inline-flex min-w-14 justify-center rounded-full px-3 py-1 text-sm font-semibold {{ $mediaFinal !== null && $mediaFinal >= 7 ? 'bg-[#ecfdf5] text-[#087443]' : 'bg-[#fff7ed] text-[#b45309]' }}" data-final-note>{{ $mediaFinal !== null ? number_format($mediaFinal, 1, ',', '.') : '-' }}</span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-xs text-[#5c706b]">A recuperação só substitui a média quando for maior que a nota original.</p>
            <div class="flex gap-3">
                <a href="{{ url('/coordenacao/notas/notas') }}" class="inline-flex items-center gap-2 rounded-lg border border-[#d8e5df] px-4 py-2.5 text-sm font-medium text-[#5c706b] hover:bg-white transition-colors">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i> Voltar
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#008a4b] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#00703c] transition-colors">
                    <i data-lucide="save" class="h-4 w-4"></i> Salvar notas
                </button>
            </div>
        </div>
    </form>
</div>

@if(!$isRecuperacao)
<script>
    document.querySelectorAll('[data-note-form]').forEach(function (form) {
        form.querySelectorAll('tr').forEach(function (row) {
            const baseInput = row.querySelector('[data-base-note]');
            const monthlyInput = row.querySelector('input[name^="AM"]');
            const recoveryInput = row.querySelector('[data-recovery-note]');
            const finalNote = row.querySelector('[data-final-note]');
            if (!baseInput || !recoveryInput || !finalNote) return;

            const updateFinal = function () {
                const base = Number.parseFloat(baseInput.value.replace(',', '.')) || 0;
                const monthly = monthlyInput ? (Number.parseFloat(monthlyInput.value.replace(',', '.')) || 0) : 0;
                const recovery = Number.parseFloat(recoveryInput.value.replace(',', '.')) || 0;
                const assessments = [baseInput.value.trim() !== '' ? base : null];
                if (monthlyInput) assessments.push(monthlyInput.value.trim() !== '' ? monthly : null);
                const validAssessments = assessments.filter(function (value) { return value !== null; });
                if (!validAssessments.length) {
                    finalNote.textContent = '-';
                    return;
                }
                const partial = validAssessments.reduce(function (sum, value) { return sum + value; }, 0) / validAssessments.length;
                const lowestIndex = validAssessments.indexOf(Math.min.apply(null, validAssessments));
                if (partial < 7 && recovery > validAssessments[lowestIndex]) validAssessments[lowestIndex] = recovery;
                const finalValue = validAssessments.reduce(function (sum, value) { return sum + value; }, 0) / validAssessments.length;
                finalNote.textContent = finalValue > 0 ? finalValue.toFixed(1).replace('.', ',') : '-';
                finalNote.className = 'inline-flex min-w-14 justify-center rounded-full px-3 py-1 text-sm font-semibold ' + (finalValue >= 7 ? 'bg-[#ecfdf5] text-[#087443]' : 'bg-[#fff7ed] text-[#b45309]');
            };

            baseInput.addEventListener('input', updateFinal);
            if (monthlyInput) monthlyInput.addEventListener('input', updateFinal);
            recoveryInput.addEventListener('input', updateFinal);
        });
    });
</script>
@endif
@endsection
