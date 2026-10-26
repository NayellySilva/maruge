<?php

namespace App\Http\Controllers\controleDocente;

use App\Http\Controllers\Controller;
use App\Services\NotaBimestralService;
use App\Support\ProfessorLogado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PainelDocenteController extends Controller
{
    protected NotaBimestralService $notaService;

    public function __construct(NotaBimestralService $notaService)
    {
        $this->notaService = $notaService;
    }

    public function index()
    {
        $idProfessor = ProfessorLogado::id();
        $nomeProfessor = ProfessorLogado::nome() ?? 'Professor(a)';

        // Saudação por horário
        $hora = (int) date('H');
        $cumprimento = ($hora >= 5 && $hora < 12) ? 'Bom dia' : (($hora >= 12 && $hora < 18) ? 'Boa tarde' : 'Boa noite');
        $saudacao = "{$cumprimento}, {$nomeProfessor}";

        // Identificação do bimestre atual
        $mesAtual = (int) date('n');
        $bimestresConfig = config('escola.bimestres', [
            1 => [2, 3, 4],
            2 => [5, 6, 7],
            3 => [8, 9],
            4 => [10, 11, 12, 1],
        ]);
        $bimestreAtual = 1;
        foreach ($bimestresConfig as $bim => $meses) {
            if (in_array($mesAtual, $meses, true)) {
                $bimestreAtual = (int) $bim;
                break;
            }
        }

        // Turmas ativas do professor
        $turmasAtivas = ProfessorLogado::turmasAtivas();
        $idsTurmas = ProfessorLogado::idsTurmas();
        $totalTurmas = $turmasAtivas->count();

        // Total de disciplinas distintas lecionadas pelo professor
        $totalDisciplinas = empty($idProfessor) ? 0 : DB::table('tb_turmas_disciplinas')
            ->where('tb_funcionarios_idFuncionarios', $idProfessor)
            ->distinct()
            ->count('tb_disciplinas_idDisciplinas');

        // Total de alunos ativos matriculados nas turmas do professor
        $totalAlunos = empty($idsTurmas) ? 0 : DB::table('tb_aluno')
            ->whereIn('tb_turmas_idTurmas', $idsTurmas)
            ->whereIn('SituacaoAluno', ['ATIVO', 'ATIVA'])
            ->count();

        // Montagem das turmas com suas disciplinas e nível
        $turmas = $turmasAtivas->map(function ($t) {
            $nivel = $this->notaService->nivelDaTurma($t->NomeTurma ?? '');
            $disciplinas = ProfessorLogado::disciplinasNaTurma($t->idTurmas);
            $totalAlunosTurma = DB::table('tb_aluno')
                ->where('tb_turmas_idTurmas', $t->idTurmas)
                ->whereIn('SituacaoAluno', ['ATIVO', 'ATIVA'])
                ->count();

            return (object) [
                'idTurmas' => $t->idTurmas,
                'NomeTurma' => $t->NomeTurma,
                'AnoLetivo' => $t->AnoLetivo ?? date('Y'),
                'Turno' => $t->Turno ?? 'Matutino',
                'nivel' => $nivel,
                'disciplinas' => $disciplinas,
                'totalAlunos' => $totalAlunosTurma,
            ];
        });

        // Levantamento de notas pendentes do bimestre atual
        $notasPendentes = [];
        $campoNota = "AB{$bimestreAtual}";
        if (!empty($idsTurmas) && $idProfessor) {
            $vinculos = DB::table('tb_turmas_disciplinas')
                ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', $idProfessor)
                ->whereIn('tb_turmas.SituacaoTurma', ['ATIVO', 'ATIVA'])
                ->select(
                    'tb_turmas_disciplinas.tb_turmas_idTurmas',
                    'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas',
                    'tb_turmas.NomeTurma',
                    'tb_disciplinas.NomeDisciplina'
                )
                ->orderBy('tb_turmas.NomeTurma')
                ->orderBy('tb_disciplinas.NomeDisciplina')
                ->get();

            foreach ($vinculos as $v) {
                $alunosTurma = DB::table('tb_aluno')
                    ->where('tb_turmas_idTurmas', $v->tb_turmas_idTurmas)
                    ->whereIn('SituacaoAluno', ['ATIVO', 'ATIVA'])
                    ->pluck('idAluno');

                $qtdAlunos = $alunosTurma->count();
                if ($qtdAlunos === 0) {
                    continue;
                }

                $alunosComNota = DB::table('tb_notas')
                    ->where('tb_turmas_idTurmas', $v->tb_turmas_idTurmas)
                    ->where('tb_disciplinas_idDisciplinas', $v->tb_disciplinas_idDisciplinas)
                    ->whereIn('tb_aluno_idAluno', $alunosTurma)
                    ->whereNotNull($campoNota)
                    ->where($campoNota, '>', 0)
                    ->count();

                $pendentes = $qtdAlunos - $alunosComNota;
                if ($pendentes > 0) {
                    $notasPendentes[] = (object) [
                        'idTurma' => $v->tb_turmas_idTurmas,
                        'idDisciplina' => $v->tb_disciplinas_idDisciplinas,
                        'nomeTurma' => $v->NomeTurma,
                        'nomeDisciplina' => $v->NomeDisciplina,
                        'pendentes' => $pendentes,
                        'total' => $qtdAlunos,
                    ];
                }
            }
        }

        $aniversariantesDoMes = $this->buscarAniversariantesDoMes($idsTurmas, $mesAtual);

        return view('telasDocente.index', compact(
            'saudacao',
            'nomeProfessor',
            'totalTurmas',
            'totalDisciplinas',
            'totalAlunos',
            'turmas',
            'bimestreAtual',
            'notasPendentes',
            'aniversariantesDoMes'
        ));
    }

    public function imprimirAniversariantes()
    {
        $mesAtual = (int) date('n');
        $meses = [
            1 => 'janeiro', 2 => 'fevereiro', 3 => 'março', 4 => 'abril',
            5 => 'maio', 6 => 'junho', 7 => 'julho', 8 => 'agosto',
            9 => 'setembro', 10 => 'outubro', 11 => 'novembro', 12 => 'dezembro',
        ];

        return view('telasDocente.aniversariantes', [
            'aniversariantes' => $this->buscarAniversariantesDoMes(ProfessorLogado::idsTurmas(), $mesAtual),
            'nomeProfessor' => ProfessorLogado::nome() ?? 'Professor(a)',
            'nomeMes' => $meses[$mesAtual],
            'ano' => (int) date('Y'),
        ]);
    }

    private function buscarAniversariantesDoMes(array $idsTurmas, int $mesAtual): array
    {
        $aniversariantes = [];
        if ($idsTurmas === []) {
            return $aniversariantes;
        }

        $alunos = DB::table('tb_aluno')
            ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
            ->whereIn('tb_aluno.tb_turmas_idTurmas', $idsTurmas)
            ->whereIn('tb_aluno.SituacaoAluno', ['ATIVO', 'ATIVA'])
            ->whereNotNull('tb_aluno.DataNascimento')
            ->where('tb_aluno.DataNascimento', '!=', '')
            ->select('tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_turmas.NomeTurma')
            ->get();

        foreach ($alunos as $aluno) {
            $nascimento = $this->parseNascimento($aluno->DataNascimento);
            if ($nascimento && $nascimento['mes'] === $mesAtual) {
                $aniversariantes[] = (object) [
                    'nome' => $aluno->NomeAluno,
                    'turma' => $aluno->NomeTurma,
                    'dia' => $nascimento['dia'],
                ];
            }
        }

        usort($aniversariantes, fn ($a, $b) => $a->dia <=> $b->dia);

        return $aniversariantes;
    }

    /**
     * Interpreta formatos comuns de data de nascimento (YYYY-MM-DD ou DD/MM/YYYY).
     */
    protected function parseNascimento(?string $data): ?array
    {
        if (!$data) {
            return null;
        }
        $d = trim($data);
        if (preg_match('/^(\d{4})[-\/.](\d{1,2})[-\/.](\d{1,2})/', $d, $m)) {
            return ['dia' => (int) $m[3], 'mes' => (int) $m[2]];
        }
        if (preg_match('/^(\d{1,2})[-\/.](\d{1,2})[-\/.](\d{2}|\d{4})/', $d, $m)) {
            return ['dia' => (int) $m[1], 'mes' => (int) $m[2]];
        }
        return null;
    }
}
