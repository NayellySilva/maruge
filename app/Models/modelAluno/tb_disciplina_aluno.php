<?php
namespace App\Models\modelAluno;
use Illuminate\Database\Eloquent\Model;

class tb_disciplina_aluno extends Model {
    protected $table = 'tb_disciplinas';
    protected $guard = ['idDisciplina'];
    protected $primaryKey = 'idDisciplinas';
    public $timestamps = false;
    
// Metodo que busca as disciplinas que a turma tem
    public static function DisciplinasdoAluno($idTurmas) {
        return tb_turmas_disciplinas_aluno::select()             
                ->where('tb_turmas_disciplinas.tb_turmas_idTurmas', '=', $idTurmas)
                ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                ->select('tb_disciplinas.NomeDisciplina')
                ->groupby('NomeDisciplina')
                ->orderBy('NomeDisciplina')
                ->get();
    }
// Metodo que busca as disciplinas e seus professores
    public static function disciplinaseProfessordoAluno($idAluno) {
        return tb_turmas_disciplinas_aluno::select()             
                ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                ->join('tb_aluno', 'tb_aluno.tb_turmas_idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                ->where('tb_aluno.idAluno', $idAluno)
                ->where('tb_turmas.SituacaoTurma', 'ATIVO')              
                ->select('tb_disciplinas.NomeDisciplina','tb_funcionarios.NomeFuncionario','tb_turmas.NomeTurma')
                ->groupBy('NomeDisciplina')
                ->orderBy('NomeDisciplina')
                ->get();
    }
   
    //Metodo conta a quantidade de turma do aluno
    public static function TurmadoAluno($idAluno) {
        $Alunos = tb_aluno_aluno::select()
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_turmas.idTurmas','tb_turmas.NomeTurma')
                ->where('tb_aluno.idAluno',$idAluno)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->where('tb_turmas.SituacaoTurma', 'ATIVO')
                ->get();
        return $Alunos;
    }
    
    // Metodo que busca as disciplinas que a turma tem
    public static function QuantidadeDisciplinasdoAluno($idAluno) {
        return tb_turmas_disciplinas_aluno::select()             
                ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                ->join('tb_aluno', 'tb_aluno.tb_turmas_idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                ->where('tb_aluno.idAluno',$idAluno)
                ->select('tb_disciplinas.NomeDisciplina')
                ->groupby('NomeDisciplina')
                ->orderBy('NomeDisciplina')
                ->get();
    }
    

//Fechando a classe principal
}
