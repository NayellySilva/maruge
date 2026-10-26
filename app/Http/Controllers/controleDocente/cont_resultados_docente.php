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
class cont_resultados_docente extends Controller {

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

    // Metodo para busca as turmas ativas cadastradas
    public function index() {
        $situacao = strtoupper((string) $this->request->input('SituacaoTurma', 'ATIVO'));
        if (!in_array($situacao, ['ATIVO', 'INATIVO', 'TODOS'], true)) {
            $situacao = 'ATIVO';
        }

        $query = DB::table('tb_turmas')
            ->whereIn('idTurmas', ProfessorLogado::idsTurmas() ?: [0]);

        if ($situacao === 'ATIVO') {
            $query->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA']);
        } elseif ($situacao === 'INATIVO') {
            $query->whereIn('SituacaoTurma', ['INATIVO', 'INATIVA']);
        }

        $pesquisar = trim((string) $this->request->input('pesquisar', ''));
        if ($pesquisar !== '') {
            $query->where(function ($filtro) use ($pesquisar) {
                $filtro->where('NomeTurma', 'like', "%{$pesquisar}%")
                    ->orWhere('AnoLetivo', 'like', "%{$pesquisar}%");
            });
        }

        $turmas = $query->orderBy('NomeTurma')->paginate(15)->withQueryString();
        return view('telasDocente.resultado.resultados', compact('turmas'));
    }

    // Metodo que faz o levantamento de todos os alunos de um determinada turma que estao em recuperacao parcial
    public function resultado_parcial($idTurmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Recuperação Parcial';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $professores = tb_turmas_disciplinas_docente::ProfessoreSuasDisciplinas($idTurmas);
        $nivel = app(\App\Services\NotaBimestralService::class)->nivelDaTurma($turma->NomeTurma ?? '');
        if ($nivel === 'inf') {
            return view('telasDocente.resultado.resultado_inf_parcial_final');
        } else if ($nivel === 'fun2') {
            return view('telasDocente.resultado.resultado_fund2_parcial', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else {
            return view('telasDocente.resultado.resultado_fund1_parcial', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        }
    }

    // Metodo que faz o levantamento de todos os alunos de um determinada turma que estao em recuperacao final
    public function resultado_final($idTurmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Recuperação Final';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $professores = tb_turmas_disciplinas_docente::ProfessoreSuasDisciplinas($idTurmas);
        $nivel = app(\App\Services\NotaBimestralService::class)->nivelDaTurma($turma->NomeTurma ?? '');
        if ($nivel === 'inf') {
            return view('telasDocente.resultado.resultado_inf_parcial_final');
        } else if ($nivel === 'fun2') {
            return view('telasDocente.resultado.resultado_fund2_final', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else {
            return view('telasDocente.resultado.resultado_fund1_final', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        }
    }

    // Metodo que faz o levantamento de todos os alunos aprovados no 1º semestre
    public function aprovados_1semestre($idTurmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Aprovados 1º Semestre';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $professores = tb_turmas_disciplinas_docente::ProfessoreSuasDisciplinas($idTurmas);
        $nivel = app(\App\Services\NotaBimestralService::class)->nivelDaTurma($turma->NomeTurma ?? '');
        if ($nivel === 'inf') {
            return view('telasDocente.resultado.resultado_inf_aprovados_1sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else if ($nivel === 'fun2') {
            return view('telasDocente.resultado.resultado_fund2_aprovados_1sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else {
            return view('telasDocente.resultado.resultado_fund1_aprovados_1sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        }
    }

    // Metodo que faz o levantamento de todos os alunos aprovados no 2º semestre
    public function aprovados_2semestre($idTurmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Aprovados 2º Semestre';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $professores = tb_turmas_disciplinas_docente::ProfessoreSuasDisciplinas($idTurmas);
        $nivel = app(\App\Services\NotaBimestralService::class)->nivelDaTurma($turma->NomeTurma ?? '');
        if ($nivel === 'inf') {
            return view('telasDocente.resultado.resultado_inf_aprovados_2sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else if ($nivel === 'fun2') {
            return view('telasDocente.resultado.resultado_fund2_aprovados_2sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else {
            return view('telasDocente.resultado.resultado_fund1_aprovados_2sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        }
    }
}
