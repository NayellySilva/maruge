@php
    try {
        $escolas = $escolas ?? \DB::table('tb_dados_escola')->first();
        if (!$escolas) {
            $escolas = \DB::table('tb_escola')->first();
        }
        $endereco = $endereco ?? $escolas;
        if (!$endereco && isset($escolas->tb_endereco_idEndereco)) {
            $endereco = \DB::table('tb_endereco')->where('idEndereco', $escolas->tb_endereco_idEndereco)->first();
        }
    } catch (\Exception $e) {
        $escolas = null;
        $endereco = null;
    }

    // Carregar indicadores caso venha diretamente pela rota
    try {
        $quantAlunosCadastrados = $quantAlunosCadastrados ?? \App\Models\modelCoordenacao\tb_aluno::quantAlunosCadastrados();
    } catch (\Exception $e) {
        $quantAlunosCadastrados = $quantAlunosCadastrados ?? 0;
    }

    try {
        $quantMatriculasAtivas = $quantMatriculasAtivas ?? \App\Models\modelCoordenacao\tb_matricula::quantMatriculasAtivas();
    } catch (\Exception $e) {
        $quantMatriculasAtivas = $quantMatriculasAtivas ?? 0;
    }

    try {
        $quantMatriculasInativas = $quantMatriculasInativas ?? \App\Models\modelCoordenacao\tb_matricula::quantMatriculasInativas();
    } catch (\Exception $e) {
        $quantMatriculasInativas = $quantMatriculasInativas ?? 0;
    }

    try {
        $quantTurmasAtivas = $quantTurmasAtivas ?? \App\Models\modelCoordenacao\tb_turma::turmasAtivas()->count();
    } catch (\Exception $e) {
        $quantTurmasAtivas = $quantTurmasAtivas ?? 0;
    }

    try {
        $quantDisciplina = $quantDisciplina ?? \App\Models\modelCoordenacao\tb_disciplina::quantDisciplinasCadastradas();
    } catch (\Exception $e) {
        $quantDisciplina = $quantDisciplina ?? 0;
    }

    try {
        $quantFuncionariosCadastrados = $quantFuncionariosCadastrados ?? \App\Models\modelCoordenacao\tb_funcionario::funcionarioCadastrados()->count();
    } catch (\Exception $e) {
        $quantFuncionariosCadastrados = $quantFuncionariosCadastrados ?? 0;
    }

    try {
        $quantUsuarioCadastrados = $quantUsuarioCadastrados ?? \App\Models\modelCoordenacao\tb_usuario::listagemUsuarios()->count();
    } catch (\Exception $e) {
        $quantUsuarioCadastrados = $quantUsuarioCadastrados ?? 0;
    }

    $meses = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];
    $dataHojeExtenso = date('d') . ' de ' . ($meses[(int)date('n')] ?? '') . ' de ' . date('Y');
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Geral da Escola — {{ $escolas->NomeEscola ?? 'Instituição' }}</title>
    <x-estilo-impressao />
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1a202c;
            background-color: #f7fafc;
            padding: 24px;
            font-size: 13px;
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
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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
            background-color: #edf2f7;
            color: #4a5568;
        }
        .btn-fechar:hover {
            background-color: #e2e8f0;
        }
        .folha-relatorio {
            max-width: 820px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .cabecalho-timbre {
            display: flex;
            align-items: center;
            gap: 24px;
            border-bottom: 2px solid #008a4b;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .timbre-logo {
            width: 110px;
            height: 110px;
            object-fit: contain;
            flex-shrink: 0;
        }
        .timbre-info {
            flex-grow: 1;
        }
        .timbre-nome {
            font-size: 19px;
            font-weight: 700;
            color: #0a241e;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .timbre-detalhes {
            font-size: 11.5px;
            color: #4a5568;
            line-height: 1.4;
        }
        .titulo-secao-relatorio {
            background: #f0fdf4;
            border-left: 4px solid #008a4b;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 700;
            color: #0a241e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
            border-radius: 0 6px 6px 0;
        }
        .grid-estatisticas {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 26px;
        }
        .card-stat {
            background: #f8faf9;
            border: 1px solid #e3e8e6;
            border-radius: 10px;
            padding: 14px;
            text-align: center;
        }
        .card-stat-destaque {
            background: #ecfdf5;
            border-color: #a7f3d0;
        }
        .stat-valor {
            font-size: 26px;
            font-weight: 800;
            color: #008a4b;
            line-height: 1.1;
            margin-bottom: 4px;
        }
        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #5c706b;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .tabela-dados {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 26px;
            font-size: 12.5px;
        }
        .tabela-dados th, .tabela-dados td {
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            text-align: left;
        }
        .tabela-dados th {
            background-color: #f8fafc;
            color: #4a5568;
            font-weight: 600;
            width: 32%;
        }
        .tabela-dados td {
            color: #1a202c;
            font-weight: 500;
        }
        .rodape-assinatura {
            margin-top: 48px;
            padding-top: 20px;
            border-top: 1px dashed #cbd5e1;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .bloco-data {
            font-size: 12px;
            color: #4a5568;
        }
        .bloco-carimbo {
            text-align: center;
            width: 280px;
        }
        .linha-assinatura {
            border-top: 1px solid #2d3748;
            margin-bottom: 6px;
        }
        .nome-cargo {
            font-size: 12px;
            font-weight: 700;
            color: #1a202c;
        }
        .sub-cargo {
            font-size: 11px;
            color: #718096;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .no-print-bar {
                display: none !important;
            }
            .folha-relatorio {
                box-shadow: none;
                border: none;
                padding: 10px 20px;
                max-width: 100%;
            }
            .grid-estatisticas {
                grid-template-columns: repeat(4, 1fr) !important;
            }
        }
    </style>
</head>
<body>

    <!-- Barra Superior de Controle (Oculta na Impressão) -->
    <div class="no-print-bar">
        <span style="font-size: 13px; font-weight: 600; color: #4a5568;">Visualização de Impressão — Ficha Institucional</span>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn-acao btn-imprimir">
                Imprimir Relatório
            </button>
            <button onclick="window.close()" class="btn-acao btn-fechar">
                Fechar
            </button>
        </div>
    </div>

    <!-- Conteúdo do Relatório em Papel -->
    <div class="folha-relatorio">

        <!-- Timbre / Cabeçalho Institucional -->
        <div class="cabecalho-timbre">
            <img src="{{ \App\Support\LogoColegio::src() }}" alt="Logo da Escola" class="timbre-logo">
            <div class="timbre-info">
                <div class="timbre-nome">{{ $escolas->NomeEscola ?? 'COLÉGIO CARINHO DA MAMÃE' }}</div>
                <div class="timbre-detalhes">
                    {{ $endereco->Rua ?? 'Rua Principal' }}, {{ $endereco->Numero ?? 'S/N' }} — {{ $endereco->Bairro ?? 'Centro' }}<br>
                    CEP: {{ $endereco->CEP ?? '00000-000' }} — {{ $endereco->Cidade ?? 'Cidade' }} / {{ $endereco->Estado ?? 'UF' }}<br>
                    Telefone(s): {{ $endereco->Fone1 ?? 'Não informado' }} @if(!empty($endereco->Fone2)) / {{ $endereco->Fone2 }} @endif<br>
                    E-mail: {{ $escolas->EmailColegio ?? 'contato@colegio.com' }} | CNPJ: {{ $escolas->CNPJ ?? '00.000.000/0001-00' }} | INEP: {{ $escolas->NumeroInep ?? '00000000' }}<br>
                    Portaria CME Nº 020/2024 // CEE - Resolução nº 524/2026
                </div>
            </div>
        </div>

        <!-- Seção 1: Indicadores e Métricas do Sistema -->
        <div class="titulo-secao-relatorio">Indicadores e Estatísticas Gerais</div>
        <div class="grid-estatisticas">
            <div class="card-stat card-stat-destaque">
                <div class="stat-valor">{{ $quantAlunosCadastrados }}</div>
                <div class="stat-label">Total Alunos</div>
            </div>
            <div class="card-stat">
                <div class="stat-valor" style="color: #059669;">{{ $quantMatriculasAtivas }}</div>
                <div class="stat-label">Alunos Ativos</div>
            </div>
            <div class="card-stat">
                <div class="stat-valor" style="color: #dc2626;">{{ $quantMatriculasInativas }}</div>
                <div class="stat-label">Inativos / Transferidos</div>
            </div>
            <div class="card-stat">
                <div class="stat-valor" style="color: #2563eb;">{{ $quantTurmasAtivas }}</div>
                <div class="stat-label">Turmas Ativas</div>
            </div>
            <div class="card-stat">
                <div class="stat-valor" style="color: #7c3aed;">{{ $quantDisciplina }}</div>
                <div class="stat-label">Disciplinas</div>
            </div>
            <div class="card-stat">
                <div class="stat-valor" style="color: #0284c7;">{{ $quantFuncionariosCadastrados }}</div>
                <div class="stat-label">Funcionários / Docentes</div>
            </div>
            <div class="card-stat">
                <div class="stat-valor" style="color: #d97706;">{{ $quantUsuarioCadastrados }}</div>
                <div class="stat-label">Usuários do Sistema</div>
            </div>
            <div class="card-stat">
                <div class="stat-valor" style="color: #4b5563;">{{ date('Y') }}</div>
                <div class="stat-label">Ano Letivo</div>
            </div>
        </div>

        <!-- Seção 2: Dados Oficiais da Entidade de Ensino -->
        <div class="titulo-secao-relatorio">Dados Cadastrais da Instituição</div>
        <table class="tabela-dados">
            <tbody>
                <tr>
                    <th>Nome / Razão Social</th>
                    <td><strong>{{ $escolas->NomeEscola ?? 'Não cadastrado' }}</strong></td>
                </tr>
                <tr>
                    <th>CNPJ</th>
                    <td>{{ $escolas->CNPJ ?? 'Não informado' }}</td>
                </tr>
                <tr>
                    <th>Código INEP</th>
                    <td>{{ $escolas->NumeroInep ?? 'Não informado' }}</td>
                </tr>
                <tr>
                    <th>Endereço Completo</th>
                    <td>{{ $endereco->Rua ?? '' }}, Nº {{ $endereco->Numero ?? 'S/N' }} — Bairro {{ $endereco->Bairro ?? '' }}</td>
                </tr>
                <tr>
                    <th>Município / UF / CEP</th>
                    <td>{{ $endereco->Cidade ?? '' }} - {{ $endereco->Estado ?? '' }} — CEP: {{ $endereco->CEP ?? '' }}</td>
                </tr>
                <tr>
                    <th>Contato Telefônico</th>
                    <td>{{ $endereco->Fone1 ?? '' }} @if(!empty($endereco->Fone2)) / {{ $endereco->Fone2 }} @endif</td>
                </tr>
                <tr>
                    <th>Correio Eletrônico (E-mail)</th>
                    <td>{{ $escolas->EmailColegio ?? 'Não informado' }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Rodapé e Assinaturas -->
        <div class="rodape-assinatura">
            <div class="bloco-data">
                <p><strong>Emissão:</strong> {{ $endereco->Cidade ?? 'Sede Escolar' }}, {{ $dataHojeExtenso }}.</p>
                <p style="font-size: 11px; color: #718096; margin-top: 4px;">Documento gerado eletronicamente através do Sistema de Gestão Escolar Maruge.</p>
            </div>
            <div class="bloco-carimbo">
                <div class="linha-assinatura"></div>
                <div class="nome-cargo">Secretaria / Direção Geral</div>
                <div class="sub-cargo">Carimbo e Assinatura</div>
            </div>
        </div>

    </div>

</body>
</html>
