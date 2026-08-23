<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbTurmasDisciplinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

public function up()
    {
        if (!Schema::hasTable('tb_turmas_disciplinas')) {
        Schema::create('tb_turmas_disciplinas', function (Blueprint $table) {
            $table->integer('tb_turmas_idTurmas')->unsigned();
            $table->foreign('tb_turmas_idTurmas')->references('idTurmas')->on('tb_turmas');
            $table->integer('tb_disciplinas_idDisciplinas')->unsigned();
            $table->foreign('tb_disciplinas_idDisciplinas')->references('idDisciplinas')->on('tb_disciplinas');
            $table->integer('tb_funcionarios_idFuncionarios')->unsigned();
            $table->foreign('tb_funcionarios_idFuncionarios')->references('idFuncionarios')->on('tb_funcionarios');
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
