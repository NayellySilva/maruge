<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbReceitas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('tb_receitas', function (Blueprint $table) {
            $table->increments('idReceita');
            $table->integer('tb_categoria_idCategoria')->unsigned();
            $table->foreign('tb_categoria_idCategoria')->references('idCategoria')->on('tb_categoria');
            $table->string('NomeReceita',180);
            $table->string('DataReceita',50);
            $table->decimal('ReceitaValor',20);           
            $table->string('StatusReceita',15);
            $table->string('ObsReceita',2000);
            $table->string('imgReceita',2000)->nullable();
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
