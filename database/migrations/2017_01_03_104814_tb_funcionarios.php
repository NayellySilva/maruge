<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbFuncionarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    
    
     public function up()
    {
         if (!Schema::hasTable('tb_funcionarios')) {
        Schema::create('tb_funcionarios', function (Blueprint $table) {
    $table->increments('idFuncionarios');
    $table->integer('tb_endereco_idEndereco')->unsigned();
    $table->foreign('tb_endereco_idEndereco')->references('idEndereco')->on('tb_endereco');
    $table->string('NomeFuncionario',150);
    $table->string('CPFFuncionario',20);
    $table->string('RGFuncionario',40);
    $table->string('Funcao',30);
    $table->string('Salario',30);
    $table->string('EmailFuncionario',100);
    $table->string('Formacao',50);
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
