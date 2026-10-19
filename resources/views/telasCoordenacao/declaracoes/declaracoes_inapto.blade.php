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
    <link rel="stylesheet" href="{{ asset('css/utilitarios.css') }}">
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

        <div class="area-assinaturas">
            <div class="bloco-assinatura">
                <div class="linha-assinatura"></div>
                <div class="cargo-assinatura">Secretaria Escolar</div>
            </div>
            <div class="bloco-assinatura">
                <div class="linha-assinatura"></div>
                <div class="cargo-assinatura">Direção Geral / Carimbo</div>
            </div>
        </div>

        <div class="nota-rodape">
            Esta declaração só terá validade com assinatura e carimbo oficiais da instituição, sem emendas ou rasuras.
        </div>
    </div>

</body>
</html>