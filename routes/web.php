<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\controleLogin\loginPrincipal;
use App\Http\Controllers\controleLogin\loginAluno;
use App\Http\Controllers\controleCoordenacao\cont_aluno;
use App\Http\Controllers\controleCoordenacao\cont_boletins;
use App\Http\Controllers\controleCoordenacao\cont_cadescola;
use App\Http\Controllers\controleCoordenacao\cont_declaracoes;
use App\Http\Controllers\controleCoordenacao\cont_disciplina;
use App\Http\Controllers\controleCoordenacao\cont_escola;
use App\Http\Controllers\controleCoordenacao\cont_financeiro;
use App\Http\Controllers\controleCoordenacao\cont_frequencias;
use App\Http\Controllers\controleCoordenacao\cont_funcionario;
use App\Http\Controllers\controleCoordenacao\cont_gabarito;
use App\Http\Controllers\controleCoordenacao\cont_historico;
use App\Http\Controllers\controleCoordenacao\cont_lanche;
use App\Http\Controllers\controleCoordenacao\cont_mapas;
use App\Http\Controllers\controleCoordenacao\cont_notas;
use App\Http\Controllers\controleCoordenacao\cont_recibos;
use App\Http\Controllers\controleCoordenacao\cont_relatorios;
use App\Http\Controllers\controleCoordenacao\cont_resultados;
use App\Http\Controllers\controleCoordenacao\cont_turma;
use App\Http\Controllers\controleCoordenacao\cont_turma_disciplina;
use App\Http\Controllers\controleCoordenacao\cont_usuario;

// =============================================================================
// 1. PAINEL E APIs DO PAINEL
// =============================================================================
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/api/aniversariantes', [DashboardController::class, 'aniversariantes'])->name('api.aniversariantes');

// Calendário (feriados + eventos da escola salvos em storage/app/eventos.json)
Route::get('/api/feriados', [CalendarioController::class, 'feriados'])->name('api.feriados');
Route::post('/api/eventos', [CalendarioController::class, 'salvarEvento'])->name('api.eventos.salvar');
Route::delete('/api/eventos', [CalendarioController::class, 'excluirEvento'])->name('api.eventos.excluir');

// =============================================================================
// 2. LOGIN / LOGOUT
// =============================================================================
Route::get('/login', [loginPrincipal::class, 'login'])->name('login');
Route::post('/login', [loginPrincipal::class, 'postlogin']);
Route::get('/logout', [loginPrincipal::class, 'logout']);
Route::get('/docente', [loginPrincipal::class, 'docenteIndex']);

Route::get('/aluno/login', [loginAluno::class, 'login']);
Route::post('/aluno/login', [loginAluno::class, 'postlogin']);
// PENDENTE (fase de login): loginAluno@postlogin redireciona para '/aluno' (sucesso)
// e '/loginaluno' (falha), rotas que não existem.

// =============================================================================
// 3. COORDENAÇÃO  (todas as URIs abaixo começam com /coordenacao)
// =============================================================================
Route::prefix('coordenacao')->group(function () {

    Route::get('/', [loginPrincipal::class, 'coordenacaoIndex']);

    // Central de ajuda
    Route::get('/ajuda', fn () => view('telasCoordenacao.ajuda', ['titulo' => 'Central de Ajuda']));
    Route::get('/ajuda/ajuda', fn () => view('telasCoordenacao.ajuda', ['titulo' => 'Central de Ajuda']));

    // -------------------------------------------------------------------------
    // Alunos (matrícula, edição, transferência, ficha, rematrícula)
    // -------------------------------------------------------------------------
    Route::get('/aluno_cad', [cont_aluno::class, 'novoaluno']);
    Route::get('/alunos/aluno_cad', [cont_aluno::class, 'novoaluno']);   // botão "Nova Matrícula" do painel/menu
    Route::post('/aluno_cad', [cont_aluno::class, 'postnovoaluno']);
    Route::get('/aluno_inf', [cont_aluno::class, 'aluno_inf']);
    Route::get('/alunos/aluno_inf', [cont_aluno::class, 'aluno_inf']);
    Route::get('/aluno_editar/{id}', [cont_aluno::class, 'editar']);
    Route::post('/aluno_editar/{id}', [cont_aluno::class, 'editando']);
    Route::get('/aluno_transferir/{id}', [cont_aluno::class, 'transferir']);
    Route::post('/aluno_transferir/{id}', [cont_aluno::class, 'transferindo']);
    Route::get('/aluno_ficha/{id}', [cont_aluno::class, 'ficha']);
    Route::get('/aluno_deletar/{id}', [cont_aluno::class, 'deletar']);
    Route::match(['get', 'post'], '/aluno_pesq', [cont_aluno::class, 'aluno_pesq']);
    Route::match(['get', 'post'], '/aluno_filtro', [cont_aluno::class, 'aluno_filtro']);
    Route::get('/aluno_rematricula', [cont_aluno::class, 'aluno_rematricula']);
    Route::post('/aluno_pesq_rematricula', [cont_aluno::class, 'aluno_pesq_rematricula']);

    // Pré-matrícula / reserva de vaga
    Route::get('/aluno_pre_matricula/{id}', [cont_aluno::class, 'reservar']);
    Route::post('/aluno_pre_matricula', [cont_aluno::class, 'reservando']);
    Route::get('/aluno_pre_matriculado', [cont_aluno::class, 'pre_matriculados']);
    Route::get('/aluno_pre_matricula_lista', [cont_aluno::class, 'pre_matricula']);
    Route::post('/aluno_pesq_reserva', [cont_aluno::class, 'aluno_pesq_reserva']);   // NOVA: busca da lista de pré-matrícula
    Route::get('/aluno_pre_matriculado_deletar/{id}', [cont_aluno::class, 'pre_matriculado_deletar']);

    // -------------------------------------------------------------------------
    // Turmas
    // -------------------------------------------------------------------------
    Route::get('/cadturma', [cont_turma::class, 'novaturma']);
    Route::get('/turma_cad', [cont_turma::class, 'novaturma']);            // NOVA: link das telas de gabarito
    Route::post('/cadturma', [cont_turma::class, 'postnovaturma']);
    Route::get('/turma_inf', [cont_turma::class, 'turma_inf']);
    Route::get('/turma_editar/{id}', [cont_turma::class, 'editar']);
    Route::post('/editar_turma/{id}', [cont_turma::class, 'editando']);
    Route::match(['get', 'post'], '/turma_pesq', [cont_turma::class, 'turma_pesq']);
    Route::match(['get', 'post'], '/turma_filtro', [cont_turma::class, 'turma_filtro']);
    Route::get('/turma_deletar/{id}', [cont_turma::class, 'deletar']);

    // -------------------------------------------------------------------------
    // Disciplinas e vínculo Turma x Disciplina x Professor
    // -------------------------------------------------------------------------
    Route::get('/disciplina_cad', [cont_disciplina::class, 'novadisciplina']);
    Route::post('/disciplina_cad', [cont_disciplina::class, 'postnovadisciplina']);
    Route::get('/disciplina_inf', [cont_disciplina::class, 'disciplina_inf']);
    Route::get('/disciplina_editar/{id}', [cont_disciplina::class, 'editar']);
    Route::post('/disciplina_editar/{id}', [cont_disciplina::class, 'editando']);
    Route::get('/disciplina_deletar/{id}', [cont_disciplina::class, 'deletar']);

    Route::get('/turma_disciplina_cad', [cont_turma_disciplina::class, 'vincularProfessor']);
    Route::get('/turma_disc/turma_disciplina_cad', [cont_turma_disciplina::class, 'vincularProfessor']);
    Route::post('/turma_disciplina_cad', [cont_turma_disciplina::class, 'postvincularProfessor']);
    Route::get('/turma_disciplina_inf', [cont_turma_disciplina::class, 'turmaDisciplinaInf']);
    Route::get('/turma_disc/turma_disciplina_inf', [cont_turma_disciplina::class, 'turmaDisciplinaInf']);
    Route::get('/turma_disciplina/deletar/{id}', [cont_turma_disciplina::class, 'turma_disciplina_deletar']);

    // -------------------------------------------------------------------------
    // Funcionários e usuários do sistema
    // -------------------------------------------------------------------------
    Route::get('/funcionario_cad', [cont_funcionario::class, 'novofuncionario']);
    Route::get('/funcionarios/funcionario_cad', [cont_funcionario::class, 'novofuncionario']);
    Route::post('/funcionario_cad', [cont_funcionario::class, 'postnovofuncionario']);
    Route::get('/cadfuncionario', [cont_funcionario::class, 'novofuncionario']);
    Route::post('/cadfuncionario', [cont_funcionario::class, 'postnovofuncionario']);
    Route::get('/funcionario_inf', [cont_funcionario::class, 'funcionario_inf']);
    Route::get('/funcionarios/funcionario_inf', [cont_funcionario::class, 'funcionario_inf']);
    Route::get('/funcionario_perfil/{id}', [cont_funcionario::class, 'perfil']);
    Route::get('/funcionario_editar/{id}', [cont_funcionario::class, 'editar']);
    Route::post('/funcionario_editar/{id}', [cont_funcionario::class, 'editando']);
    Route::get('/funcionario_deletar/{id}', [cont_funcionario::class, 'deletar']);
    Route::match(['get', 'post'], '/funcionario_pesq', [cont_funcionario::class, 'funcionario_pesq']);
    Route::match(['get', 'post'], '/funcionario_filtro', [cont_funcionario::class, 'funcionario_filtro']);

    Route::get('/cadusuario', [cont_usuario::class, 'novousuario']);
    Route::post('/cadusuario', [cont_usuario::class, 'postnovousuario']);
    Route::post('/usuario_cad', [cont_usuario::class, 'postnovousuario']);   // NOVA: form usuario_cad posta aqui
    Route::get('/usuario_inf', [cont_usuario::class, 'usuario_inf']);
    Route::get('/usuario_editar/{id}', [cont_usuario::class, 'editar']);
    Route::post('/usuario_editar/{id}', [cont_usuario::class, 'editando']);
    Route::get('/usuario_deletar/{id}', [cont_usuario::class, 'deletar']);
    Route::match(['get', 'post'], '/usuario_pesq', [cont_usuario::class, 'usuario_pesq']);
    Route::match(['get', 'post'], '/usuario_filtro', [cont_usuario::class, 'usuario_filtro']);

    // -------------------------------------------------------------------------
    // Escola (dados da instituição + logo)
    // -------------------------------------------------------------------------
    Route::get('/escola/escola_inf', [cont_escola::class, 'escola_inf']);
    Route::get('/escola_cad', [cont_cadescola::class, 'novaescola']);
    Route::post('/escola_cad', [cont_cadescola::class, 'postnovaescola']);
    Route::get('/escola_editar/{id}', [cont_escola::class, 'editar'])->whereNumber('id');
    Route::post('/escola_editar/{id}', [cont_escola::class, 'editando'])->whereNumber('id');
    Route::get('/escola_perfil/{id}', [cont_escola::class, 'perfil'])->whereNumber('id');
    Route::get('/escola_impressao/{id}', function ($id) {
        $escolas = \App\Models\modelCoordenacao\tb_escola::find($id) ?? \App\Models\modelCoordenacao\tb_escola::first();
        $endereco = $escolas ? \App\Models\modelCoordenacao\tb_endereco::find($escolas->tb_endereco_idEndereco) : null;

        return view('telasCoordenacao.escola.escola_imp', [
            'escolas' => $escolas,
            'endereco' => $endereco,
            'quantAlunosCadastrados' => \App\Models\modelCoordenacao\tb_matricula::quantAlunosCadastrados(),
            'quantMatriculasAtivas' => \App\Models\modelCoordenacao\tb_matricula::quantMatriculasAtivas(),
            'quantMatriculasInativas' => \App\Models\modelCoordenacao\tb_matricula::quantMatriculasInativas(),
            'quantTurmasAtivas' => \App\Models\modelCoordenacao\tb_turma::turmasAtivas()->count(),
            'quantDisciplina' => \App\Models\modelCoordenacao\tb_disciplina::quantDisciplinasCadastradas(),
            'quantFuncionariosCadastrados' => \App\Models\modelCoordenacao\tb_funcionario::funcionarioCadastrados()->count(),
            'quantUsuarioCadastrados' => \App\Models\modelCoordenacao\tb_usuario::listagemUsuarios()->count(),
        ]);
    })->whereNumber('id');

    // -------------------------------------------------------------------------
    // Notas
    // -------------------------------------------------------------------------
    Route::get('/notas/notas', [cont_notas::class, 'index']);
    Route::post('/notas/notas_pesq', [cont_notas::class, 'notas_pesq']);
    Route::post('/notas_pesq', [cont_notas::class, 'notas_pesq']);           // NOVA: busca da tela "Lançar Notas"
    Route::get('/notas/pesquisar', [cont_notas::class, 'notas_pesquisa_ajax']);
    Route::get('/notas/notas_filtro', [cont_notas::class, 'notas_filtro']);
    Route::get('/notas_bimestre_1/{id}', [cont_notas::class, 'bimestre_1']);
    Route::get('/notas_bimestre_2/{id}', [cont_notas::class, 'bimestre_2']);
    Route::get('/notas_bimestre_3/{id}', [cont_notas::class, 'bimestre_3']);
    Route::get('/notas_bimestre_4/{id}', [cont_notas::class, 'bimestre_4']);
    Route::get('/notas_rp_rf/{id}', [cont_notas::class, 'rp_rf']);
    foreach (['inf', 'fun1', 'fun2'] as $nivel) {
        foreach ([1, 2, 3, 4] as $bim) {
            Route::post("/salva_nota_{$bim}bim_{$nivel}", [cont_notas::class, "salva_nota_{$bim}bim_{$nivel}"]);
        }
    }
    Route::post('/salva_nota_rp_rf', [cont_notas::class, 'salva_nota_rp_rf']);

    // Lançamento de notas por aluno e bimestre (1bim, 2bim, 3bim, 4bim, rec)
    Route::get('/lancamentos_notas_{bim}/{id}', function ($bim, $id) {
        $bimsValidos = ['1bim', '2bim', '3bim', '4bim', 'rec'];
        abort_if(!in_array($bim, $bimsValidos), 404);

        try {
            $aluno = \DB::table('tb_aluno')->where('idAluno', $id)->first();
        } catch (\Exception $e) { $aluno = null; }

        abort_if(!$aluno, 404);

        try {
            $matricula = \DB::table('tb_matriculas')->where('idMatriculas', $aluno->tb_matriculas_idMatriculas ?? 0)->first();
        } catch (\Exception $e) { $matricula = null; }

        try {
            $turma = \DB::table('tb_turmas')->where('idTurmas', $aluno->tb_turmas_idTurmas ?? 0)->first();
        } catch (\Exception $e) { $turma = null; }

        try {
            $disciplinas = \DB::table('tb_turmas_disciplinas')
                ->leftJoin('tb_disciplinas', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas', '=', 'tb_disciplinas.idDisciplinas')
                ->where('tb_turmas_disciplinas.tb_turmas_idTurmas', $aluno->tb_turmas_idTurmas ?? 0)
                ->select('tb_turmas_disciplinas.*', 'tb_disciplinas.NomeDisciplina')
                ->get();
        } catch (\Exception $e) { $disciplinas = collect(); }

        $titulo = 'Lançamento de Notas — ' . ($aluno->NomeAluno ?? 'Aluno');

        if ($bim === 'rec') {
            $nivel = 'fund1';
        } else {
            $nivelCode = \App\Http\Controllers\controleCoordenacao\cont_relatorios::determinarNivelTurma($turma->NomeTurma ?? '');
            $nivel = ($nivelCode === 'fun1') ? 'fund1' : (($nivelCode === 'fun2') ? 'fund2' : 'inf');
        }

        $bimestre = $bim;
        return view('telasCoordenacao.notas.lancamento', compact('aluno', 'matricula', 'turma', 'disciplinas', 'titulo', 'bimestre', 'nivel'));
    })->where(['id' => '[0-9]+', 'bim' => '1bim|2bim|3bim|4bim|rec']);

    // -------------------------------------------------------------------------
    // Boletins
    // -------------------------------------------------------------------------
    Route::get('/boletins/boletins', [cont_boletins::class, 'index']);
    Route::post('/boletim_pesq', [cont_boletins::class, 'boletim_pesq']);
    Route::match(['get', 'post'], '/boletim_filtro', [cont_boletins::class, 'boletim_filtro']);   // era só GET, o form posta
    Route::get('/boletim/{id}', [cont_boletins::class, 'boletim']);

    // Boletim forçando o nível (inf, fun1, fun2)
    Route::get('/boletim_{tipo}/{id}', function ($tipo, $id) {
        $tiposValidos = ['inf', 'fun1', 'fun2'];
        abort_if(!in_array($tipo, $tiposValidos), 404);

        try {
            $aluno = \DB::table('tb_aluno')
                ->leftJoin('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_aluno.tb_endereco_idEndereco')
                ->where('idAluno', $id)
                ->select('tb_aluno.*', 'tb_endereco.Rua', 'tb_endereco.Numero', 'tb_endereco.Bairro', 'tb_endereco.Cidade', 'tb_endereco.Estado')
                ->first();
        } catch (\Exception $e) { $aluno = null; }

        abort_if(!$aluno, 404);

        try {
            $matricula = \DB::table('tb_matriculas')->where('idMatriculas', $aluno->tb_matriculas_idMatriculas ?? 0)->first();
        } catch (\Exception $e) { $matricula = null; }
        if (!$matricula) $matricula = (object)['RA' => '', 'SituacaoAluno' => '', 'Bonus' => 0];

        try {
            $turma = \DB::table('tb_turmas')->where('idTurmas', $aluno->tb_turmas_idTurmas ?? 0)->first();
        } catch (\Exception $e) { $turma = null; }
        if (!$turma) $turma = (object)['NomeTurma' => '', 'AnoLetivo' => ''];

        try {
            $Pais = \DB::table('tb_pais')->where('idPais', $aluno->tb_pais_idPais ?? 0)->first();
        } catch (\Exception $e) { $Pais = null; }
        if (!$Pais) $Pais = (object)['NomePai' => '', 'NomeMae' => ''];

        try {
            $escolas = \DB::table('tb_escola')
                ->leftJoin('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_escola.tb_endereco_idEndereco')
                ->select('tb_escola.*', 'tb_endereco.*')
                ->get();
        } catch (\Exception $e) { $escolas = collect(); }

        try {
            $anoletivo = \DB::table('tb_turmas')->where('idTurmas', $aluno->tb_turmas_idTurmas ?? 0)->get();
        } catch (\Exception $e) { $anoletivo = collect(); }

        try {
            $disciplinas = \DB::table('tb_turmas_disciplinas')
                ->leftJoin('tb_disciplinas', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas', '=', 'tb_disciplinas.idDisciplinas')
                ->where('tb_turmas_disciplinas.tb_turmas_idTurmas', $aluno->tb_turmas_idTurmas ?? 0)
                ->select('tb_turmas_disciplinas.*', 'tb_disciplinas.NomeDisciplina')
                ->get();
        } catch (\Exception $e) { $disciplinas = collect(); }

        try {
            $notasgraficos = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno_grafico($id);
        } catch (\Exception $e) { $notasgraficos = collect(); }

        $titulo = 'Boletim Escolar — ' . ($aluno->NomeAluno ?? 'Aluno');

        return view("telasCoordenacao.boletins.boletim_{$tipo}",
            compact('aluno', 'matricula', 'turma', 'Pais', 'escolas', 'anoletivo', 'disciplinas', 'notasgraficos', 'titulo'));
    })->where('tipo', 'inf|fun1|fun2')->where('id', '[0-9]+');

    // -------------------------------------------------------------------------
    // Relatórios
    // -------------------------------------------------------------------------
    Route::get('/relatorios_bimestrais', [cont_relatorios::class, 'relatorios_bimestrais']);
    Route::get('/relatorios/relatorios_bimestrais', [cont_relatorios::class, 'relatorios_bimestrais']);   // menu lateral
    Route::get('/relatorios_filtro', [cont_relatorios::class, 'relatorios_filtro']);
    Route::post('/relatorios_pesq', [cont_relatorios::class, 'relatorios_pesq']);
    Route::get('/boletim_acompanhamento_1bim/{id}', [cont_relatorios::class, 'bimestre_1']);
    Route::get('/boletim_acompanhamento_2bim/{id}', [cont_relatorios::class, 'bimestre_2']);
    Route::get('/boletim_acompanhamento_3bim/{id}', [cont_relatorios::class, 'bimestre_3']);
    Route::get('/boletim_acompanhamento_4bim/{id}', [cont_relatorios::class, 'bimestre_4']);

    Route::get('/relatorios/relatorio_alunos_matriculados', [cont_relatorios::class, 'alunosMatriculados']);
    Route::get('/relatorios/relatorio_alunos_transferidos', [cont_relatorios::class, 'alunosTransferidos']);
    Route::get('/relatorios/relatorio_pre_matriculado', [cont_relatorios::class, 'pre_matriculados']);
    Route::get('/relatorios/relatorio_alunos_turmas', [cont_relatorios::class, 'listagem_turmas']);
    Route::get('/relatorio_alunos_turmas', [cont_relatorios::class, 'listagem_turmas']);
    Route::post('/relatorio_pesquisar_turmas', [cont_relatorios::class, 'turma_pesq']);
    Route::post('/relatorio_alunos_turmas_pesq', [cont_relatorios::class, 'turma_pesq']);   // NOVA: busca da tela "Alunos por Turma"
    Route::post('/relatorio_filtro_turmas_anoletivo', [cont_relatorios::class, 'turma_filtro']);
    Route::get('/relatorio_alunos_turmas/{id}', [cont_relatorios::class, 'alunosPorTurma']);
    Route::get('/relatorios/relatorio_alunos_por_turma/{id?}', [cont_relatorios::class, 'alunosPorTurma']);
    Route::get('/relatorio_alunos_turmas_endereco/{id}', [cont_relatorios::class, 'alunosPorTurmaEndereco']);

    // -------------------------------------------------------------------------
    // Mapas de notas  (específicas ANTES de mapa_{tipo})
    // -------------------------------------------------------------------------
    Route::get('/mapa/mapas_notas', [cont_mapas::class, 'index']);
    Route::get('/mapas_notas', [cont_mapas::class, 'index']);
    Route::post('/mapas_pesq', [cont_mapas::class, 'mapas_pesq']);
    Route::match(['get', 'post'], '/mapas_filtro', [cont_mapas::class, 'mapas_filtro']);
    Route::get('/mapa_1bim/{id}', [cont_mapas::class, 'bimestre_1']);
    Route::get('/mapa_2bim/{id}', [cont_mapas::class, 'bimestre_2']);
    Route::get('/mapa_3bim/{id}', [cont_mapas::class, 'bimestre_3']);
    Route::get('/mapa_4bim/{id}', [cont_mapas::class, 'bimestre_4']);
    Route::get('/mapa_global/{id}', [cont_mapas::class, 'mapa_global']);
    Route::get('/mapa_{tipo}/{id}', [cont_mapas::class, 'mapa_dinamico']);

    // -------------------------------------------------------------------------
    // Resultados acadêmicos
    // -------------------------------------------------------------------------
    Route::get('/resultados', [cont_resultados::class, 'index']);
    Route::get('/resultado/resultados', [cont_resultados::class, 'index']);
    Route::post('/resultados_pesq', [cont_resultados::class, 'resultados_pesq']);
    Route::post('/resultados_filtro', [cont_resultados::class, 'resultados_filtro']);
    Route::get('/resultados_parcial/{id}', [cont_resultados::class, 'resultado_parcial']);
    Route::get('/resultados_final/{id}', [cont_resultados::class, 'resultado_final']);
    Route::get('/resultados_aprovados_1semestre/{id}', [cont_resultados::class, 'aprovados_1semestre']);
    Route::get('/resultados_aprovados_2semestre/{id}', [cont_resultados::class, 'aprovados_2semestre']);

    // -------------------------------------------------------------------------
    // Gabaritos
    // -------------------------------------------------------------------------
    Route::get('/gabaritos', [cont_gabarito::class, 'index']);
    Route::post('/gabarito_pesq', [cont_gabarito::class, 'gabarito_pesq']);
    Route::match(['get', 'post'], '/gabarito_filtro', [cont_gabarito::class, 'gabarito_filtro']);   // era só GET, o form posta
    Route::get('/gabarito_08/{id}', [cont_gabarito::class, 'gabarito_08']);
    Route::get('/gabarito_10/{id}', [cont_gabarito::class, 'gabarito_10']);
    // PENDENTE: não existe layout de 11 questões; imprime o de 8 (mesmo comportamento de antes).
    Route::get('/gabarito_11/{id}', [cont_gabarito::class, 'gabarito_08']);

    // -------------------------------------------------------------------------
    // Frequência
    // -------------------------------------------------------------------------
    Route::get('/frequencia/frequencias', [cont_frequencias::class, 'index']);
    Route::post('/frequencias_pesq', [cont_frequencias::class, 'frequencias_pesq']);
    Route::get('/frequencias_filtro', [cont_frequencias::class, 'frequencias_filtro']);
    Route::post('/frequencia_cad', [cont_frequencias::class, 'postnovafrequencia']);
    Route::get('/frequencia_virtual/{id}', [cont_frequencias::class, 'frequencia_virtual']);
    Route::get('/frequencia_relatorio/{id}', [cont_frequencias::class, 'frequencia_relatorio']);
    Route::get('/frequencia/frequencia_relatorio/{id}', [cont_frequencias::class, 'frequencia_relatorio']);
    Route::get('/frequencia_mensal/{id}', [cont_frequencias::class, 'frequencia_mensal']);
    Route::get('/frequencia_edfisica/{id}', [cont_frequencias::class, 'frequencia_edfisica']);
    Route::get('/frequencia_entrega/{id}', [cont_frequencias::class, 'frequencia_entrega']);

    // -------------------------------------------------------------------------
    // Histórico e declarações
    // -------------------------------------------------------------------------
    Route::get('/historico/historico', [cont_historico::class, 'index']);
    Route::post('/historico_pesq', [cont_historico::class, 'historico_pesq']);       // NOVA
    Route::post('/historico_filtro', [cont_historico::class, 'historico_filtro']);   // NOVA
    Route::get('/historico/{id}', function ($id) {
        try {
            $aluno = \DB::table('tb_aluno')->where('idAluno', $id)->first();
        } catch (\Exception $e) { $aluno = null; }

        abort_if(!$aluno, 404);

        try {
            $matricula = \DB::table('tb_matriculas')->where('idMatriculas', $aluno->tb_matriculas_idMatriculas ?? 0)->first();
        } catch (\Exception $e) { $matricula = null; }

        try {
            $turma = \DB::table('tb_turmas')->where('idTurmas', $aluno->tb_turmas_idTurmas ?? 0)->first();
        } catch (\Exception $e) { $turma = null; }

        try {
            $Pais = \DB::table('tb_pais')->where('idPais', $aluno->tb_pais_idPais ?? 0)->first();
        } catch (\Exception $e) { $Pais = null; }

        try {
            $escolas = \App\Models\modelCoordenacao\tb_escola::informacaoEscolar();
        } catch (\Exception $e) { $escolas = collect(); }

        try {
            $anoletivo = \DB::table('tb_turmas')->where('idTurmas', $aluno->tb_turmas_idTurmas ?? 0)->get();
        } catch (\Exception $e) { $anoletivo = collect(); }

        try {
            $disciplinas = \DB::table('tb_turmas_disciplinas')
                ->leftJoin('tb_disciplinas', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas', '=', 'tb_disciplinas.idDisciplinas')
                ->where('tb_turmas_disciplinas.tb_turmas_idTurmas', $aluno->tb_turmas_idTurmas ?? 0)
                ->select('tb_turmas_disciplinas.*', 'tb_disciplinas.NomeDisciplina')
                ->get();
        } catch (\Exception $e) { $disciplinas = collect(); }

        $titulo = 'Histórico — ' . ($aluno->NomeAluno ?? 'Aluno');

        return view('telasCoordenacao.historico.historico_inf',
            compact('aluno', 'matricula', 'turma', 'Pais', 'escolas', 'anoletivo', 'disciplinas', 'titulo'));
    })->where('id', '[0-9]+');

    Route::get('/declaracoes/declaracoes', [cont_declaracoes::class, 'index']);
    Route::post('/declaracoes_pesq', [cont_declaracoes::class, 'declaracao_pesq']);                    // NOVA
    Route::match(['get', 'post'], '/declaracao_filtro', [cont_declaracoes::class, 'declaracao_filtro']); // NOVA
    // Impressão: cursando, transferencia, apto, quitacao, inapto, completa
    Route::get('/declaracoes_{tipo}/{id}', function ($tipo, $id) {
        $tiposValidos = ['cursando', 'transferencia', 'apto', 'quitacao', 'inapto', 'completa'];
        abort_if(!in_array($tipo, $tiposValidos), 404);

        try {
            $aluno = \DB::table('tb_aluno')->where('idAluno', $id)->first();
        } catch (\Exception $e) { $aluno = null; }

        abort_if(!$aluno, 404);

        try {
            $matricula = \DB::table('tb_matriculas')->where('idMatriculas', $aluno->tb_matriculas_idMatriculas ?? 0)->first();
        } catch (\Exception $e) { $matricula = null; }

        try {
            $turma = \DB::table('tb_turmas')->where('idTurmas', $aluno->tb_turmas_idTurmas ?? 0)->first();
        } catch (\Exception $e) { $turma = null; }

        try {
            $pais = \DB::table('tb_pais')->where('idPais', $aluno->tb_pais_idPais ?? 0)->first();
        } catch (\Exception $e) { $pais = null; }

        try {
            $escolas = \DB::table('tb_escola')->get();
        } catch (\Exception $e) { $escolas = collect(); }

        $meses = [1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril', 5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'];
        $dia = date('d') . ' de ' . ($meses[(int)date('n')] ?? '') . ' de ' . date('Y');
        $titulo = 'Declaração — ' . ($aluno->NomeAluno ?? 'Aluno');

        return view("telasCoordenacao.declaracoes.declaracoes_{$tipo}",
            compact('aluno', 'matricula', 'turma', 'pais', 'escolas', 'dia', 'titulo'));
    })->where(['id' => '[0-9]+', 'tipo' => 'cursando|transferencia|apto|quitacao|inapto|completa']);

    // -------------------------------------------------------------------------
    // Financeiro, carnês, acordos e recibos
    // -------------------------------------------------------------------------
    Route::get('/financeiro/financeiro_receber', [cont_financeiro::class, 'financeiro_receber']);
    Route::get('/financeiro/financeiro_receitas_e_despesas', [cont_financeiro::class, 'financeiro_receitas_e_despesas']);
    Route::get('/financeiro/financeiro_estatistica', [cont_financeiro::class, 'financeiro_estatistica']);
    Route::get('/financeiro/financeiro_relatorios', [cont_financeiro::class, 'financeiro_relatorios']);
    Route::post('/financeiro_pesq', [cont_financeiro::class, 'financeiro_pesq']);
    // NOVAS: botões da tela de baixa e dos relatórios financeiros (os métodos já existiam)
    Route::post('/financeiro_baixar', [cont_financeiro::class, 'financeiro_baixar']);
    Route::post('/financeiro_baixar_acordo', [cont_financeiro::class, 'financeiro_baixar_Acordo']);
    Route::post('/financeiro_comprovante', [cont_financeiro::class, 'financeiro_comprovante']);
    Route::post('/financeiro_comprovante_acordo', [cont_financeiro::class, 'financeiro_comprovante_acordo']);
    Route::post('/financeiro_pesq_relatorio', [cont_financeiro::class, 'financeiro_pesq_relatorio']);
    Route::post('/financeiro_pesq_relatorio_turma', [cont_financeiro::class, 'financeiro_pesq_relatorio_turma']);
    Route::post('/financeiro_pesq_relatorio_balanco', [cont_financeiro::class, 'financeiro_pesq_relatorio_balanco']);
    // PENDENTE: financeiro_criar_receita / _despesa / _categoria e financeiro_contas_pagar_pesq
    // (tela Receitas e Despesas) ainda não têm implementação no controller.

    Route::get('/criarcarne/{id}', [cont_recibos::class, 'criarCarne']);
    Route::post('/criarcarne', [cont_recibos::class, 'criando']);
    Route::get('/carner/{id}', [cont_recibos::class, 'carner']);
    Route::post('/carne_pesq', [cont_recibos::class, 'carne_pesq']);         // NOVA
    Route::post('/carne_filtro', [cont_recibos::class, 'carne_filtro']);     // NOVA
    Route::get('/criaracordo/{id}', [cont_recibos::class, 'criarAcordo']);
    Route::post('/criaracordo', [cont_recibos::class, 'criando_acordo']);
    Route::post('/acordo_pesq', [cont_recibos::class, 'acordo_pesq']);       // NOVA
    Route::post('/acordo_filtro', [cont_recibos::class, 'acordo_filtro']);   // NOVA
    Route::get('/recibo_mensalidade/{id}', [cont_recibos::class, 'recibo_mensalidade']);   // NOVA: tela de baixa
    Route::get('/recibo_acordo/{id}', [cont_recibos::class, 'recibo_acordo']);             // NOVA: tela de baixa

    // -------------------------------------------------------------------------
    // Lanche
    // -------------------------------------------------------------------------
    Route::get('/lanche_cad', [cont_lanche::class, 'novolanche_cad']);
    Route::post('/lanche_cad', [cont_lanche::class, 'postnovalanche']);   // CORRIGIDO: apontava p/ "postnovolanche" (não existe)
    Route::get('/lanche_inf', [cont_lanche::class, 'lanche_inf']);
    Route::post('/lanche_pesq', [cont_lanche::class, 'lanche_pesq']);     // NOVA
    Route::get('/lanche_deletar/{id}', [cont_lanche::class, 'deletar']);

    // =========================================================================
    // 4. ROTAS LEGADAS — nenhuma tela/JS do projeto aponta para elas.
    //    Mantidas por segurança (favoritos antigos, módulo docente/aluno).
    //    Depois de testar o sistema, podem ser apagadas.
    // =========================================================================
    Route::get('/vincularProfessor', [cont_turma_disciplina::class, 'vincularProfessor']);
    Route::post('/vincularProfessor', [cont_turma_disciplina::class, 'postvincularProfessor']);
    Route::get('/turma_disciplina_deletar/{id}', [cont_turma_disciplina::class, 'turma_disciplina_deletar']);
    Route::get('/funcionarios/funcionario_perfil/{id}', [cont_funcionario::class, 'perfil']);
    Route::get('/funcionarios/funcionario_editar/{id}', [cont_funcionario::class, 'editar']);
    Route::post('/funcionarios/funcionario_editar/{id}', [cont_funcionario::class, 'editando']);
    Route::get('/funcionarios/funcionario_deletar/{id}', [cont_funcionario::class, 'deletar']);
    Route::get('/bimestre_1/{id}', [cont_relatorios::class, 'bimestre_1']);
    Route::get('/bimestre_2/{id}', [cont_relatorios::class, 'bimestre_2']);
    Route::get('/bimestre_3/{id}', [cont_relatorios::class, 'bimestre_3']);
    Route::get('/bimestre_4/{id}', [cont_relatorios::class, 'bimestre_4']);
    Route::get('/relatorios/relatorio_alunos_por_turma_endereco/{id}', [cont_relatorios::class, 'alunosPorTurmaEndereco']);
    Route::get('/gabarito/gabaritos', [cont_gabarito::class, 'index']);
    Route::post('/postnovafrequencia', [cont_frequencias::class, 'postnovafrequencia']);
    Route::post('/frequencia/frequencia_cad', [cont_frequencias::class, 'postnovafrequencia']);
    Route::get('/frequencia/frequencia_virtual/{id}', [cont_frequencias::class, 'frequencia_virtual']);
    Route::get('/frequencia/frequencia_mensal/{id}', [cont_frequencias::class, 'frequencia_mensal']);
    Route::get('/frequencia/frequencia_edfisica/{id}', [cont_frequencias::class, 'frequencia_edfisica']);
    Route::get('/declaracoes/cursando/{id}', [cont_declaracoes::class, 'cursando']);
    Route::get('/declaracoes/apto/{id}', [cont_declaracoes::class, 'apto']);
    Route::get('/declaracoes/transferencia/{id}', [cont_declaracoes::class, 'transferencia']);
    Route::get('/declaracoes/quitacao/{id}', [cont_declaracoes::class, 'quitacao']);
    Route::get('/declaracoes/inapto/{id}', [cont_declaracoes::class, 'inapto']);

    Route::get('/{pasta}/{pagina}', function ($pasta, $pagina) {
        $viewName = "telasCoordenacao.{$pasta}.{$pagina}";
        if (view()->exists($viewName)) {
            return view($viewName);
        }

        $title = ucwords(str_replace(['_', '-'], ' ', $pagina));
        return view('telasCoordenacao.construcao', compact('title'));
    })->where(['pasta' => '[A-Za-z0-9_]+', 'pagina' => '[A-Za-z0-9_]+'])
      ->name('coordenacao.pagina');
});
