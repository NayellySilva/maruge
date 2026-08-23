<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_reserva extends Model {

    protected $table = 'tb_reservas';
    protected $primaryKey = 'idReservas';
    public $timestamps = false;
    //Campos que podem ser preenchido com informação do usuario
    protected $fillable = [
        'tb_aluno_idAluno', 'tb_turmas_idTurmas', 'data_reserva'
    ];
    // Campos Obrigatorios
    static $camposObg = [
        'data_reserva' => 'required',
        'tb_turmas_idTurmas' => 'required',
    ];

    //Metodo pra salva um novo aluno
    public static function salvandoReserva($dadosForm) {
        $novaReseva = new tb_reserva($dadosForm);
        $novaReseva->save();
        return $novaReseva;
    }

    // Metodo que lista todos os pre-matriculados
    public static function prematriculados() {
        return tb_reserva::select()
                        ->join('tb_aluno', 'tb_aluno.idAluno', '=', 'tb_reservas.tb_aluno_idAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_reservas.tb_turmas_idTurmas')
                        ->select('tb_reservas.idReservas','tb_reservas.data_reserva', 'tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                        ->get();
    }
      // Metodo que verificar se o aluno ja tem uma reserva feita
    public static function verificar_preMatricula($dadosForm) {
       
        $Alunos = tb_reserva::select()
            ->select('tb_reservas.*')
            ->where([['tb_aluno_idAluno', $dadosForm['tb_aluno_idAluno']]])
            ->count();
        return $Alunos > 0;
          
    }
//Fechando a Class Principal
}
