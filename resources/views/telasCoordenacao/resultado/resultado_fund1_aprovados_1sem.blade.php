<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Resultados - 1º Semestre' }}</title>
    <x-estilo-impressao arquivo="resultado" />
</head>
<body>

    @php
        if (!isset($escolas) || empty($escolas) || !isset($escolas->first()->Rua)) {
            try { $escolas = \App\Models\modelCoordenacao\tb_escola::informacaoEscolar(); } catch (\Exception $e) { $escolas = collect(); }
        }
    @endphp

    <div class="no-print-bar no-print">
        <button type="button" onclick="window.print()" class="btn-imprimir">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Imprimir Resultados
        </button>
    </div>

    <div class="report-card">
        <div class="school-header">
            <img src="{{ \App\Support\LogoColegio::src() }}" class="school-logo" alt="Logo Escola">
            @forelse($escolas as $escola)
                <div class="school-info">
                    {{ $escola->Rua ?? '' }} , {{ $escola->Numero ?? '' }} - {{ $escola->Bairro ?? '' }} - CEP: {{ $escola->CEP ?? '' }}<br>
                    {{ $escola->Cidade ?? '' }} - {{ $escola->Estado ?? '' }} | Tel: {{ $escola->Fone1 ?? '' }} / {{ $escola->Fone2 ?? '' }}<br>
                    E-mail: {{ $escola->EmailColegio ?? '' }} | CNPJ: {{ $escola->CNPJ ?? '' }} - INEP: {{ $escola->NumeroInep ?? '' }}
                </div>
            @empty
                <div class="school-info">COLÉGIO MARUGE</div>
            @endforelse
        </div>

        <div class="resultado-header">
            <h1 class="resultado-title">{{ $titulo ?? 'RESULTADOS - 1º SEMESTRE' }} - {{ $turma->AnoLetivo ?? '' }}</h1>
            <p class="resultado-subtitle">TURMA - {{ $turma->NomeTurma ?? '' }}</p>
        </div>

        @forelse($professores as $professor)
            @if(isset($professor->NomeFuncionario))
                <div class="subject-panel">
                    <div class="subject-panel-header">
                        <strong>{{ $professor->NomeDisciplina }}:</strong> &nbsp; {{ $professor->NomeFuncionario }}
                    </div>
                    <table class="resultado-table">
                        <thead>
                            <tr>
                                <th style="width: 70px;">RA</th>
                                <th class="aluno-nome">NOME ALUNO</th>
                                <th style="width: 100px;">1º BIMESTRE</th>
                                <th style="width: 100px;">2º BIMESTRE</th>
                                <th style="width: 130px;">MÉDIA 1º SEMESTRE</th>
                                <th style="width: 120px;">SITUAÇÃO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($professor->alunos ?? [] as $aluno)
                                <tr>
                                    <td>{{ $aluno->RA }}</td>
                                    <td class="aluno-nome">{{ $aluno->NomeAluno }}</td>
                                    <td>{{ $aluno->Nota_1Bimestre }}</td>
                                    <td>{{ $aluno->Nota_2Bimestre }}</td>
                                    <td><strong>{{ $aluno->Media1Semestre }}</strong></td>
                                    <td>
                                        @if($aluno->Media1Semestre >= 7)
                                            <span class="badge-aprovado">APROVADO</span>
                                        @else
                                            <span class="badge-recuperacao">RECUPERAÇÃO</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="padding: 12px; color: #64748b;">Nenhum aluno encontrado para esta disciplina.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        @empty
            <div style="text-align: center; padding: 20px; color: #64748b;">Nenhuma disciplina ou professor cadastrado para esta turma.</div>
        @endforelse
    </div>

</body>
</html>