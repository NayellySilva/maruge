<?php

namespace App\Models\modelAluno;

use Illuminate\Database\Eloquent\Model;

class tb_turmas_disciplinas_aluno extends Model {

    protected $table = 'tb_turmas_disciplinas';
    protected $primaryKey = 'idTurmas_Disciplinas';
    public $timestamps = false;
    protected $fillable = ['tb_turmas_idTurmas', 'tb_disciplinas_idDisciplinas', 'tb_funcionarios_idFuncionarios'];

// Conta quantas disciplinas o aluno tem
    public static function QuantidadedeDisciplinadoAluno($idAluno) {
        return tb_turmas_disciplinas_aluno::select()
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_aluno', 'tb_aluno.tb_turmas_idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->select('tb_disciplinas.NomeDisciplina')
                        ->where('tb_aluno.idAluno', $idAluno)
                        ->where('tb_turmas.SituacaoTurma', 'ATIVO')
                        ->get();
    }

    // Metodo que localiza a quantidade de professores do aluno  
    public static function QuantidadeDeProfessordoAluno($idAluno) {
        return tb_turmas_disciplinas_aluno::select()
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_aluno', 'tb_aluno.tb_turmas_idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->where('tb_aluno.idAluno', $idAluno)
                        ->where('tb_turmas.SituacaoTurma', 'ATIVO')
                        ->select('tb_funcionarios.idFuncionarios')
                        ->groupBy('idFuncionarios')
                        ->get();
    }
    // busca todas as disciplinas que pertece a uma determinada turma que ta sendo passado por paramentro  
    public static function disciplinaTurma($idTurmas) {
        return tb_turmas_disciplinas_aluno::select()
                        ->orderBy('NomeDisciplina')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->select('tb_disciplinas.NomeDisciplina', 'tb_turmas_disciplinas.*')
                        ->where('tb_turmas.idTurmas', $idTurmas)
                        ->get();
    }
    // Fecha Classe Principal
}
