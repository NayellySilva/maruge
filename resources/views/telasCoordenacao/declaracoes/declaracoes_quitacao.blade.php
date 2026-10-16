@php
    try {
        $escola = $escolas instanceof \Illuminate\Support\Collection ? $escolas->first() : ($escolas ?? \DB::table('tb_dados_escola')->first());
        if (!$escola) {
            $escola = \DB::table('tb_escola')->first();
        }
        $endereco = $escola;
        if (isset($escola->tb_endereco_idEndereco)) {
            $end = \DB::table('tb_endereco')->where('idEndereco', $escola->tb_endereco_idEndereco)->first();
            if ($end) {
                $endereco = $end;
            }
        }
    } catch (\Exception $e) {
        $escola = null;
        $endereco = null;
    }

    $meses = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];
    $dataHojeExtenso = date('d') . ' de ' . ($meses[(int)date('n')] ?? '') . ' de ' . date('Y');
    $diaFormatado = !empty($dia) ? $dia : $dataHojeExtenso;
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo ?? 'Declaração de Quitação Financeira' }}</title>
    <x-estilo-impressao arquivo="declaracao" />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #111827;
            background-color: #f3f4f6;
            padding: 24px;
            font-size: 13pt;
            line-height: 1.8;
        }
        .no-print-bar {
            max-width: 800px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .btn-acao {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
        }
        .btn-imprimir {
            background-color: #008a4b;
            color: #ffffff;
        }
        .btn-imprimir:hover {
            background-color: #00703c;
        }
        .btn-fechar {
            background-color: #f3f4f6;
            color: #374151;
        }
        .btn-fechar:hover {
            background-color: #e5e7eb;
        }
        .folha-declaracao {
            max-width: 800px;
            min-height: 1050px;
            margin: 0 auto;
            background: #ffffff;
            padding: 50px 60px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .cabecalho-timbre {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 16px;
            margin-bottom: 40px;
        }
        .timbre-logo {
            max-width: 130px;
            max-height: 110px;
            object-fit: contain;
            flex-shrink: 0;
        }
        .timbre-texto {
            flex-grow: 1;
            text-align: center;
            font-size: 10.5pt;
            line-height: 1.4;
            color: #000;
        }
        .timbre-nome-escola {
            font-size: 15pt;
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .titulo-doc {
            text-align: center;
            font-size: 22pt;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 40px;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .corpo-declaracao {
            text-align: justify;
            text-indent: 50px;
            font-size: 13.5pt;
            line-height: 2.2;
            margin-bottom: 35px;
        }
        .filiacao-bloco {
            background-color: #fbfbfb;
            border: 1px solid #e0e0e0;
            padding: 16px 24px;
            border-radius: 6px;
            margin-bottom: 40px;
            font-size: 12pt;
            line-height: 1.8;
        }
        .data-emissao {
            text-align: right;
            font-size: 13pt;
            margin-bottom: 60px;
        }
        .area-assinaturas {
            display: flex;
            justify-content: space-around;
            gap: 40px;
            margin-bottom: 30px;
        }
        .bloco-assinatura {
            text-align: center;
            width: 280px;
        }
        .linha-assinatura {
            border-top: 1px solid #000;
            margin-bottom: 6px;
        }
        .cargo-assinatura {
            font-size: 11pt;
            font-weight: bold;
        }
        .nota-rodape {
            text-align: center;
            font-size: 9.5pt;
            color: #555;
            border-top: 1px solid #ddd;
            padding-top: 12px;
            margin-top: 20px;
            font-style: italic;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .no-print-bar {
                display: none !important;
            }
            .folha-declaracao {
                box-shadow: none;
                border: none;
                padding: 20px 30px;
                min-height: auto;
                max-width: 100%;
            }
            .filiacao-bloco {
                border-color: #ccc;
                background-color: #fff;
            }
        }
    </style>
</head>
<body>

    <!-- Barra de Impressão -->
    <div class="no-print-bar">
        <span>Visualização do Documento — Declaração de Quitação de Débitos</span>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn-acao btn-imprimir">
                Imprimir Declaração
            </button>
            <button onclick="window.close()" class="btn-acao btn-fechar">
                Fechar
            </button>
        </div>
    </div>

    <!-- Conteúdo da Declaração -->
    <div class="folha-declaracao">
        <div>
            <!-- Timbre -->
            <div class="cabecalho-timbre">
                <img src="{{ \App\Support\LogoColegio::src() }}" alt="Logo Escola" class="timbre-logo">
                <div class="timbre-texto">
                    <div class="timbre-nome-escola">{{ $escola->NomeEscola ?? 'COLÉGIO CARINHO DA MAMÃE' }}</div>
                    {{ $endereco->Rua ?? 'Rua Principal' }}, {{ $endereco->Numero ?? 'S/N' }} — {{ $endereco->Bairro ?? 'Bairro' }}<br>
                    CEP: {{ $endereco->CEP ?? '' }} — {{ $endereco->Cidade ?? '' }} / {{ $endereco->Estado ?? '' }}<br>
                    Telefone(s): {{ $endereco->Fone1 ?? '' }} @if(!empty($endereco->Fone2)) / {{ $endereco->Fone2 }} @endif — E-mail: {{ $escola->EmailColegio ?? '' }}<br>
                    CNPJ: {{ $escola->CNPJ ?? '' }} | INEP: {{ $escola->NumeroInep ?? '' }}<br>
                    Portaria CME Nº 020/2024 // CEE - Resolução nº: 524/2026
                </div>
            </div>

            <!-- Título -->
            <div class="titulo-doc">DECLARAÇÃO DE QUITAÇÃO</div>

            <!-- Texto Principal -->
            <div class="corpo-declaracao">
                Declaramos para os devidos fins de direito que em relação ao(à) aluno(a) <strong>{{ $aluno->NomeAluno ?? 'NOME DO ALUNO' }}</strong>,
                inscrito(a) sob o número de matrícula/RA <strong>{{ $aluno->NumeroMac ?? ($matricula->RA ?? 'NÃO INFORMADO') }}</strong>,
                turma do <strong>{{ $turma->NomeTurma ?? 'Ensino Regular' }}</strong>, <strong>NADA CONSTA EM ABERTO</strong> a título de mensalidades
                ou encargos escolares referentes ao ano letivo de <strong>{{ $turma->AnoLetivo ?? date('Y') }}</strong>, encontrando-se suas obrigações
                financeiras integralmente quitadas perante o setor financeiro desta instituição de ensino até a presente data (Art. 1º da Lei nº 12.007/2009).
            </div>

            <!-- Responsáveis / Filiação -->
            <div class="filiacao-bloco">
                <strong>Responsáveis Financeiros / Filiação:</strong><br>
                <strong>Pai:</strong> {{ $pais->NomePai ?? 'Não informado' }}<br>
                <strong>Mãe:</strong> {{ $pais->NomeMae ?? 'Não informada' }}
            </div>

            <!-- Data de Emissão -->
            <div class="data-emissao">
                {{ $escola->Cidade ?? ($endereco->Cidade ?? 'Sede Escolar') }}, {{ $diaFormatado }}.
            </div>
        </div>

        <div>
            <!-- Assinaturas -->
            <div class="area-assinaturas">
                <div class="bloco-assinatura">
                    <div class="linha-assinatura"></div>
                    <div class="cargo-assinatura">Setor Financeiro / Tesouraria</div>
                </div>
                <div class="bloco-assinatura">
                    <div class="linha-assinatura"></div>
                    <div class="cargo-assinatura">Direção Administrativa</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>