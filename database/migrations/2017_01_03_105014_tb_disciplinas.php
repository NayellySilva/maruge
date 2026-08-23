<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbDisciplinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    if (!Schema::hasTable('tb_disciplinas')) {
        Schema::create('tb_disciplinas', function (Blueprint $table) {
    $table->increments('idDisciplinas');
    $table->string('NomeDisciplina',50);
    
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
