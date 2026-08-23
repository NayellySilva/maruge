<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class tb_aluno extends Model {

    protected $table = 'tb_aluno';
    protected $primaryKey = 'idAluno';
    public $timestamps = false;
    //Campos que podem ser preenchido com informação do usuario
    protected $fillable = [
        'NomeAluno', 'DataNascimento', 'Sexo', 'EstadoCartorio', 'NumeroRGNovo',
        'NumeroFolha', 'NumeroLivro', 'NumeroMac', 'CidadeCartorio', 'NumeroRG','CPFAluno',
        'DataEmissao', 'NomeCartorio', 'ObsAluno', 'Ultima_Turma','Acompanhamento', 'tb_turmas_idTurmas'
    ];

    /*     * **************
      Relacionamentos entre as tabelas
     * ************* */

    //Relacionamento com a tabela endereço
    public function endAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_endereco', 'idEndereco', 'tb_endereco_idEndereco');
    }

    //Relacionamento com a tabela matricula
    public function matriculaAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_matricula', 'idMatriculas', 'tb_matriculas_idMatriculas');
    }

    //Relacionamento com a tabela turma
    public function turmaAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_turma', 'idTurmas', 'tb_turmas_idTurmas');
    }

    //Relacionamento com a tabela pais
    public function paisAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_pais', 'idPais', 'tb_pais_idPais');
    }
    //Relacionamento com a tabela DAS NOTAS 2016
    public function notas_2016() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_notas_2016', 'tb_aluno_idAluno', 'idAluno');
    }
    //Relacionamento com a tabela DAS NOTAS 2017
    public function notas_2017() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_notas_2017', 'tb_aluno_idAluno', 'idAluno');
    }
    //Relacionamento com a tabela de Boletos
    public function boletosInf() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_carne', 'tb_aluno_idAluno', 'idAluno');
    }
    
//Metodo pra salva um novo aluno
    public static function salvandoAluno($dadosForm, $RA) {
              
      
       
        
        
//Gerando Senha do Acesso ao Portal do aluno
        $password = bcrypt($RA);
// Gerando o Email
        $condificação = Str::words($dadosForm['NomeAluno'], 1, '');
       $Email = Str::lower($condificação.$RA."@ccdm.com.br");
// Salvando os dados referente a tabela de matricula
       
       
      
       
        $novaMatricula = new tb_matricula($dadosForm);
        $novaMatricula->RA = $RA;
        $novaMatricula->Email = $Email;
        $novaMatricula->password = $password;
        $novaMatricula->save();
        $idMatriculas = $novaMatricula->idMatriculas;
// Salvando os dados referente a tabela de endereco
        $novoEndereco = new tb_endereco($dadosForm);
        $novoEndereco->save();
        $idEndereco = $novoEndereco->idEndereco;
// Salvando os dados referente a tabela de pais
        $novosPais = new tb_pais($dadosForm);
        $novosPais->save();
        $idPais = $novosPais->idPais;
// Salvando os dados referente a tabela aluno
        $novoAluno = new tb_aluno($dadosForm);
        // $novoAluno->tb_turmas_idTurmas = $dadosForm['NomeTurma'];
        $novoAluno->tb_matriculas_idMatriculas = $idMatriculas;
        $novoAluno->tb_endereco_idEndereco = $idEndereco;
        $novoAluno->tb_pais_idPais = $idPais;
        $novoAluno->save();
        return 1;
    }


    
    
    // Metodo que lista todos os alunos matriculados
    public static function listagemAluno() {
        return tb_aluno::orderBy('tb_aluno.NomeAluno')
                        ->leftJoin('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->leftJoin('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                        ->where(function($query) {
                            $query->whereIn('tb_matriculas.SituacaoAluno', ['ATIVO', 'MATRICULADO'])
                                  ->orWhereNull('tb_matriculas.SituacaoAluno')
                                  ->orWhere('tb_matriculas.SituacaoAluno', '');
                        })
                        ->paginate(15);
    }
  
    

// Metodo que lista todos os alunos cadastrado no sistema (ATIVO-INATIVO-TRANSFERIDO OU DESISTENTE)
    public static function listagemDeTodosAlunos() {
        return tb_aluno::select()
                        ->orderBy('NomeAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                      //  ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->paginate(10);
    }
    
    
    
    
    
    
    // Metodo que lista todos os alunos matriculados
    public static function listagemAlunoComBoletosRegistrados() {
        return tb_aluno::select()
                        ->orderBy('NomeAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                        ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                        ->paginate(10);
    }
   
    
    
    
    
    
    
    
    // Metodo que verificar se o aluno ja esta matriculado atravez do relacionamento com a mãe
    public static function verificarAluno($dadosForm) {
        $Alunos = tb_aluno::select()
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                ->select('tb_pais.NomeMae', 'tb_aluno.NomeAluno')
                ->where([['NomeMae', $dadosForm['NomeMae']], ['NomeAluno', $dadosForm['NomeAluno']]])
                ->count();
        return $Alunos > 0;
    }
    
    
    //Relatorios de alunos matriculados (ATIVOS)
    public static function alunoMatriculados() {
        return tb_aluno::select()
                        ->orderBy('NomeAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_matriculas.RA', 'tb_turmas.NomeTurma', 'tb_pais.FonePai1', 'tb_pais.FoneMae1', 'tb_aluno.Sexo','tb_pais.NomeMae','tb_pais.NomePai')
                        ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                        ->get();
    }
    
    
    //Relatorios de alunos TRANSFERISOS OU INATIVOS 
    public static function alunoTransferidos() {
        return tb_aluno::select()
                        ->orderBy('NomeAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_aluno.Ultima_Turma', 'tb_matriculas.RA', 'tb_matriculas.Saida', 'tb_turmas.NomeTurma', 'tb_turmas.AnoLetivo', 'tb_pais.FonePai1', 'tb_pais.FoneMae1')
                      // ->where('tb_matriculas.SituacaoAluno', 'INATIVO')
                      // ->where('tb_matriculas.SituacaoAluno', '<>', 'ATIVO')
                        ->get();
    }
    
    
    
    
    //Metodo ultilizado para busca todos os alunos inativos (metodo usado no modulos:Rematricula)
    public static function alunoInativos() {
        return tb_aluno::select()
                        ->orderBy('NomeAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        //  ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                        ->where('tb_matriculas.SituacaoAluno', '<>', 'ATIVO')
                        ->paginate(10);
    }
    //Metodo ultilizado para busca todos os alunos inativos (metodo usado no modulos:Reservas)
    public static function todosAlunos() {
        return tb_aluno::select()
                        ->orderBy('NomeAluno')
                        ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                        //  ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                        ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                        ->paginate(10);
    }
    // Metodo que pesquisa o aluno pos palavra chave
    public static function pesquisar($palavrachave) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_turmas.NomeTurma', 'tb_matriculas.SituacaoAluno')
                ->where('NomeAluno', 'LIKE', "%$palavrachave%")
                ->where('tb_matriculas.SituacaoAluno', '<>', 'INATIVO')
                ->get();
        return $Alunos;
    }
    // Metodo que pesquisa o aluno pos palavra chave
    public static function pesquisarAlunoBoleto($palavrachave) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_turmas.NomeTurma', 'tb_matriculas.SituacaoAluno')
                ->where('NomeAluno', 'LIKE', "%$palavrachave%")
               // ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->get();
        return $Alunos;
    }
    // Metodo que pesquisa o aluno pos palavra chave
    public static function pesquisarAlunoAcordo($palavrachave) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_turmas.NomeTurma', 'tb_matriculas.SituacaoAluno')
                ->where('NomeAluno', 'LIKE', "%$palavrachave%")
            //    ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->get();
        return $Alunos;
    }
    // Metodo que pesquisa o aluno pos palavra chave para rematricula
    public static function pesquisarInativos($palavrachave) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_turmas.NomeTurma', 'tb_matriculas.SituacaoAluno')
                ->where('NomeAluno', 'LIKE', "%$palavrachave%")
                ->where('tb_matriculas.SituacaoAluno', '<>', 'ATIVO')
            //    ->where('tb_matriculas.SituacaoAluno', 'INATIVO')
                ->paginate(10);
        return $Alunos;
    }
    // Metodo que pesquisa o aluno pos palavra chave para reserva
    public static function pesqTodosAlunos($palavrachave) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA', 'tb_turmas.NomeTurma', 'tb_matriculas.SituacaoAluno')
                ->where('NomeAluno', 'LIKE', "%$palavrachave%")
                ->paginate(50);
        return $Alunos;
    }
    //Metodo que filtra o aluno por turma
    public static function filtroporTurma($idTurma) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->leftJoin('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_aluno.tb_endereco_idEndereco')
                ->select(
                    'tb_aluno.idAluno', 'tb_aluno.NomeAluno','tb_aluno.DataNascimento', 
                    'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma',
                    'tb_endereco.Rua', 'tb_endereco.Numero', 'tb_endereco.Bairro', 'tb_endereco.Cidade', 'tb_endereco.Estado', 'tb_endereco.Fone1'
                )
                ->where('tb_aluno.tb_turmas_idTurmas', $idTurma)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->paginate(60);
        return $Alunos;
    }
//Metodo que busca alunos por turma
    public static function alunosPorTurma($idturmas) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma','tb_pais.NomeMae','tb_pais.NomePai','tb_pais.FonePai1', 'tb_pais.FoneMae1')
                ->where('tb_aluno.tb_turmas_idTurmas', $idturmas)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->get();
        return $Alunos;
    }
    
//Metodo que busca alunos por turma
    public static function alunosPorTurmaEndereco($idturmas) {
        $Alunos = tb_aluno::select()
                ->orderBy('NomeAluno')
                
                
                
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
                ->join('tb_pais', 'tb_pais.idPais', '=', 'tb_aluno.tb_pais_idPais')
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_aluno.tb_endereco_idEndereco')
                
           
                
                
                ->select(
                        'tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 
                        'tb_matriculas.RA',
                        'tb_matriculas.Email',
                        'tb_matriculas.SituacaoAluno', 
                        'tb_turmas.NomeTurma',
                        'tb_endereco.Numero',
                        'tb_endereco.Rua',
                        'tb_endereco.Bairro',
                        'tb_endereco.Referencia',
                        'tb_endereco.Fone1'
                        
                        )
              
                
                
                
                ->where('tb_aluno.tb_turmas_idTurmas', $idturmas)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->get();
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
    // Campos Obrigatorios para transferir aluno
    static $camposObgTransferindo = [
        'Saida' => 'required',
    ];

//Fechando a Class Principal
}
