@extends('layouts.app')

@section('content')

@php
    date_default_timezone_set('America/Sao_Paulo');
    $turma = $turma ?? null;
    $Alunos = $Alunos ?? collect();

    // Se a turma não possuir alunos cadastrados no banco de dados, gera alunos fictícios para testes
    if ($Alunos->isEmpty()) {
        $Alunos = collect([
            (object)['idAluno' => 101, 'RA' => '2026001', 'NomeAluno' => 'ANA CLARA SILVA'],
            (object)['idAluno' => 102, 'RA' => '2026002', 'NomeAluno' => 'BRUNO HENRIQUE SANTOS'],
            (object)['idAluno' => 103, 'RA' => '2026003', 'NomeAluno' => 'CARLOS EDUARDO OLIVEIRA'],
            (object)['idAluno' => 104, 'RA' => '2026004', 'NomeAluno' => 'DANIELA SOUZA MARTINS'],
            (object)['idAluno' => 105, 'RA' => '2026005', 'NomeAluno' => 'GABRIEL FERREIRA ALVES'],
            (object)['idAluno' => 106, 'RA' => '2026006', 'NomeAluno' => 'ISABELA RIBEIRO COSTA'],
            (object)['idAluno' => 107, 'RA' => '2026007', 'NomeAluno' => 'LUCAS RODRIGUES LIMA'],
        ]);
    }
    
    $dia = str_pad((string)($dia ?? date('d')), 2, '0', STR_PAD_LEFT);
    $mes = str_pad((string)($mes ?? date('m')), 2, '0', STR_PAD_LEFT);
    $ano = (string)($ano ?? date('Y'));
    
    $inf_dia = "{$dia}/{$mes}/{$ano}";
    $dataInputVal = "{$ano}-{$mes}-{$dia}";
    $titulo = $titulo ?? 'Frequência Virtual';
    $frequenciasDia = $frequenciasDia ?? [];
@endphp

<div class="flex flex-col gap-6 w-full">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/frequencia/frequencias') }}" class="hover:text-[#008a4b] transition-colors">Frequência</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Frequência Virtual</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Frequência Virtual</h1>
            <p class="text-sm text-[#5c706b]">
                Turma: <strong>{{ $turma->NomeTurma ?? 'Turma' }}</strong>
                @if(isset($turma->Turno))
                    &bull; Turno: <strong>{{ $turma->Turno }}</strong>
                @endif
                &bull; Total: <strong>{{ count($Alunos) }} alunos</strong>
            </p>
        </div>
    </div>

    <!-- Card Principal com o Formulário de Chamada -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-6 w-full">

        <!-- Mensagens de Alerta e Feedback -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl text-sm font-medium flex items-center gap-2">
                <i data-lucide="check-circle" class="w-4 h-4 text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if((isset($errors) ? count($errors) : 0) > 0)
            <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-xl text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulário de Gravação da Frequência -->
        <form action="{{ url('/coordenacao/frequencia_cad') }}" method="POST" id="form-frequencia" class="flex flex-col gap-6 w-full">
            @csrf

            <!-- Barra de Seleção de Data e Ação em Lote -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 bg-[#f8faf9] p-4 rounded-xl border border-[#e3e8e6]">
                
                <!-- Seletor de Data -->
                <div class="flex items-center gap-3">
                    <label for="input-data-chamada" class="text-sm font-medium text-[#0a241e] shrink-0">Data da Chamada:</label>
                    <div class="relative flex items-center">
                        <input
                            type="date"
                            id="input-data-chamada"
                            name="data_chamada"
                            value="{{ $dataSelecionada ?? $dataInputVal ?? now()->format('Y-m-d') }}"
                            onchange="alterarDataUnificada(this.value)"
                            class="h-10 px-3 bg-white border border-[#e3e8e6] rounded-xl text-sm font-semibold text-[#0a241e] focus:outline-none focus:border-[#008a4b] cursor-pointer shadow-2xs"
                        />
                    </div>
                    <button
                        type="button"
                        onclick="irParaHoje()"
                        class="h-10 px-3 text-xs font-medium bg-white text-[#5c706b] border border-[#e3e8e6] hover:text-[#008a4b] hover:border-[#008a4b]/40 rounded-xl transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs"
                        title="Ir para a data de hoje"
                    >
                        <i data-lucide="rotate-ccw" class="w-3.5 h-3.5"></i>
                        <span>Hoje</span>
                    </button>
                </div>

                <!-- Botão de Ação Rápida -->
                <button
                    type="button"
                    onclick="marcarTodosPresentes()"
                    class="h-10 px-4 text-xs font-medium bg-[#ecfdf5] text-[#008a4b] border border-[#a7f3d0] hover:bg-[#d1fae5] rounded-xl transition-all flex items-center justify-center gap-2 cursor-pointer shadow-2xs"
                >
                    <i data-lucide="check-check" class="w-4 h-4"></i>
                    <span>Marcar Todos como PRESENTE</span>
                </button>

            </div>

            <!-- Tabela de Alunos -->
            <div class="border border-[#e3e8e6] rounded-xl overflow-hidden shadow-2xs w-full">
                <div class="overflow-x-auto custom-scroll w-full">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#f8faf9] border-b border-[#e3e8e6]">
                            <tr>
                                <th class="px-4 py-3.5 font-semibold text-[#5c706b] w-12 text-center">#</th>
                                <th class="px-4 py-3.5 font-semibold text-[#5c706b] w-28">RA</th>
                                <th class="px-4 py-3.5 font-semibold text-[#5c706b]">Nome do Aluno</th>
                                <th class="px-4 py-3.5 font-semibold text-[#5c706b] text-center min-w-[500px]">
                                    Presença / Situação <span class="text-xs font-normal text-[#008a4b]">({{ $dia }}/{{ $mes }}/{{ $ano }})</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e3e8e6] bg-white">
                            @forelse($Alunos as $key => $Aluno)
                                @php
                                    $situacaoSalva = $frequenciasDia[$Aluno->idAluno] ?? 'PRESENTE';
                                    $situacaoUpper = strtoupper(trim($situacaoSalva));
                                    if ($situacaoUpper === 'P') $situacaoUpper = 'PRESENTE';
                                    elseif ($situacaoUpper === 'F') $situacaoUpper = 'FALTA';
                                    elseif ($situacaoUpper === 'FJ') $situacaoUpper = 'JUSTIFICADO';
                                    elseif ($situacaoUpper === 'A') $situacaoUpper = 'ATESTADO';
                                @endphp
                                <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                                    <td class="px-4 py-3.5 text-center text-[#5c706b] font-medium text-xs">
                                        {{ $key + 1 }}
                                    </td>
                                    <td class="px-4 py-3.5 text-[#5c706b] font-medium text-xs whitespace-nowrap">
                                        {{ $Aluno->RA }}
                                    </td>
                                    <td class="px-4 py-3.5 text-[#0a241e] font-semibold text-sm">
                                        {{ mb_strtoupper($Aluno->NomeAluno) }}
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <!-- Campos Ocultos com Dados do Aluno -->
                                        <input type="hidden" name="ano[{{$key}}]" value="{{ $ano }}">
                                        <input type="hidden" name="RA[{{$key}}]" value="{{ $Aluno->RA }}">
                                        <input type="hidden" name="tb_aluno_idAluno[{{$key}}]" value="{{ $Aluno->idAluno }}">
                                        <input type="hidden" name="tb_turmas_idTurmas[{{$key}}]" value="{{ $turma->idTurmas ?? '' }}">
                                        <input type="hidden" name="inf_dia[{{$key}}]" value="{{ $inf_dia }}">
                                        <input type="hidden" name="dia[{{$key}}]" value="{{ $dia }}">
                                        <input type="hidden" name="mes[{{$key}}]" value="{{ $mes }}">

                                        <!-- Botões Segmentados de Situação -->
                                        <div class="inline-flex flex-wrap gap-2 items-center justify-center">
                                            <!-- PRESENTE -->
                                            <label
                                                class="btn-situacao cursor-pointer text-xs font-semibold px-3 py-1.5 rounded-xl border transition-all flex items-center gap-1.5 select-none shrink-0"
                                                style="{{ $situacaoUpper === 'PRESENTE' ? 'background-color: #059669; color: #ffffff; border-color: #059669;' : 'background-color: #ecfdf5; color: #047857; border-color: #a7f3d0;' }}"
                                            >
                                                <input type="radio" name="situacao[{{$key}}]" value="PRESENTE" {{ $situacaoUpper === 'PRESENTE' ? 'checked' : '' }} onchange="atualizarEstiloOpcao(this)" class="hidden">
                                                <i data-lucide="check-circle-2" class="w-3.5 h-3.5 shrink-0"></i>
                                                <span>PRESENTE</span>
                                            </label>

                                            <!-- JUSTIFICADO -->
                                            <label
                                                class="btn-situacao cursor-pointer text-xs font-semibold px-3 py-1.5 rounded-xl border transition-all flex items-center gap-1.5 select-none shrink-0"
                                                style="{{ $situacaoUpper === 'JUSTIFICADO' ? 'background-color: #d97706; color: #ffffff; border-color: #d97706;' : 'background-color: #fffbeb; color: #b45309; border-color: #fde68a;' }}"
                                            >
                                                <input type="radio" name="situacao[{{$key}}]" value="JUSTIFICADO" {{ $situacaoUpper === 'JUSTIFICADO' ? 'checked' : '' }} onchange="atualizarEstiloOpcao(this)" class="hidden">
                                                <i data-lucide="alert-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                                <span>JUSTIFICADO</span>
                                            </label>

                                            <!-- ATESTADO -->
                                            <label
                                                class="btn-situacao cursor-pointer text-xs font-semibold px-3 py-1.5 rounded-xl border transition-all flex items-center gap-1.5 select-none shrink-0"
                                                style="{{ $situacaoUpper === 'ATESTADO' ? 'background-color: #0284c7; color: #ffffff; border-color: #0284c7;' : 'background-color: #f0f9ff; color: #0369a1; border-color: #bae6fd;' }}"
                                            >
                                                <input type="radio" name="situacao[{{$key}}]" value="ATESTADO" {{ $situacaoUpper === 'ATESTADO' ? 'checked' : '' }} onchange="atualizarEstiloOpcao(this)" class="hidden">
                                                <i data-lucide="file-text" class="w-3.5 h-3.5 shrink-0"></i>
                                                <span>ATESTADO</span>
                                            </label>

                                            <!-- FALTA -->
                                            <label
                                                class="btn-situacao cursor-pointer text-xs font-semibold px-3 py-1.5 rounded-xl border transition-all flex items-center gap-1.5 select-none shrink-0"
                                                style="{{ $situacaoUpper === 'FALTA' ? 'background-color: #e11d48; color: #ffffff; border-color: #e11d48;' : 'background-color: #fff1f2; color: #be123c; border-color: #fecdd3;' }}"
                                            >
                                                <input type="radio" name="situacao[{{$key}}]" value="FALTA" {{ $situacaoUpper === 'FALTA' ? 'checked' : '' }} onchange="atualizarEstiloOpcao(this)" class="hidden">
                                                <i data-lucide="x-circle" class="w-3.5 h-3.5 shrink-0"></i>
                                                <span>FALTA</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center text-sm text-[#95aba5]">
                                        Nenhum aluno encontrado para esta turma.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Botões de Ação do Rodapé -->
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm text-sm cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>SALVAR FREQUÊNCIA</span>
                </button>
                <a href="{{ url('/coordenacao/frequencia/frequencias') }}" class="bg-white hover:bg-[#f8faf9] text-[#5c706b] border border-[#e3e8e6] font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all text-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    <span>Voltar</span>
                </a>
            </div>
        </form>

    </div>

</div>

<script>
    function alterarDataUnificada(dataVal) {
        if (!dataVal) return;
        const parts = dataVal.split('-');
        if (parts.length === 3) {
            const ano = parts[0];
            const mes = parts[1];
            const dia = parts[2];
            const idTurma = {{ $turma->idTurmas ?? 0 }};
            window.location.href = `{{ url('/coordenacao/frequencia_virtual') }}/${idTurma}?dia=${dia}&mes=${mes}&ano=${ano}`;
        }
    }

    function irParaHoje() {
        const idTurma = {{ $turma->idTurmas ?? 0 }};
        window.location.href = `{{ url('/coordenacao/frequencia_virtual') }}/${idTurma}`;
    }

    function marcarTodosPresentes() {
        const radiosPresentes = document.querySelectorAll('input[type="radio"][value="PRESENTE"]');
        radiosPresentes.forEach(radio => {
            radio.checked = true;
            atualizarEstiloOpcao(radio);
        });
    }

    function atualizarEstiloOpcao(inputRadio) {
        const parentContainer = inputRadio.closest('td');
        if (!parentContainer) return;

        const labels = parentContainer.querySelectorAll('label.btn-situacao');
        labels.forEach(lbl => {
            const radio = lbl.querySelector('input[type="radio"]');
            const val = radio.value;

            if (radio.checked) {
                if (val === 'PRESENTE') {
                    lbl.style.backgroundColor = '#059669';
                    lbl.style.color = '#ffffff';
                    lbl.style.borderColor = '#059669';
                } else if (val === 'JUSTIFICADO') {
                    lbl.style.backgroundColor = '#d97706';
                    lbl.style.color = '#ffffff';
                    lbl.style.borderColor = '#d97706';
                } else if (val === 'ATESTADO') {
                    lbl.style.backgroundColor = '#0284c7';
                    lbl.style.color = '#ffffff';
                    lbl.style.borderColor = '#0284c7';
                } else if (val === 'FALTA') {
                    lbl.style.backgroundColor = '#e11d48';
                    lbl.style.color = '#ffffff';
                    lbl.style.borderColor = '#e11d48';
                }
            } else {
                if (val === 'PRESENTE') {
                    lbl.style.backgroundColor = '#ecfdf5';
                    lbl.style.color = '#047857';
                    lbl.style.borderColor = '#a7f3d0';
                } else if (val === 'JUSTIFICADO') {
                    lbl.style.backgroundColor = '#fffbeb';
                    lbl.style.color = '#b45309';
                    lbl.style.borderColor = '#fde68a';
                } else if (val === 'ATESTADO') {
                    lbl.style.backgroundColor = '#f0f9ff';
                    lbl.style.color = '#0369a1';
                    lbl.style.borderColor = '#bae6fd';
                } else if (val === 'FALTA') {
                    lbl.style.backgroundColor = '#fff1f2';
                    lbl.style.color = '#be123c';
                    lbl.style.borderColor = '#fecdd3';
                }
            }
        });
    }
</script>

@endsection