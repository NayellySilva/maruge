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
       DB::table('tb_matriculas')->insert([
       	 
       	'password' => Hash::make('20170001'),
        'RA' => '20170001',
        'Nivel' => 'ALUNO',
        'Situacao' => 'ATIVO',
           
           
                  	]);
    }
}
