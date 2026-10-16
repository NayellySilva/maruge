<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class TbEscola extends Migration {
    public function up() {
        if (!Schema::hasTable('tb_escola')) {
        Schema::create('tb_escola', function (Blueprint $table) {
            $table->increments('idEscola');
            $table->integer('tb_endereco_idEndereco')->unsigned();
            $table->foreign('tb_endereco_idEndereco')->references('idEndereco')->on('tb_endereco')->onDelete('cascade');
            $table->string('NomeEscola', 100);
            $table->string('CNPJ', 50);
            $table->string('EmailColegio', 100);
            $table->string('NumeroInep', 50);
        });
        }
    }
   public function down() {
       //
    }
}