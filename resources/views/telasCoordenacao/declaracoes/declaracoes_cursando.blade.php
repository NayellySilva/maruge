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
    <title>{{ $titulo ?? 'Declaração — Aluno Cursando' }}</title>
    <x-estilo-impressao arquivo="declaracao" />
    <link rel="stylesheet" href="{{ asset('css/utilitarios.css') }}">
</head>
<body>

    <!-- Barra de Impressão -->
    <div class="no-print-bar">
        <span>Visualização do Documento — Declaração de Matrícula e Frequência</span>
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
            <div class="titulo-doc">DECLARAÇÃO</div>

            <!-- Texto Principal -->
            <div class="corpo-declaracao">
                Declaramos para os devidos fins que o(a) aluno(a) <strong>{{ $aluno->NomeAluno ?? 'NOME DO ALUNO' }}</strong>,
                inscrito(a) sob o número de matrícula/RA <strong>{{ $aluno->NumeroMac ?? ($matricula->RA ?? 'NÃO INFORMADO') }}</strong>,
                está regularmente matriculado(a) e com frequência ativa neste estabelecimento de ensino no ano letivo de <strong>{{ $turma->AnoLetivo ?? date('Y') }}</strong>,
                cursando a turma do <strong>{{ $turma->NomeTurma ?? 'Ensino Regular' }}</strong>.
            </div>

            <!-- Filiação -->
            <div class="filiacao-bloco">
                <strong>Filiação:</strong><br>
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
                    <div class="cargo-assinatura">Secretaria Escolar</div>
                </div>
                <div class="bloco-assinatura">
                    <div class="linha-assinatura"></div>
                    <div class="cargo-assinatura">Direção Pedagógica</div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>