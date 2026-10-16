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
         if (!Schema::hasTable('tb_matriculas')) {
        Schema::create('tb_matriculas', function (Blueprint $table) {
    $table->increments('idMatriculas');
    $table->string('Foto',10)->nullable();
    $table->string('Registro',60)->nullable();
    $table->string('ValorPGTO',40)->nullable();
    $table->string('FormaPGTO',10)->nullable(); 
    $table->string('Pasta',10)->nullable();
    $table->string('AlunoNV',10)->nullable();
    $table->string('RA',50)->nullable();
    $table->string('Email',100)->nullable();
    $table->string('Situacao',10)->nullable();
    $table->string('SituacaoAluno',20)->nullable();
    $table->string('Nivel',20)->nullable();
    $table->string('password',60)->nullable();
    $table->string('DataMatricula',50)->nullable();
    $table->string('Saida',50)->nullable();
    $table->string('Taxa',50)->nullable();
    $table->string('Historico',50)->nullable();
    $table->string('Declaracao',50)->nullable();
    $table->string('Bonus',50)->nullable();
           });
        }
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
