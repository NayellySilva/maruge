<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tb_receitas')) {
            Schema::create('tb_receitas', function (Blueprint $table) {
                $table->increments('idReceita');
                $table->integer('tb_categoria_idCategoria')->unsigned();
                $table->foreign('tb_categoria_idCategoria')->references('idCategoria')->on('tb_categoria');
                $table->string('NomeReceita', 180);
                $table->string('DataReceita', 50);
                $table->decimal('ReceitaValor', 20, 2);           
                $table->string('StatusReceita', 15);
                $table->text('ObsReceita')->nullable();
                $table->text('imgReceita')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_receitas');
    }
};
