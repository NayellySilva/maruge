<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo ?? 'Boletim Escolar - Fundamental I' }}</title>
    <x-estilo-impressao arquivo="boletim" />
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
            <p class="boletim-subtitle">FUNDAMENTAL I</p>
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

        <!-- Tabela de Notas -->
        <table class="boletim-table">
            <thead>
                <tr>
                    <th style="width: 40px;">CÓD</th>
                    <th style="width: 140px;" class="text-left">DISCIPLINA</th>
                    <th style="width: 50px;">1º BIM</th>
                    <th style="width: 50px;">REC.1</th>
                    <th style="width: 50px;">2º BIM</th>
                    <th style="width: 50px;">REC.2</th>
                    <th style="width: 50px;">REC.P</th>
                    <th style="width: 50px;">3º BIM</th>
                    <th style="width: 50px;">REC.3</th>
                    <th style="width: 50px;">4º BIM</th>
                    <th style="width: 50px;">REC.4</th>
                    <th style="width: 50px;">REC.F</th>
                    <th style="width: 55px;">MÉDIA</th>
                    <th style="width: 90px;">RESULTADO</th>
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
                                $rb1_orig = $nota->RB1 ?? 0;
                                $rb2_orig = $nota->RB2 ?? 0;
                                $rb3_orig = $nota->RB3 ?? 0;
                                $rb4_orig = $nota->RB4 ?? 0;

                                $ab1_orig = $nota->AB1 ?? 0;
                                $ab2_orig = $nota->AB2 ?? 0;
                                $ab3_orig = $nota->AB3 ?? 0;
                                $ab4_orig = $nota->AB4 ?? 0;

                                $eff1 = ($rb1_orig > 0 && $rb1_orig > $ab1_orig) ? $rb1_orig : $ab1_orig;
                                $eff2 = ($rb2_orig > 0 && $rb2_orig > $ab2_orig) ? $rb2_orig : $ab2_orig;
                                $eff3 = ($rb3_orig > 0 && $rb3_orig > $ab3_orig) ? $rb3_orig : $ab3_orig;
                                $eff4 = ($rb4_orig > 0 && $rb4_orig > $ab4_orig) ? $rb4_orig : $ab4_orig;

                                $mediaN = ($eff1 + $eff2 + $eff3 + $eff4) / 4; 
                                $mediaRP = (($nota->RP * 2) + $eff3 + $eff4) / 4; 
                            @endphp
                            <tr>
                                <td>{{ $disciplina->tb_disciplinas_idDisciplinas }}</td>
                                <td class="disc-name">{{ $disciplina->NomeDisciplina }}</td>
                                
                                <!-- AB1 -->
                                <td>
                                    @if($ab1_orig == 0) -
                                    @elseif($ab1_orig < 7) <span class="nota-vermelha">{{ number_format($ab1_orig, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($ab1_orig, 1) }}</span> @endif
                                </td>

                                <!-- RB1 -->
                                <td>
                                    @if($rb1_orig == 0) -
                                    @elseif($rb1_orig < 7) <span class="nota-vermelha">{{ number_format($rb1_orig, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($rb1_orig, 1) }}</span> @endif
                                </td>

                                <!-- AB2 -->
                                <td>
                                    @if($ab2_orig == 0) -
                                    @elseif($ab2_orig < 7) <span class="nota-vermelha">{{ number_format($ab2_orig, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($ab2_orig, 1) }}</span> @endif
                                </td>

                                <!-- RB2 -->
                                <td>
                                    @if($rb2_orig == 0) -
                                    @elseif($rb2_orig < 7) <span class="nota-vermelha">{{ number_format($rb2_orig, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($rb2_orig, 1) }}</span> @endif
                                </td>

                                <!-- RP -->
                                <td>
                                    @if(($nota->RP) == 0) -
                                    @elseif(($nota->RP) < 7) <span class="nota-vermelha">{{ number_format($nota->RP, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($nota->RP, 1) }}</span> @endif
                                </td>

                                <!-- AB3 -->
                                <td>
                                    @if($ab3_orig == 0) -
                                    @elseif($ab3_orig < 7) <span class="nota-vermelha">{{ number_format($ab3_orig, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($ab3_orig, 1) }}</span> @endif
                                </td>

                                <!-- RB3 -->
                                <td>
                                    @if($rb3_orig == 0) -
                                    @elseif($rb3_orig < 7) <span class="nota-vermelha">{{ number_format($rb3_orig, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($rb3_orig, 1) }}</span> @endif
                                </td>

                                <!-- AB4 -->
                                <td>
                                    @if($ab4_orig == 0) -
                                    @elseif($ab4_orig < 7) <span class="nota-vermelha">{{ number_format($ab4_orig, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($ab4_orig, 1) }}</span> @endif
                                </td>

                                <!-- RB4 -->
                                <td>
                                    @if($rb4_orig == 0) -
                                    @elseif($rb4_orig < 7) <span class="nota-vermelha">{{ number_format($rb4_orig, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($rb4_orig, 1) }}</span> @endif
                                </td>

                                <!-- RF -->
                                <td>
                                    @if(($nota->RF) == 0) -
                                    @elseif(($nota->RF) < 7) <span class="nota-vermelha">{{ number_format($nota->RF, 1) }}</span>
                                    @else <span class="nota-azul">{{ number_format($nota->RF, 1) }}</span> @endif
                                </td>

                                <!-- MEDIA E RESULTADO -->
                                @if(($nota->RP) == 0 && ($nota->RF) == 0)
                                    @if($mediaN < 7)
                                        <td><span class="nota-vermelha">{{ number_format($mediaN, 1) }}</span></td>
                                        <td><span class="resultado-recuperacao">RECUPERAÇÃO</span></td>
                                    @else
                                        <td><span class="nota-azul">{{ number_format($mediaN, 1) }}</span></td>
                                        <td><span class="resultado-aprovado">APROVADO</span></td>
                                    @endif
                                @elseif(($nota->RP) != 0 && ($nota->RF) == 0)
                                    @if($mediaRP < 7)
                                        <td><span class="nota-vermelha">{{ number_format($mediaRP, 1) }}</span></td>
                                        <td><span class="resultado-recuperacao">RECUPERAÇÃO FINAL</span></td>
                                    @else
                                        <td><span class="nota-azul">{{ number_format($mediaRP, 1) }}</span></td>
                                        <td><span class="resultado-aprovado">APROVADO (REC)</span></td>
                                    @endif
                                @elseif(($nota->RF) != 0)
                                    @if(($nota->RF) < 7)
                                        <td><span class="nota-vermelha">{{ number_format($nota->RF, 1) }}</span></td>
                                        <td><span class="resultado-recuperacao">REPROVADO</span></td>
                                    @else
                                        <td><span class="nota-azul">{{ number_format($nota->RF, 1) }}</span></td>
                                        <td><span class="resultado-aprovado">APROVADO (REC)</span></td>
                                    @endif
                                @endif
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td>{{ $disciplina->tb_disciplinas_idDisciplinas }}</td>
                            <td class="disc-name">{{ $disciplina->NomeDisciplina }}</td>
                            <td colspan="12">-</td>
                        </tr>
                    @endforelse
                @endforeach
            </tbody>
        </table>

        <!-- Assinaturas -->
        <div class="signatures-container">
            <div class="signatures-row">
                <div class="signature-line">Professor(a)</div>
                <div class="signature-line">Responsável</div>
            </div>
            <div class="obs-lines">
                <div style="font-weight: 700; margin-bottom: 2px;">Observações:</div>
                <div class="obs-line-item"></div>
                <div class="obs-line-item"></div>
            </div>
        </div>
    </div>

</body>
</html>