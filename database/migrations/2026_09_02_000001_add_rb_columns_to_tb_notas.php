<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddRbColumnsToTbNotas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tb_notas', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_notas', 'RB1')) {
                $table->double('RB1', 20)->nullable()->default(0)->after('AB1');
            }
            if (!Schema::hasColumn('tb_notas', 'RB2')) {
                $table->double('RB2', 20)->nullable()->default(0)->after('AB2');
            }
            if (!Schema::hasColumn('tb_notas', 'RB3')) {
                $table->double('RB3', 20)->nullable()->default(0)->after('AB3');
            }
            if (!Schema::hasColumn('tb_notas', 'RB4')) {
                $table->double('RB4', 20)->nullable()->default(0)->after('AB4');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tb_notas', function (Blueprint $table) {
            $table->dropColumn(['RB1', 'RB2', 'RB3', 'RB4']);
        });
    }
}
