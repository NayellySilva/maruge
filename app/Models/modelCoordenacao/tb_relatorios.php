<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_relatorios extends Model {

    protected $table = 'tb_aluno';
    protected $primaryKey = 'idAluno';

    //Relatorios de alunos matriculados (ATIVOS)
    public static function alunoMatriculados() {
        return tb_aluno::select()
                        ->orderBy('NomeAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_matriculas.RA', 'tb_turmas.NomeTurma', 'tb_pais.FonePai1', 'tb_pais.FoneMae1')
                        ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                        ->get();
    }

    //Relatorios de alunos Transferidos ou Desistentes (INATIVOS)
    public static function alunoTransferidos() {
        return tb_aluno::select()
                        ->orderBy('NomeAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.NomeAluno', 'tb_aluno.DataNascimento','tb_aluno.Ultima_Turma',    'tb_matriculas.RA', 'tb_matriculas.Saida', 'tb_turmas.NomeTurma', 'tb_turmas.AnoLetivo', 'tb_pais.FonePai1', 'tb_pais.FoneMae1')
                        ->where('tb_matriculas.SituacaoAluno', 'INATIVO')
                        ->get();
    }

    //Metodo que filtra o aluno por turma
    public static function alunosPorTurma($idturmas) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                ->select('tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_matriculas.RA', 'tb_turmas.NomeTurma', 'tb_pais.FonePai1', 'tb_pais.FoneMae1')
                ->where('tb_aluno.tb_turmas_idTurmas', $idturmas)
                ->get(10);
        return $Alunos;
    }
     // Quantidade de alunos cadastrados
    public static function quantAlunosCadastrados() {
        return tb_aluno::select()
                        ->count();
    }

    // Campos Obrigatorios
    static $camposObg = [
        'NomeAluno' => 'required',
        'tb_turmas_idTurmas' => 'required',
    ];

    // Metodo de Messagens
    public function messages() {
        return [
            'NomeAluno.required' => 'O nome do aluno é Obrigatório',
            'tb_turmas_idTurmas.required' => 'É obrigatório informar o nome da turma',
        ];
    }

//Fechando a Class Principal
}
