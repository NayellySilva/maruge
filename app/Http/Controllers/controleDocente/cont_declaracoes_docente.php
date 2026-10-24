<?php

namespace App\Http\Controllers\controleDocente;

use App\Models\modelCoordenacao\tb_usuario;
use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_funcionario;
use App\Support\ProfessorLogado;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

// INICIO DA CLASSE CONTROLE DAS DECLARACOES
class cont_declaracoes_docente extends Controller {

    private $request;
    private $tb_usuario;
    private $tb_funcionario;
    private $tb_escola;

    public function __construct(Request $dadosForm, tb_usuario $tb_usuario, tb_funcionario $tb_funcionario, tb_escola $tb_escola) {
        $this->request = $dadosForm;
        $this->tb_usuario = $tb_usuario;
        $this->tb_funcionario = $tb_funcionario;
        $this->tb_escola = $tb_escola;
    }

    // Metodo para emitir declaracao funcional do docente
    public function index() {
        $idFuncionarios = ProfessorLogado::id();
        $meses = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];
        $dia = date('d') . ' de ' . ($meses[(int)date('n')] ?? '') . ' de ' . date('Y');
        $titulo = 'Declaração do Funcionário';
        $Funcionario = $idFuncionarios ? tb_funcionario::declaracaoFuncionario($idFuncionarios) : collect();
        $escolas = tb_escola::informacaoEscolar();
        return view('telasDocente.declaracoes.declaracoes_funcionario', compact('Funcionario', 'dia', 'titulo','escolas'));
    }
}
