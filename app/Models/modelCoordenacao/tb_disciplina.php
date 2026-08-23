<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;
use App\Models\modelCoordenacao\tb_notas;

class tb_disciplina extends Model {

    protected $table = 'tb_disciplinas';
    protected $guard = ['idDisciplina'];
    protected $primaryKey = 'idDisciplinas';
    public $timestamps = false;
    protected $fillable = ['NomeDisciplina'];
// Campos Obrigatorios para edita o nome da disciplina
    static $camposObg = [
        'NomeDisciplina' => 'required|unique:tb_disciplinas',
    ];
        
// Selecionando todas as disciplinas paginando   
 public static function disciplinasCadastradas()
{    return tb_disciplina::select()
              ->orderBy('NomeDisciplina')
                ->paginate(20); 
}
// Selecionando todas as disciplinas paginando   
 public static function listagemDeDisciplinas()
{    return tb_disciplina::select()
              ->orderBy('NomeDisciplina')
        ->get();
 
}
// verificando quantas disciplinas estão cadastradas  
 public static function quantDisciplinasCadastradas()
{    return tb_disciplina::select()
              ->count(); 
}
 // Buscando a nota do aluno, referente a disciplina informada no parametro
        public static function busca_notas_do_aluno($idAluno, $disciplina) {

            return tb_notas::select()
                            ->select('tb_notas.*')
                            ->where('tb_notas.tb_aluno_idAluno', '=', $idAluno)
                            ->where('tb_notas.tb_disciplinas_idDisciplinas', '=', $disciplina)
                            ->get('AB1');
        }
        
// METODOS ULTILIZADOS NO MODULO DOCENTE        
// Quantidande de disciplinas vinculadas ao professor
public static function quantidadeDeDisciplinasDoProfessor($idFuncionarios) {
        return tb_turmas_disciplinas::select()
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', $idFuncionarios)
                        ->groupBy('tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->get();
    }

        

//Fechando a classe principal
}
