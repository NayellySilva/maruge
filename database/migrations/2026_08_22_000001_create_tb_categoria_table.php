<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tb_categoria')) {
            Schema::create('tb_categoria', function (Blueprint $table) {
                $table->increments('idCategoria');
                $table->string('NomeCategoria', 50)->unique();
                $table->rememberToken();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_categoria');
    }
};
