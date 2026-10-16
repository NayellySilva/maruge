<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbCategoria extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    //
    Schema::create('tb_categoria', function (Blueprint $table) {
    $table->increments('idCategoria');
    $table->string('NomeCategoria',50)->unique();
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
