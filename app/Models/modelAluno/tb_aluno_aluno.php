<?php

namespace App\Models\modelAluno;

use Illuminate\Database\Eloquent\Model;

class tb_aluno_aluno extends Model {

    protected $table = 'tb_aluno';
    protected $primaryKey = 'idAluno';
    public $timestamps = false;
    
    
    //Campos que podem ser preenchido com informação do usuario
    protected $fillable = [
        'NomeAluno', 'DataNascimento', 'Sexo', 'EstadoCartorio', 'NumeroRGNovo',
        'NumeroFolha', 'NumeroLivro', 'NumeroMac', 'CidadeCartorio', 'NumeroRG','CPFAluno',
        'DataEmissao', 'NomeCartorio', 'ObsAluno', 'Ultima_Turma', 'tb_turmas_idTurmas'
    ];

    /*     * **************
      Relacionamentos entre as tabelas
     * ************* */

    //Relacionamento com a tabela endereço
    public function endAluno() {
        return $this->hasOne('App\Models\modelAluno\tb_endereco_aluno', 'idEndereco', 'tb_endereco_idEndereco');
    }

    //Relacionamento com a tabela matricula
    public function matriculaAluno() {
        return $this->hasOne('App\Models\modelAluno\tb_matricula_aluno', 'idMatriculas', 'tb_matriculas_idMatriculas');
    }

    //Relacionamento com a tabela turma
    public function turmaAluno() {
        return $this->hasOne('App\Models\modelAluno\tb_turma_aluno', 'idTurmas', 'tb_turmas_idTurmas');
    }

    //Relacionamento com a tabela pais
    public function paisAluno() {
        return $this->hasOne('App\Models\modelAluno\tb_pais_aluno', 'idPais', 'tb_pais_idPais');
    }


    // Metodo que busca o aluno que esta logado
    public static function infAluno($RA) {
        return tb_aluno_aluno::select()
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->select('tb_aluno.NomeAluno','tb_aluno.idAluno','tb_matriculas.RA')
                ->where('tb_matriculas.RA',$RA)
                ->get();
    }
    // Metodo que busca o aluno que esta logado
    public static function perfilAluno($idAluno) {
        return tb_aluno_aluno::select()
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_aluno.tb_endereco_idEndereco')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                ->where('tb_aluno.idAluno',$idAluno)
                ->get();
    }
    // Metodo que busca o aluno que esta logado
    public static function perfilParaDeclaraçãoAluno($idAluno) {
        return tb_aluno_aluno::select()
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_aluno.tb_endereco_idEndereco')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                ->where('tb_aluno.idAluno',$idAluno)
                ->where('tb_turmas.SituacaoTurma', 'ATIVO')
                ->get();
    }
    // Metodo que busca o aluno que esta logado
    public static function infAlunopraNotas($idAluno) {
        return tb_aluno_aluno::select()
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_aluno.tb_endereco_idEndereco')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                ->where('tb_aluno.idAluno',$idAluno)
                ->where('tb_turmas.SituacaoTurma', 'ATIVO')
                ->get();
    }
    
    // Campos Obrigatorios para transferir aluno
    static $alterarSenha = [
        'password' => 'required|min:8|max:8',
    ];
    

//Fechando a Class Principal
}
