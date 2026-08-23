<?php

namespace App\Models\modelDocente;

use Illuminate\Database\Eloquent\Model;

class tb_matricula_docente extends Model {

    protected $table = 'tb_matriculas';
    protected $primaryKey = 'idMatriculas';
    public $timestamps = false;
    protected $fillable = ['Foto','Registro','ValorPGTO','Taxa','FormaPGTO','Pasta',
                           'AlunoNV','SituacaoAluno','Nivel','DataMatricula','Saida'
                          ];
}
