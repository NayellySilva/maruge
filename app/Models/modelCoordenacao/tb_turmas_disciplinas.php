<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_turmas_disciplinas extends Model {

    protected $table = 'tb_turmas_disciplinas';
    protected $primaryKey = 'idTurmas_Disciplinas';
    public $timestamps = false;
    protected $fillable = ['tb_turmas_idTurmas', 'tb_disciplinas_idDisciplinas', 'tb_funcionarios_idFuncionarios'];
// Campos Obrigatorios
    static $camposObg = [
        'idTurmas' => 'required',
        'idDisciplinas' => 'required',
        'idFuncionarios' => 'required',
    ];

//Metodo pra salvar vinculos dos professores e suas disciplina das turmas que os pertence
    public static function salvandoVinculacao($dadosForm) {
        $novovinculo = new tb_turmas_disciplinas($dadosForm);
        $novovinculo->tb_turmas_idTurmas = $dadosForm['idTurmas'];
        $novovinculo->tb_disciplinas_idDisciplinas = $dadosForm['idDisciplinas'];
        $novovinculo->tb_funcionarios_idFuncionarios = $dadosForm['idFuncionarios'];
        $novovinculo->save();
        return 1;
    }

    
    // Verificando se já existe professor nessa turma com a disciplina informada
    public static function verificarSeDisciplinaJaTemProfessor($dadosForm) {
        $verificar = \DB::table('tb_turmas_disciplinas')
                ->where('tb_turmas_idTurmas', '=', $dadosForm['idTurmas'])
                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm['idDisciplinas'])
               // ->where('tb_funcionarios_idFuncionarios', '=', $dadosForm['idFuncionarios']) 
                ->get();
        return $verificar;
    }
    
    
    
    
    
    
    
// Metodo que fas uma listagem de todos os professores em suas turmas com suas determinada disciplina(turma_disciplina_cad)    
    public static function disciplinasDoProfessor() {
        return \DB::table('tb_turmas_disciplinas')
                        ->orderBy('tb_turmas.NomeTurma')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->select(
                            'tb_turmas.NomeTurma as NomeTurma',
                            'tb_disciplinas.NomeDisciplina as NomeDisciplina',
                            'tb_funcionarios.NomeFuncionario as NomeFuncionario',
                            'tb_turmas_disciplinas.tb_turmas_idTurmas',
                            'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas',
                            'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios'
                        )
                        ->get();
    }
// Metodo que fas uma listagem de todos os professores em suas turmas com suas determinada disciplina(turma_disciplina_cad)    
    public static function ProfessoreSuasDisciplinas($idTurmas) {
        return \DB::table('tb_turmas_disciplinas')
                        ->where('tb_turmas_disciplinas.tb_turmas_idTurmas', '=', $idTurmas)
                        ->orderBy('tb_disciplinas.NomeDisciplina')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->select(
                            'tb_turmas.NomeTurma as NomeTurma',
                            'tb_disciplinas.NomeDisciplina as NomeDisciplina',
                            'tb_funcionarios.NomeFuncionario as NomeFuncionario',
                            'tb_turmas_disciplinas.tb_turmas_idTurmas',
                            'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas',
                            'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios'
                        )
                        ->get();
    }

// Metodo que lista os professores sua turma e suas disciplinas com metodo paginate (turma_disciplina_inf)    
    public static function listadisciplinasDoProfessor() {
        return \DB::table('tb_turmas_disciplinas')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->whereIn('tb_turmas.SituacaoTurma', ['ATIVO', 'ATIVA'])
                        ->select(
                            'tb_turmas.NomeTurma as NomeTurma',
                            'tb_disciplinas.NomeDisciplina as NomeDisciplina',
                            'tb_funcionarios.NomeFuncionario as NomeFuncionario',
                            'tb_turmas_disciplinas.tb_turmas_idTurmas',
                            'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas',
                            'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios'
                        )
                        ->orderBy('tb_turmas.NomeTurma')
                        ->paginate(20);
    }

// Filtro de professor e suas disciplinas por professor    
    public static function professorEscolhido($idFuncionarios) {
        return \DB::table('tb_turmas_disciplinas')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->where('tb_funcionarios.idFuncionarios', $idFuncionarios)
                        ->select(
                            'tb_turmas.NomeTurma as NomeTurma',
                            'tb_disciplinas.NomeDisciplina as NomeDisciplina',
                            'tb_funcionarios.NomeFuncionario as NomeFuncionario',
                            'tb_turmas_disciplinas.tb_turmas_idTurmas',
                            'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas',
                            'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios'
                        )
                        ->orderBy('tb_turmas.NomeTurma')
                        ->paginate(20);
    }

// Filtro de professor e suas disciplinas por turmas    
    public static function turmaEscolhida($idTurmas) {
        return \DB::table('tb_turmas_disciplinas')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->where('tb_turmas.idTurmas', $idTurmas)
                        ->select(
                            'tb_turmas.NomeTurma as NomeTurma',
                            'tb_disciplinas.NomeDisciplina as NomeDisciplina',
                            'tb_funcionarios.NomeFuncionario as NomeFuncionario',
                            'tb_turmas_disciplinas.tb_turmas_idTurmas',
                            'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas',
                            'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios'
                        )
                        ->orderBy('tb_turmas.NomeTurma')
                        ->paginate(20);
    }
// busca todas as disciplinas que pertece a uma determinada turma que ta sendo passado por paramentro  
    public static function disciplinaTurma($idTurmas) {
        return \DB::table('tb_turmas_disciplinas')
                        ->orderBy('NomeDisciplina')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->leftJoin('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->select(
                            'tb_turmas.NomeTurma as NomeTurma',
                            'tb_disciplinas.NomeDisciplina as NomeDisciplina',
                            'tb_funcionarios.NomeFuncionario as NomeFuncionario',
                            'tb_turmas_disciplinas.tb_turmas_idTurmas',
                            'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas',
                            'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios'
                        )
                        ->where('tb_turmas.idTurmas', $idTurmas)
                        ->get();
    }
// busca todas as disciplinas que pertece a turma do aluno do ano de 2016 
    public static function disciplinaTurma2016($idAluno) {
        return \DB::table('tb_turmas_disciplinas')
        ->orderBy('NomeDisciplina')
        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
        ->join('tb_notas_2016', 'tb_notas_2016.tb_turmas_idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
        ->where('tb_notas_2016.tb_aluno_idAluno', $idAluno)
        ->groupBy('tb_disciplinas.NomeDisciplina')
        ->get();
}
// busca todas as disciplinas que pertece a turma do aluno do ano de 2017
    public static function disciplinaTurma2017($idAluno) {
        return \DB::table('tb_turmas_disciplinas')
        ->orderBy('NomeDisciplina')
        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
        ->join('tb_notas_2017', 'tb_notas_2017.tb_turmas_idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
        ->where('tb_notas_2017.tb_aluno_idAluno', $idAluno)
        ->groupBy('tb_disciplinas.NomeDisciplina')
        ->get();
}

    

    
    
    
    
// Faz uma contagem de quantas disciplinas tem em uma determinada turma
    public static function QuantidadeDisciplinasNaTurma($idTurmas) {
        return \DB::table('tb_turmas_disciplinas')
                        ->orderBy('NomeDisciplina')
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->select(
                            'tb_turmas.NomeTurma as NomeTurma',
                            'tb_disciplinas.NomeDisciplina as NomeDisciplina',
                            'tb_funcionarios.NomeFuncionario as NomeFuncionario',
                            'tb_turmas_disciplinas.tb_turmas_idTurmas',
                            'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas',
                            'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios'
                        )
                        ->where('tb_turmas.idTurmas', $idTurmas)
                        ->count();
    }

// Metodo que deleta um vinculor de professor sua disciplina com a turma
    public function vinculoDeletar($idTurmas_Disciplinas) {
        return tb_turmas_disciplinas::find($idTurmas_Disciplinas)->delete();
    }

// Fecha Classe Principal
}
