<?php

namespace App\Models\modelDocente;

use Illuminate\Database\Eloquent\Model;

class tb_funcionario_docente extends Model {

    protected $table = 'tb_funcionarios';
    protected $primaryKey = 'idFuncionarios';
    public $timestamps = false;
    protected $fillable = [
        'NomeFuncionario', 'CPFFuncionario', 'RGFuncionario', 'Funcao',
        'Salario', 'EmailFuncionario', 'Formacao'
    ];

// Metodo que mostra o perfil do Funcionario
    public static function perfilFuncionario($idFuncionarios) {
        $Funcionario = tb_funcionario_docente::select()->find($idFuncionarios)
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_funcionarios.tb_endereco_idEndereco')
                ->select('tb_funcionarios.*', 'tb_endereco.*')
                ->where('idFuncionarios', $idFuncionarios)
                ->get();
        return $Funcionario;
    }

// Fechando a classe principal
}
