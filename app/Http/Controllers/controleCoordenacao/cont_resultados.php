<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_endereco;
use App\Models\modelCoordenacao\tb_notas;
use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_turmas_disciplinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\controleCoordenacao\cont_relatorios;

class cont_resultados extends Controller {

    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_endereco;
    private $tb_turma;
    private $tb_escola;
    private $tb_notas;
    private $tb_matricula;

    public function __construct(Request $dadosForm, tb_matricula $tb_matricula, tb_escola $tb_escola, tb_aluno $tb_aluno, tb_notas $tb_notas, tb_endereco $tb_endereco, tb_turma $tb_turma, Validator $validator) {
        $this->request = request();
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_endereco;
        $this->tb_turma = $tb_turma;
        $this->tb_escola = $tb_escola;
        $this->tb_notas = $tb_notas;
        $this->tb_matricula = $tb_matricula;
    }

    public function index() {
        $turmas = tb_turma::listandoTurmasAtivas();
        return view('telasCoordenacao.resultado.resultados', compact('turmas'));
    }

    public function resultados_pesq() {
        $palavrachave = $this->request->get('pesquisar');
        $turmas = tb_turma::pesquisar($palavrachave);
        return view('telasCoordenacao.resultado.resultados_pesq', compact('turmas'));
    }

    public function resultados_filtro() {
        $SituacaoTurma = $this->request->get('SituacaoTurma');
        if ($SituacaoTurma == null) {
            return redirect('/coordenacao/resultados');
        }
        $turmas = tb_turma::filtroporSituacaoTurma($SituacaoTurma);
        return view('telasCoordenacao.resultado.resultados_filtro', compact('turmas'));
    }

    private function renderizarResultado($idTurmas, $tipo, $tituloPadrao = '') {
        $turma = $this->tb_turma->find($idTurmas);
        if (!$turma) {
            return redirect('/coordenacao/resultados')->with('error', 'Turma não encontrada.');
        }

        $escolas = tb_escola::informacaoEscolar();
        $Alunos = tb_turma::alunosdaturma($idTurmas);
        $alunos = $Alunos;
        $disciplinas = tb_turmas_disciplinas::disciplinaTurma($idTurmas);
        $professores = tb_turmas_disciplinas::ProfessoreSuasDisciplinas($idTurmas);
        $titulo = $tituloPadrao ?: "Resultados — {$turma->NomeTurma}";

        $rawNivel = cont_relatorios::determinarNivelTurma($turma->NomeTurma ?? '');
        $nivel = ($rawNivel === 'fun1') ? 'fund1' : (($rawNivel === 'fun2') ? 'fund2' : 'inf');

        if ($nivel === 'inf' && in_array($tipo, ['parcial', 'final'])) {
            return view('telasCoordenacao.resultado.resultado_inf_parcial_final', compact('titulo', 'escolas', 'turma', 'Alunos', 'alunos', 'disciplinas', 'professores'));
        }

        $viewName = "telasCoordenacao.resultado.resultado_{$nivel}_{$tipo}";
        if (!view()->exists($viewName)) {
            $viewName = "telasCoordenacao.resultado.resultado_fund1_{$tipo}";
        }

        return view($viewName, compact('titulo', 'escolas', 'turma', 'Alunos', 'alunos', 'disciplinas', 'professores'));
    }

    public function resultado_parcial($idTurmas) {
        return $this->renderizarResultado($idTurmas, 'parcial', 'Recuperação Parcial');
    }

    public function resultado_final($idTurmas) {
        return $this->renderizarResultado($idTurmas, 'final', 'Recuperação Final');
    }

    public function aprovados_1semestre($idTurmas) {
        return $this->renderizarResultado($idTurmas, 'aprovados_1sem', 'Aprovados 1º Semestre');
    }

    public function aprovados_2semestre($idTurmas) {
        return $this->renderizarResultado($idTurmas, 'aprovados_2sem', 'Aprovados 2º Semestre');
    }

    public function mapa_dinamico($tipo, $idTurmas) {
        $mapaTipos = [
            'parcial' => 'parcial',
            'final' => 'final',
            'aprovados_1semestre' => 'aprovados_1sem',
            'aprovados_2semestre' => 'aprovados_2sem',
        ];

        if (!array_key_exists($tipo, $mapaTipos)) {
            abort(404);
        }

        $tipoSufixo = $mapaTipos[$tipo];
        return $this->renderizarResultado($idTurmas, $tipoSufixo);
    }
}
