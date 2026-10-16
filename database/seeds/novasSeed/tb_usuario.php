<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('tb_usuario')->insert([
       	 
       	'password' => Hash::make('11111111'),
        'CPFUsuario' => '111.111.111-11',
        'Nivel' => 'COORDENACAO',
        'Situacao' => 'ATIVO',
           
           
                  	]);
    }
}
