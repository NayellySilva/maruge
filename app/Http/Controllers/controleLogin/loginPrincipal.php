<?php

namespace App\Http\Controllers\controleLogin;

use Illuminate\Http\Request;
use App\Models\modelCoordenacao\tb_disciplina;
use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_funcionario;
use App\Models\modelCoordenacao\tb_usuario;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\loginPrincipalRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class loginPrincipal extends Controller {

    // Metodo que direciona ao painel da coordenacao
    public function coordenacaoIndex() {
        $quantDisciplina = tb_disciplina::quantDisciplinasCadastradas();
       // $quantAlunosCadastrados = tb_aluno::quantAlunosCadastrados();
        $quantAlunosCadastrados = tb_matricula::quantAlunosCadastrados();
        $quantMatriculasAtivas = tb_matricula::quantMatriculasAtivas();
        $quantMatriculasInativas = tb_matricula::quantMatriculasInativas();
        $quantTurmasAtivas = tb_turma::turmasAtivas()->count();
        $quantFuncionariosCadastrados = tb_funcionario::funcionarioCadastrados()->count();
        $quantUsuarioCadastrados = tb_usuario::listagemUsuarios()->count();
        return view('telasCoordenacao.index', compact('quantDisciplina', 'quantAlunosCadastrados', 'quantMatriculasAtivas', 'quantMatriculasInativas', 'quantTurmasAtivas', 'quantFuncionariosCadastrados', 'quantUsuarioCadastrados'));
    }

    // Metodo que direciona ao painel do docente
    public function docenteIndex() {
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
           $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
// Informações de quantidade de turmas e quantidade de disciplinas que o professor esta vinculados
$quantTurmasDocente = \App\Models\modelDocente\tb_turma_docente::quantidadeDeTurmaDoProfessor($idFuncionarios)->count();
$quantDisciplinaDocente = \App\Models\modelDocente\tb_disciplina_docente::quantidadeDeDisciplinasDoProfessor($idFuncionarios)->count();       
$Alunos = \App\Models\modelDocente\tb_aluno_docente::AlunosdoProfessorTotal($idFuncionarios)->count();


return view('telasCoordenacao.index', compact('quantTurmasDocente','quantDisciplinaDocente','Alunos'));
    }

    // Metodo que direciona para tela de login
    public function login() {
        return view('telasLogin.loginPrincipal');
    }

    /* Metodo de solicitacao de acesso, nesse metodos e validado o tipo de usuario 
      que esta solicitando o acesso e direcionado para a rota principal do mesmo.
     */

    public function postlogin(loginPrincipalRequest $inf_valores) {
        // atribuindo valores digitados para uma validação
        $validacao = ['CPFUsuario' => $inf_valores->get('CPF'), 'password' => $inf_valores->get('password'),];
//dd($validacao);
//dd($inf_valores->all());
        if (Auth::guard('guardLogin')->attempt($validacao)) {  // Validando as informações.
            $Situacao = auth()->guard('guardLogin')->user()->Situacao; // Atribuindo o valor do campo situação para uma vareavel

            if ($Situacao == "ATIVO") { // validando se o aluno esta ativo
                $Nivel = auth()->guard('guardLogin')->user()->Nivel; // Atribuindo o valor do campo Nivel para uma vareavel     
                if ($Nivel == "COORDENACÃO") {
                    return redirect('/coordenacao'); // SE O USUARIO FOR DA COORDENACAO SERÁ DIRECIONARO PARA ROTAS DA COORDENACAO
                } else if ($Nivel == "DOCENTE") {
                    return redirect('/docente'); // SE O USUARIO FOR um docente SERÁ DIRECIONARO PARA ROTAS de docencia
                } else {
                    return redirect('/login') // direcionando para pagina de login 
                                    ->withErrors(['SEMPERMISSOES' => 'Usuário sem Permissão!']) // messagem de erros aluno inativo
                                    ->withInput(); // levando as informações de digitada de volta para o form login
                }
            } else { // condição caso o aluno esteje inativo
                return redirect('/login') // direcionando para pagina de login 
                                ->withErrors(['Inativo' => 'Usuário Inativo!']) // messagem de erros aluno inativo
                                ->withInput(); // levando as informações de digitada de volta para o form login
            }
        } else {
            return redirect('/login') // caso a senha ou ra esteja incorretos
                            ->withErrors(['ERRO-LOGIN' => 'CPF ou Senha Inválidos!']) // messagem de dados invalidos
                            ->withInput(); // levando as informações de digitada de volta para o form login
        }
    }

    public function logout() {
        auth()->guard('guardLogin')->logout();
        return redirect('/login');
    }

}
