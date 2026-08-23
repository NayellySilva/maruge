<?php
namespace App\Http\Controllers\controleAluno;
use App\Models\modelAluno\tb_aluno_aluno;
use App\Models\modelAluno\tb_turma_aluno;
use App\Models\modelAluno\tb_matricula_aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DO ALUNO
class cont_aluno_aluno extends Controller {
    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_turma;
    private $tb_matricula;
    public function __construct(Request $dadosForm, tb_turma_aluno $tb_turma, tb_matricula_aluno $tb_matricula , tb_aluno_aluno $tb_aluno, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_turma;
        $this->tb_matricula = $tb_matricula;
    }
    // Metodo para vizualizar o perfil do aluno via opção da parte superios que vem com id
    public function perfil($idAluno) {
        $Aluno = tb_aluno_aluno::perfilAluno($idAluno);
        $Turmas = tb_turma_aluno::TurmadoAluno($idAluno);
        return view('telasAluno.aluno_perfil', compact('Aluno', 'Turmas'));
    }
    // Metodo para vizualizar o perfil do aluno via menu secretaria onde tem que busca o id.
    public function perfil_request() {
        $RA = auth()->guard('guardLoginAluno')->user()->RA; // Recuperando o RA do aluno para busca os resto de informações sobre ele
        $nomedoaluno = tb_aluno_aluno::infAluno($RA);   //Buscando nome e id desse usuario 
        foreach ($nomedoaluno as $idAluno) { // pecorrendo o array para 
            $idAluno = $idAluno['idAluno'];
        }
        $Aluno = tb_aluno_aluno::perfilAluno($idAluno);
        $Turmas = tb_turma_aluno::TurmadoAluno($idAluno);
        return view('telasAluno.aluno_perfil', compact('Aluno', 'Turmas'));
    }
    
      //Alterar Senha
    /*
    public function alterarSenha(){
        $dadosForm = $this->request->all();
         $validando = Validator::make($dadosForm, tb_aluno_aluno::$alterarSenha);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
         $updateSenha= tb_matricula_aluno::alterarSenha($dadosForm);
                     if ($updateSenha) {
            return 'senhaAlunoAtualizado';
        } else {
            return 'ErrosenhaAluno';
        }
        dd($dadosForm);
    }
*/


// Chava da class principal  
}
