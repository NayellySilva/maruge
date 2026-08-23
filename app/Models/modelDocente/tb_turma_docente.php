<?php

namespace App\Models\modelDocente;

use Illuminate\Database\Eloquent\Model;
use TbAluno;

class tb_turma_docente extends Model {

    protected $table = 'tb_turmas';
    protected $guard = ['idTurmas'];
    protected $primaryKey = 'idTurmas';
    public $timestamps = false;
    protected $fillable = ['NomeTurma', 'Mensalidade', 'SituacaoTurma', 'AnoLetivo'];

    // Selecionando as Turmas Ativas que o docente esta vinculado.    
    public static function quantidadeDeTurmaDoProfessor($idFuncionarios) {
        return tb_turmas_disciplinas_docente::select()
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', $idFuncionarios)
                        ->where('SituacaoTurma', 'ATIVO')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->groupBy('tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->get();
    }
    // Metodo que fas uma listagem de todos os professores em suas turmas com suas determinada disciplina(turma_disciplina_cad)    
    public static function TurmasdoProfessor($idFuncionarios) {
        return tb_turmas_disciplinas_docente::select()
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
                        ->where('SituacaoTurma', 'ATIVO')
                        ->orderBy('NomeTurma')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->select('tb_funcionarios.NomeFuncionario', 'tb_turmas.NomeTurma', 'tb_turmas.idTurmas')
                        ->groupby('NomeTurma')
                        ->get();
    }
    // Metodo busca todas as turmas do professor 
    public static function ListaTuramsdoProfessor($idFuncionarios) {
        return tb_turmas_disciplinas_docente::select()
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
                        ->where('SituacaoTurma', 'ATIVO')
                        ->orderBy('NomeTurma')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->select('tb_funcionarios.NomeFuncionario', 'tb_turmas.NomeTurma', 'tb_turmas.idTurmas')
                        ->groupby('NomeTurma')
                        ->get();
    }
    //Metodo qque busca os alunos da turma
    public static function alunosdaturma($idTurma) {
        $Alunos = tb_aluno_docente::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                ->where('tb_aluno.tb_turmas_idTurmas', $idTurma)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->paginate(40);
        return $Alunos;
    }

// Fecha Classe Principal
}
