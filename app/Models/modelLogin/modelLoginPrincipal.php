<?php

namespace App\Models\modelLogin;

use Illuminate\Foundation\Auth\User as Authenticatable;

class modelLoginPrincipal extends Authenticatable
{
    	protected $table = 'tb_usuario';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'idUsuario';
    protected $fillable = [
        'Situacao', 'CPFUsuario', 'password','Nivel'
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
