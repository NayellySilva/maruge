<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbCarne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
    Schema::create('tb_carne', function (Blueprint $table) {
    $table->increments('idcarne');
   
    
    
    $table->integer('tb_turmas_idTurmas')->unsigned();
    $table->foreign('tb_turmas_idTurmas')->references('idTurmas')->on('tb_turmas');
    $table->integer('tb_turmas_Mensalidade')->unsigned();
    $table->foreign('tb_turmas_idTurmas')->references('Mensalidade')->on('tb_turmas');
    $table->integer('tb_aluno_idAluno')->unsigned();
    $table->foreign('tb_aluno_idAluno')->references('idAluno')->on('tb_aluno');
    $table->string('RA',50);
    $table->string('parcelas',5);
    $table->string('Ano_Letivo',4);
    $table->decimal('ValorPGTO',11);
    $table->decimal('valor_prestacao',11);
    $table->decimal('valor_Acordo',11);
    $table->string('codbarras',60);
    $table->string('data_pagamento',10);
    $table->string('status_pagamento',10);
    $table->string('obs_pagamento',10000);
    $table->string('obs_do_acordo',30000);
    $table->string('Meses',15);
    $table->string('Digito_verificador',2);
    $table->string('Carteira',4);
    $table->string('Acordo',4);
    $table->string('Data_venc',11);
    
    
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
