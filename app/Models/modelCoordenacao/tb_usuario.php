<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_usuario extends Model {

    protected $table = 'tb_usuario';
    protected $guard = ['idUsuario'];
    protected $primaryKey = 'idUsuario';
    // public $timestamps = false;
    protected $fillable = ['password', 'CPFUsuario', 'Nivel', 'Situacao'];
    // Campos Obrigatorios


    static $camposObg = [
        'password' => 'required|min:8',
        'Nivel' => 'required',
        'Usuario' => 'required',
        'Situacao' => 'required',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Relacionamento Funcionario e Usuario
    public function cpfFuncionario() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_funcionarios', 'idFuncionarios', 'tb_funcionarios_idFuncionariosÃ?ndice');
    }

    // Salvando novo usuario
    public static function salvandoUsuario($dadosForm, $CPFfuncionario, $idFuncionarios) {
        $novaUsuario = new tb_usuario($dadosForm);
        $novaUsuario->CPFUsuario = $CPFfuncionario;
        $novaUsuario->tb_funcionarios_idFuncionarios = $idFuncionarios;
        $novaUsuario->save();
        return 1;
    }

    public static function verificarUsuarioExistente($CPFfuncionario) {
        $usuario = tb_usuario::select('CPFUsuario')
                ->where('CPFUsuario', $CPFfuncionario)
                ->get();
        return $usuario;
    }

// metodo que busca os dados de usuario para uso de indentifica na tela do painel dashboard
    public static function infUsuario($CPFfuncionario) {
         return tb_usuario::select()
                ->where('CPFUsuario', $CPFfuncionario)
                 ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_usuario.tb_funcionarios_idFuncionarios')
                 ->select('tb_funcionarios.NomeFuncionario','tb_funcionarios.idFuncionarios')
                ->get('tb_funcionarios.NomeFuncionario','tb_funcionarios.idFuncionarios');
         
    }

    // Puxando todos usuarios  
    public static function listagemUsuarios() {
        return tb_usuario::select()
                        ->orderBy('NomeFuncionario')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_usuario.tb_funcionarios_idFuncionarios')
                        ->select('tb_funcionarios.NomeFuncionario', 'tb_usuario.*')
                        ->paginate(8);
    }

    public static function pesquisarUsuario($palavrachave) {
        $Usuarios = tb_usuario::select()
                ->orderBy('NomeFuncionario')
                ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_usuario.tb_funcionarios_idFuncionarios')
                ->select('tb_usuario.*', 'tb_funcionarios.NomeFuncionario')
                ->where('NomeFuncionario', 'LIKE', "%$palavrachave%")
                ->paginate(10);
        return $Usuarios;
    }

// Atualizando os dados dos usuario
    public static function editandoUsuario($dadosForm, $idUsuario) {
        $Usuario = tb_usuario::select()->find($idUsuario);
        $updateUsuario = $Usuario->update($dadosForm);
        return $updateUsuario;
    }

// Fecha Classe Principal
}
