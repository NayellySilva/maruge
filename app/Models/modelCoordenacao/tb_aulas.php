<?php
namespace App\Models\modelCoordenacao;
use Illuminate\Database\Eloquent\Model;
class tb_aulas extends Model {
    protected $table = 'tb_aulas';
    protected $primaryKey = 'idAula';
    public $timestamps = false;
    
    
    
    protected $fillable = [
        'tb_turmas_idTurmas', 'aula', 'data_aula', 'ObsAula'
    ];  

    
    // Campos Obrigatorios
    static $camposObg = [
        'aula' => 'required',
        'data_aula' => 'required',
        'tb_turmas_idTurmas' => 'required',
    ];
    
    
    //Relacionamento com a tabela turma
    public function turmaAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_turma', 'idTurmas', 'tb_turmas_idTurmas');
    }
    
    // Verificando se a aula informada ja existe no banco de dados
    public static function verificarSeAulaExistem($dadosForm) {
        $verificar = tb_aulas::select()
                ->where('tb_turmas_idTurmas', '=', $dadosForm['tb_turmas_idTurmas'])
                ->where('aula', '=', $dadosForm['aula'])
                ->where('data_aula', '=', $dadosForm['data_aula'])
                 ->get();
        return $verificar;
    }
  
    //Metodo pra salva uma nova aula
    public static function salvandoAula($dadosForm) {
        $novaAula = new tb_aulas($dadosForm);
        $novaAula->save();
        return 1;
    }
    //Metodo QUE BUSCA AS AULAS DE MA TURMA
    public static function BuscaAulas($idTurmas) {
                return tb_aulas::select()
                  ->orderBy('data_aula', 'desc')
                        ->where('tb_turmas_idTurmas', $idTurmas)
                        ->get();
    }
    
    //Editando Turma recebendo a turma por parametro idturma
    public static function editandoAula($idAula, $dadosForm) {
        $aula = tb_aulas::select()->find($idAula);
        $updateAula = $aula->update($dadosForm);
        return $updateAula;
    }
    
    // Buscando a nota do aluno, referente a disciplina informada no parametro
    public static function quantidadesdeaulas($turma) {
        
       
        return tb_aulas::select()
                        ->select('tb_aulas.*')
                        ->where('tb_aulas.tb_turmas_idTurmas', '=', $turma)
                        ->count();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    // FECHANDO A CLASSE MODEL TB_AULAS
}