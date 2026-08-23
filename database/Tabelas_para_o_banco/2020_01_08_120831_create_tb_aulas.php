<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAulas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    Schema::create('tb_aulas', function (Blueprint $table) {
    $table->increments('idAula');
    $table->integer('tb_turmas_idTurmas')->unsigned();
    $table->foreign('tb_turmas_idTurmas')->references('idTurmas')->on('tb_turmas');
    $table->string('aula',90);
    $table->date('data_aula');
    $table->string('ObsAula',30000);
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
