<?php
namespace App\Models\modelDocente;
use Illuminate\Database\Eloquent\Model;
class tb_escola_docente extends Model {
    protected $table = 'tb_escola';
    protected $primaryKey = 'idEscola';
    public $timestamps = false;
    protected $fillable = [
        'NomeEscola', 'CNPJ', 'EmailColegio', 'NumeroInep'
    ];  
    // Campos Obrigatorios
    static $camposObg = [
        'NomeEscola' => 'required',
        'Rua' => 'required',
        'Numero' => 'required',
        'Cidade' => 'required',
        'Bairro' => 'required',
        'Estado' => 'required',  
    ];
//Relacionamento com a tabela endereço 1<>1
public function endEscola(){
    return $this->hasOne('App\Models\modelDocente\tb_endereco_docente','idEndereco','tb_endereco_idEndereco');
    }
    
 // Puxando todas as informações sobre a escola   
 public static function informacaoEscolar()
{    return tb_escola_docente::select()
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_escola.tb_endereco_idEndereco')
                ->select('tb_escola.idEscola', 'tb_escola.*', 'tb_escola.tb_endereco_idEndereco', 'tb_endereco.*')
                ->get();
}
// FECHANDO A CLASSE MODEL TB_ESCOLA    
}