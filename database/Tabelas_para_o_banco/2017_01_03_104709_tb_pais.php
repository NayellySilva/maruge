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
         Schema::create('tb_pais', function (Blueprint $table) {
            $table->increments('idPais');
            $table->string('NomePai',150);
            $table->string('ProfPai',30);
            $table->string('FonePai1',20);
            $table->string('FonePai2',20);
            $table->string('CPFPai',20);
            $table->string('Nas_Pai',10);
            $table->string('Nas_Mae',10);
            $table->string('RGPai',40);
            $table->string('NomeMae',150);
            $table->string('ProfMae',30);
            $table->string('RGMae',40);
            $table->string('CPFMae',20);
            $table->string('FoneMae1',20);  
            $table->string('FoneMae2',20);
            $table->string('Responsavel',150);
            $table->string('CPFResponsavel',20);
            $table->string('RGResponsavel',40);
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
