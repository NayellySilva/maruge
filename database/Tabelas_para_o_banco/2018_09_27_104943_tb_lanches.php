<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbLanches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('tb_lanches', function (Blueprint $table) {
    $table->increments('idlanche');
    $table->string('NomeLanche',50);
    $table->decimal('ValorLanche');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tb_lanches');
    }
}
