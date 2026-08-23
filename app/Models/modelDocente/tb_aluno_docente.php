<?php

namespace App\Models\modelDocente;

use Illuminate\Database\Eloquent\Model;

class tb_aluno_docente extends Model {

    protected $table = 'tb_aluno';
    protected $primaryKey = 'idAluno';
    public $timestamps = false;
    //Campos que podem ser preenchido com informação do usuario
    protected $fillable = [
        'NomeAluno', 'DataNascimento', 'Sexo', 'EstadoCartorio', 'NumeroRGNovo',
        'NumeroFolha', 'NumeroLivro', 'NumeroMac', 'CidadeCartorio', 'NumeroRG',
        'DataEmissao', 'NomeCartorio', 'ObsAluno', 'Ultima_Turma', 'tb_turmas_idTurmas'
    ];

 //Relacionamento com a tabela endereço
    public function endAluno() {
        return $this->hasOne('App\Models\modelDocente\tb_endereco_docente', 'idEndereco', 'tb_endereco_idEndereco');
    }

    //Relacionamento com a tabela matricula
    public function matriculaAluno() {
        return $this->hasOne('App\Models\modelDocente\tb_matricula_docente', 'idMatriculas', 'tb_matriculas_idMatriculas');
    }

    //Relacionamento com a tabela turma
    public function turmaAluno() {
        return $this->hasOne('App\Models\modelDocente\tb_turma_docente', 'idTurmas', 'tb_turmas_idTurmas');
    }

    //Relacionamento com a tabela pais
    public function paisAluno() {
        return $this->hasOne('App\Models\modelDocente\tb_pais_docente', 'idPais', 'tb_pais_idPais');
    }

    // Metodo que faz alistagem de todos os alunos que o professor possuir    
    public static function AlunosdoProfessor($idFuncionarios) {
        return tb_turmas_disciplinas_docente::select()       
        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
        ->join('tb_aluno', 'tb_aluno.tb_turmas_idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
        ->select('tb_turmas.NomeTurma', 'tb_turmas.idTurmas','tb_aluno.NomeAluno' , 'tb_aluno.idAluno', 'tb_matriculas.RA')
        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
        ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
        ->groupby('idAluno')
        ->orderBy('NomeAluno')
        ->paginate(10);
    }
    // Metodo que faz alistagem de todos os alunos que o professor possuir    
    public static function AlunosdoProfessorTotal($idFuncionarios) {
        return tb_turmas_disciplinas_docente::select()       
        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
        ->join('tb_aluno', 'tb_aluno.tb_turmas_idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
        ->select('tb_turmas.NomeTurma', 'tb_turmas.idTurmas','tb_aluno.NomeAluno' , 'tb_aluno.idAluno', 'tb_matriculas.RA')
        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
        ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
        ->groupby('idAluno')
        ->orderBy('NomeAluno')
        ->get();
    }
        
    
    //Metodo que filtra o aluno por turma
    public static function filtroporTurma($idTurma) {
        $Alunos = tb_aluno_docente::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_aluno.idAluno','tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                ->where('tb_aluno.tb_turmas_idTurmas', $idTurma)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->paginate(100);
        return $Alunos;
    }
    
    // Metodo que pesquisa o aluno pos palavra chave
    public static function pesquisar($palavrachave, $idFuncionarios) {
         return tb_turmas_disciplinas_docente::select()       
        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
        ->join('tb_aluno', 'tb_aluno.tb_turmas_idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
        ->select('tb_turmas.NomeTurma', 'tb_turmas.idTurmas','tb_aluno.NomeAluno', 'tb_aluno.idAluno', 'tb_matriculas.RA')
        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
        ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
        ->where('NomeAluno', 'LIKE', "%$palavrachave%")
        ->groupby('idAluno')
        ->orderBy('NomeAluno')
        ->get();
       
    }
    
    //Metodo que busca alunos por turma
    public static function alunosPorTurma($idturmas) {
        $Alunos = tb_aluno_docente::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma', 'tb_pais.FonePai1', 'tb_pais.FoneMae1')
                ->where('tb_aluno.tb_turmas_idTurmas', $idturmas)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->get();
        return $Alunos;
    }
    
//Fechando a Class Principal
}
