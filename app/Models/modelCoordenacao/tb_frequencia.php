<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_frequencia extends Model {
   protected $table = 'tb_frequencia';
    protected $primaryKey = 'idfrequencia';
    public $timestamps = false;
    //Campos que podem ser preenchido com informação do usuario
    protected $fillable = [
        'inf_dia', 'dia', 'mes', 'ano', 'situacao','RA','tb_aluno_idAluno','tb_turmas_idTurmas'
        ];
    //Relacionamento com a tabela turma
    public function turmaAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_turma', 'idTurmas', 'tb_turmas_idTurmas');
    }
        
    //Relacionamento com a tabela Aluno
    public function RfrequenciaAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_aluno', 'idAluno', 'tb_aluno_idAluno');
    }
    //Metodo pra salva nota dos alunos educação infantil 1bim
    public static function salvandoFrequencia($dadosForm) {
        $count = count($dadosForm["RA"]); // CRIANDO UM CONTADO COM REFERENCIAS AOS RA DOS ALUNOS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $frequencia = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["RA"][$i])) {
                    $frequencia = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'inf_dia' => $dadosForm["inf_dia"][$i],
                        'dia' => $dadosForm["dia"],//[$i],
                        'mes' => $dadosForm["mes"],//[$i],
                        'ano' => $dadosForm["ano"][$i],
                        'situacao' => $dadosForm["situacao"][$i],
                    ];
                    $contador = tb_frequencia::select()// buscando Inf_dia/turma e aluno para verificar se a chamada ja foi realizada , se tive realizada ela vai atualizar.
                           ->select('tb_frequencia.*')
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                           // ->where('inf_dia', '=', $dadosForm["inf_dia"][$i])
                            ->where('dia', '=', $dadosForm["dia"])
                            ->where('mes', '=', $dadosForm["mes"])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_frequencia::select()
                                ->select('tb_frequencia.*')
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->where('dia', '=', $dadosForm["dia"])
                                ->where('mes', '=', $dadosForm["mes"])
                                ->update($frequencia);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_frequencia::create($frequencia);// SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "FrequenciaRealizada";
        }
    }  
    
    
    
    
    
    
    
        //Metodo que filtra o aluno por turma
   // Buscando a frequencia do aluno, referente a mes informada no parametro
    public static function Busca_Frequencia_do_Aluno($idAluno,$mes) {
        return tb_frequencia::select()
                       ->select('tb_frequencia.mes')
                       ->where('tb_frequencia.tb_aluno_idAluno', '=', $idAluno)
                       ->where('tb_frequencia.mes', '=', $mes)
                       ->groupBy('tb_frequencia.mes')
                       ->get();
    }
   // Buscando as presença do aluno do aluno, referente a mes informada no parametro
    public static function Busca_Presenca($idAluno,$mes) {
                    return tb_frequencia::select()
                        ->select('tb_frequencia.situacao')
                        ->where('tb_frequencia.tb_aluno_idAluno', '=', $idAluno)
                        ->where('tb_frequencia.mes', '=', $mes)
                        ->where('tb_frequencia.situacao', '=', "PRESENTE")
                        ->count();
    }
   // Buscando as presença do aluno do aluno, referente a mes informada no parametro
    public static function Busca_Falta($idAluno,$mes) {
                    return tb_frequencia::select()
                        ->select('tb_frequencia.situacao')
                        ->where('tb_frequencia.tb_aluno_idAluno', '=', $idAluno)
                        ->where('tb_frequencia.mes', '=', $mes)
                        ->where('tb_frequencia.situacao', '=', "FALTA")
                        ->count();
    }
   // Buscando as presença do aluno do aluno, referente a mes informada no parametro
    public static function Busca_Justificado($idAluno,$mes) {
                    return tb_frequencia::select()
                        ->select('tb_frequencia.situacao')
                        ->where('tb_frequencia.tb_aluno_idAluno', '=', $idAluno)
                        ->where('tb_frequencia.mes', '=', $mes)
                        ->where('tb_frequencia.situacao', '=', "JUSTIFICADO")
                        ->count();
    }
    
    
    
        //Metodo que busca os alunos e suas faltas
    public static function buscandoFrequenciadoAluno($idTurma) {       
         $FrequenciadoAluno = tb_frequencia::select()
                //->orderBy('NomeAluno')
                ->join('tb_aluno', 'tb_aluno.idAluno', '=', 'tb_frequencia.tb_aluno_idAluno')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_frequencia.tb_turmas_idTurmas')
                ->select('tb_frequencia.*')
                ->where('tb_frequencia.tb_turmas_idTurmas', $idTurma)
              //  ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->get();
        return $FrequenciadoAluno;
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        //Metodo que busca os alunos e suas faltas
    public static function buscandoFrequenciadoAluno222($idTurma) {       
         $FrequenciadoAluno = tb_frequencia::select()
                //->orderBy('NomeAluno')
                ->join('tb_aluno', 'tb_aluno.idAluno', '=', 'tb_frequencia.tb_aluno_idAluno')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_frequencia.tb_turmas_idTurmas')
                ->select('tb_frequencia.*')
                ->where('tb_frequencia.tb_turmas_idTurmas', $idTurma)
              //  ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->get();
        return $FrequenciadoAluno;
    }
    
    
    
    
    
        //Metodo que busca os alunos e suas faltas
    public static function buscandoFrequenciadoAluno2($idTurma) {       
         $FrequenciadoAluno = tb_aluno::select()
                ->orderBy('NomeAluno')
                ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
                ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')

                ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
                ->where('tb_aluno.tb_turmas_idTurmas', $idTurma)
                ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
                ->get();
        return $FrequenciadoAluno;

    }
    
    
    
    

    
    
    
    
    
    
    
 } //CHAVE PRINCIPAL