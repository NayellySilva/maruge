<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_pais extends Model {

    protected $table = 'tb_pais';
    protected $primaryKey = 'idPais';
    public $timestamps = false;
    protected $fillable = [
        'NomePai','ProfPai','FonePai1','FonePai2','CPFPai','RGPai',
        'NomeMae','ProfMae','FoneMae1','FoneMae2','CPFMae','RGMae','Nas_Pai',
        'Nas_Mae','Responsavel','CPFResponsavel','RGResponsavel'
    ];
}
