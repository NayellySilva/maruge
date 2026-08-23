<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbReservas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('tb_reservas', function (Blueprint $table) {
            $table->increments('idReservas');
            $table->integer('tb_turmas_idTurmas')->unsigned();
            $table->foreign('tb_turmas_idTurmas')->references('idTurmas')->on('tb_turmas');
            $table->integer('tb_aluno_idAluno')->unsigned();
            $table->foreign('tb_aluno_idAluno')->references('idAluno')->on('tb_aluno');
            $table->string('data_reserva',50);
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
