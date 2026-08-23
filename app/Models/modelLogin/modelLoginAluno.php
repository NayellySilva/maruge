<?php

namespace App\Models\modelLogin;

use Illuminate\Foundation\Auth\User as Authenticatable;

class modelLoginAluno extends Authenticatable {

    protected $table = 'tb_matriculas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'idMatriculas';
    protected $fillable = [
        'SituacaoAluno', 'RA', 'password', 'Nivel'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
