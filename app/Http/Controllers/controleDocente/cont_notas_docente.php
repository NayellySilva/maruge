<?php

namespace App\Http\Controllers\controleDocente;

use App\Models\modelDocente\tb_funcionario_docente;
use App\Models\modelDocente\tb_usuario_docente;
use App\Models\modelDocente\tb_turma_docente;
use App\Models\modelDocente\tb_aluno_docente;
use App\Models\modelDocente\tb_disciplina_docente;
use App\Models\modelDocente\tb_matricula_docente;
use App\Models\modelDocente\tb_turmas_disciplinas_docente;
use App\Models\modelCoordenacao\tb_notas;
use App\Services\NotaBimestralService;
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
    private $notaService;

    public function __construct(Request $dadosForm, tb_matricula_docente $tb_matricula, tb_aluno_docente $tb_aluno, tb_notas $tb_notas, tb_turma_docente $tb_turma, Validator $validator, NotaBimestralService $notaService) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
        $this->tb_aluno = $tb_aluno;
        $this->tb_matricula = $tb_matricula;
        $this->tb_notas = $tb_notas;
        $this->notaService = $notaService;
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
        return view('telasDocente.notas.notas', compact('Alunos', 'turmas'));
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
            $nivelCode = $this->notaService->nivelDaTurma($turma->NomeTurma ?? '');
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

        // Forcar ID do usuario logado para gravacao correta do autor
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
        return $this->salvarNotaInfantil(1);
    }

    public function salva_nota_2bim_inf() {
        return $this->salvarNotaInfantil(2);
    }

    public function salva_nota_3bim_inf() {
        return $this->salvarNotaInfantil(3);
    }

    public function salva_nota_4bim_inf() {
        return $this->salvarNotaInfantil(4);
    }

    private function salvarNotaInfantil(int $bim) {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);

        $campo = 'AB' . $bim;
        if (!empty($dadosForm[$campo]) && is_array($dadosForm[$campo])) {
            foreach ($dadosForm[$campo] as $k => $v) {
                $dadosForm[$campo][$k] = $this->notaService->normalizarNota($v);
            }
        }

        $count = count($dadosForm[$campo] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm[$campo][$i])) {
                return tb_notas::{"salva_nota_{$bim}bim_inf"}($dadosForm);
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
        return $this->salvarNotaFundamental1(1);
    }

    public function salva_nota_2bim_fun1() {
        return $this->salvarNotaFundamental1(2);
    }

    public function salva_nota_3bim_fun1() {
        return $this->salvarNotaFundamental1(3);
    }

    public function salva_nota_4bim_fun1() {
        return $this->salvarNotaFundamental1(4);
    }

    private function salvarNotaFundamental1(int $bim) {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $dadosForm = $this->notaService->normalizarFormularioBimestre($dadosForm, $bim);

        $campo = 'AB' . $bim;
        $campoRb = 'RB' . $bim;
        $count = count($dadosForm[$campo] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (isset($dadosForm[$campo][$i]) || isset($dadosForm[$campoRb][$i])) {
                return tb_notas::{"salva_nota_{$bim}bim_fun1"}($dadosForm);
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
        return $this->salvarNotaFundamental2(1);
    }

    public function salva_nota_2bim_fun2() {
        return $this->salvarNotaFundamental2(2);
    }

    public function salva_nota_3bim_fun2() {
        return $this->salvarNotaFundamental2(3);
    }

    public function salva_nota_4bim_fun2() {
        return $this->salvarNotaFundamental2(4);
    }

    private function salvarNotaFundamental2(int $bim) {
        $dadosForm = $this->request->all();
        $this->validarPermissaoLancamento($dadosForm);
        $dadosForm = $this->notaService->normalizarFormularioBimestre($dadosForm, $bim);

        $campoAm = 'AM' . $bim;
        $campoAb = 'AB' . $bim;
        $count = count($dadosForm["RA"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm[$campoAm][$i]) || !empty($dadosForm[$campoAb][$i])) {
                return tb_notas::{"salva_nota_{$bim}bim_fun2"}($dadosForm);
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

        foreach (['RP', 'RF'] as $campo) {
            if (!empty($dadosForm[$campo]) && is_array($dadosForm[$campo])) {
                foreach ($dadosForm[$campo] as $k => $v) {
                    $dadosForm[$campo][$k] = $this->notaService->normalizarNota($v);
                }
            }
        }

        $count = count($dadosForm["RA"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["RP"][$i]) || !empty($dadosForm["RF"][$i])) {
                return tb_notas::salva_nota_rp_rf($dadosForm);
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

        $updateNota = tb_notas::editandoNotas($dadosForm);
        if ($updateNota) {
            return 'notaAtualizada';
        } else {
            return 'erroAoAtualizarNota';
        }
    }

    // Tela de lancamento de notas por turma inteira
    public function lancarTurma($idTurma, $idDisciplina, $bim) {
        $bimsValidos = ['1bim', '2bim', '3bim', '4bim'];
        abort_if(!in_array($bim, $bimsValidos), 404);
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurma), 403);
        abort_unless(ProfessorLogado::podeLancarDisciplina($idTurma, $idDisciplina), 403);

        $turma = DB::table('tb_turmas')->where('idTurmas', $idTurma)->first();
        abort_if(!$turma, 404);

        $disciplina = DB::table('tb_disciplinas')->where('idDisciplinas', $idDisciplina)->first();
        abort_if(!$disciplina, 404);

        $nivel = $this->notaService->nivelDaTurma($turma->NomeTurma ?? '');
        $bimestreNumero = (int) str_replace('bim', '', $bim);

        $alunos = DB::table('tb_aluno')
            ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
            ->where('tb_aluno.tb_turmas_idTurmas', $idTurma)
            ->whereIn('tb_aluno.SituacaoAluno', ['ATIVO', 'ATIVA'])
            ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_matriculas.RA')
            ->orderBy('tb_aluno.NomeAluno')
            ->get();

        $idsAlunos = $alunos->pluck('idAluno');
        $notasExistentes = DB::table('tb_notas')
            ->where('tb_turmas_idTurmas', $idTurma)
            ->where('tb_disciplinas_idDisciplinas', $idDisciplina)
            ->whereIn('tb_aluno_idAluno', $idsAlunos)
            ->get()
            ->keyBy('tb_aluno_idAluno');

        return view('telasDocente.notas.lancar_turma', compact('turma', 'disciplina', 'bim', 'bimestreNumero', 'nivel', 'alunos', 'notasExistentes'));
    }

    // Salvar notas da turma inteira de uma vez
    public function salvarNotasTurma(Request $request) {
        $idTurma = $request->integer('idTurmas');
        $idDisciplina = $request->integer('tb_disciplinas_idDisciplinas');
        $bim = $request->input('bim');

        $bimsValidos = ['1bim', '2bim', '3bim', '4bim'];
        abort_if(!in_array($bim, $bimsValidos), 404);
        abort_unless(ProfessorLogado::podeAcessarTurma($idTurma), 403);
        abort_unless(ProfessorLogado::podeLancarDisciplina($idTurma, $idDisciplina), 403);

        $turma = DB::table('tb_turmas')->where('idTurmas', $idTurma)->first();
        abort_if(!$turma, 404);
        $nivel = $this->notaService->nivelDaTurma($turma->NomeTurma ?? '');
        $bimNumero = (int) str_replace('bim', '', $bim);

        $alunos = (array) $request->input('tb_aluno_idAluno', []);
        $ras = (array) $request->input('RA', []);
        $abs = (array) $request->input("AB{$bimNumero}", []);
        $ams = (array) $request->input("AM{$bimNumero}", []);
        $rbs = (array) $request->input("RB{$bimNumero}", []);

        $userId = auth()->guard('guardLogin')->id() ?? 1;

        foreach ($alunos as $i => $idAluno) {
            abort_unless(ProfessorLogado::podeAcessarAluno($idAluno), 403);

            $ab = $this->notaService->normalizarNota($abs[$i] ?? null);
            $am = ($nivel === 'fun2') ? $this->notaService->normalizarNota($ams[$i] ?? null) : null;
            $rb = ($nivel !== 'inf') ? $this->notaService->normalizarNota($rbs[$i] ?? null) : null;

            // Se for fundamental, verificar se a recuperacao e aplicavel
            if ($nivel !== 'inf') {
                $avaliacoes = array_values(array_filter([$am, $ab], fn($v) => $v !== null));
                $mediaParcial = $this->notaService->calcularMediaParcial($avaliacoes);
                if ($mediaParcial !== null && !$this->notaService->deveHabilitarRecuperacao($mediaParcial)) {
                    $rb = null;
                }
            }

            // Defesa extra: garantir que todos os campos NOT NULL tenham valor
            // ao fazer INSERT (updateOrInsert emite INSERT quando não existe linha)
            $defaults = [
                'AM1' => 0, 'AM2' => 0, 'AM3' => 0, 'AM4' => 0,
                'AB1' => 0, 'AB2' => 0, 'AB3' => 0, 'AB4' => 0,
                'RP'  => 0, 'RF'  => 0,
            ];

            $campos = [
                "AB{$bimNumero}" => $ab,
                'tb_usuario_idUsuario' => $userId,
            ];
            if ($nivel === 'fun2') {
                $campos["AM{$bimNumero}"] = $am;
            }
            if ($nivel !== 'inf') {
                $campos["RB{$bimNumero}"] = $rb;
            }

            DB::table('tb_notas')->updateOrInsert(
                [
                    'tb_turmas_idTurmas' => $idTurma,
                    'tb_disciplinas_idDisciplinas' => $idDisciplina,
                    'tb_aluno_idAluno' => $idAluno,
                ],
                array_merge($defaults, $campos, [
                    'RA'         => $ras[$i] ?? '',
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        return redirect("/docente/lancar_turma/{$idTurma}/{$idDisciplina}/{$bim}")
            ->with('status', 'Notas da turma salvas com sucesso!');
    }
}
