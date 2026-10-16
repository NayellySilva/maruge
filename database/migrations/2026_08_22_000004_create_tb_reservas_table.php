<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tb_reservas')) {
            Schema::create('tb_reservas', function (Blueprint $table) {
                $table->increments('idReservas');
                $table->integer('tb_turmas_idTurmas')->unsigned();
                $table->foreign('tb_turmas_idTurmas')->references('idTurmas')->on('tb_turmas');
                $table->integer('tb_aluno_idAluno')->unsigned();
                $table->foreign('tb_aluno_idAluno')->references('idAluno')->on('tb_aluno');
                $table->string('data_reserva', 50);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_reservas');
    }
};
