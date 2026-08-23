<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;
use TbAluno;

class tb_turma extends Model {

    protected $table = 'tb_turmas';
    protected $guard = ['idTurmas'];
    protected $primaryKey = 'idTurmas';
    public $timestamps = false;
    protected $fillable = ['NomeTurma', 'Mensalidade', 'SituacaoTurma', 'AnoLetivo'];
// Campos Obrigatorios
    static $camposObg = [
        'NomeTurma' => 'required',
        'Mensalidade' => 'required',
        'SituacaoTurma' => 'required',
        'AnoLetivo' => 'required',
    ];

// METODO QUE ESTÃO SENDO USADO PARA OS USUARIO COORDENAÇÃO
//Relacionamento com a tabela Aluno
    public function alunoTurma() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_aluno', 'tb_turmas_idTurmas', 'idTurmas');
    }

//Relacionamento com a tabela turma
    public function disciplinaTurma() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_turmas_disciplinas', 'tb_turmas_idTurmas', 'idTurmas');
    }

// Selecionando as Turmas Ativas ultilizando no selecte do formularo da cad_aluno    
    public static function turmasAtivas() {
        return tb_turma::select('NomeTurma', 'idTurmas')
                        ->orderBy('NomeTurma')
                        ->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA'])
                        ->get();
    }
    
    // Selecionando as Turmas Ativas ultilizando no selecte do formularo da cad_aluno    
    public static function turmasAtivasRelatorioFinaceiro() {
        return tb_turma::select('NomeTurma', 'idTurmas')
                        ->orderBy('NomeTurma')
                        ->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA'])
                        ->get();
    }
    
// Selecionando as Turmas Inativas para ultilizar no selecte para usar no relatorio de alunos por turma (relatorio_aluno_turmas)    
    public static function AnoLetivoTurmasInativas() {
        return tb_turma::select('AnoLetivo')
                        ->whereIn('SituacaoTurma', ['INATIVO', 'INATIVA'])
                        ->groupBy('AnoLetivo')
                        ->orderBy('AnoLetivo')
                        ->get();
    }

// listando as turmas ultilizando na view turma_inf
    public static function listandoTurmasAtivas() {
        return tb_turma::select()
                        ->orderBy('NomeTurma')
                        ->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA'])
                        ->paginate(10);
    }
// Buscando anos da turma existentes.
    public static function AnosLetivosExistentes() {
        return tb_turma::select('AnoLetivo')
                        ->orderBy('AnoLetivo')
                        ->groupBy('AnoLetivo')
                        ->orderBy('AnoLetivo')
                        ->get();
    }
// listando as turmas ultilizando na view turma_inf
    public static function listandoTurmasAtivasAulas() {
        return tb_turma::select()
                        ->orderBy('NomeTurma')
                        ->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA'])
                        ->get();
    }
// listando as turmas ultilizando na view turma_inf
    public static function relatorioTurmasAtivas() {
        return tb_turma::select()
                        ->orderBy('NomeTurma')
                        ->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA'])
                        ->get();
    }

// listando as turmas ultilizando no selectec do filtro turma
    public static function listandoTurmasAtivasNoSelect() {
        return tb_turma::select()
                        ->orderBy('NomeTurma')
                        ->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA'])
                        ->get();
    }

// listando as turmas ultilizando na view turma_inf
    public static function listandoTurmaslocadas() {
        return tb_turma::select()
                        ->orderBy('NomeTurma')
                        ->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA'])
                        ->paginate(3);
    }

// Verificando se a turma informada ja existe no banco de dados
    public static function verificarSeTurmaExistem($dadosForm) {
        $verificar = tb_turma::select()
                ->where('NomeTurma', '=', $dadosForm['NomeTurma'])
                ->where('AnoLetivo', '=', $dadosForm['AnoLetivo'])
                ->where('SituacaoTurma', '=', $dadosForm['SituacaoTurma'])
                ->where('Mensalidade', '=', $dadosForm['Mensalidade'])
                ->get();
        return $verificar;
    }

//Editando Turma recebendo a turma por parametro idturma
    public static function editandoTurma($idTurmas, $dadosForm) {
        $turma = tb_turma::select()->find($idTurmas);
        $updateTurma = $turma->update($dadosForm);
        return $updateTurma;
    }

// Metodo que pesquisa uma turma pos palavra chave ultilizado no controle turmas
    public static function pesquisar($palavrachave) {
        $turma = tb_turma::select()
                ->orderBy('NomeTurma')
                ->where('NomeTurma', 'LIKE', "%$palavrachave%")
                ->where('SituacaoTurma', 'ATIVO')
                ->paginate(10);
        return $turma;
    }
// Metodo que pesquisa uma turma pos palavra chave usado no controle relatorios
    public static function pesquisadoRelatorio($palavrachave) {
        $turma = tb_turma::select()
                ->orderBy('NomeTurma')
                ->where('NomeTurma', 'LIKE', "%$palavrachave%")
                ->where('SituacaoTurma', 'ATIVO')
                ->get();
        return $turma;
    }
// Metodo que pesquisa uma turma por ano letivo
    public static function pesquisarAnoletivo($AnoLetivo) {
        $turma = tb_turma::select()
                ->orderBy('NomeTurma')
                ->where('AnoLetivo', 'LIKE', "%$AnoLetivo%")
                ->get();
        return $turma;
    }

// Metodo que filtra turmas por situação
    public static function filtroporSituacaoTurma($SituacaoTurma) {
        $turma = tb_turma::select()
                ->orderBy('NomeTurma')
                ->where('SituacaoTurma', $SituacaoTurma)
                ->get();
        return $turma;
    }

// Metodo que filtra turmas por IdTurma
    public static function filtroporidTurmas($idTurmas) {
        $turma = tb_turma::select()
                ->orderBy('idTurmas')
                ->where('idTurmas', $idTurmas)
                ->paginate(10);
        return $turma;
    }

// Metodo que busca informações sobre a turma
    public static function infTurma($idTurmas) {
        $turma = tb_turma::select()
                ->where('idTurmas', $idTurmas)
                ->get();
        return $turma;
    }


//Metodo qque busca os alunos da turma
    public static function alunosdaturma($idTurma) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                ->where('tb_aluno.tb_turmas_idTurmas', $idTurma)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->paginate(60);
        return $Alunos;
    }
//Metodo que busca os alunos da turma que estão ativos e inativos
    public static function alunosdaturmaParaMapas($idTurma) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                ->where('tb_aluno.tb_turmas_idTurmas', $idTurma)
                ->where('tb_matriculas.SituacaoAluno', '<>', 'INATIVO')
                ->paginate(60);
        return $Alunos;
    }

    //METODOS QUE SÃO ULTILIZADO PARA USUARIOS DOCENTES
    // Selecionando as Turmas Ativas que o docente esta vinculado.    
    public static function quantidadeDeTurmaDoProfessor($idFuncionarios) {
        return tb_turmas_disciplinas::select()
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', $idFuncionarios)
                        ->where('SituacaoTurma', 'ATIVO')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->groupBy('tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->get();
    }
    
    //Metodo que busca a turma do aluno em 2016
    public static function turma2016($idAluno) {
        return tb_turma::select()
  ->orderBy('NomeTurma')
                ->join('tb_notas_2016', 'tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
                ->where('tb_notas_2016.tb_aluno_idAluno', $idAluno)
                ->select('tb_turmas.idTurmas', 'AnoLetivo','NomeTurma')
                ->groupBy('tb_turmas.NomeTurma')
                        ->get();
    }
    //Metodo que busca a turma do aluno em 2017
    public static function turma2017($idAluno) {
        return tb_turma::select()
  ->orderBy('NomeTurma')
                ->join('tb_notas_2017', 'tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
                ->where('tb_notas_2017.tb_aluno_idAluno', $idAluno)
                ->select('tb_turmas.idTurmas', 'AnoLetivo','NomeTurma')
                ->groupBy('tb_turmas.NomeTurma')
                        ->get();
    }
    
    
    
    
    

// Fecha Classe Principal
}
