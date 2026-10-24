@extends('layouts.app')

@section('content')
@php
    $notaCampo = 'AB' . $bimestreNumero;
    $mensalCampo = ($nivel === 'fun2') ? 'AM' . $bimestreNumero : null;
    $recuperacaoCampo = ($nivel !== 'inf') ? 'RB' . $bimestreNumero : null;
    $notaService = app(\App\Services\NotaBimestralService::class);
@endphp

<div class="flex flex-col gap-6">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-[#5c706b]">
        <a href="{{ url('/docente/notas') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span>/</span>
        <a href="{{ url('/docente/notas') }}" class="hover:text-[#008a4b] transition-colors">Notas</a>
        <span>/</span>
        <span class="font-semibold text-[#0a241e]">Lançamento por Turma</span>
    </div>

    <!-- Cabecalho -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full {{ $nivel === 'inf' ? 'bg-pink-50 text-pink-700' : ($nivel === 'fun2' ? 'bg-emerald-50 text-emerald-700' : 'bg-sky-50 text-sky-700') }}">
                    {{ $nivel === 'inf' ? 'Educação Infantil' : ($nivel === 'fun2' ? 'Fundamental II' : 'Fundamental I') }}
                </span>
                <span class="text-xs text-[#5c706b]">·</span>
                <span class="text-xs text-[#5c706b]">Ano {{ $turma->AnoLetivo ?? date('Y') }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#0a241e] mt-1">
                {{ $turma->NomeTurma }} · <span class="text-[#008a4b]">{{ $disciplina->NomeDisciplina }}</span>
            </h1>
            <p class="text-sm text-[#5c706b] mt-0.5">Lançamento de notas em lote para todos os alunos ativos da turma</p>
        </div>

        <!-- Seletor de Bimestres -->
        <div class="inline-flex rounded-xl bg-white border border-[#e3e8e6] p-1 shadow-2xs">
            @foreach([1, 2, 3, 4] as $b)
                <a href="{{ url('/docente/lancar_turma/' . $turma->idTurmas . '/' . $disciplina->idDisciplinas . '/' . $b . 'bim') }}"
                   class="px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all {{ $bimestreNumero === $b ? 'bg-[#008a4b] text-white shadow-xs' : 'text-[#5c706b] hover:text-[#0a241e]' }}">
                    {{ $b }}º Bimestre
                </a>
            @endforeach
        </div>
    </div>

    @if(session('status'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600 shrink-0"></i>
            <span>{{ session('status') }}</span>
        </div>
    @endif

    @if($alunos->isEmpty())
        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-10 text-center shadow-2xs">
            <p class="text-sm text-[#5c706b]">Nenhum aluno ativo matriculado nesta turma.</p>
        </div>
    @else
        <form action="{{ url('/docente/lancar_turma') }}" method="POST" class="flex flex-col gap-5" data-batch-note-form>
            @csrf
            <input type="hidden" name="idTurmas" value="{{ $turma->idTurmas }}">
            <input type="hidden" name="tb_disciplinas_idDisciplinas" value="{{ $disciplina->idDisciplinas }}">
            <input type="hidden" name="bim" value="{{ $bim }}">

            <div class="overflow-hidden rounded-2xl border border-[#e3e8e6] bg-white shadow-2xs">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[720px] border-collapse">
                        <thead class="bg-[#f8faf9] text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">
                            <tr class="border-b border-[#e3e8e6]">
                                <th class="px-4 py-3.5 w-12 text-center">#</th>
                                <th class="px-4 py-3.5 w-24">RA</th>
                                <th class="px-5 py-3.5">Nome do Aluno</th>
                                @if($nivel === 'fun2')
                                    <th class="px-4 py-3.5 text-center w-32">Aval. Mensal</th>
                                @endif
                                <th class="px-4 py-3.5 text-center w-32">{{ $bimestreNumero }}º Bimestre</th>
                                @if($nivel !== 'inf')
                                    <th class="px-4 py-3.5 text-center w-32">Recuperação</th>
                                    <th class="px-4 py-3.5 text-center w-28">Média Final</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e3e8e6]">
                            @foreach($alunos as $index => $aluno)
                                @php
                                    $nota = $notasExistentes->get($aluno->idAluno);
                                    $base = $nota ? (float) ($nota->{$notaCampo} ?? 0) : 0;
                                    $mensal = ($nota && $mensalCampo) ? (float) ($nota->{$mensalCampo} ?? 0) : 0;
                                    $rec = ($nota && $recuperacaoCampo) ? (float) ($nota->{$recuperacaoCampo} ?? 0) : 0;

                                    $avaliacoes = [$mensalCampo ? ($mensal > 0 ? $mensal : null) : null, $base > 0 ? $base : null];
                                    $mediaParcial = $notaService->calcularMediaParcial($avaliacoes);
                                    $mediaFinal = $notaService->calcularMediaFinalComRecuperacao($avaliacoes, $rec > 0 ? $rec : null);
                                @endphp
                                <tr class="hover:bg-[#f8faf9]/70 transition-colors">
                                    <td class="px-4 py-3 text-center text-xs text-[#5c706b]">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 text-xs font-mono text-[#5c706b]">{{ $aluno->RA }}</td>
                                    <td class="px-5 py-3 text-sm font-semibold text-[#0a241e]">
                                        {{ $aluno->NomeAluno }}
                                        <input type="hidden" name="tb_aluno_idAluno[{{ $index }}]" value="{{ $aluno->idAluno }}">
                                        <input type="hidden" name="RA[{{ $index }}]" value="{{ $aluno->RA }}">
                                    </td>

                                    @if($nivel === 'fun2')
                                        <td class="px-4 py-3 text-center">
                                            <input type="number" step="0.1" min="0" max="10"
                                                   name="{{ $mensalCampo }}[{{ $index }}]"
                                                   value="{{ $mensal > 0 ? $mensal : '' }}"
                                                   placeholder="0,0"
                                                   class="w-24 mx-auto rounded-lg border border-[#d8e5df] px-2.5 py-1.5 text-center text-sm text-[#0a241e] outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10"
                                                   data-monthly-input>
                                        </td>
                                    @endif

                                    <td class="px-4 py-3 text-center">
                                        <input type="number" step="0.1" min="0" max="10"
                                               name="{{ $notaCampo }}[{{ $index }}]"
                                               value="{{ $base > 0 ? $base : '' }}"
                                               placeholder="0,0"
                                               class="w-24 mx-auto rounded-lg border border-[#d8e5df] px-2.5 py-1.5 text-center text-sm text-[#0a241e] outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10"
                                               data-base-input>
                                    </td>

                                    @if($nivel !== 'inf')
                                        <td class="px-4 py-3 text-center">
                                            <input type="number" step="0.1" min="0" max="10"
                                                   name="{{ $recuperacaoCampo }}[{{ $index }}]"
                                                   value="{{ $rec > 0 ? $rec : '' }}"
                                                   placeholder="Opcional"
                                                   class="w-24 mx-auto rounded-lg border border-[#d8e5df] px-2.5 py-1.5 text-center text-sm text-[#0a241e] outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10"
                                                   data-recovery-input>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-flex min-w-12 justify-center rounded-full px-2.5 py-0.5 text-xs font-bold {{ $mediaFinal !== null && $mediaFinal >= 7 ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}" data-final-note>
                                                {{ $mediaFinal !== null ? number_format($mediaFinal, 1, ',', '.') : '-' }}
                                            </span>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rodapé fixo ou alinhado com acao -->
            <div class="flex flex-wrap items-center justify-between gap-4 p-4 bg-white border border-[#e3e8e6] rounded-2xl shadow-2xs">
                <div class="text-xs text-[#5c706b]">
                    Total de alunos: <strong>{{ $alunos->count() }}</strong>
                    @if($nivel !== 'inf')
                        · Notas de 0 a 10 · Média mínima para aprovação: 7,0
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ url('/docente/notas') }}" class="inline-flex items-center gap-2 rounded-lg border border-[#d8e5df] px-4 py-2.5 text-sm font-medium text-[#5c706b] hover:bg-[#f8faf9] transition-colors">
                        <i data-lucide="arrow-left" class="h-4 w-4"></i> Voltar
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#008a4b] hover:bg-[#00703c] px-6 py-2.5 text-sm font-semibold text-white transition-colors shadow-xs">
                        <i data-lucide="save" class="h-4 w-4"></i> Salvar Notas da Turma
                    </button>
                </div>
            </div>
        </form>
    @endif

</div>

@if($nivel !== 'inf')
<script>
    document.querySelectorAll('[data-batch-note-form]').forEach(function (form) {
        form.querySelectorAll('tbody tr').forEach(function (row) {
            const baseInput = row.querySelector('[data-base-input]');
            const monthlyInput = row.querySelector('[data-monthly-input]');
            const recoveryInput = row.querySelector('[data-recovery-input]');
            const finalNote = row.querySelector('[data-final-note]');
            if (!baseInput || !finalNote) return;

            const updateFinal = function () {
                const baseVal = baseInput.value.trim();
                const base = baseVal !== '' ? (Number.parseFloat(baseVal.replace(',', '.')) || 0) : null;
                const monthlyVal = monthlyInput ? monthlyInput.value.trim() : '';
                const monthly = monthlyVal !== '' ? (Number.parseFloat(monthlyVal.replace(',', '.')) || 0) : null;
                const recVal = recoveryInput ? recoveryInput.value.trim() : '';
                const rec = recVal !== '' ? (Number.parseFloat(recVal.replace(',', '.')) || 0) : null;

                const valid = [];
                if (monthly !== null) valid.push(monthly);
                if (base !== null) valid.push(base);

                if (!valid.length) {
                    finalNote.textContent = '-';
                    finalNote.className = 'inline-flex min-w-12 justify-center rounded-full px-2.5 py-0.5 text-xs font-bold bg-[#f8faf9] text-[#5c706b]';
                    return;
                }

                const partial = valid.reduce((s, v) => s + v, 0) / valid.length;
                if (partial < 7 && rec !== null) {
                    const minIdx = valid.indexOf(Math.min(...valid));
                    if (rec > valid[minIdx]) {
                        valid[minIdx] = rec;
                    }
                }

                const finalValue = valid.reduce((s, v) => s + v, 0) / valid.length;
                finalNote.textContent = finalValue.toFixed(1).replace('.', ',');
                finalNote.className = 'inline-flex min-w-12 justify-center rounded-full px-2.5 py-0.5 text-xs font-bold ' +
                    (finalValue >= 7 ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700');
            };

            baseInput.addEventListener('input', updateFinal);
            if (monthlyInput) monthlyInput.addEventListener('input', updateFinal);
            if (recoveryInput) recoveryInput.addEventListener('input', updateFinal);
        });
    });
</script>
@endif
@endsection
