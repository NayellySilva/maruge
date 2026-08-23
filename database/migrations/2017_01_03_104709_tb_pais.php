<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbPais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('tb_pais')) {
        Schema::create('tb_pais', function (Blueprint $table) {
            $table->increments('idPais');
            $table->string('NomePai',150)->nullable();
            $table->string('ProfPai',30)->nullable();
            $table->string('FonePai1',20)->nullable();
            $table->string('FonePai2',20)->nullable();
            $table->string('CPFPai',20)->nullable();
            $table->string('RGPai',40)->nullable();
            $table->string('Nas_Pai',50)->nullable();
            $table->string('NomeMae',150)->nullable();
            $table->string('ProfMae',30)->nullable();
            $table->string('RGMae',40)->nullable();
            $table->string('CPFMae',20)->nullable();
            $table->string('FoneMae1',20)->nullable();  
            $table->string('FoneMae2',20)->nullable();
            $table->string('Nas_Mae',50)->nullable();
            $table->string('Responsavel',150)->nullable();
            $table->string('CPFResponsavel',20)->nullable();
            $table->string('RGResponsavel',40)->nullable();
     });
        }
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
