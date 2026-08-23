<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbEndereco extends Migration {

    public function up() {
        Schema::create('tb_endereco', function (Blueprint $table) {
            $table->increments('idEndereco');
            $table->string('Fone1', 20);
            $table->string('Fone2', 20);
            $table->string('Numero', 10);
            $table->string('Rua', 100);
            $table->string('Bairro', 50);
            $table->string('Referencia', 100);
            $table->string('CEP', 15);
            $table->string('Cidade', 50);
            $table->string('Estado', 15);
        });
    }

    public function down() {
        //
    }

}
