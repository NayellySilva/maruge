<?php
namespace App\Models\modelCoordenacao;
use Illuminate\Database\Eloquent\Model;


class tb_categoria extends Model {

    protected $table = 'tb_categoria';
    protected $guard = ['idCategoria'];
    protected $primaryKey = 'idCategoria';
    public $timestamps = false;
    protected $fillable = ['NomeCategoria'];
// Campos Obrigatorios
    static $camposObg = [
        'NomeCategoria' => 'required',
        
    ];
    
    // Verificando se a turma informada ja existe no banco de dados
    public static function verificarCategoraExiste($dadosForm) {
        $verificar = tb_categoria::select()
                ->where('NomeCategoria', '=', $dadosForm['NomeCategoria'])
                ->get();
        return $verificar;
    }
    // BUSCANDO as categorias que existem cadastrados
    public static function categorias() {
        return tb_categoria::select()
                        ->orderBy('NomeCategoria')
                        ->get();
    }
    
    

    
    
    public static function pesquisar($palavrachave) {
        $categorias = tb_categoria::select()
        ->where('NomeCategoria', 'LIKE', "%$palavrachave%")
                ->get();
                return $categorias;
    }
    
// Fecha Classe Principal
}

