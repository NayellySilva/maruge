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
    <title>{{ $titulo ?? 'Declaração Geral de Escolaridade / Situação' }}</title>
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
            font-size: 11.5pt;
            line-height: 1.5;
        }
        .no-print-bar {
            max-width: 820px;
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
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            padding: 35px 50px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.06);
        }
        .cabecalho-timbre {
            display: flex;
            align-items: center;
            gap: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .timbre-logo {
            max-width: 110px;
            max-height: 95px;
            object-fit: contain;
            flex-shrink: 0;
        }
        .timbre-texto {
            flex-grow: 1;
            text-align: center;
            font-size: 10pt;
            line-height: 1.35;
            color: #000;
        }
        .timbre-nome-escola {
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 3px;
            text-transform: uppercase;
        }
        .titulo-doc {
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
            letter-spacing: 3px;
            margin: 15px 0 20px 0;
            text-transform: uppercase;
        }
        .texto-intro {
            font-size: 12pt;
            line-height: 1.6;
            margin-bottom: 14px;
            text-align: justify;
        }
        .caixa {
            border: 1.5px solid #000;
            padding: 8px 12px;
            margin-bottom: 12px;
            border-radius: 6px;
            font-size: 11pt;
            line-height: 1.5;
        }
        .subtitulo-campo {
            font-weight: bold;
            font-size: 11pt;
            margin: 10px 0 4px 0;
        }
        .opcao {
            margin-right: 18px;
            display: inline-block;
        }
        .linha-obs {
            height: 20px;
            border-bottom: 1px solid #000;
            margin-bottom: 6px;
        }
        .data-emissao {
            text-align: center;
            margin-top: 18px;
            font-size: 11pt;
        }
        .nota-rodape {
            text-align: center;
            font-size: 9pt;
            color: #444;
            margin-top: 6px;
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
                padding: 10px 25px;
                max-width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/utilitarios.css')}}">
</head>
<body>

    <!-- Barra de Impressão -->
    <div class="no-print-bar">
        <span>Visualização do Documento — Declaração Geral / Histórico de Situação</span>
        <div class="flex-gap-10">
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
        <div class="titulo-doc">DECLARAÇÃO</div>

        <!-- Texto Principal -->
        <div class="texto-intro">
            Declaramos para os devidos fins que <strong>{{ $aluno->NomeAluno ?? 'NOME DO ALUNO' }}</strong>,
            inscrito(a) sob o número de matrícula/RA <strong>{{ $aluno->NumeroMac ?? ($matricula->RA ?? 'NÃO INFORMADO') }}</strong>,
            aluno(a) desta Unidade Escolar no ano letivo de <strong>{{ $turma->AnoLetivo ?? date('Y') }}</strong>, e:
        </div>

        <!-- Opções de Finalidade -->
        <div class="caixa">
            <p>▢ Está cursando o(a): ____________________________________________________________________</p>
            <p>▢ Cursou Creche (2 e 3 anos)</p>
            <p>▢ Cursou a Pré-Escola: &nbsp; ( &nbsp; ) 4 anos &nbsp;&nbsp; / &nbsp;&nbsp; ( &nbsp; ) 5 anos</p>
            <p>
                ▢ Concluiu o Ensino Fundamental: 
                <span class="opcao">( &nbsp; ) 1º Ano</span>
                <span class="opcao">( &nbsp; ) 2º Ano</span>
                <span class="opcao">( &nbsp; ) 3º Ano</span>
                <span class="opcao">( &nbsp; ) 4º Ano</span>
                <span class="opcao">( &nbsp; ) 5º Ano</span>
            </p>
            <p style="padding-left: 20px;">
                <span class="opcao">( &nbsp; ) 6º Ano</span>
                <span class="opcao">( &nbsp; ) 7º Ano</span>
                <span class="opcao">( &nbsp; ) 8º Ano</span>
                <span class="opcao">( &nbsp; ) 9º Ano</span>
            </p>
            <p style="margin-top: 4px;">
                ▢ Solicitou nesta data sua transferência para outra Unidade Escolar com direito a matricular-se no(a): ________________________________________________. A transferência definitiva será entregue no prazo de <strong>30 dias</strong>.
            </p>
        </div>

        <!-- Consideração -->
        <div class="subtitulo-campo">Tendo sido considerado(a):</div>
        <div class="caixa">
            <span class="opcao">▢ Aprovado(a)</span>
            <span class="opcao">▢ Reprovado(a)</span>
            <span class="opcao">▢ Evadido(a)</span>
            <span class="opcao">▢ Não se aplica</span>
        </div>

        <!-- Frequência -->
        <div class="subtitulo-campo">Com índice de frequência escolar:</div>
        <div class="caixa">
            <span class="opcao">▢ Superior a 75%</span>
            <span class="opcao">▢ Inferior a 75%</span>
            <span class="opcao">▢ Sem registro nesta escola</span>
            <span class="opcao">▢ Não se aplica</span>
        </div>

        <!-- Efeito -->
        <div class="subtitulo-campo">Efeito desta declaração:</div>
        <div class="caixa">
            <span class="opcao">▢ Transferência Escolar</span>
            <span class="opcao">▢ Programa Bolsa Família</span>
            <span class="opcao">▢ Carteira Estudantil</span>
            <p style="margin-top: 4px;">▢ Outros: _________________________________________________________________________________</p>
        </div>

        <!-- Filiação -->
        <div class="subtitulo-campo">Dados adicionais do(a) aluno(a):</div>
        <div class="caixa">
            <p><strong>Data de Nascimento:</strong> {{ $aluno->DataNascimento ?? 'Não informada' }}</p>
            <p><strong>Filiação:</strong> {{ $pais->NomePai ?? '' }} &nbsp;|&nbsp; {{ $pais->NomeMae ?? '' }}</p>
        </div>

        <!-- Observações -->
        <div class="caixa" style="margin-top: 8px;">
            <p><strong>Observações:</strong></p>
            <div class="linha-obs"></div>
            <div class="linha-obs"></div>
        </div>

        <!-- Rodapé -->
        <div class="data-emissao">
            {{ $escola->Cidade ?? ($endereco->Cidade ?? 'Sede Escolar') }}, {{ $diaFormatado }}.
        </div>

        <div style="display: flex; justify-content: space-around; margin-top: 35px;">
            <div style="text-align: center; width: 260px;">
                <div style="border-top: 1px solid #000; margin-bottom: 4px;"></div>
                <div style="font-size: 10.5pt; font-weight: bold;">Secretaria Escolar</div>
            </div>
            <div style="text-align: center; width: 260px;">
                <div style="border-top: 1px solid #000; margin-bottom: 4px;"></div>
                <div style="font-size: 10.5pt; font-weight: bold;">Direção Geral / Carimbo</div>
            </div>
        </div>

        <div class="nota-rodape">
            Esta declaração só terá validade com assinatura e carimbo oficiais da instituição, sem emendas ou rasuras.
        </div>
    </div>

</body>
</html>