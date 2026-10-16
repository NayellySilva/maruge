<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Mapa de Notas Global' }}</title>
    <x-estilo-impressao arquivo="mapa" />
</head>
<body>

    <div class="no-print-bar no-print">
        <button type="button" onclick="window.print()" class="btn-imprimir">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Imprimir Mapa Global
        </button>
    </div>

    <div class="report-card">
        <div class="school-header">
            <img src="{{ \App\Support\LogoColegio::src() }}" class="school-logo" alt="Logo Escola">
            @forelse($escolas as $escola)
                <div class="school-info">
                    {{ $escola->Rua }} , {{ $escola->Numero }} - {{ $escola->Bairro }} - CEP: {{ $escola->CEP }}<br>
                    {{ $escola->Cidade }} - {{ $escola->Estado }} | Tel: {{ $escola->Fone1 }} / {{ $escola->Fone2 }}<br>
                    E-mail: {{ $escola->EmailColegio }} | CNPJ: {{ $escola->CNPJ }} - INEP: {{ $escola->NumeroInep }}
                </div>
            @empty
                <div class="school-info">COLÉGIO MARUGE</div>
            @endforelse
        </div>

        <div class="mapa-header">
            <h1 class="mapa-title">MAPA DE NOTA GLOBAL - {{ $turma->AnoLetivo }}</h1>
            <p class="mapa-subtitle">TURMA - {{ $turma->NomeTurma }}</p>
        </div>

        <table class="mapa-table">
            <thead>
                <tr>
                    <th style="width: 70px;">RA</th>
                    <th style="width: 80px;">SITUAÇÃO</th>
                    <th class="text-left" style="min-width: 200px;">ALUNO</th>
                    @foreach($disciplinas as $disciplina)
                        <th>{{ mb_strtoupper(mb_substr($disciplina->NomeDisciplina, 0, 4)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($Alunos as $Aluno)
                    <tr>
                        <td>{{ $Aluno->RA }}</td>
                        <td>{{ $Aluno->SituacaoAluno }}</td>
                        <td class="aluno-nome">{{ $Aluno->NomeAluno }}</td>
                        @foreach($disciplinas as $disciplina)
                            @php
                                $notasDoAluno = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($Aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
                            @endphp
                            @forelse($notasDoAluno as $nota)
                                @if(isset($nota->AB4))
                                    @php
                                        $mediaN = (($nota->AB1 ?? 0) + ($nota->AB2 ?? 0) + ($nota->AB3 ?? 0) + ($nota->AB4 ?? 0)) / 4;
                                        $mediaRP = ((($nota->RP ?? 0) * 2) + ($nota->AB3 ?? 0) + ($nota->AB4 ?? 0)) / 4;
                                        $valFinal = $mediaN;
                                        if (($nota->RF ?? 0) > 0) {
                                            $valFinal = $nota->RF;
                                        } elseif (($nota->RP ?? 0) > 0) {
                                            $valFinal = $mediaRP;
                                        }
                                    @endphp
                                    @if($valFinal < 7)
                                        <td><span class="nota-vermelha">{{ number_format($valFinal, 1) }}</span></td>
                                    @else
                                        <td><span class="nota-azul">{{ number_format($valFinal, 1) }}</span></td>
                                    @endif
                                @endif
                            @empty
                                <td><span class="valor-x">X</span></td>
                            @endforelse
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 3 + count($disciplinas) }}">Nenhum aluno encontrado nesta turma.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>