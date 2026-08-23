<?php

namespace App\Models\modelDocente;

use Illuminate\Database\Eloquent\Model;
use App\Models\modelCoordenacao\tb_notas;

class tb_disciplina_docente extends Model {

    protected $table = 'tb_disciplinas';
    protected $guard = ['idDisciplina'];
    protected $primaryKey = 'idDisciplinas';
    public $timestamps = false;
    protected $fillable = ['NomeDisciplina'];

// Quantidande de disciplinas vinculadas ao professor
    public static function quantidadeDeDisciplinasDoProfessor($idFuncionarios) {
        return tb_turmas_disciplinas_docente::select()
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', $idFuncionarios)
                        ->groupBy('tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->where('SituacaoTurma', 'ATIVO')
                        ->get();
    }

// busca todas as disciplinas que pertece a uma determinada turma e seu professor  
    public static function disciplinaTurmadoProfessor($idTurmas, $idFuncionarios) {
        return tb_turmas_disciplinas_docente::select()
                        ->orderBy('NomeDisciplina')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->select('tb_disciplinas.NomeDisciplina', 'tb_turmas_disciplinas.*')
                        ->where('tb_turmas.idTurmas', $idTurmas)
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
                        ->get();
    }

    // Metodo que busca as disciplinas do professor sobre seu id e o id da turma
    public static function DisciplinasdoProfessor($idFuncionarios, $idTurmas) {
        return tb_turmas_disciplinas_docente::select()
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
                        ->where('tb_turmas_disciplinas.tb_turmas_idTurmas', '=', $idTurmas)
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->select('tb_disciplinas.NomeDisciplina')
                        ->groupby('NomeDisciplina')
                        ->orderBy('NomeDisciplina')
                        ->get();
    }

    // Faz uma contagem de quantas disciplinas tem em uma determinada turma
    public static function QuantidadeDisciplinasNaTurma($idTurmas) {
        return tb_turmas_disciplinas_docente::select()
                        ->orderBy('NomeDisciplina')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->select('tb_disciplinas.NomeDisciplina', 'tb_turmas_disciplinas.*')
                        ->where('tb_turmas.idTurmas', $idTurmas)
                        ->count();
    }

//Fechando a classe principal
}
