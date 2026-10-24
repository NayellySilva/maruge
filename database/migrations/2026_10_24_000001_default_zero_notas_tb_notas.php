<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adiciona DEFAULT 0 nas colunas NOT NULL de tb_notas.
 *
 * Sem default, o MySQL em modo strict rejeita INSERTs que omitem
 * AM1..AM4, AB1..AB4, RP e RF com erro 1364 ("doesn't have a default value").
 * RB1..RB4 já possuem DEFAULT 0 desde a migration anterior.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_notas', function (Blueprint $table) {
            // Notas mensais (Fundamental II)
            $table->double('AM1', 40)->default(0)->change();
            $table->double('AM2', 20)->default(0)->change();
            $table->double('AM3', 40)->default(0)->change();
            $table->double('AM4', 20)->default(0)->change();

            // Notas bimestrais
            $table->double('AB1', 20)->default(0)->change();
            $table->double('AB2', 60)->default(0)->change();
            $table->double('AB3', 20)->default(0)->change();
            $table->double('AB4', 20)->default(0)->change();

            // Recuperações
            $table->double('RP', 20)->default(0)->change();
            $table->double('RF', 20)->default(0)->change();
        });
    }

    public function down(): void
    {
        // Revertendo para NOT NULL sem default (comportamento original)
        Schema::table('tb_notas', function (Blueprint $table) {
            $table->double('AM1', 40)->nullable(false)->change();
            $table->double('AM2', 20)->nullable(false)->change();
            $table->double('AM3', 40)->nullable(false)->change();
            $table->double('AM4', 20)->nullable(false)->change();
            $table->double('AB1', 20)->nullable(false)->change();
            $table->double('AB2', 60)->nullable(false)->change();
            $table->double('AB3', 20)->nullable(false)->change();
            $table->double('AB4', 20)->nullable(false)->change();
            $table->double('RP', 20)->nullable(false)->change();
            $table->double('RF', 20)->nullable(false)->change();
        });
    }
};
