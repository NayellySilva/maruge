<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbNotas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

            
     
   public function up()
    {
        if (!Schema::hasTable('tb_notas')) {
        Schema::create('tb_notas', function (Blueprint $table) {
            $table->integer('tb_turmas_idTurmas')->unsigned();
            $table->foreign('tb_turmas_idTurmas')->references('idTurmas')->on('tb_turmas');
            $table->integer('tb_disciplinas_idDisciplinas')->unsigned();
            $table->foreign('tb_disciplinas_idDisciplinas')->references('idDisciplinas')->on('tb_disciplinas');
            $table->integer('tb_aluno_idAluno')->unsigned();
            $table->foreign('tb_aluno_idAluno')->references('idAluno')->on('tb_aluno');
             $table->integer('tb_usuario_idUsuario')->unsigned();
            $table->foreign('tb_usuario_idUsuario')->references('idUsuario')->on('tb_usuario');
            $table->double('RA',60);                  
            $table->double('AM1',40);
            $table->double('AB1',20);
            $table->double('AM2',20);
            $table->double('AB2',60);                  
            $table->double('AM3',40);
            $table->double('AB3',20);
            $table->double('AM4',20);
            $table->double('AB4',20);
            $table->double('RP',20);
            $table->double('RF',20);
            $table->rememberToken();
            $table->timestamps();
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
