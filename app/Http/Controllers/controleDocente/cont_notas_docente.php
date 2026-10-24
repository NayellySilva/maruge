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
use App\Support\ProfessorLogado;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

// INICIO DA CLASSE CONTROLE DO ALUNO
class cont_notas_docente extends Controller {

    private $request;
    private $validator;
    private $tb_turma;
    private $tb_aluno;
    private $tb_matricula;
    private $tb_notas;

    public function __construct(Request $dadosForm, tb_matricula_docente $tb_matricula, tb_aluno_docente $tb_aluno, tb_notas_docente $tb_notas, tb_turma_docente $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
        $this->tb_aluno = $tb_aluno;
        $this->tb_matricula = $tb_matricula;
        $this->tb_notas = $tb_notas;
    }

    // Metodo que lista os alunos
    public function index() {
        $idFuncionarios = ProfessorLogado::id();
        $Alunos = $idFuncionarios ? tb_aluno_docente::AlunosdoProfessor($idFuncionarios) : collect();
        $turmas = ProfessorLogado::turmasAtivas();
        return view('telasDocente.notas.notas', compact('Alunos', 'turmas'));
    }

    // Metodo pesquisar aluno por filtro de turma
    public function notas_filtro() {
        $idTurma = $this->request->get('idTurmas');
        $idFuncionarios = ProfessorLogado::id();
        $turmas = ProfessorLogado::turmasAtivas();
        if (empty($idTurma)) {
            $Alunos = $idFuncionarios ? tb_aluno_docente::AlunosdoProfessor($idFuncionarios) : collect();
        } else {
            abort_unless(ProfessorLogado::podeAcessarTurma($idTurma), 403);
            $Alunos = tb_aluno_docente::filtroporTurma($idTurma);
        }
        return view('telasDocente.notas.notas', compact('Alunos', 'turmas'));
    }

    // Metodo pesquisar aluno por palavra chave
    public function notas_pesq() {
        $idFuncionarios = ProfessorLogado::id();
        $turmas = ProfessorLogado::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = $idFuncionarios ? tb_aluno_docente::pesquisar($palavrachave, $idFuncionarios) : collect();
        return view('telasDocente.notas.notas_pesq', compact('Alunos', 'turmas'));
    }

    // Lançamento por aluno e bimestre
    public function lancamento($bim, $id) {
        $bimsValidos = ['1bim', '2bim', '3bim', '4bim', 'rec'];
        abort_if(!in_array($bim, $bimsValidos), 404);
        abort_unless(ProfessorLogado::podeAcessarAluno($id), 403);

        $aluno = DB::table('tb_aluno')->where('idAluno', $id)->first();
        abort_if(!$aluno, 404);

        $matricula = DB::table('tb_matriculas')->where('idMatriculas', $aluno->tb_matriculas_idMatriculas ?? 0)->first();
        $turma = DB::table('tb_turmas')->where('idTurmas', $aluno->tb_turmas_idTurmas ?? 0)->first();

        // Pegar disciplinas vinculadas exclusivamente ao professor para esta turma (sem fallback perigoso)
        $disciplinas = ProfessorLogado::disciplinasNaTurma($turma->idTurmas ?? 0);

        $titulo = 'Lançamento de Notas — ' . ($aluno->NomeAluno ?? 'Aluno');

        if ($bim === 'rec') {
            $nivel = 'fund1';
        } else {
            $nivelCode = \App\Http\Controllers\controleCoordenacao\cont_relatorios::determinarNivelTurma($turma->NomeTurma ?? '');
            $nivel = ($nivelCode === 'fun1') ? 'fund1' : (($nivelCode === 'fun2') ? 'fund2' : 'inf');
        }

        $bimestre = $bim;
        return view('telasDocente.notas.lancamento', compact('aluno', 'matricula', 'turma', 'disciplinas', 'titulo', 'bimestre', 'nivel'));
    }

    public function bimestre_1($idAluno) {
        return redirect("/docente/lancamentos_notas_1bim/{$idAluno}");
    }

    public function bimestre_2($idAluno) {
        return redirect("/docente/lancamentos_notas_2bim/{$idAluno}");
    }

    public function bimestre_3($idAluno) {
        return redirect("/docente/lancamentos_notas_3bim/{$idAluno}");
    }

    public function bimestre_4($idAluno) {
        return redirect("/docente/lancamentos_notas_4bim/{$idAluno}");
    }

    /**
     * Valida se o docente tem permissao para lancar notas para o aluno e disciplinas informadas.
     */
    private function validarPermissaoLancamento(array &$dadosForm): void {
        $alunos = (array) ($dadosForm['tb_aluno_idAluno'] ?? []);
        $turmas = (array) ($dadosForm['tb_turmas_idTurmas'] ?? []);
        $disciplinas = (array) ($dadosForm['tb_disciplinas_idDisciplinas'] ?? []);

        abort_if(empty($alunos) || empty($disciplinas), 403);

        foreach ($alunos as $idAluno) {
            abort_unless(ProfessorLogado::podeAcessarAluno($idAluno), 403);
        }

        $count = count($disciplinas);
        for ($i = 0; $i < $count; $i++) {
            $idTurma = $turmas[$i] ?? reset($turmas);
            $idDisc = $disciplinas[$i] ?? null;
            abort_unless($idTurma && $idDisc && ProfessorLogado::podeLancarDisciplina($idTurma, $idDisc), 403);
        }

        // Forcar ID do usuario logado para evitar adulteracao
        $userId = auth()->guard('guardLogin')->id() ?? 1;
        if (isset($dadosForm['tb_usuario_idUsuario']) && is_array($dadosForm['tb_usuario_idUsuario'])) {
            foreach ($dadosForm['tb_usuario_idUsuario'] as $k => $v) {
                $dadosForm['tb_usuario_idUsuario'][$k] = $userId;
            }
        }
    }

    /**
     * ********************************************
     * Metodos para uso exclusivo para turma do Infantil
     * ********************************************
     */
    public function salva_nota_1bim_inf() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["AB1"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB1"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_1bim_inf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    public function salva_nota_2bim_inf() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["AB2"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB2"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_2bim_inf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    public function salva_nota_3bim_inf() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["AB3"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB3"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_3bim_inf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    public function salva_nota_4bim_inf() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["AB4"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB4"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_4bim_inf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    /**
     * ********************************************
     * Metodos para uso exclusivo para turma do Fundamental I
     * ********************************************
     */
    public function salva_nota_1bim_fun1() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["AB1"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB1"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_1bim_fun1($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    public function salva_nota_2bim_fun1() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["AB2"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB2"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_2bim_fun1($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    public function salva_nota_3bim_fun1() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["AB3"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB3"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_3bim_fun1($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    public function salva_nota_4bim_fun1() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["AB4"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB4"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_4bim_fun1($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    /**
     * ********************************************
     * Metodos para uso exclusivo para turma do Fundamental II
     * ********************************************
     */
    public function salva_nota_1bim_fun2() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["RA"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AM1"][$i]) || !empty($dadosForm["AB1"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_1bim_fun2($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    public function salva_nota_2bim_fun2() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["RA"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AM2"][$i]) || !empty($dadosForm["AB2"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_2bim_fun2($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    public function salva_nota_3bim_fun2() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["RA"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AM3"][$i]) || !empty($dadosForm["AB3"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_3bim_fun2($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    public function salva_nota_4bim_fun2() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["RA"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AM4"][$i]) || !empty($dadosForm["AB4"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_4bim_fun2($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    // Metodo recuperacoes do aluno para a view apropriada
    public function rp_rf($idAluno) {
        abort_unless(ProfessorLogado::podeAcessarAluno($idAluno), 403);
        return redirect("/docente/lancamentos_notas_rec/{$idAluno}");
    }

    // Salvar nota DE RECUPERACAO PARCIAL E FINAL
    public function salva_nota_rp_rf() {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $count = count($dadosForm["RA"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["RP"][$i]) || !empty($dadosForm["RF"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_rp_rf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    // Edita Nota
    public function editarNota() {
        $dadosForm = $this->request->all();
        $idAluno = $dadosForm["tb_aluno_idAluno"] ?? null;
        abort_unless($idAluno && ProfessorLogado::podeAcessarAluno($idAluno), 403);

        $aluno = $this->tb_aluno->find($idAluno);
        $turma = $aluno->turmaAluno ?? null;
        $idTurmas = $turma['idTurmas'] ?? ($turma->idTurmas ?? null);

        $idDisciplina = $dadosForm["tb_disciplinas_idDisciplinas"] ?? null;
        abort_unless($idTurmas && $idDisciplina && ProfessorLogado::podeLancarDisciplina($idTurmas, $idDisciplina), 403);

        $dadosForm['tb_usuario_idUsuario'] = auth()->guard('guardLogin')->id() ?? 1;

        $updateNota = tb_notas_docente::editandoNotas($dadosForm);
        if ($updateNota) {
            return 'notaAtualizada';
        } else {
            return 'erroAoAtualizarNota';
        }
    }
}
