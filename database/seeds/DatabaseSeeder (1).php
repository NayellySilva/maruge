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
      DB::table('tb_endereco')->insert([ 
       	'Rua' => 'usuario1',
        ]);
      
      DB::table('tb_funcionarios')->insert([ 
       	
        'NomeFuncionario' => 'JEFFERSON DAVID',
        'CPFFuncionario' => '111.111.111-11',
        'tb_endereco_idEndereco' => '1',            
                  	]);
      
      DB::table('tb_usuario')->insert([ 
       	'password' => Hash::make('11111111'),
        'CPFUsuario' => '111.111.111-11',
        'Nivel' => 'COORDENACAO',
        'Situacao' => 'ATIVO',
        'tb_funcionarios_idFuncionarios' => '1',            
                  	]);
    }
}