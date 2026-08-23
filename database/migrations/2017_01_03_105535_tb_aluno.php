<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbAluno extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        if (!Schema::hasTable('tb_aluno')) {
        Schema::create('tb_aluno', function (Blueprint $table) {
            $table->increments('idAluno');
            $table->integer('tb_matriculas_idMatriculas')->unsigned();
            $table->foreign('tb_matriculas_idMatriculas')->references('idMatriculas')->on('tb_matriculas');
            $table->integer('tb_turmas_idTurmas')->unsigned();
            $table->foreign('tb_turmas_idTurmas')->references('idTurmas')->on('tb_turmas');   
            $table->integer('tb_endereco_idEndereco')->unsigned();
            $table->foreign('tb_endereco_idEndereco')->references('idEndereco')->on('tb_endereco');
            $table->integer('tb_pais_idPais')->unsigned();
            $table->foreign('tb_pais_idPais')->references('idPais')->on('tb_pais');
            $table->string('NomeAluno',100);                  
            $table->string('DataNascimento',50)->nullable();
            $table->string('Sexo',40)->nullable();
            $table->string('EstadoCartorio',40)->nullable();
            $table->string('NumeroRGNovo',50)->nullable();
            $table->string('NumeroFolha',50)->nullable();
            $table->string('NumeroLivro',50)->nullable();
            $table->string('NumeroMac',50)->nullable();
            $table->string('CidadeCartorio',50)->nullable();
            $table->string('NumeroRG',50)->nullable();
            $table->string('CPFAluno',30)->nullable();
            $table->string('DataEmissao',50)->nullable();
            $table->string('NomeCartorio',50)->nullable();
            $table->string('ObsAluno',200)->nullable();
            $table->string('Ultima_Turma',50)->nullable();
            $table->string('Acompanhamento',50)->nullable();
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
