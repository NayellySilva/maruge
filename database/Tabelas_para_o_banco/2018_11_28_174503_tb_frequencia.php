<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbFrequencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('tb_frequencia', function (Blueprint $table) {
    $table->increments('idfrequencia');
    $table->integer('tb_turmas_idTurmas')->unsigned();
    $table->foreign('tb_turmas_idTurmas')->references('idTurmas')->on('tb_turmas');
    $table->integer('tb_aluno_idAluno')->unsigned();
    $table->foreign('tb_aluno_idAluno')->references('idAluno')->on('tb_aluno');
    $table->string('RA',20);
    $table->string('inf_dia',30);
    $table->string('dia',2);
    $table->string('mes',2);
    $table->string('ano',4);
    $table->string('situacao',11);
    });
    }

    
    
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tb_frequencia');
    }
}
