<?php

namespace App\Models\modelAluno;

use Illuminate\Database\Eloquent\Model;
use TbAluno;

class tb_aulas_aluno extends Model {

    protected $table = 'tb_aulas';
    protected $primaryKey = 'idAula';
    public $timestamps = false;
    protected $fillable = [
        'tb_turmas_idTurmas', 'aula', 'data_aula', 'ObsAula'
    ];  
    
    
    
//Relacionamento com a tabela Aluno
    public function alunoTurma() {
        return $this->hasOne('App\Models\modelAluno\tb_aluno', 'tb_turmas_idTurmas', 'idTurmas');
    }
    
//Relacionamento com a tabela turma
    public function disciplinaTurma() {
        return $this->hasOne('App\Models\modelAluno\tb_turmas_disciplinas', 'tb_turmas_idTurmas', 'idTurmas');
    }
    
    
    
    
     //Metodo QUE BUSCA AS AULAS DE MA TURMA
    public static function BuscaAulas($idTurmas) {
                return tb_aulas_aluno::select()
                  ->orderBy('data_aula', 'desc')
                        ->where('tb_turmas_idTurmas', $idTurmas)
                        ->get();
    }
    
    
    
    
    
    
    
    
    
    
    

//Metodo conta a quantidade de turma do aluno
    public static function quantidadeTurmadoAluno($idAluno) {
        $Alunos = tb_aluno_aluno::select()
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_turmas.NomeTurma')
                ->where('tb_aluno.idAluno',$idAluno)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->where('tb_turmas.SituacaoTurma', 'ATIVO')
                ->get();
        return $Alunos;
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
    // Metodo que busca informações sobre a turma
    public static function infTurma($idTurmas) {
        $turma = tb_turma_aluno::select()
                ->where('idTurmas', $idTurmas)
                ->get();
        return $turma;
    }

// Fecha Classe Principal
}
