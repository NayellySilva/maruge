<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardService
{
    /**
     * Retorna os contadores gerais da instituição.
     */
    public function getCounters(): array
    {
        $hasAluno = Schema::hasTable('tb_aluno');
        $hasMatriculas = Schema::hasTable('tb_matriculas');
        $hasTurmas = Schema::hasTable('tb_turmas');
        $hasDisciplinas = Schema::hasTable('tb_disciplinas');
        $hasFuncionarios = Schema::hasTable('tb_funcionarios');
        $hasUsuarios = Schema::hasTable('tb_usuario');

        return [
            'quantAlunosCadastrados' => $hasAluno ? DB::table('tb_aluno')->count() : 0,
            'quantMatriculasAtivas' => $hasMatriculas ? \App\Models\modelCoordenacao\tb_matricula::quantMatriculasAtivas() : 0,
            'quantMatriculasInativas' => $hasMatriculas ? \App\Models\modelCoordenacao\tb_matricula::quantMatriculasInativas() : 0,
            'quantUsuarioCadastrados' => $hasUsuarios ? \App\Models\modelCoordenacao\tb_usuario::listagemUsuarios()->count() : 0,
            'quantTurmasAtivas' => $hasTurmas ? \App\Models\modelCoordenacao\tb_turma::turmasAtivas()->count() : 0,
            'quantDisciplina' => $hasDisciplinas ? \App\Models\modelCoordenacao\tb_disciplina::quantDisciplinasCadastradas() : 0,
            'quantFuncionariosCadastrados' => $hasFuncionarios ? \App\Models\modelCoordenacao\tb_funcionario::funcionarioCadastrados()->count() : 0,
        ];
    }

    /**
     * Calcula a contagem real de matrículas mês a mês (Jan-Dez).
     */
    public function getMonthlyEnrollments(): array
    {
        if (!Schema::hasTable('tb_matriculas')) {
            return array_fill(0, 12, 0);
        }

        $matriculas = DB::table('tb_matriculas')->select('DataMatricula')->get();
        $monthly = array_fill(0, 12, 0);

        foreach ($matriculas as $m) {
            if (!$m->DataMatricula) {
                continue;
            }
            $mes = null;
            if (preg_match('/^\d{4}-(\d{2})-\d{2}/', $m->DataMatricula, $matches)) {
                $mes = (int)$matches[1] - 1;
            } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}/', $m->DataMatricula)) {
                $mes = (int)substr($m->DataMatricula, 3, 2) - 1;
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
        if (!Schema::hasTable('tb_notas') || !Schema::hasTable('tb_turmas')) {
            return ['labels' => [], 'values' => []];
        }

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
        if (!Schema::hasTable('tb_carne')) {
            return [
                'pagas' => 0,
                'atrasadas' => 0,
                'parcial' => 0,
            ];
        }

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
        if (!Schema::hasTable('tb_aluno') || !Schema::hasTable('tb_matriculas')) {
            return [];
        }

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

        // 2. Docentes e Funcionários (ativos)
        $queryFuncionarios = $this->funcionariosAtivosQuery();
        $funcionarios = $queryFuncionarios
            ? $queryFuncionarios->whereNotNull('DataNascimento')
                ->where('DataNascimento', '!=', '')
                ->select('NomeFuncionario', 'DataNascimento', 'Funcao')
                ->get()
            : collect();

        foreach ($funcionarios as $f) {
            $parsed = $this->parseBirthDayAndMonth($f->DataNascimento);
            if ($parsed && $parsed['month'] === $targetMonth) {
                $rawName = mb_convert_encoding(trim($f->NomeFuncionario ?? ''), 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
                $name = mb_convert_case($rawName, MB_CASE_TITLE, "UTF-8");
                $parts = array_values(array_filter(explode(' ', $name)));

                $initial1 = isset($parts[0]) ? mb_substr($parts[0], 0, 1, 'UTF-8') : '';
                $initial2 = isset($parts[1]) ? mb_substr($parts[1], 0, 1, 'UTF-8') : '';
                $initials = mb_strtoupper($initial1 . $initial2, 'UTF-8');

                $rawFuncao = mb_convert_encoding(trim($f->Funcao ?? '') ?: 'Funcionário', 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
                $funcao = mb_convert_case($rawFuncao, MB_CASE_TITLE, "UTF-8");

                $aniversariantes[] = [
                    'name' => $name,
                    'day' => $parsed['day'],
                    'month' => $parsed['month'],
                    'role' => $funcao,
                    'avatar' => $initials ?: 'FU',
                    'color' => 'bg-[#ffb300]/15 text-[#b45309]', // Destaque âmbar/dourado para funcionários
                    'tipo' => 'docente',
                ];
            }
        }

        usort($aniversariantes, fn($a, $b) => $a['day'] <=> $b['day']);

        return $aniversariantes;
    }

    /**
     * Query base dos funcionários ativos, ou null se a tabela/coluna de
     * nascimento ainda não existir (migration não executada).
     */
    protected function funcionariosAtivosQuery()
    {
        if (!Schema::hasTable('tb_funcionarios') || !Schema::hasColumn('tb_funcionarios', 'DataNascimento')) {
            return null;
        }

        $query = DB::table('tb_funcionarios')
            ->where('NomeFuncionario', 'not like', '%(SAIU)%')
            ->where('NomeFuncionario', 'not like', '%(INATIVO)%');

        if (Schema::hasColumn('tb_funcionarios', 'Situacao')) {
            $query->where(function ($q) {
                $q->whereNull('Situacao')
                  ->orWhere('Situacao', '')
                  ->orWhereNotIn('Situacao', ['INATIVO', 'INATIVA', '[INATIVO]']);
            });
        }

        return $query;
    }

    /**
     * Situação do cadastro de nascimento dos funcionários, para o aviso do card.
     * Retorna ['coluna' => bool, 'sem_data' => int].
     */
    public function getFuncionariosSemDataNascimento(): array
    {
        $query = $this->funcionariosAtivosQuery();
        if ($query === null) {
            return ['coluna' => false, 'sem_data' => 0];
        }

        $semData = 0;
        foreach ($query->select('DataNascimento')->get() as $f) {
            if (!$this->parseBirthDayAndMonth($f->DataNascimento)) {
                $semData++;
            }
        }

        return ['coluna' => true, 'sem_data' => $semData];
    }

    /**
     * Utilitário para parse seguro de datas de nascimento.
     * Aceita YYYY-MM-DD (com ou sem hora), DD/MM/YYYY, DD-MM-YYYY, DD.MM.YYYY e ano com 2 dígitos.
     */
    protected function parseBirthDayAndMonth(?string $dateStr): ?array
    {
        if (!$dateStr) return null;
        $d = trim($dateStr);
        $day = null;
        $month = null;

        if (preg_match('/^(\d{4})[-\/.](\d{1,2})[-\/.](\d{1,2})/', $d, $m)) {
            $month = (int)$m[2] - 1;
            $day = (int)$m[3];
        } elseif (preg_match('/^(\d{1,2})[-\/.](\d{1,2})[-\/.](\d{2}|\d{4})\b/', $d, $m)) {
            $day = (int)$m[1];
            $month = (int)$m[2] - 1;
        }

        if ($month !== null && $month >= 0 && $month <= 11 && $day >= 1 && $day <= 31) {
            return ['day' => $day, 'month' => $month];
        }

        return null;
    }
}
