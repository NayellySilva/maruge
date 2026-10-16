<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbEndereco extends Migration {

    public function up() {
        if (!Schema::hasTable('tb_endereco')) {
        Schema::create('tb_endereco', function (Blueprint $table) {
            $table->increments('idEndereco');
            $table->string('Fone1', 20)->nullable();
            $table->string('Fone2', 20)->nullable();
            $table->string('Numero', 10)->nullable();
            $table->string('Rua', 100)->nullable();
            $table->string('Bairro', 50)->nullable();
            $table->string('Referencia', 100)->nullable();
            $table->string('CEP', 15)->nullable();
            $table->string('Cidade', 50)->nullable();
            $table->string('Estado', 15)->nullable();
        });
        }
    }

    public function down() {
        //
    }

}
