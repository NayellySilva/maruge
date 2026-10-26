<?php

namespace App\Services;

use InvalidArgumentException;

class NotaBimestralService
{
    public const MEDIA_MINIMA = 7.0;

    // Calcula a média apenas com avaliações preenchidas, sem contar campos vazios.
    public function calcularMediaParcial(array $avaliacoes): ?float
    {
        $notas = array_values(array_filter(array_map([$this, 'normalizarNota'], $avaliacoes), static fn ($nota) => $nota !== null));

        if ($notas === []) {
            return null;
        }

        return round(array_sum($notas) / count($notas), 2);
    }

    // A recuperação só é necessária quando a média parcial fica abaixo de 7.
    public function deveHabilitarRecuperacao(?float $media): bool
    {
        return $media !== null && $media < self::MEDIA_MINIMA;
    }

    // Mantém a compatibilidade com chamadas que já trabalham com uma média pronta.
    public function calcularMediaFinal(?float $media, ?float $recuperacao): ?float
    {
        if ($media === null) {
            return $recuperacao;
        }

        if (!$this->deveHabilitarRecuperacao($media) || $recuperacao === null) {
            return $media;
        }

        return round(max($media, $recuperacao), 2);
    }

    // Substitui a menor avaliação pela recuperação e recalcula a média da disciplina.
    public function calcularMediaFinalComRecuperacao(array $avaliacoes, $recuperacao = null): ?float
    {
        $notas = array_values(array_filter(array_map([$this, 'normalizarNota'], $avaliacoes), static fn ($nota) => $nota !== null));
        $media = $this->calcularMediaParcial($notas);
        $recuperacao = $this->normalizarNota($recuperacao);

        if ($media === null || !$this->deveHabilitarRecuperacao($media) || $recuperacao === null) {
            return $media;
        }

        $menorNota = min($notas);
        if ($recuperacao <= $menorNota) {
            return $media;
        }

        $notas[array_search($menorNota, $notas, true)] = $recuperacao;
        return round(array_sum($notas) / count($notas), 2);
    }

    public function statusBimestre(?float $media, ?float $recuperacao = null): string
    {
        $final = $this->calcularMediaFinal($media, $recuperacao);

        if ($final === null) {
            return 'sem_nota';
        }

        return $final >= self::MEDIA_MINIMA ? 'aprovado' : 'recuperacao';
    }

    // Normaliza entradas brasileiras e rejeita valores fora da escala de 0 a 10.
    public function normalizarNota($nota): ?float
    {
        if ($nota === null || $nota === '') {
            return null;
        }

        if (is_string($nota)) {
            $nota = str_replace(',', '.', trim($nota));
        }

        if (!is_numeric($nota)) {
            throw new InvalidArgumentException('A nota deve ser numérica.');
        }

        $nota = (float) $nota;
        if ($nota < 0 || $nota > 10) {
            throw new InvalidArgumentException('A nota deve estar entre 0 e 10.');
        }

        return $nota;
    }

    // Valida o payload legado antes de entregá-lo aos métodos de persistência existentes.
    public function normalizarFormularioBimestre(array $dados, int $bimestre): array
    {
        $notaCampo = 'AB' . $bimestre;
        $recuperacaoCampo = 'RB' . $bimestre;
        $mensalCampo = 'AM' . $bimestre;
        $total = count($dados['tb_disciplinas_idDisciplinas'] ?? []);

        for ($indice = 0; $indice < $total; $indice++) {
            foreach ([$notaCampo, $recuperacaoCampo, $mensalCampo] as $campo) {
                if (array_key_exists($campo, $dados) && array_key_exists($indice, $dados[$campo])) {
                    $dados[$campo][$indice] = $this->normalizarNota($dados[$campo][$indice]);
                }
            }

            $media = $this->calcularMediaParcial([
                $dados[$mensalCampo][$indice] ?? null,
                $dados[$notaCampo][$indice] ?? null,
            ]);
            if ($media !== null && !$this->deveHabilitarRecuperacao($media)) {
                $dados[$recuperacaoCampo][$indice] = null;
            }
        }

        return $dados;
    }

    /**
     * Nível da turma pelo NOME: 'inf', 'fun1' ou 'fun2'.
     * Única regra de negócio do sistema — nunca usar quantidade de disciplinas.
     */
    public function nivelDaTurma(?string $nomeTurma): string
    {
        $nome = mb_strtoupper(trim((string) $nomeTurma), 'UTF-8');

        // Infantil: nome contém palavras-chave de educação infantil
        if (preg_match('/INFANTIL|BEB[ÊE]|BER[ÇC][ÁA]RIO|MATERNAL|TURMINHA/u', $nome)
            || preg_match('/(^|[^A-Z])INF([^A-Z]|$)/u', $nome)) {
            return 'inf';
        }

        // Fundamental II: 6º ao 9º ano ou "FUNDAMENTAL II/2"
        if (preg_match('/(^|\D)[6-9]\s*(º|°|O)?\s*ANO/u', $nome)
            || preg_match('/FUNDAMENTAL\s*(II|2)\b/u', $nome)) {
            return 'fun2';
        }

        // Qualquer outro: Fundamental I
        return 'fun1';
    }

    /**
     * Converte valor do banco: null, '' ou 0 = não lançado (retorna null).
     * Valores positivos retornam float.
     */
    private function valorLancado($valor): ?float
    {
        if ($valor === null || $valor === '') {
            return null;
        }
        $v = (float) str_replace(',', '.', (string) $valor);
        return $v > 0 ? $v : null;
    }

    /**
     * Nota do bimestre já com a recuperação bimestral (RB) aplicada.
     *
     * @param  mixed      $nota      Linha de tb_notas (objeto ou array com chaves AB1..AB4, AM1..AM4, RB1..RB4).
     * @param  int        $bimestre  Número do bimestre: 1..4.
     * @param  string     $nivel     'fun1' (só AB) ou 'fun2' (média AM+AB).
     * @return float|null            null se o bimestre não foi lançado.
     */
    public function notaDoBimestre($nota, int $bimestre, string $nivel): ?float
    {
        if (!$nota) {
            return null;
        }

        $ab = $this->valorLancado(data_get($nota, "AB{$bimestre}"));
        $am = $nivel === 'fun2' ? $this->valorLancado(data_get($nota, "AM{$bimestre}")) : null;
        $rb = $this->valorLancado(data_get($nota, "RB{$bimestre}"));

        // Monta apenas as avaliações efetivamente lançadas
        $avaliacoes = array_values(array_filter([$am, $ab], static fn($v) => $v !== null));

        if ($avaliacoes === []) {
            return null;
        }

        // Delega para calcularMediaFinalComRecuperacao, que já aplica a regra da RB corretamente
        return $this->calcularMediaFinalComRecuperacao($avaliacoes, $rb);
    }

    /**
     * Calcula o resultado anual do Fundamental I ou II considerando RP e RF.
     *
     * @return array{media: float, situacao: string}
     */
    public function situacaoAnual($nota, string $nivel): array
    {
        if (!in_array($nivel, ['fun1', 'fun2'], true)) {
            throw new InvalidArgumentException('A situação anual está disponível apenas para o Ensino Fundamental.');
        }

        $bimestres = [];
        foreach ([1, 2, 3, 4] as $bimestre) {
            $bimestres[] = $this->notaDoBimestre($nota, $bimestre, $nivel) ?? 0.0;
        }

        $mediaRegular = array_sum($bimestres) / 4;
        $rp = $this->valorLancado(data_get($nota, 'RP'));
        $rf = $this->valorLancado(data_get($nota, 'RF'));

        if ($rf !== null) {
            return [
                'media' => $rf,
                'situacao' => $rf >= self::MEDIA_MINIMA ? 'aprovado_rec' : 'reprovado',
            ];
        }

        if ($rp !== null) {
            $mediaRecuperacao = (($rp * 2) + $bimestres[2] + $bimestres[3]) / 4;
            if ($nivel === 'fun2' && (($bimestres[0] + $bimestres[1]) / 2) > (($rp * 2) / 4)) {
                $mediaRecuperacao = $mediaRegular;
            }

            return [
                'media' => $mediaRecuperacao,
                'situacao' => $mediaRecuperacao >= self::MEDIA_MINIMA ? 'aprovado_rec' : 'recuperacao_final',
            ];
        }

        return [
            'media' => $mediaRegular,
            'situacao' => $mediaRegular >= self::MEDIA_MINIMA ? 'aprovado' : 'recuperacao',
        ];
    }
}
