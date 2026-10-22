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
    $func = is_iterable($Funcionario) ? $Funcionario->first() : $Funcionario;
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo ?? 'Declaração do Funcionário' }}</title>
    <x-estilo-impressao arquivo="declaracao" />
    <link rel="stylesheet" href="{{ asset('css/utilitarios.css') }}">
</head>
<body>

    <!-- Barra de Impressão -->
    <div class="no-print-bar">
        <span>Visualização do Documento — Declaração Funcional do Docente</span>
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
                    <div class="timbre-nome-escola">{{ $escola->NomeEscola ?? 'COLÉGIO MARUGE' }}</div>
                    {{ $endereco->Rua ?? 'Rua Principal' }}, {{ $endereco->Numero ?? 'S/N' }} — {{ $endereco->Bairro ?? 'Bairro' }}<br>
                    CEP: {{ $endereco->CEP ?? '' }} — {{ $endereco->Cidade ?? '' }} / {{ $endereco->Estado ?? '' }}<br>
                    Telefone(s): {{ $endereco->Fone1 ?? '' }} @if(!empty($endereco->Fone2)) / {{ $endereco->Fone2 }} @endif — E-mail: {{ $escola->EmailColegio ?? '' }}<br>
                    CNPJ: {{ $escola->CNPJ ?? '' }} | INEP: {{ $escola->NumeroInep ?? '' }}
                </div>
            </div>

            <!-- Título do Documento -->
            <div class="declaracao-titulo">
                DECLARAÇÃO FUNCIONAL
            </div>

            <!-- Texto Principal -->
            @if($func)
            <div class="declaracao-corpo">
                Declaramos para os devidos fins de direito e comprovação que o(a) docente
                <strong>{{ $func->NomeFuncionario }}</strong>,
                portador(a) do CPF nº <strong>{{ $func->CPFFuncionario ?? '-' }}</strong>
                e RG nº <strong>{{ $func->RGFuncionario ?? '-' }}</strong>,
                desenvolve atividades docentes na função de
                <strong>{{ $func->Funcao ?? 'PROFESSOR(A)' }}</strong>
                junto a esta Instituição de Ensino.
            </div>
            @endif

            <div class="declaracao-rodape-obs">
                Documento emitido para fins funcionais. Após a impressão, apresentar à Coordenação para validação e assinatura.
            </div>
        </div>

        <!-- Data e Linhas de Assinatura -->
        <div>
            <div class="declaracao-data">
                {{ $endereco->Cidade ?? 'Localidade' }}, {{ $diaFormatado }}.
            </div>

            <div class="declaracao-assinaturas-dupla">
                <div class="assinatura-bloco">
                    <div class="assinatura-linha"></div>
                    <div class="assinatura-cargo">Coordenação Pedagógica</div>
                </div>
                <div class="assinatura-bloco">
                    <div class="assinatura-linha"></div>
                    <div class="assinatura-cargo">Direção Escolar</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
