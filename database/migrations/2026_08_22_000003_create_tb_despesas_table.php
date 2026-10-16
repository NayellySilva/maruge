<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tb_despesas')) {
            Schema::create('tb_despesas', function (Blueprint $table) {
                $table->increments('idDespesa');
                $table->integer('tb_categoria_idCategoria')->unsigned();
                $table->foreign('tb_categoria_idCategoria')->references('idCategoria')->on('tb_categoria');
                $table->string('NomeDespesa', 180);
                $table->string('DataDespesa', 50);
                $table->decimal('DespesaValor', 20, 2);           
                $table->string('StatusDespesa', 15);
                $table->text('ObsDespesa')->nullable();
                $table->text('CompDespesa')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_despesas');
    }
};
