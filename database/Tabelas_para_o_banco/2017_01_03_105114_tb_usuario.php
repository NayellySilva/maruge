<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_usuario', function (Blueprint $table) {
            $table->increments('idUsuario');
            $table->integer('tb_funcionarios_idFuncionarios')->unsigned();
            $table->foreign('tb_funcionarios_idFuncionarios')->references('idFuncionarios')->on('tb_funcionarios');
            $table->string('password',60);                  
            $table->string('CPFUsuario',40);
            $table->string('Nivel',20);
            $table->string('Situacao',20);
            $table->rememberToken();
            $table->timestamps();
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
