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

class cont_funcionario_docente extends Controller {

    private $request;
    private $validator;
    private $tb_funcionario_docente;
    private $tb_usuario_docente;
    private $tb_turma;

    public function __construct(Request $dadosForm, tb_funcionario_docente $tb_funcionario_docente, tb_usuario_docente $tb_usuario_docente, tb_turma_docente $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_funcionario_docente = $tb_funcionario_docente;
        $this->tb_usuario_docente = $tb_usuario_docente;
        $this->tb_turma = $tb_turma;
    }

    // Metodo para visualizar o perfil do docente
    public function perfil($idFuncionarios = null) {
        if (empty($idFuncionarios)) {
            if (auth()->guard('guardLogin')->check()) {
                $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
                $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
                foreach ($nomedeusuario as $item) {
                    $idFuncionarios = $item->idFuncionarios ?? $item['idFuncionarios'] ?? null;
                }
            }
        }

        $Funcionario = $idFuncionarios ? tb_funcionario_docente::perfilFuncionario($idFuncionarios) : collect();
        $Turmas = $idFuncionarios ? tb_turma_docente::TurmasdoProfessor($idFuncionarios) : collect();
        return view('telasDocente.funcionarios.funcionario_perfil', compact('Funcionario', 'Turmas'));
    }

    // Metodo para visualizar o perfil via request
    public function perfil_request() {
        return $this->perfil();
    }
}
