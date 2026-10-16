<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class tb_matricula extends Model {

    protected $table = 'tb_matriculas';
    protected $primaryKey = 'idMatriculas';
    public $timestamps = false;
    protected $fillable = ['Foto','Registro','ValorPGTO','Taxa','FormaPGTO','Pasta','Email', 'Historico', 'Declaracao',
                           'AlunoNV','RA','SituacaoAluno','Nivel','DataMatricula','Saida','password','Bonus'
                          ];

    // Criando um novo RA   
 public static function novoRA()
{   
      $novoRA = tb_matricula::select()->max('idMatriculas');
      $RA = $novoRA + 20160000;
      return $RA;
}




    // Não Esta sendo usado
/*
 public static function BuscaRA($idMatriculas){   
       $RA = tb_matricula::select('tb_matriculas.RA')
            ->select('tb_matriculas.RA')
            ->where('tb_matriculas.idMatriculas', $idMatriculas)
            ->get('RA');
        return $RA;
    }
    */
    
    
        // Quando o aluno não está matriculado esse metodo ajuda a gerar o email dele.   
 public static function Email($dadosForm,$RA)
{   
        $condificação = Str::words($dadosForm['NomeAluno'], 1, '');
        $Email = Str::lower($condificação.$RA."@ccdm.com.br");
        return $Email;
}





    // Quantidade de alunos no banco de dados
    public static function quantAlunosCadastrados() {
        return tb_matricula::select()
           //     ->where('tb_matriculas.SituacaoAluno', "ATIVO")
                ->count();
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
                ->where('tb_matriculas.SituacaoAluno', '<>', "ATIVO")
                ->count();
    }







    
}
