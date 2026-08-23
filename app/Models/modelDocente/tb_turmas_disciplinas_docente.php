<?php

namespace App\Models\modelDocente;

use Illuminate\Database\Eloquent\Model;

class tb_turmas_disciplinas_docente extends Model {

    protected $table = 'tb_turmas_disciplinas';
    protected $primaryKey = 'idTurmas_Disciplinas';
    public $timestamps = false;
    protected $fillable = ['tb_turmas_idTurmas', 'tb_disciplinas_idDisciplinas', 'tb_funcionarios_idFuncionarios'];

    
    
    // busca todas as disciplinas que pertece a uma determinada turma que ta sendo passado por paramentro  
    public static function disciplinaTurma($idTurmas) {
        return tb_turmas_disciplinas_docente::select()
                        ->orderBy('NomeDisciplina')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->select('tb_disciplinas.NomeDisciplina', 'tb_turmas_disciplinas.*')
                        ->where('tb_turmas.idTurmas', $idTurmas)
                        ->get();
    }
    // Metodo que fas uma listagem de todos os professores em suas turmas com suas determinada disciplina(turma_disciplina_cad)    
    public static function ProfessoreSuasDisciplinas($idTurmas) {
        return tb_turmas_disciplinas_docente::select()
                        ->where('tb_turmas_disciplinas.tb_turmas_idTurmas', '=', $idTurmas)
                        ->orderBy('NomeDisciplina')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->select('tb_disciplinas.NomeDisciplina','tb_disciplinas.idDisciplinas', 'tb_funcionarios.NomeFuncionario', 'tb_turmas_disciplinas.*', 'tb_turmas.NomeTurma')
                        ->get();
    }
    // Fecha Classe Principal
}
