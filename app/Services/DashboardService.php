<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Retorna os contadores gerais da instituição.
     */
    public function getCounters(): array
    {
        return [
            'quantAlunosCadastrados' => DB::table('tb_aluno')->count(),
            'quantMatriculasAtivas' => \App\Models\modelCoordenacao\tb_matricula::quantMatriculasAtivas(),
            'quantMatriculasInativas' => \App\Models\modelCoordenacao\tb_matricula::quantMatriculasInativas(),
            'quantUsuarioCadastrados' => \App\Models\modelCoordenacao\tb_usuario::listagemUsuarios()->count(),
            'quantTurmasAtivas' => \App\Models\modelCoordenacao\tb_turma::turmasAtivas()->count(),
            'quantDisciplina' => \App\Models\modelCoordenacao\tb_disciplina::quantDisciplinasCadastradas(),
            'quantFuncionariosCadastrados' => \App\Models\modelCoordenacao\tb_funcionario::funcionarioCadastrados()->count(),
        ];
    }

    /**
     * Calcula a contagem real de matrículas mês a mês (Jan-Dez).
     */
    public function getMonthlyEnrollments(): array
    {
        $matriculas = DB::table('tb_matriculas')->select('DataMatricula')->get();
        $monthly = array_fill(0, 12, 0);

        foreach ($matriculas as $m) {
            if (!$m->DataMatricula) {
                continue;
            }
            $mes = null;
            if (preg_match('/^\d{4}-(\d{2})-\d{2}/', $m->DataMatricula, $matches)) {
                $mes = (int)$matches[1] - 1;
            } elseif (preg_match('/^\d{2}\/(\d{2})\/\d{4}/', $m->DataMatricula, $matches)) {
                $mes = (int)$matches[1] - 1;
            }

            if ($mes !== null && $mes >= 0 && $mes <= 11) {
                $monthly[$mes]++;
            }
        }

        return $monthly;
    }

    /**
     * Obtém as médias reais calculadas para cada turma escolar.
     */
    public function getClassGradeAverages(int $limit = 12): array
    {
        $turmasNotas = DB::table('tb_notas')
            ->join('tb_turmas', 'tb_notas.tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
            ->select('tb_turmas.NomeTurma', DB::raw('ROUND(AVG((COALESCE(AM1,0)+COALESCE(AB1,0))/2), 1) as media'))
            ->groupBy('tb_turmas.idTurmas', 'tb_turmas.NomeTurma')
            ->orderBy('tb_turmas.NomeTurma')
            ->limit($limit)
            ->get();

        $labels = [];
        $values = [];

        foreach ($turmasNotas as $tn) {
            $clean = str_ireplace(['MANHÃ', 'TARDE', 'NOITE', 'ANO'], ['M', 'T', 'N', 'º'], $tn->NomeTurma);
            $clean = preg_replace('/[^\wº]/u', ' ', $clean);
            $labels[] = trim(preg_replace('/\s+/', ' ', $clean)) ?: $tn->NomeTurma;
            $values[] = (float)$tn->media;
        }

        return [
            'labels' => $labels,
            'values' => $values,
        ];
    }

    /**
     * Agrupa as mensalidades por status de quitação.
     */
    public function getTuitionStatus(): array
    {
        $statusCounts = DB::table('tb_carne')
            ->select('status_pagamento', DB::raw('count(*) as total'))
            ->groupBy('status_pagamento')
            ->pluck('total', 'status_pagamento')
            ->toArray();

        return [
            'pagas' => (int)($statusCounts['PAGO'] ?? 0),
            'atrasadas' => (int)($statusCounts['ABERTO'] ?? 0),
            'parcial' => (int)($statusCounts['PARCIAL'] ?? 0),
        ];
    }

    /**
     * Busca aniversariantes do mês (0 a 11) dos alunos ATIVOS e DOCENTES/FUNCIONÁRIOS no banco.
     */
    public function getBirthdaysByMonth(int $targetMonth): array
    {
        $colorsAlunos = [
            'bg-[#09492f]/10 text-[#09492f]',
            'bg-[#008a4b]/10 text-[#008a4b]',
            'bg-[#3b82f6]/10 text-[#3b82f6]',
            'bg-[#8b5cf6]/10 text-[#8b5cf6]',
            'bg-[#f43f5e]/10 text-[#f43f5e]',
        ];

        $aniversariantes = [];

        // 1. Alunos Ativos
        $alunos = DB::table('tb_aluno')
            ->join('tb_matriculas', 'tb_aluno.tb_matriculas_idMatriculas', '=', 'tb_matriculas.idMatriculas')
            ->leftJoin('tb_turmas', 'tb_aluno.tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
            ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
            ->whereNotNull('tb_aluno.DataNascimento')
            ->where('tb_aluno.DataNascimento', '!=', '')
            ->select('tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_turmas.NomeTurma')
            ->get();

        foreach ($alunos as $a) {
            $parsed = $this->parseBirthDayAndMonth($a->DataNascimento);
            if ($parsed && $parsed['month'] === $targetMonth) {
                $rawName = mb_convert_encoding(trim($a->NomeAluno ?? ''), 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
                $name = mb_convert_case($rawName, MB_CASE_TITLE, "UTF-8");
                $parts = array_values(array_filter(explode(' ', $name)));
                
                $initial1 = isset($parts[0]) ? mb_substr($parts[0], 0, 1, 'UTF-8') : '';
                $initial2 = isset($parts[1]) ? mb_substr($parts[1], 0, 1, 'UTF-8') : '';
                $initials = mb_strtoupper($initial1 . $initial2, 'UTF-8');

                $colorIndex = abs(crc32($name)) % count($colorsAlunos);
                $rawTurma = $a->NomeTurma ? mb_convert_encoding(trim($a->NomeTurma), 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252') : '';

                $aniversariantes[] = [
                    'name' => $name,
                    'day' => $parsed['day'],
                    'month' => $parsed['month'],
                    'role' => 'Aluno' . ($rawTurma ? ' - ' . $rawTurma : ''),
                    'avatar' => $initials ?: 'AL',
                    'color' => $colorsAlunos[$colorIndex],
                    'tipo' => 'aluno',
                ];
            }
        }

        // 2. Docentes e Funcionários
        if (\Illuminate\Support\Facades\Schema::hasColumn('tb_funcionarios', 'DataNascimento')) {
            $funcionarios = DB::table('tb_funcionarios')
                ->whereNotNull('DataNascimento')
                ->where('DataNascimento', '!=', '')
                ->select('NomeFuncionario', 'DataNascimento', 'Funcao')
                ->get();

            foreach ($funcionarios as $f) {
                $parsed = $this->parseBirthDayAndMonth($f->DataNascimento);
                if ($parsed && $parsed['month'] === $targetMonth) {
                    $rawName = mb_convert_encoding(trim($f->NomeFuncionario ?? ''), 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
                    $name = mb_convert_case($rawName, MB_CASE_TITLE, "UTF-8");
                    $parts = array_values(array_filter(explode(' ', $name)));

                    $initial1 = isset($parts[0]) ? mb_substr($parts[0], 0, 1, 'UTF-8') : '';
                    $initial2 = isset($parts[1]) ? mb_substr($parts[1], 0, 1, 'UTF-8') : '';
                    $initials = mb_strtoupper($initial1 . $initial2, 'UTF-8');

                    $funcao = mb_convert_case(trim($f->Funcao ?? 'Docente'), MB_CASE_TITLE, "UTF-8");

                    $aniversariantes[] = [
                        'name' => $name,
                        'day' => $parsed['day'],
                        'month' => $parsed['month'],
                        'role' => $funcao,
                        'avatar' => $initials ?: 'PR',
                        'color' => 'bg-[#ffb300]/15 text-[#b45309]', // Destaque âmbar/dourado para professores
                        'tipo' => 'docente',
                    ];
                }
            }
        }

        usort($aniversariantes, fn($a, $b) => $a['day'] <=> $b['day']);

        return $aniversariantes;
    }

    /**
     * Utilitário para parse seguro de datas de nascimento (YYYY-MM-DD ou DD/MM/YYYY).
     */
    protected function parseBirthDayAndMonth(?string $dateStr): ?array
    {
        if (!$dateStr) return null;
        $d = trim($dateStr);
        $day = null;
        $month = null;

        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})/', $d, $m)) {
            $month = (int)$m[2] - 1;
            $day = (int)$m[3];
        } elseif (preg_match('/^(\d{2})\/(\d{2})\/\d{4}/', $d, $m)) {
            $day = (int)$m[1];
            $month = (int)$m[2] - 1;
        }

        if ($month !== null && $month >= 0 && $month <= 11 && $day >= 1 && $day <= 31) {
            return ['day' => $day, 'month' => $month];
        }

        return null;
    }
}
