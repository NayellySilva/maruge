<?php

namespace App\Models\modelDocente;

use Illuminate\Database\Eloquent\Model;

class tb_usuario_docente extends Model {

    protected $table = 'tb_usuario';
    protected $guard = ['idUsuario'];
    protected $primaryKey = 'idUsuario';
    // public $timestamps = false;
    protected $fillable = ['password', 'CPFUsuario', 'Nivel', 'Situacao'];
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Relacionamento Funcionario e Usuario
    public function cpfFuncionario() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_funcionarios', 'idFuncionarios', 'tb_funcionarios_idFuncionariosÃ?ndice');
    }


// metodo que busca os dados de usuario para uso de indentifica na tela do painel dashboard
    public static function infUsuario($CPFfuncionario) {
         return tb_usuario_docente::select()
                ->where('CPFUsuario', $CPFfuncionario)
                 ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_usuario.tb_funcionarios_idFuncionarios')
                 ->select('tb_funcionarios.NomeFuncionario','tb_funcionarios.idFuncionarios')
                ->get('tb_funcionarios.NomeFuncionario','tb_funcionarios.idFuncionarios');
         
    }

// Fecha Classe Principal
}
