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
            ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
            ->whereIn('tb_aluno.tb_turmas_idTurmas', $idsTurmas)
            ->whereIn('tb_matriculas.SituacaoAluno', ['ATIVO', 'ATIVA'])
            ->count();

        // Montagem das turmas com suas disciplinas e nível
        $turmas = $turmasAtivas->map(function ($t) {
            $nivel = $this->notaService->nivelDaTurma($t->NomeTurma ?? '');
            $disciplinas = ProfessorLogado::disciplinasNaTurma($t->idTurmas);
            $totalAlunosTurma = DB::table('tb_aluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->where('tb_aluno.tb_turmas_idTurmas', $t->idTurmas)
                ->whereIn('tb_matriculas.SituacaoAluno', ['ATIVO', 'ATIVA'])
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

        return view('telasDocente.index', compact(
            'saudacao',
            'nomeProfessor',
            'totalTurmas',
            'totalDisciplinas',
            'totalAlunos',
            'turmas',
            'bimestreAtual'
        ));
    }
}
