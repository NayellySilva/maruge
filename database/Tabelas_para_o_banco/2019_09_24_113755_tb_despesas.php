<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbDespesas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
      public function up()
    {
        Schema::create('tb_despesas', function (Blueprint $table) {
            $table->increments('idDespesa');
            $table->integer('tb_categoria_idCategoria')->unsigned();
            $table->foreign('tb_categoria_idCategoria')->references('idCategoria')->on('tb_categoria');
            $table->string('NomeDespesa',180);
            $table->string('DataDespesa',50);
            $table->decimal('DespesaValor',20);           
            $table->string('StatusDespesa',15);
            $table->string('ObsDespesa',2000);
            $table->string('CompDespesa',2000)->nullable();
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
