<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbTurmas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
         Schema::create('tb_turmas', function (Blueprint $table) {
    $table->increments('idTurmas');
    $table->string('NomeTurma',30);
    $table->string('Mensalidade',60);
    $table->string('SituacaoTurma',40);
    $table->string('AnoLetivo',10);
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
