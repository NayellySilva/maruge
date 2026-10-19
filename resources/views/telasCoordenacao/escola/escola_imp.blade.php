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
    <x-estilo-impressao arquivo="escola" />
    <link rel="stylesheet" href="{{ asset('css/utilitarios.css') }}">
</head>
<body>

    <!-- Barra Superior de Controle (Oculta na Impressão) -->
    <div class="no-print-bar">
        <span style="font-size: 13px; font-weight: 600; color: #4a5568;">Visualização de Impressão — Ficha Institucional</span>
        <div class="flex-gap-10">
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
