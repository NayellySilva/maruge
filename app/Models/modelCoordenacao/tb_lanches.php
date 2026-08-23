<?php
namespace App\Models\modelCoordenacao;
use Illuminate\Database\Eloquent\Model;


class tb_lanches extends Model {

    protected $table = 'tb_lanches';
    protected $guard = ['idlanche'];
    protected $primaryKey = 'idlanche';
    public $timestamps = false;
    protected $fillable = ['NomeLanche', 'ValorLanche'];
// Campos Obrigatorios
    static $camposObg = [
        'NomeLanche' => 'required',
        'ValorLanche' => 'required',
    ];
    
    // Verificando se a turma informada ja existe no banco de dados
    public static function verificarSeLancheExistem($dadosForm) {
        $verificar = tb_lanches::select()
                ->where('NomeLanche', '=', $dadosForm['NomeLanche'])
                ->get();
        return $verificar;
    }
    // listando os lanches que existem cadastrados para exibir na view lanche_inf
    public static function lanche_inf() {
        return tb_lanches::select()
                        ->orderBy('NomeLanche')
                        ->paginate(10);
    }
    
    public static function pesquisar($palavrachave) {
        $lanches = tb_lanches::select()
        ->where('NomeLanche', 'LIKE', "%$palavrachave%")
                ->get();
                return $lanches;
    }
    
// Fecha Classe Principal
}
