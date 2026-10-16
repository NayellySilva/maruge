<?php
namespace App\Http\Controllers\controleAluno;
use App\Models\modelAluno\tb_aluno_aluno;
use App\Models\modelAluno\tb_turma_aluno;
use App\Models\modelAluno\tb_disciplina_aluno;
use App\Models\modelAluno\tb_escola_aluno;
use App\Models\modelAluno\tb_turmas_disciplinas_aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//INICIO DA CLASSE CONTROLE DO ALUNO
class cont_notas_aluno extends Controller {
    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_turma;
    private $tb_disciplina;
    private $tb_escola;
    private $tb_turma_disciplina;
   
public function __construct(Request $dadosForm, tb_turmas_disciplinas_aluno $tb_turma_disciplina, tb_escola_aluno $tb_escola, tb_disciplina_aluno $tb_disciplina, tb_turma_aluno $tb_turma, tb_aluno_aluno $tb_aluno, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_turma;
        $this->tb_disciplina = $tb_disciplina;
        $this->tb_escola = $tb_escola;
        $this->tb_turma_disciplina = $tb_turma_disciplina;
    }
//Metodo que lista os alunos  
    public function index() {
        $RA = auth()->guard('guardLoginAluno')->user()->RA; // Recuperando o RA do aluno para busca os resto de informações sobre ele
        $nomedoaluno = tb_aluno_aluno::infAluno($RA);   //Buscando nome e id desse usuario 
        foreach ($nomedoaluno as $idAluno) { // pecorrendo o array para 
            $idAluno = $idAluno['idAluno'];
        }
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $idTurmas = $turma['idTurmas'];
        $anoletivo = tb_turma_aluno::infTurma($idTurmas);
        $disciplinas = tb_turmas_disciplinas_aluno::disciplinaTurma($idTurmas);
        $escolas = tb_escola_aluno::informacaoEscolar();// Dados para forma o timbre (cabeçario)  
       // $Aluno = tb_aluno_aluno::infAlunopraNotas($idAluno);
        $titulo = 'Minhas Notas';
        $quantidadeDisciplina = tb_disciplina_aluno::QuantidadeDisciplinasdoAluno($idAluno)->count();
        if ($quantidadeDisciplina <= 7) {
           return view('telasAluno.minhasnotas_inf', compact('aluno','matricula','turma','anoletivo','disciplinas','escolas','titulo'));
        } else if ($quantidadeDisciplina <= 17) {
            return view('telasAluno.minhasnotas_fun1', compact('aluno','matricula','turma','anoletivo','disciplinas','escolas','titulo'));
        } else if ($quantidadeDisciplina > 17) {
            return view('telasAluno.minhasnotas_fun2', compact('aluno','matricula','turma','anoletivo','disciplinas','escolas','titulo'));
        }
    }
    //Fecha a classe principal
}