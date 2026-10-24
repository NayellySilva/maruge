<?php

namespace App\Support;

class NivelUsuario
{
    /**
     * Normaliza a string de nível para 'coordenacao', 'docente' ou 'outro'.
     *
     * @param string|null $nivel
     * @return string
     */
    public static function normalizar(?string $nivel): string
    {
        if ($nivel === null) {
            return 'outro';
        }

        $nivelLimpo = trim($nivel);
        $nivelUpper = mb_strtoupper($nivelLimpo, 'UTF-8');

        // Remover acentos para comparação uniforme
        $semAcento = strtr($nivelUpper, [
            'Á' => 'A', 'À' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'É' => 'E', 'È' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'Í' => 'I', 'Ì' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ó' => 'O', 'Ò' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
            'Ú' => 'U', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'Ç' => 'C',
        ]);

        if (in_array($semAcento, ['COORDENACAO', 'COORDENACAO', 'ADMIN', 'ADMINISTRADOR'], true)) {
            return 'coordenacao';
        }

        if (in_array($semAcento, ['DOCENTE', 'PROFESSOR', 'PROFESSORA'], true)) {
            return 'docente';
        }

        return 'outro';
    }
}
