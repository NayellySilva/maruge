<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Funcionários antigos não possuíam situação própria; o valor padrão preserva o comportamento atual.
        if (!Schema::hasColumn('tb_funcionarios', 'Situacao')) {
            Schema::table('tb_funcionarios', function (Blueprint $table) {
                $table->string('Situacao', 20)->default('ATIVO')->after('Funcao');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tb_funcionarios', 'Situacao')) {
            Schema::table('tb_funcionarios', function (Blueprint $table) {
                $table->dropColumn('Situacao');
            });
        }
    }
};
