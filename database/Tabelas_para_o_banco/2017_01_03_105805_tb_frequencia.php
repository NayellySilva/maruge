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
            $table->integer('tb_turmas_idTurmas')->unsigned();
            $table->foreign('tb_turmas_idTurmas')->references('idTurmas')->on('tb_turmas');
            $table->integer('tb_aluno_idAluno')->unsigned();
            $table->foreign('tb_aluno_idAluno')->references('idAluno')->on('tb_aluno');
            $table->string('DataFrequencia',60);                  
            $table->string('Dia',40);
            $table->string('Mes',20);
            $table->string('Ano',20);
            $table->string('Presenca',60);                  
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
