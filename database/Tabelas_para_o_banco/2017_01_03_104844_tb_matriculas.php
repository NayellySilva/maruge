<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbMatriculas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
    Schema::create('tb_matriculas', function (Blueprint $table) {
    $table->increments('idMatriculas');
    $table->string('Foto',10);
    $table->string('Registro',60);
    $table->string('ValorPGTO',40);
    $table->string('FormaPGTO',10); 
    $table->string('Pasta',10);
    $table->string('AlunoNV',10);
    $table->string('RA',50);
    $table->string('Email',100);
    $table->string('SituacaoAluno',10);
    $table->string('password',60);
    $table->string('DataMatricula',50);
    $table->string('Saida',50);
           });
    }


    
    
    
    
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
