<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuditTestDataService
{
    /**
     * Padrões de teste identificados.
     */
    protected array $patternsText = ['teste', 'test', 'dummy', 'fake', 'asdasd', '123456'];
    protected array $patternsCPF = ['000.000.000-00', '111.111.111-11', '123.456.789-00', '999.999.999-99'];

    /**
     * Realiza a identificação de registros suspeitos sem alterar nada.
     */
    public function identifySuspects(): array
    {
        $suspects = [];

        // 1. Alunos de teste
        $alunos = DB::table('tb_aluno')->get();
        foreach ($alunos as $a) {
            $nome = mb_strtolower($a->NomeAluno ?? '');
            $isTestName = false;
            foreach ($this->patternsText as $pt) {
                if (str_contains($nome, $pt)) {
                    $isTestName = true;
                    break;
                }
            }

            if ($isTestName) {
                $mat = DB::table('tb_matriculas')->where('idMatriculas', $a->tb_matriculas_idMatriculas)->first();
                $carnes = DB::table('tb_carne')->where('tb_aluno_idAluno', $a->idAluno)->count();
                $notas = DB::table('tb_notas')->where('tb_aluno_idAluno', $a->idAluno)->count();

                $suspects['alunos'][] = [
                    'idAluno' => $a->idAluno,
                    'NomeAluno' => $a->NomeAluno,
                    'idMatriculas' => $a->tb_matriculas_idMatriculas,
                    'RA' => $mat->RA ?? 'N/A',
                    'idPais' => $a->tb_pais_idPais,
                    'idEndereco' => $a->tb_endereco_idEndereco,
                    'TotalCarnes' => $carnes,
                    'TotalNotas' => $notas,
                    'criterio' => "Nome com padrão de teste: '{$a->NomeAluno}'"
                ];
            }
        }

        return $suspects;
    }

    /**
     * Gera backup dos registros antes de qualquer exclusão.
     */
    public function backupRecords(array $alunoIds): string
    {
        $backupData = [];

        foreach ($alunoIds as $id) {
            $aluno = DB::table('tb_aluno')->where('idAluno', $id)->first();
            if (!$aluno) continue;

            $backupData['tb_aluno'][] = (array)$aluno;
            $backupData['tb_matriculas'][] = (array)DB::table('tb_matriculas')->where('idMatriculas', $aluno->tb_matriculas_idMatriculas)->first();
            $backupData['tb_pais'][] = (array)DB::table('tb_pais')->where('idPais', $aluno->tb_pais_idPais)->first();
            $backupData['tb_endereco'][] = (array)DB::table('tb_endereco')->where('idEndereco', $aluno->tb_endereco_idEndereco)->first();
            $backupData['tb_frequencia'][] = DB::table('tb_frequencia')->where('tb_aluno_idAluno', $id)->get()->map(fn($f) => (array)$f)->toArray();
        }

        $backupDir = storage_path('app/backups');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filename = $backupDir . '/backup_teste_' . date('Y_m_d_His') . '.json';
        file_put_contents($filename, json_encode($backupData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $filename;
    }

    /**
     * Executa a exclusão segura dentro de transação de banco de dados.
     */
    public function deleteConfirmed(array $alunoIds): array
    {
        $report = [
            'tb_frequencia' => 0,
            'tb_aluno' => 0,
            'tb_matriculas' => 0,
            'tb_pais' => 0,
            'tb_endereco' => 0,
        ];

        DB::transaction(function () use ($alunoIds, &$report) {
            foreach ($alunoIds as $idAluno) {
                $aluno = DB::table('tb_aluno')->where('idAluno', $idAluno)->first();
                if (!$aluno) continue;

                // 1. Remover frequências de teste
                $report['tb_frequencia'] += DB::table('tb_frequencia')->where('tb_aluno_idAluno', $idAluno)->delete();

                // 2. Remover aluno
                $report['tb_aluno'] += DB::table('tb_aluno')->where('idAluno', $idAluno)->delete();

                // 3. Remover matrícula se não houver outro aluno vinculado
                if ($aluno->tb_matriculas_idMatriculas) {
                    $outros = DB::table('tb_aluno')->where('tb_matriculas_idMatriculas', $aluno->tb_matriculas_idMatriculas)->count();
                    if ($outros === 0) {
                        $report['tb_matriculas'] += DB::table('tb_matriculas')->where('idMatriculas', $aluno->tb_matriculas_idMatriculas)->delete();
                    }
                }

                // 4. Remover pais se não houver outro aluno vinculado
                if ($aluno->tb_pais_idPais) {
                    $outros = DB::table('tb_aluno')->where('tb_pais_idPais', $aluno->tb_pais_idPais)->count();
                    if ($outros === 0) {
                        $report['tb_pais'] += DB::table('tb_pais')->where('idPais', $aluno->tb_pais_idPais)->delete();
                    }
                }

                // 5. Remover endereço se não houver outro aluno/escola/funcionário vinculado
                if ($aluno->tb_endereco_idEndereco) {
                    $outros = DB::table('tb_aluno')->where('tb_endereco_idEndereco', $aluno->tb_endereco_idEndereco)->count();
                    if ($outros === 0) {
                        $report['tb_endereco'] += DB::table('tb_endereco')->where('idEndereco', $aluno->tb_endereco_idEndereco)->delete();
                    }
                }
            }
        });

        Log::info('Auditoria: exclusão de registros de teste concluída', $report);

        return $report;
    }
}
