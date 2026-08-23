<?php

namespace App\Http\Controllers\controleDocente;

use App\Models\modelDocente\tb_funcionario_docente;
use App\Models\modelDocente\tb_turma_docente;
use App\Models\modelDocente\tb_usuario_docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DA ESCOLA
class cont_funcionario_docente extends Controller {

    private $request;
    private $validator;
    private $tb_funcionario;
    private $tb_usuario_docente;
    private $tb_turma;

    public function __construct(Request $dadosForm, tb_funcionario_docente $tb_funcionario_docente, tb_usuario_docente $tb_usuario_docente, tb_turma_docente $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_funcionario_docente = $tb_funcionario_docente;
        $this->tb_usuario_docente = $tb_usuario_docente;
        $this->tb_turma = $tb_turma;
    }

    // Metodo para vizualizar o perfil do funcionario via opção da parte superios que vem com id
    public function perfil($idFuncionarios) {
        $Funcionario = tb_funcionario_docente::perfilFuncionario($idFuncionarios);
        $Turmas = tb_turma_docente::TurmasdoProfessor($idFuncionarios);
        return view('telasCoordenacao.funcionarios.funcionario_perfil', compact('Funcionario', 'Turmas'));
    }

// Metodo para vizualizar o perfil do funcionario via menu secretaria onde tem que busca o id.
    public function perfil_request() {
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $Funcionario = tb_funcionario_docente::perfilFuncionario($idFuncionarios);
        $Turmas = tb_turma_docente::TurmasdoProfessor($idFuncionarios);
        return view('telasCoordenacao.funcionarios.funcionario_perfil', compact('Funcionario', 'Turmas'));
    }
//FIM DA CLASSE CONTROLE DA ESCOLA  
}
