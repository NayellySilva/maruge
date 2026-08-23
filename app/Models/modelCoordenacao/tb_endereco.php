<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_endereco extends Model {

    protected $table = 'tb_endereco';
    protected $primaryKey = 'idEndereco';
    public $timestamps = false;
    protected $fillable = [
        'Fone1', 'Fone2', 'Numero', 'Rua', 'Bairro', 'Referencia', 'CEP', 'Cidade', 'Estado'
    ];
}
