<?php
namespace App\Http\Controllers\controleLogin;

use App\Models\modelAluno\tb_aluno_aluno;
use App\Models\modelAluno\tb_turmas_disciplinas_aluno;
use App\Models\modelAluno\tb_disciplina;
use App\Models\modelAluno\tb_matricula_aluno;
use App\Models\modelAluno\tb_turma_aluno;
use App\Models\modelAluno\tb_funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\loginAlunoRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class loginAluno extends Controller {

    // Metodo que direciona ao painel da coordenacao
    public function Index() {
       $RA = auth()->guard('guardLoginAluno')->user()->RA; // Recuperando o RA do aluno para busca os resto de informações sobre ele
       $nomedoaluno = tb_aluno_aluno::infAluno($RA);   //Buscando nome e id desse usuario 
       foreach ($nomedoaluno as $idAluno) { // pecorrendo o array para 
       $idAluno = $idAluno['idAluno'];
       }
// Informações de quantidade de turmas e quantidade de disciplinas que o professor esta vinculados
$quantTurmasAluno= tb_turma_aluno::quantidadeTurmadoAluno($idAluno)->count();
$quantDisciplinadoAluno = tb_turmas_disciplinas_aluno::QuantidadedeDisciplinadoAluno($idAluno)->count();
$quantProfessordoAluno = tb_turmas_disciplinas_aluno::QuantidadeDeProfessordoAluno($idAluno)->count();
return view('telasCoordenacao.index', compact('quantTurmasAluno','quantDisciplinadoAluno','quantProfessordoAluno'));
    }

    // Metodo que direciona para tela de login
    public function login() {
        return view('telasLogin.loginAluno');
    }

    /* Metodo de solicitacao de acesso, nesse metodos e validado o tipo de usuario 
      que esta solicitando o acesso e direcionado para a rota principal do mesmo.
     */

    public function postlogin(loginAlunoRequest $inf_valores) {
// atribuindo valores digitados para uma validação
        $validacao = ['RA' => $inf_valores->get('RA'), 'password' => $inf_valores->get('password'),];
//dd($validacao);
//dd($inf_valores->all());
        if (Auth::guard('guardLoginAluno')->attempt($validacao)) {  // Validando as informações.
            $Situacao = auth()->guard('guardLoginAluno')->user()->SituacaoAluno; // Atribuindo o valor do campo situação para uma vareavel
            if ($Situacao == "ATIVO") { // validando se o aluno esta ativo
                return redirect('/aluno'); // direcionando o usuario para pagina solicitada
            } else { // condição caso o aluno esteje inativo
                return redirect('/loginaluno') // direcionando para pagina de login 
                                ->withErrors(['Inativo' => 'Aluno Inativo!']) // messagem de erros aluno inativo
                                ->withInput(); // levando as informações de digitada de volta para o form login
            }
        } else {
            return redirect('/loginaluno') // caso a senha ou ra esteja incorretos
                            ->withErrors(['ERRO-LOGIN' => 'RA ou Senha Inválidos!']) // messagem de dados invalidos
                            ->withInput(); // levando as informações de digitada de volta para o form login
        }
    }
    public function logout() {
        auth()->guard('guardLoginAluno')->logout();
        return redirect('/loginaluno');
    }

}