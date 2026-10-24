<?php

namespace App\Http\Controllers\controleDocente;

use App\Models\modelDocente\tb_funcionario_docente;
use App\Models\modelDocente\tb_usuario_docente;
use App\Models\modelDocente\tb_turma_docente;
use App\Models\modelDocente\tb_aluno_docente;
use App\Models\modelDocente\tb_disciplina_docente;
use App\Models\modelDocente\tb_matricula_docente;
use App\Models\modelDocente\tb_turmas_disciplinas_docente;
use App\Models\modelDocente\tb_notas_docente;
use App\Models\modelDocente\tb_escola_docente;
use App\Support\ProfessorLogado;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

// INICIO DA CLASSE CONTROLE DO ALUNO
class cont_relatorios_docente extends Controller {

    private $request;
    private $validator;
    private $tb_turma;
    private $tb_aluno;
    private $tb_matricula;
    private $tb_notas;
    private $tb_escola;

    public function __construct(Request $dadosForm, tb_escola_docente $tb_escola, tb_matricula_docente $tb_matricula, tb_aluno_docente $tb_aluno, tb_notas_docente $tb_notas, tb_turma_docente $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
        $this->tb_aluno = $tb_aluno;
        $this->tb_matricula = $tb_matricula;
        $this->tb_notas = $tb_notas;
        $this->tb_escola = $tb_escola;
    }

    // Metodo que lista as turmas ativas para solicitacao de relatorios de alunos matriculados
    public function listagem_turmas() {
        $turmas = ProfessorLogado::turmasAtivas();
        return view('telasDocente.relatorios.relatorio_alunos_turmas', compact('turmas'));
    }

    // Metodo que gera o relatorio dos alunos da turma
    public function alunosPorTurma($idturmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idturmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $alunos = tb_aluno_docente::alunosPorTurma($idturmas);
        $turma = $this->tb_turma->find($idturmas);
        $titulo = 'Alunos Por Turma';
        return view('telasDocente.relatorios.relatorio_alunos_por_turma', compact('titulo', 'escolas', 'turma', 'alunos'));
    }
}
