<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbMatricula extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('tb_matriculas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Foto',5);
            $table->string('Registro');
            $table->string('ValorPGTO');
            $table->string('Taxa');
            $table->string('FormaPGTO');
            $table->string('Pasta');
            $table->string('AlunoNV');
            $table->string('RA');   
            $table->string('Situacao');
            $table->string('Nivel');
            $table->string('password',60);
            $table->string('DataMatricula');
            $table->string('Saida');
            $table->rememberToken();
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
