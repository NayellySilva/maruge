<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Boletim Escolar - Educação Infantil' }}</title>
    <x-estilo-impressao arquivo="boletim_inf" />
</head>
<body>

    <!-- Botao de Impressao (Apenas na Tela) -->
    <div class="no-print-bar no-print">
        <button type="button" onclick="window.print()" class="btn-imprimir">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            Imprimir Boletim
        </button>
    </div>

    <div class="report-card">
        <!-- Timbre da Escola -->
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

        <!-- Titulo do Boletim -->
        <div class="boletim-header">
            <h1 class="boletim-title">BOLETIM ESCOLAR</h1>
            <p class="boletim-subtitle">EDUCAÇÃO INFANTIL</p>
        </div>

        <!-- Informacoes do Aluno -->
        <div class="student-info-grid">
            <div class="student-info-item"><span>Aluno(a):</span> <strong>{{ $aluno->NomeAluno }}</strong></div>
            <div class="student-info-item"><span>Nº MAC / RA:</span> <strong>{{ $aluno->NumeroMac ?? $matricula->RA ?? '-' }}</strong></div>
            <div class="student-info-item"><span>Turma:</span> <strong>{{ $turma->NomeTurma }}</strong></div>
            <div class="student-info-item">
                <span>Ano Letivo:</span> 
                <strong>
                    @foreach($anoletivo as $ano)
                        {{ $ano->AnoLetivo }}
                    @endforeach
                </strong>
            </div>
            <div class="student-info-item" style="grid-column: span 2;">
                <span>Filiação:</span> <strong>{{ $Pais->NomePai ?? '-' }} / {{ $Pais->NomeMae ?? '-' }}</strong>
            </div>
        </div>

        <!-- Legenda de Conceitos -->
        <div class="legenda-box">
            <span><strong>E:</strong> EXCELENTE (10)</span>
            <span><strong>O:</strong> ÓTIMO (9)</span>
            <span><strong>B:</strong> BOM (8)</span>
            <span><strong>S:</strong> SATISFATÓRIO (7)</span>
        </div>

        <!-- Tabela de Notas/Conceitos -->
        <table class="boletim-table">
            <thead>
                <tr>
                    <th style="width: 45px;">CÓD</th>
                    <th class="text-left">CAMPOS DE EXPERIÊNCIAS</th>
                    <th style="width: 65px;">1º BIM</th>
                    <th style="width: 65px;">2º BIM</th>
                    <th style="width: 65px;">3º BIM</th>
                    <th style="width: 65px;">4º BIM</th>
                    <th style="width: 65px;">MÉDIA</th>
                    <th style="width: 100px;">RESULTADO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($disciplinas as $disciplina)
                    @php
                        $notasDoAluno = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
                    @endphp
                    @forelse($notasDoAluno as $nota)
                        @if(isset($nota->AB1))
                            @php
                                $c1 = $nota->AB1 == 0 ? '-' : ($nota->AB1 < 8 ? 'S' : ($nota->AB1 < 9 ? 'B' : ($nota->AB1 < 10 ? 'O' : 'E')));
                                $c2 = $nota->AB2 == 0 ? '-' : ($nota->AB2 < 8 ? 'S' : ($nota->AB2 < 9 ? 'B' : ($nota->AB2 < 10 ? 'O' : 'E')));
                                $c3 = $nota->AB3 == 0 ? '-' : ($nota->AB3 < 8 ? 'S' : ($nota->AB3 < 9 ? 'B' : ($nota->AB3 < 10 ? 'O' : 'E')));
                                $c4 = $nota->AB4 == 0 ? '-' : ($nota->AB4 < 8 ? 'S' : ($nota->AB4 < 9 ? 'B' : ($nota->AB4 < 10 ? 'O' : 'E')));
                                $mediaVal = ($nota->AB1 + $nota->AB2 + $nota->AB3 + $nota->AB4) / 4;
                                $cm = $mediaVal == 0 ? '-' : ($mediaVal < 8 ? 'S' : ($mediaVal < 9 ? 'B' : ($mediaVal < 10 ? 'O' : 'E')));
                            @endphp
                            <tr>
                                <td>{{ $disciplina->tb_disciplinas_idDisciplinas }}</td>
                                <td class="disc-name">{{ $disciplina->NomeDisciplina }}</td>
                                <td><span class="conceito-badge">{{ $c1 }}</span></td>
                                <td><span class="conceito-badge">{{ $c2 }}</span></td>
                                <td><span class="conceito-badge">{{ $c3 }}</span></td>
                                <td><span class="conceito-badge">{{ $c4 }}</span></td>
                                <td><span class="conceito-badge">{{ $cm }}</span></td>
                                <td>
                                    @if($mediaVal < 6)
                                        <span class="resultado-reprovado">REPROVADO</span>
                                    @else
                                        <span class="resultado-aprovado">APROVADO</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td>{{ $disciplina->tb_disciplinas_idDisciplinas }}</td>
                            <td class="disc-name">{{ $disciplina->NomeDisciplina }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @endforelse
                @endforeach
            </tbody>
        </table>

        <!-- Legenda de Campos de Experiencia -->
        <div class="campos-exp-box">
            <strong>Legenda dos Campos de Experiências:</strong><br>
            <strong>CG</strong> - Corpo, Gestos e Movimentos | 
            <strong>EF</strong> - Escuta, Fala, Pensamento e Imaginação | 
            <strong>EO</strong> - O Eu, O Outro e O Nós | 
            <strong>ET</strong> - Espaços, Tempos, Quantidades, Relações e Transformações | 
            <strong>TS</strong> - Traços, Sons, Cores e Formas
        </div>

        <!-- Assinaturas e Observacao -->
        <div class="signatures-container">
            <div class="signatures-row">
                <div class="signature-line">Professor(a)</div>
                <div class="signature-line">Responsável</div>
            </div>
            <div class="obs-lines">
                <div><strong>Obs:</strong></div>
                <div class="obs-line-item"></div>
                <div class="obs-line-item"></div>
            </div>
        </div>
    </div>

</body>
</html>