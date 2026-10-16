<?php
namespace App\Http\Controllers\controleAluno;
use App\Models\modelAluno\tb_disciplina_aluno;
use App\Models\modelAluno\tb_aluno_aluno;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
//Controle (metodos) principais do modulo disciplina
class cont_disciplina_aluno extends Controller {
    private $request;
    private $validator;
    private $tb_disciplina;
    private $tb_aluno;

    public function __construct(Request $NomeDisciplina, tb_disciplina_aluno $tb_disciplina, tb_aluno_aluno $tb_aluno, Validator $validator) {
        $this->request = $NomeDisciplina;
        $this->validator = $validator;
        $this->tb_disciplina = $tb_disciplina;
        $this->tb_aluno = $tb_aluno;
    }
    //Metodo que chama os metodos da model  para págian de informações
    public function turmaDisciplinaInf() {
        $RA = auth()->guard('guardLoginAluno')->user()->RA; // Recuperando o RA do aluno para busca os resto de informações sobre ele
        $nomedoaluno = tb_aluno_aluno::infAluno($RA);   //Buscando nome e id desse usuario 
        foreach ($nomedoaluno as $idAluno) { // pecorrendo o array para 
            $idAluno = $idAluno['idAluno'];
        }
        $DisciplinaseProfessor = tb_disciplina_aluno::disciplinaseProfessordoAluno($idAluno);
        return view('telasCoordenacao.turma_disc.turma_disciplina_inf', compact('DisciplinaseProfessor'));
    }

// Fechando o controle principal
}
