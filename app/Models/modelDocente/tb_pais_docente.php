<?php

namespace App\Models\modelDocente;

use Illuminate\Database\Eloquent\Model;

class tb_pais_docente extends Model {

    protected $table = 'tb_pais';
    protected $primaryKey = 'idPais';
    public $timestamps = false;
    protected $fillable = [
        'NomePai','ProfPai','FonePai1','FonePai2','CPFPai','RGPai',
        'NomeMae','ProfMae','FoneMae1','FoneMae2','CPFMae','RGMae',
        'Responsavel','CPFResponsavel','RGResponsavel'
    ];
}
