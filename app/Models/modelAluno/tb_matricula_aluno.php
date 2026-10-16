<?php

namespace App\Models\modelAluno;

use Illuminate\Database\Eloquent\Model;

class tb_matricula_aluno extends Model {

    protected $table = 'tb_matriculas';
    protected $primaryKey = 'idMatriculas';
    public $timestamps = false;
    protected $fillable = ['Foto','Registro','ValorPGTO','Taxa','FormaPGTO','Pasta',
                           'AlunoNV','SituacaoAluno','Nivel','DataMatricula','Saida','password','RA'
                          ];

    // Criando um novo RA   
 public static function novoRA()
{   
      $novoRA = tb_matricula::select()->max('idMatriculas');
      $RA = $novoRA + 20160000;
      return $RA;
}
    
    // Quantidade de matriculas ativas
    public static function quantMatriculasAtivas() {
        return tb_matricula::select()
                ->where('tb_matriculas.SituacaoAluno', "ATIVO")
                ->count();
    }
    // Quantidade de matriculas inativas
    public static function quantMatriculasInativas() {
        return tb_matricula::select()
                ->where('tb_matriculas.SituacaoAluno', "INATIVO")
                ->count();
    }
// alterar Senha comentado
/*
    public static function alterarSenha($dadosForm){
                $RA = $dadosForm["RA"];    
               $Aluno = tb_matricula_aluno::select()
                ->where('tb_matriculas.RA', $RA) ;
                $updateNota = $RA->update($dadosForm);
                dd($updateNota);
        return $Aluno;
    }
  */      
}
