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
}
