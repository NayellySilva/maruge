<?php

namespace App\Http\Controllers\controleDocente;

use App\Models\modelDocente\tb_funcionario_docente;
use App\Models\modelDocente\tb_usuario_docente;
use App\Models\modelDocente\tb_turma_docente;
use App\Models\modelDocente\tb_aluno_docente;
use App\Models\modelDocente\tb_disciplina_docente;
use App\Models\modelDocente\tb_escola_docente;
use App\Models\modelDocente\tb_matricula_docente;
use App\Models\modelDocente\tb_turmas_disciplinas_docente;
use App\Models\modelDocente\tb_notas_docente;
use App\Support\ProfessorLogado;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

// INICIO DA CLASSE CONTROLE DO ALUNO
class cont_mapas_docente extends Controller {

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
        $this->tb_escola = $tb_escola;
        $this->tb_notas = $tb_notas;
    }

    // Metodo faz solicitacao dos relatorios bimestrais dos alunos
    public function index() {
        $turmas = $this->turmasFiltradas();
        return view('telasDocente.mapa.mapas_notas', compact('turmas'));
    }

    // Metodo faz solicitacao dos relatorios bimestrais dos alunos
    public function index_por_docente() {
        $turmas = $this->turmasFiltradas();
        return view('telasDocente.mapa.mapas_notas', compact('turmas'));
    }

    private function turmasFiltradas()
    {
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

        return $query->orderBy('NomeTurma')->paginate(15)->withQueryString();
    }

    // Metodo do primeiro bimestre que direciona o aluno para a view apropriada
    public function bimestre_1($idTurmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Mapa de Nota 1º Bimestre';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $nivel = app(\App\Services\NotaBimestralService::class)->nivelDaTurma($turma->NomeTurma ?? '');
        if ($nivel === 'inf') {
            return view('telasDocente.mapa.mapa_inf_1bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($nivel === 'fun2') {
            return view('telasDocente.mapa.mapa_fund2_1bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else {
            return view('telasDocente.mapa.mapa_fund1_1bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }
    }

    // Metodo do segundo bimestre que direciona o aluno para a view apropriada
    public function bimestre_2($idTurmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Mapa de Nota 2º Bimestre';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $nivel = app(\App\Services\NotaBimestralService::class)->nivelDaTurma($turma->NomeTurma ?? '');
        if ($nivel === 'inf') {
            return view('telasDocente.mapa.mapa_inf_2bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($nivel === 'fun2') {
            return view('telasDocente.mapa.mapa_fund2_2bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else {
            return view('telasDocente.mapa.mapa_fund1_2bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }
    }

    // Metodo do terceiro bimestre que direciona o aluno para a view apropriada
    public function bimestre_3($idTurmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Mapa de Nota 3º Bimestre';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $nivel = app(\App\Services\NotaBimestralService::class)->nivelDaTurma($turma->NomeTurma ?? '');
        if ($nivel === 'inf') {
            return view('telasDocente.mapa.mapa_inf_3bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($nivel === 'fun2') {
            return view('telasDocente.mapa.mapa_fund2_3bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else {
            return view('telasDocente.mapa.mapa_fund1_3bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }
    }

    // Metodo do quarto bimestre que direciona o aluno para a view apropriada
    public function bimestre_4($idTurmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Mapa de Nota 4º Bimestre';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $nivel = app(\App\Services\NotaBimestralService::class)->nivelDaTurma($turma->NomeTurma ?? '');
        if ($nivel === 'inf') {
            return view('telasDocente.mapa.mapa_inf_4bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($nivel === 'fun2') {
            return view('telasDocente.mapa.mapa_fund2_4bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else {
            return view('telasDocente.mapa.mapa_fund1_4bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }
    }

    // Metodo do mapa global que direciona o aluno para a view apropriada
    public function mapa_global($idTurmas) {
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurmas), 403);
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Mapa de Nota Global';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $nivel = app(\App\Services\NotaBimestralService::class)->nivelDaTurma($turma->NomeTurma ?? '');
        if ($nivel === 'inf') {
            return view('telasDocente.mapa.mapa_inf_global', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($nivel === 'fun2') {
            return view('telasDocente.mapa.mapa_fund2_global', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else {
            return view('telasDocente.mapa.mapa_fund1_global', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }
    }
}
