<?php

namespace App\Models\modelAluno;

use Illuminate\Database\Eloquent\Model;

class tb_endereco_aluno extends Model {

    protected $table = 'tb_endereco';
    protected $primaryKey = 'idEndereco';
    public $timestamps = false;
    protected $fillable = [
        'Fone1', 'Fone2', 'Numero', 'Rua', 'Bairro', 'Referencia', 'CEP', 'Cidade', 'Estado'
    ];
}
