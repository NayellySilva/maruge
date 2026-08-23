<?php

use Illuminate\Support\Facades\Route;
use App\Models\modelCoordenacao\tb_usuario;
use App\Http\Controllers\controleCoordenacao\cont_aluno;
use App\Http\Controllers\controleCoordenacao\cont_turma;
use App\Http\Controllers\controleCoordenacao\cont_disciplina;
use App\Http\Controllers\controleCoordenacao\cont_turma_disciplina;
use App\Http\Controllers\controleCoordenacao\cont_funcionario;
use App\Http\Controllers\controleCoordenacao\cont_usuario;
use App\Http\Controllers\controleCoordenacao\cont_escola;
use App\Http\Controllers\controleCoordenacao\cont_cadescola;
use App\Http\Controllers\controleCoordenacao\cont_notas;
use App\Http\Controllers\controleCoordenacao\cont_boletins;
use App\Http\Controllers\controleCoordenacao\cont_frequencias;
use App\Http\Controllers\controleCoordenacao\cont_relatorios;
use App\Http\Controllers\controleCoordenacao\cont_mapas;
use App\Http\Controllers\controleCoordenacao\cont_resultados;
use App\Http\Controllers\controleCoordenacao\cont_historico;
use App\Http\Controllers\controleCoordenacao\cont_declaracoes;
use App\Http\Controllers\controleCoordenacao\cont_financeiro;
use App\Http\Controllers\controleCoordenacao\cont_recibos;
use App\Http\Controllers\controleCoordenacao\cont_lanche;
use App\Http\Controllers\controleCoordenacao\cont_gabarito;
use App\Http\Controllers\controleLogin\loginPrincipal;
use App\Http\Controllers\controleLogin\loginAluno;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/usuarios', function () {
    $Usuarios = tb_usuario::listagemUsuarios();
    return view('telasCoordenacao.usuario_inf', compact('Usuarios'));
})->name('usuarios.info');

Route::get('/api/feriados', function (\Illuminate\Http\Request $request) {
    $ano = (int)$request->query('ano', date('Y'));
    $holidaysMap = [];

    // 1. Tentar BrasilAPI (Feriados Nacionais via API externa)
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(3)->get("https://brasilapi.com.br/api/feriados/v1/{$ano}");
        if ($response->successful()) {
            $data = $response->json();
            if (is_array($data)) {
                foreach ($data as $item) {
                    if (isset($item['date'], $item['name'])) {
                        $p = explode('-', $item['date']);
                        if (count($p) === 3) {
                            $dateKey = $item['date'];
                            $holidaysMap[$dateKey] = [
                                'day' => (int)$p[2],
                                'month' => (int)$p[1] - 1,
                                'year' => (int)$p[0],
                                'name' => $item['name'],
                                'type' => isset($item['type']) && $item['type'] === 'national' ? 'Feriado Nacional' : ($item['type'] ?? 'Feriado'),
                                'custom' => false
                            ];
                        }
                    }
                }
            }
        }
    } catch (\Exception $e) {
        // Fallback local caso haja falha de rede
    }

    // 2. Feriados Nacionais Fixos (Garantia offline)
    $fixedNational = [
        ['01-01', 'Confraternização Universal', 'Feriado Nacional'],
        ['04-21', 'Tiradentes', 'Feriado Nacional'],
        ['05-01', 'Dia do Trabalho', 'Feriado Nacional'],
        ['09-07', 'Independência do Brasil', 'Feriado Nacional'],
        ['10-12', 'Nossa Senhora Aparecida / Dia das Crianças', 'Feriado Nacional'],
        ['11-02', 'Finados', 'Feriado Nacional'],
        ['11-15', 'Proclamação da República', 'Feriado Nacional'],
        ['11-20', 'Dia da Consciência Negra', 'Feriado Nacional'],
        ['12-25', 'Natal', 'Feriado Nacional'],
    ];

    foreach ($fixedNational as $h) {
        list($md, $name, $type) = $h;
        $dateStr = sprintf("%04d-%s", $ano, $md);
        if (!isset($holidaysMap[$dateStr])) {
            $p = explode('-', $dateStr);
            $holidaysMap[$dateStr] = [
                'day' => (int)$p[2],
                'month' => (int)$p[1] - 1,
                'year' => (int)$p[0],
                'name' => $name,
                'type' => $type,
                'custom' => false
            ];
        }
    }

    // 3. Feriados Estaduais do Ceará (CE)
    $stateCE = [
        ['03-19', 'Dia de São José (Padroeiro do Ceará)', 'Feriado Estadual'],
        ['03-25', 'Data Magna do Ceará', 'Feriado Estadual'],
    ];

    foreach ($stateCE as $h) {
        list($md, $name, $type) = $h;
        $dateStr = sprintf("%04d-%s", $ano, $md);
        if (!isset($holidaysMap[$dateStr])) {
            $p = explode('-', $dateStr);
            $holidaysMap[$dateStr] = [
                'day' => (int)$p[2],
                'month' => (int)$p[1] - 1,
                'year' => (int)$p[0],
                'name' => $name,
                'type' => $type,
                'custom' => false
            ];
        }
    }

    // 4. Feriados Escolares & Datas Comemorativas Fixas
    $schoolFixed = [
        ['10-15', 'Dia do Professor', 'Feriado Escolar'],
        ['08-11', 'Dia do Estudante', 'Data Comemorativa'],
        ['06-12', 'Dia dos Namorados', 'Data Comemorativa'],
    ];

    foreach ($schoolFixed as $h) {
        list($md, $name, $type) = $h;
        $dateStr = sprintf("%04d-%s", $ano, $md);
        if (!isset($holidaysMap[$dateStr])) {
            $p = explode('-', $dateStr);
            $holidaysMap[$dateStr] = [
                'day' => (int)$p[2],
                'month' => (int)$p[1] - 1,
                'year' => (int)$p[0],
                'name' => $name,
                'type' => $type,
                'custom' => false
            ];
        }
    }

    // 5. Feriados Móveis Calculados Dinamicamente (Páscoa, Carnaval, Semana Santa, Corpus Christi)
    $easterTs = easter_date($ano);
    $moveable = [
        [-48, 'Segunda-feira de Carnaval', 'Feriado Escolar'],
        [-47, 'Terça-feira de Carnaval', 'Feriado Escolar'],
        [-46, 'Quarta-feira de Cinzas', 'Ponto Facultativo'],
        [-3,  'Quinta-feira Santa', 'Feriado Escolar'],
        [-2,  'Sexta-feira Santa (Paixão de Cristo)', 'Feriado Nacional'],
        [0,   'Páscoa', 'Data Comemorativa'],
        [60,  'Corpus Christi', 'Feriado Escolar']
    ];

    foreach ($moveable as $m) {
        list($offsetDays, $name, $type) = $m;
        $ts = $easterTs + ($offsetDays * 86400);
        $dateStr = date('Y-m-d', $ts);
        if (!isset($holidaysMap[$dateStr])) {
            $p = explode('-', $dateStr);
            $holidaysMap[$dateStr] = [
                'day' => (int)$p[2],
                'month' => (int)$p[1] - 1,
                'year' => (int)$p[0],
                'name' => $name,
                'type' => $type,
                'custom' => false
            ];
        }
    }

    // 6. Datas Comemorativas Móveis (Dia das Mães, Dia dos Pais)
    $motherDay = date('Y-m-d', strtotime("second sunday of May {$ano}"));
    if (!isset($holidaysMap[$motherDay])) {
        $pM = explode('-', $motherDay);
        $holidaysMap[$motherDay] = [
            'day' => (int)$pM[2],
            'month' => (int)$pM[1] - 1,
            'year' => (int)$pM[0],
            'name' => 'Dia das Mães',
            'type' => 'Data Comemorativa',
            'custom' => false
        ];
    }

    $fatherDay = date('Y-m-d', strtotime("second sunday of August {$ano}"));
    if (!isset($holidaysMap[$fatherDay])) {
        $pF = explode('-', $fatherDay);
        $holidaysMap[$fatherDay] = [
            'day' => (int)$pF[2],
            'month' => (int)$pF[1] - 1,
            'year' => (int)$pF[0],
            'name' => 'Dia dos Pais',
            'type' => 'Data Comemorativa',
            'custom' => false
        ];
    }

    // 7. Eventos Customizados Armazenados em storage/app/eventos.json
    try {
        $path = storage_path('app/eventos.json');
        if (file_exists($path)) {
            $customEvents = json_decode(file_get_contents($path), true) ?: [];
            foreach ($customEvents as $dateStr => $event) {
                $p = explode('-', $dateStr);
                if (count($p) === 3 && (int)$p[0] === $ano) {
                    $holidaysMap[$dateStr] = [
                        'day' => (int)$p[2],
                        'month' => (int)$p[1] - 1,
                        'year' => (int)$p[0],
                        'name' => $event['name'],
                        'type' => $event['type'],
                        'custom' => true
                    ];
                }
            }
        }
    } catch (\Exception $e) {
        // Ignora erros no JSON customizado
    }

    ksort($holidaysMap);
    return response()->json(array_values($holidaysMap));
});

// Salvar ou atualizar evento customizado
Route::post('/api/eventos', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'date' => 'required|date_format:Y-m-d',
        'name' => 'required|string|max:100',
        'type' => 'required|string|max:50',
    ]);

    $path = storage_path('app/eventos.json');
    
    // Ensure parent directory exists
    $dir = dirname($path);
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }

    $eventos = [];
    if (file_exists($path)) {
        $eventos = json_decode(file_get_contents($path), true) ?: [];
    }

    $eventos[$request->date] = [
        'name' => $request->name,
        'type' => $request->type
    ];

    file_put_contents($path, json_encode($eventos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    return response()->json(['success' => true]);
});

// Remover evento customizado
Route::delete('/api/eventos', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'date' => 'required|date_format:Y-m-d',
    ]);

    $path = storage_path('app/eventos.json');
    if (file_exists($path)) {
        $eventos = json_decode(file_get_contents($path), true) ?: [];
        if (isset($eventos[$request->date])) {
            unset($eventos[$request->date]);
            file_put_contents($path, json_encode($eventos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    return response()->json(['success' => true]);
});

// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
// Rotas específicas para Edição de Disciplina e Turma
Route::get('/coordenacao/disciplina_editar/{id}', function ($id) {
    try {
        $disciplina = \DB::table('tb_disciplinas')->where('idDisciplinas', $id)->first();
    } catch (\Exception $e) {
        $disciplina = null;
    }
    
    abort_if(!$disciplina, 404);

    return view('telasCoordenacao.disciplinas.disciplina_cad', compact('disciplina'));
})->name('coordenacao.disciplina_editar');

Route::get('/coordenacao/turma_editar/{id}', function ($id) {
    try {
        $turma = \DB::table('tb_turmas')->where('idTurmas', $id)->first();
    } catch (\Exception $e) {
        $turma = null;
    }
    
    abort_if(!$turma, 404);

    return view('telasCoordenacao.turma.turma_cad', compact('turma'));
})->name('coordenacao.turma_editar');
} // fim do bloco desativado



// Rota para impressão do histórico/boletim de um aluno específico
Route::get('/coordenacao/historico/{id}', function ($id) {
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
        $escolas = \DB::table('tb_escola')->get();
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

// Rotas para impressão de Declarações do aluno (cursando, transferencia, apto, quitacao, inapto, completa)
Route::get('/coordenacao/declaracoes_{tipo}/{id}', function ($tipo, $id) {
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
})->where('id', '[0-9]+');

// Rotas para emissão e visualização de Frequências da turma (virtual, mensal, edfisica, entrega, relatorio)
Route::get('/coordenacao/frequencia_{tipo}/{id}', function ($tipo, $id) {
    $tiposValidos = ['virtual', 'mensal', 'edfisica', 'entrega', 'relatorio'];
    abort_if(!in_array($tipo, $tiposValidos), 404);

    try {
        $turma = \DB::table('tb_turmas')->where('idTurmas', $id)->first();
    } catch (\Exception $e) { $turma = null; }

    abort_if(!$turma, 404);

    try {
        $Alunos = \DB::table('tb_aluno')
            ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
            ->leftJoin('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_aluno.tb_endereco_idEndereco')
            ->where('tb_aluno.tb_turmas_idTurmas', $id)
            ->select('tb_aluno.*', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_endereco.Rua', 'tb_endereco.Numero', 'tb_endereco.Bairro', 'tb_endereco.Cidade', 'tb_endereco.Estado', 'tb_endereco.Fone1')
            ->orderBy('tb_aluno.NomeAluno')
            ->get();
    } catch (\Exception $e) { $Alunos = collect(); }

    try {
        $escolas = \DB::table('tb_escola')
            ->leftJoin('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_escola.tb_endereco_idEndereco')
            ->select('tb_escola.*', 'tb_endereco.*')
            ->get();
    } catch (\Exception $e) { $escolas = collect(); }

    $meses = [1 => 'JANEIRO', 2 => 'FEVEREIRO', 3 => 'MARÇO', 4 => 'ABRIL', 5 => 'MAIO', 6 => 'JUNHO', 7 => 'JULHO', 8 => 'AGOSTO', 9 => 'SETEMBRO', 10 => 'OUTUBRO', 11 => 'NOVEMBRO', 12 => 'DEZEMBRO'];
    $mes = $meses[(int)date('n')] ?? date('F');
    $titulo = 'Frequência ' . ucfirst($tipo) . ' — ' . ($turma->NomeTurma ?? 'Turma');

    $alunos = $Alunos;
    return view("telasCoordenacao.frequencia.frequencia_{$tipo}",
        compact('turma', 'Alunos', 'alunos', 'escolas', 'mes', 'titulo'));
})->where('id', '[0-9]+');

// Rotas para emissão do Boletim Escolar (Infantil, Fund1, Fund2 ou automático)
Route::get('/coordenacao/boletim/{id}', function ($id) {
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

    $nomeTurma = strtoupper($turma->NomeTurma ?? '');
    $view = 'telasCoordenacao.boletins.boletim_fun1';
    if (str_contains($nomeTurma, 'INFANTIL') || str_contains($nomeTurma, 'INF')) {
        $view = 'telasCoordenacao.boletins.boletim_inf';
    } elseif (str_contains($nomeTurma, '6') || str_contains($nomeTurma, '7') || str_contains($nomeTurma, '8') || str_contains($nomeTurma, '9') || str_contains($nomeTurma, 'FUNDAMENTAL II')) {
        $view = 'telasCoordenacao.boletins.boletim_fun2';
    }

    return view($view, compact('aluno', 'matricula', 'turma', 'Pais', 'escolas', 'anoletivo', 'disciplinas', 'notasgraficos', 'titulo'));
})->where('id', '[0-9]+');

Route::get('/coordenacao/boletim_{tipo}/{id}', function ($tipo, $id) {
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

// Rota para o lançamento de notas por aluno e bimestre (1bim, 2bim, 3bim, 4bim, rec)
Route::get('/coordenacao/lancamentos_notas_{bim}/{id}', function ($bim, $id) {
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
        $view = 'telasCoordenacao.notas.notas_rp_rf';
    } else {
        $nomeTurma = strtoupper($turma->NomeTurma ?? '');
        $nivel = 'fund1';
        if (str_contains($nomeTurma, 'INFANTIL') || str_contains($nomeTurma, 'INF')) {
            $nivel = 'inf';
        } elseif (str_contains($nomeTurma, '6') || str_contains($nomeTurma, '7') || str_contains($nomeTurma, '8') || str_contains($nomeTurma, '9') || str_contains($nomeTurma, 'FUNDAMENTAL II')) {
            $nivel = 'fund2';
        }
        $view = "telasCoordenacao.notas.notas_{$nivel}_{$bim}";
    }

    return view($view, compact('aluno', 'matricula', 'turma', 'disciplinas', 'titulo'));
})->where('id', '[0-9]+');

// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
// Rotas para Gerar e Imprimir Carnê de Mensalidade por Aluno
Route::get('/coordenacao/criarcarne/{id}', function ($id) {
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

    $titulo = 'Gerar Carnê de Mensalidade — ' . ($aluno->NomeAluno ?? 'Aluno');

    return view('telasCoordenacao.carne.carne_criar', compact('aluno', 'matricula', 'turma', 'titulo'));
})->where('id', '[0-9]+');

Route::get('/coordenacao/carner/{id}', function ($id) {
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
        $escolas = \DB::table('tb_escola')->get();
    } catch (\Exception $e) { $escolas = collect(); }

    $titulo = 'Carnê de Mensalidades — ' . ($aluno->NomeAluno ?? 'Aluno');

    return view('telasCoordenacao.carne.carner', compact('aluno', 'matricula', 'turma', 'escolas', 'titulo'));
})->where('id', '[0-9]+');

Route::post('/coordenacao/criarcarne', function (\Illuminate\Http\Request $request) {
    $idAluno = $request->input('idAluno');
    return redirect('/coordenacao/carner/' . $idAluno);
});

// Rotas para Gerar Acordo Financeiro por Aluno
Route::get('/coordenacao/criaracordo/{id}', function ($id) {
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

    $titulo = 'Gerar Acordo Financeiro — ' . ($aluno->NomeAluno ?? 'Aluno');

    return view('telasCoordenacao.acordo.acordo_criar', compact('aluno', 'matricula', 'turma', 'titulo'));
})->where('id', '[0-9]+');

Route::post('/coordenacao/criaracordo', function (\Illuminate\Http\Request $request) {
    $idAluno = $request->input('idAluno');
    return redirect('/coordenacao/acordo/acordo_cad');
});
} // fim do bloco desativado

// Módulo Pedagógico — Mapas de Notas por Turma
Route::get('/coordenacao/mapa/mapas_notas', [cont_mapas::class, 'index']);
Route::get('/coordenacao/mapas_notas', [cont_mapas::class, 'index']);
Route::post('/coordenacao/mapas_pesq', [cont_mapas::class, 'mapas_pesq']);
Route::post('/coordenacao/mapas_filtro', [cont_mapas::class, 'mapas_filtro']);
Route::get('/coordenacao/mapas_filtro', [cont_mapas::class, 'mapas_filtro']);

Route::get('/coordenacao/mapa_1bim/{id}', [cont_mapas::class, 'bimestre_1']);
Route::get('/coordenacao/mapa_2bim/{id}', [cont_mapas::class, 'bimestre_2']);
Route::get('/coordenacao/mapa_3bim/{id}', [cont_mapas::class, 'bimestre_3']);
Route::get('/coordenacao/mapa_4bim/{id}', [cont_mapas::class, 'bimestre_4']);
Route::get('/coordenacao/mapa_global/{id}', [cont_mapas::class, 'mapa_global']);
Route::get('/coordenacao/mapa_{tipo}/{id}', [cont_mapas::class, 'mapa_dinamico']);

// Rotas para Impressão de Resultados por Turma
Route::get('/coordenacao/resultados_{tipo}/{id}', [cont_resultados::class, 'mapa_dinamico']);

// Rotas para Impressão de Gabaritos por Turma
Route::get('/coordenacao/gabarito_{tipo}/{id}', function ($tipo, $id) {
    $tiposValidos = ['08', '10', '11'];
    abort_if(!in_array($tipo, $tiposValidos), 404);

    try {
        $turma = \DB::table('tb_turmas')->where('idTurmas', $id)->first();
    } catch (\Exception $e) { $turma = null; }

    abort_if(!$turma, 404);

    try {
        $escolas = \DB::table('tb_escola')->get();
    } catch (\Exception $e) { $escolas = collect(); }

    try {
        $alunos = \DB::table('tb_aluno')->where('tb_turmas_idTurmas', $id)->orderBy('NomeAluno')->get();
    } catch (\Exception $e) { $alunos = collect(); }

    $titulo = "Gabarito ({$tipo} Questões) — " . ($turma->NomeTurma ?? 'Turma');

    $viewName = "telasCoordenacao.gabaritos.gabarito_{$tipo}";
    if (!view()->exists($viewName)) {
        $viewName = "telasCoordenacao.gabaritos.gabarito_08";
    }

    return view($viewName, compact('turma', 'escolas', 'alunos', 'titulo'));
})->where('id', '[0-9]+');

// Rotas para os Relatórios Gerenciais de Alunos
// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
Route::get('/coordenacao/relatorios/relatorio_alunos_matriculados', function () {
    try {
        $escolas = \DB::table('tb_escola')->get();
    } catch (\Exception $e) { $escolas = collect(); }

    try {
        $alunos = \DB::table('tb_aluno')
            ->leftJoin('tb_turmas', 'tb_alunos.tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
            ->where('SituacaoAluno', '!=', 'INATIVO')
            ->select('tb_alunos.*', 'tb_turmas.NomeTurma')
            ->orderBy('NomeAluno')
            ->get();
    } catch (\Exception $e) { $alunos = collect(); }

    $Alunos = $alunos;
    $titulo = 'Relatório de Alunos Matriculados';
    return view('telasCoordenacao.relatorios.relatorio_alunos_matriculados', compact('escolas', 'alunos', 'Alunos', 'titulo'));
});
} // fim do bloco desativado

// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
Route::get('/coordenacao/relatorios/relatorio_alunos_transferidos', function () {
    try {
        $escolas = \DB::table('tb_escola')->get();
    } catch (\Exception $e) { $escolas = collect(); }

    try {
        $alunos = \DB::table('tb_aluno')
            ->leftJoin('tb_turmas', 'tb_alunos.tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
            ->where('SituacaoAluno', 'INATIVO')
            ->select('tb_alunos.*', 'tb_turmas.NomeTurma')
            ->orderBy('NomeAluno')
            ->get();
    } catch (\Exception $e) { $alunos = collect(); }

    $Alunos = $alunos;
    $titulo = 'Relatório de Alunos Inativos / Transferidos';
    return view('telasCoordenacao.relatorios.relatorio_alunos_transferidos', compact('escolas', 'alunos', 'Alunos', 'titulo'));
});
} // fim do bloco desativado

Route::get('/coordenacao/relatorios/relatorio_alunos_por_turma', function (\Illuminate\Http\Request $request) {
    try {
        $escolas = \DB::table('tb_escola')->get();
    } catch (\Exception $e) { $escolas = collect(); }

    $idTurma = $request->input('idTurmas') ?? 1;

    try {
        $turma = \DB::table('tb_turmas')->where('idTurmas', $idTurma)->first();
    } catch (\Exception $e) { $turma = null; }

    try {
        $alunos = \DB::table('tb_aluno')
            ->where('tb_turmas_idTurmas', $idTurma)
            ->orderBy('NomeAluno')
            ->get();
    } catch (\Exception $e) { $alunos = collect(); }

    $Alunos = $alunos;
    $titulo = 'Relatório de Alunos por Turma — ' . ($turma->NomeTurma ?? '');
    return view('telasCoordenacao.relatorios.relatorio_alunos_por_turma', compact('escolas', 'turma', 'alunos', 'Alunos', 'titulo'));
});

// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
Route::get('/coordenacao/relatorios/relatorio_pre_matriculado', function () {
    try {
        $escolas = \DB::table('tb_escola')->get();
    } catch (\Exception $e) { $escolas = collect(); }

    try {
        $alunos = \DB::table('tb_aluno')
            ->leftJoin('tb_turmas', 'tb_alunos.tb_turmas_idTurmas', '=', 'tb_turmas.idTurmas')
            ->select('tb_alunos.*', 'tb_turmas.NomeTurma')
            ->orderBy('NomeAluno')
            ->get();
    } catch (\Exception $e) { $alunos = collect(); }

    $Alunos = $alunos;
    $titulo = 'Relatório de Alunos Pré-Matriculados';
    return view('telasCoordenacao.relatorios.relatorio_pre_matriculado', compact('escolas', 'alunos', 'Alunos', 'titulo'));
});
} // fim do bloco desativado


// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
Route::get('/coordenacao/financeiro/financeiro_receber', function () {
    try {
        $AnosLetivos = \DB::table('tb_turmas')->select('AnoLetivo')->distinct()->orderBy('AnoLetivo', 'desc')->get();
    } catch (\Exception $e) { $AnosLetivos = collect(); }

    $titulo = 'Financeiro — Recebimentos';
    return view('telasCoordenacao.financeiro.financeiro_receber', compact('AnosLetivos', 'titulo'));
});
} // fim do bloco desativado

// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
Route::get('/coordenacao/financeiro/financeiro_receitas_e_despesas', function () {
    try {
        $turmas = \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) { $turmas = collect(); }

    $titulo = 'Financeiro — Receitas e Despesas';
    return view('telasCoordenacao.financeiro.financeiro_receitas_e_despesas', compact('turmas', 'titulo'));
});
} // fim do bloco desativado

// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
Route::get('/coordenacao/financeiro/financeiro_estatistica', function () {
    $titulo = 'Financeiro — Estatísticas';
    return view('telasCoordenacao.financeiro.financeiro_estatistica', compact('titulo'));
});
} // fim do bloco desativado

// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
Route::get('/coordenacao/financeiro/financeiro_relatorios', function () {
    try {
        $turmas = \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) { $turmas = collect(); }

    $titulo = 'Financeiro — Relatórios';
    return view('telasCoordenacao.financeiro.financeiro_relatorios', compact('turmas', 'titulo'));
});
} // fim do bloco desativado

// INTEGRAÇÃO GLOBAL: bloco desativado (if(false)) — duplicava rota já registrada mais
// abaixo apontando para o Controller real. Código original preservado, apenas nunca
// mais registrado.
if (false) {
Route::post('/coordenacao/financeiro_pesq', function (\Illuminate\Http\Request $request) {
    $codbarras = $request->input('codbarras');
    try {
        $aluno = \DB::table('tb_aluno')->where('RA', $codbarras)->orWhere('idAluno', $codbarras)->first();
    } catch (\Exception $e) { $aluno = null; }

    if ($aluno) {
        return redirect('/coordenacao/financeiro_baixar/' . $aluno->idAluno);
    }
    return redirect('/coordenacao/financeiro/financeiro_receber')->with('error', 'Aluno não encontrado.');
});
} // fim do bloco desativado

// Rota da Central de Ajuda
Route::get('/coordenacao/ajuda', function () {
    $titulo = 'Central de Ajuda';
    return view('telasCoordenacao.ajuda', compact('titulo'));
});

Route::get('/coordenacao/ajuda/ajuda', function () {
    $titulo = 'Central de Ajuda';
    return view('telasCoordenacao.ajuda', compact('titulo'));
});

// GAP: NÃO desativado. Existem dois Controllers paralelos para Escola (cont_escola e
// cont_cadescola) com views e métodos diferentes (escola_cad vs escola_form; editar() vs
// iditar()). Precisa de decisão humana sobre qual Controller é o canônico.
// Rotas do Módulo Escola
Route::get('/coordenacao/escola/escola_inf', function () {
    try {
        $escolas = \DB::table('tb_escola')->get();
        if ($escolas->isEmpty()) {
            $escolas = \DB::table('tb_escola')->get();
        }
    } catch (\Exception $e) {
        $escolas = collect();
    }
    return view('telasCoordenacao.escola.escola_inf', compact('escolas'));
});

Route::get('/coordenacao/escola_cad', function () {
    try {
        $escolas = \DB::table('tb_escola')->first();
        $endereco = $escolas;
    } catch (\Exception $e) {
        $escolas = null;
        $endereco = null;
    }
    $titulo = 'Cadastrar / Editar Escola';
    return view('telasCoordenacao.escola.escola_cad', compact('escolas', 'endereco', 'titulo'));
});

Route::get('/coordenacao/escola_editar/{id}', function ($id) {
    try {
        $escolas = \DB::table('tb_escola')->where('idEscola', $id)->first();
        if (!$escolas) {
            $escolas = \DB::table('tb_escola')->first();
        }
        $endereco = $escolas;
    } catch (\Exception $e) {
        $escolas = null;
        $endereco = null;
    }
    $titulo = 'Editar Escola';
    return view('telasCoordenacao.escola.escola_cad', compact('escolas', 'endereco', 'titulo'));
})->where('id', '[0-9]+');

Route::get('/coordenacao/escola_perfil/{id}', function ($id) {
    try {
        $escolas = \DB::table('tb_escola')->where('idEscola', $id)->first();
        if (!$escolas) {
            $escolas = \DB::table('tb_escola')->first();
        }
        $endereco = $escolas;
    } catch (\Exception $e) {
        $escolas = null;
        $endereco = null;
    }
    return view('telasCoordenacao.escola.escola_vis', compact('escolas', 'endereco'));
})->where('id', '[0-9]+');

Route::get('/coordenacao/escola_impressao/{id}', function ($id) {
    try {
        $escolas = \DB::table('tb_escola')->where('idEscola', $id)->first();
        if (!$escolas) {
            $escolas = \DB::table('tb_escola')->first();
        }
        $endereco = $escolas;
    } catch (\Exception $e) {
        $escolas = null;
        $endereco = null;
    }

    try { $quantAlunosCadastrados = \DB::table('tb_aluno')->count(); } catch (\Exception $e) { $quantAlunosCadastrados = 0; }
    try { $quantMatriculasAtivas = \DB::table('tb_aluno')->where('SituacaoAluno', '!=', 'INATIVO')->count(); } catch (\Exception $e) { $quantMatriculasAtivas = 0; }
    try { $quantMatriculasInativas = \DB::table('tb_aluno')->where('SituacaoAluno', 'INATIVO')->count(); } catch (\Exception $e) { $quantMatriculasInativas = 0; }
    try { $quantTurmasAtivas = \DB::table('tb_turmas')->count(); } catch (\Exception $e) { $quantTurmasAtivas = 0; }
    try { $quantDisciplina = \DB::table('tb_disciplinas')->count(); } catch (\Exception $e) { $quantDisciplina = 0; }
    try { $quantFuncionariosCadastrados = \DB::table('tb_funcionarios')->count(); } catch (\Exception $e) { $quantFuncionariosCadastrados = 0; }
    try { $quantUsuarioCadastrados = \DB::table('users')->count(); } catch (\Exception $e) { $quantUsuarioCadastrados = 0; }

    return view('telasCoordenacao.escola.escola_imp', compact(
        'escolas', 'endereco', 'quantAlunosCadastrados', 'quantMatriculasAtivas',
        'quantMatriculasInativas', 'quantTurmasAtivas', 'quantDisciplina',
        'quantFuncionariosCadastrados', 'quantUsuarioCadastrados'
    ));
})->where('id', '[0-9]+');



















// Módulo de Pré-Matrículas e Reservas
Route::get('/coordenacao/aluno_pre_matricula/{id}', [cont_aluno::class, 'reservar']);
Route::post('/coordenacao/aluno_pre_matricula', [cont_aluno::class, 'reservando']);
Route::get('/coordenacao/aluno_pre_matriculado', [cont_aluno::class, 'pre_matriculados']);
Route::get('/coordenacao/aluno_pre_matricula_lista', [cont_aluno::class, 'pre_matricula']);
Route::get('/coordenacao/aluno_pre_matriculado_deletar/{id}', [cont_aluno::class, 'pre_matriculado_deletar']);

// Rotas de Exclusão Direta de Entidades da Coordenação
Route::get('/coordenacao/aluno_deletar/{id}', [cont_aluno::class, 'deletar']);
Route::get('/coordenacao/turma_deletar/{id}', [cont_turma::class, 'deletar']);
Route::get('/coordenacao/disciplina_deletar/{id}', [cont_disciplina::class, 'deletar']);
Route::get('/coordenacao/funcionario_deletar/{id}', [cont_funcionario::class, 'deletar']);
Route::get('/coordenacao/usuario_deletar/{id}', [cont_usuario::class, 'deletar']);
Route::get('/coordenacao/lanche_deletar/{id}', [cont_lanche::class, 'deletar']);

// Rotas do Módulo de Alunos (Cadastro)
Route::get('/coordenacao/aluno_cad', [cont_aluno::class, 'novoaluno']);
Route::post('/coordenacao/aluno_cad', [cont_aluno::class, 'postnovoaluno']);


// ==========================================
// ROTAS INTEGRADAS COM CONTROLLERS REAIS
// ==========================================

// Autenticação & Login
// CORREÇÃO: '/login' apontava para coordenacaoIndex() (o painel/dashboard, que expõe
// contagens reais sem exigir login) em vez de login() (o formulário). Mesmo bug em
// '/aluno/login', que apontava para Index() (painel do aluno, quebra com usuário nulo)
// em vez de login(). Corrigido para os métodos que de fato renderizam os formulários,
// e adicionadas as rotas de painel ('/coordenacao', '/docente') para onde postlogin()
// já redirecionava mas que não existiam — logins bem-sucedidos davam 404.
Route::get('/login', [loginPrincipal::class, 'login'])->name('login');
Route::post('/login', [loginPrincipal::class, 'postlogin']);
Route::get('/logout', [loginPrincipal::class, 'logout']);
Route::get('/coordenacao', [loginPrincipal::class, 'coordenacaoIndex']);
Route::get('/docente', [loginPrincipal::class, 'docenteIndex']);
Route::get('/aluno/login', [loginAluno::class, 'login']);
Route::post('/aluno/login', [loginAluno::class, 'postlogin']);
// GAP: postlogin() do aluno redireciona sucesso para '/aluno' e falha para '/loginaluno'
// (não '/aluno/login'), nenhuma das duas rotas existe. Não corrigido ainda — decidir se
// '/aluno' deve ir para Index() (painel) e se '/loginaluno' era pra ser '/aluno/login'.

// Módulo de Alunos
Route::get('/coordenacao/aluno_inf', [cont_aluno::class, 'aluno_inf']);
Route::get('/coordenacao/aluno_editar/{id}', [cont_aluno::class, 'editar']);
Route::post('/coordenacao/aluno_editar/{id}', [cont_aluno::class, 'editando']);
Route::get('/coordenacao/aluno_transferir/{id}', [cont_aluno::class, 'transferir']);
Route::post('/coordenacao/aluno_transferir/{id}', [cont_aluno::class, 'transferindo']);
Route::get('/coordenacao/aluno_ficha/{id}', [cont_aluno::class, 'ficha']);
Route::post('/coordenacao/aluno_pesq', [cont_aluno::class, 'aluno_pesq']);
Route::get('/coordenacao/aluno_filtro', [cont_aluno::class, 'aluno_filtro']);
Route::get('/coordenacao/aluno_rematricula', [cont_aluno::class, 'aluno_rematricula']);
Route::post('/coordenacao/aluno_pesq_rematricula', [cont_aluno::class, 'aluno_pesq_rematricula']);

// Módulo de Turmas
Route::get('/coordenacao/cadturma', [cont_turma::class, 'novaturma']);
Route::post('/coordenacao/cadturma', [cont_turma::class, 'postnovaturma']);
Route::get('/coordenacao/turma_inf', [cont_turma::class, 'turma_inf']);
Route::get('/coordenacao/turma_editar/{id}', [cont_turma::class, 'editar']);
Route::post('/coordenacao/editar_turma/{id}', [cont_turma::class, 'editando']);
Route::post('/coordenacao/turma_pesq', [cont_turma::class, 'turma_pesq']);

// Módulo de Disciplinas & Lotação
Route::get('/coordenacao/disciplina_cad', [cont_disciplina::class, 'novadisciplina']);
Route::post('/coordenacao/disciplina_cad', [cont_disciplina::class, 'postnovadisciplina']);
Route::get('/coordenacao/disciplina_inf', [cont_disciplina::class, 'disciplina_inf']);
Route::get('/coordenacao/disciplina_editar/{id}', [cont_disciplina::class, 'editar']);
Route::post('/coordenacao/disciplina_editar/{id}', [cont_disciplina::class, 'editando']);
Route::get('/coordenacao/vincularProfessor', [cont_turma_disciplina::class, 'vincularProfessor']);
Route::post('/coordenacao/vincularProfessor', [cont_turma_disciplina::class, 'postvincularProfessor']);
Route::get('/coordenacao/turma_disciplina_cad', [cont_turma_disciplina::class, 'vincularProfessor']);
Route::post('/coordenacao/turma_disciplina_cad', [cont_turma_disciplina::class, 'postvincularProfessor']);
Route::get('/coordenacao/turma_disc/turma_disciplina_cad', [cont_turma_disciplina::class, 'vincularProfessor']);
Route::get('/coordenacao/turma_disciplina_inf', [cont_turma_disciplina::class, 'turmaDisciplinaInf']);
Route::get('/coordenacao/turma_disc/turma_disciplina_inf', [cont_turma_disciplina::class, 'turmaDisciplinaInf']);
Route::get('/coordenacao/turma_disciplina_deletar/{id}', [cont_turma_disciplina::class, 'turma_disciplina_deletar']);
Route::get('/coordenacao/turma_disciplina/deletar/{id}', [cont_turma_disciplina::class, 'turma_disciplina_deletar']);

// Módulo de Funcionários & Usuários & Escola
Route::get('/coordenacao/cadfuncionario', [cont_funcionario::class, 'novofuncionario']);
Route::post('/coordenacao/cadfuncionario', [cont_funcionario::class, 'postnovofuncionario']);
Route::get('/coordenacao/funcionario_cad', [cont_funcionario::class, 'novofuncionario']);
Route::post('/coordenacao/funcionario_cad', [cont_funcionario::class, 'postnovofuncionario']);
Route::get('/coordenacao/funcionario_inf', [cont_funcionario::class, 'funcionario_inf']);
Route::get('/coordenacao/funcionario_editar/{id}', [cont_funcionario::class, 'editar']);
Route::post('/coordenacao/funcionario_editar/{id}', [cont_funcionario::class, 'editando']);
Route::get('/coordenacao/cadusuario', [cont_usuario::class, 'novousuario']);
Route::post('/coordenacao/cadusuario', [cont_usuario::class, 'postnovousuario']);
Route::get('/coordenacao/usuario_inf', [cont_usuario::class, 'usuario_inf']);
Route::get('/coordenacao/usuario_editar/{id}', [cont_usuario::class, 'editar']);
Route::post('/coordenacao/usuario_editar/{id}', [cont_usuario::class, 'editando']);
Route::get('/coordenacao/escola/escola_inf', [cont_escola::class, 'escola_inf']);
Route::get('/coordenacao/escola_cad', [cont_cadescola::class, 'novaescola']);
Route::post('/coordenacao/escola_cad', [cont_cadescola::class, 'postnovaescola']);
Route::get('/coordenacao/escola_editar/{id}', [cont_escola::class, 'editar']);
Route::post('/coordenacao/escola_editar/{id}', [cont_escola::class, 'editando']);

// Módulo Financeiro & Carnês & Acordos & Recibos & Lanche
Route::get('/coordenacao/financeiro/financeiro_receber', [cont_financeiro::class, 'financeiro_receber']);
Route::get('/coordenacao/financeiro/financeiro_receitas_e_despesas', [cont_financeiro::class, 'financeiro_receitas_e_despesas']);
Route::get('/coordenacao/financeiro/financeiro_estatistica', [cont_financeiro::class, 'financeiro_estatistica']);
Route::get('/coordenacao/financeiro/financeiro_relatorios', [cont_financeiro::class, 'financeiro_relatorios']);
Route::post('/coordenacao/financeiro_pesq', [cont_financeiro::class, 'financeiro_pesq']);
Route::get('/coordenacao/criarcarne/{id}', [cont_recibos::class, 'criarCarne']);
Route::post('/coordenacao/criarcarne', [cont_recibos::class, 'criando']);
Route::get('/coordenacao/carner/{id}', [cont_recibos::class, 'carner']);
Route::get('/coordenacao/criaracordo/{id}', [cont_recibos::class, 'criarAcordo']);
Route::post('/coordenacao/criaracordo', [cont_recibos::class, 'criando_acordo']);
Route::get('/coordenacao/lanche_cad', [cont_lanche::class, 'novolanche_cad']);
Route::post('/coordenacao/lanche_cad', [cont_lanche::class, 'postnovolanche']);
Route::get('/coordenacao/lanche_inf', [cont_lanche::class, 'lanche_inf']);

// Módulo de Relatórios Gerenciais
Route::get('/coordenacao/relatorios_bimestrais', [cont_relatorios::class, 'relatorios_bimestrais']);
Route::get('/coordenacao/relatorios_filtro', [cont_relatorios::class, 'relatorios_filtro']);
Route::post('/coordenacao/relatorios_pesq', [cont_relatorios::class, 'relatorios_pesq']);

Route::get('/coordenacao/boletim_acompanhamento_1bim/{id}', [cont_relatorios::class, 'bimestre_1']);
Route::get('/coordenacao/boletim_acompanhamento_2bim/{id}', [cont_relatorios::class, 'bimestre_2']);
Route::get('/coordenacao/boletim_acompanhamento_3bim/{id}', [cont_relatorios::class, 'bimestre_3']);
Route::get('/coordenacao/boletim_acompanhamento_4bim/{id}', [cont_relatorios::class, 'bimestre_4']);

Route::get('/coordenacao/bimestre_1/{id}', [cont_relatorios::class, 'bimestre_1']);
Route::get('/coordenacao/bimestre_2/{id}', [cont_relatorios::class, 'bimestre_2']);
Route::get('/coordenacao/bimestre_3/{id}', [cont_relatorios::class, 'bimestre_3']);
Route::get('/coordenacao/bimestre_4/{id}', [cont_relatorios::class, 'bimestre_4']);

Route::get('/coordenacao/relatorios/relatorio_alunos_matriculados', [cont_relatorios::class, 'alunosMatriculados']);
Route::get('/coordenacao/relatorios/relatorio_alunos_transferidos', [cont_relatorios::class, 'alunosTransferidos']);
Route::get('/coordenacao/relatorios/relatorio_alunos_turmas', [cont_relatorios::class, 'listagem_turmas']);
Route::get('/coordenacao/relatorio_alunos_turmas', [cont_relatorios::class, 'listagem_turmas']);
Route::post('/coordenacao/relatorio_pesquisar_turmas', [cont_relatorios::class, 'turma_pesq']);
Route::post('/coordenacao/relatorio_filtro_turmas_anoletivo', [cont_relatorios::class, 'turma_filtro']);
Route::get('/coordenacao/relatorio_alunos_turmas/{id}', [cont_relatorios::class, 'alunosPorTurma']);
Route::get('/coordenacao/relatorios/relatorio_alunos_por_turma/{id?}', [cont_relatorios::class, 'alunosPorTurma']);
Route::get('/coordenacao/relatorio_alunos_turmas_endereco/{id}', [cont_relatorios::class, 'alunosPorTurmaEndereco']);
Route::get('/coordenacao/relatorios/relatorio_alunos_por_turma_endereco/{id}', [cont_relatorios::class, 'alunosPorTurmaEndereco']);
Route::get('/coordenacao/relatorios/relatorio_pre_matriculado', [cont_relatorios::class, 'pre_matriculados']);

// Módulo Pedagógico — Lançamento e Consulta de Notas Bimestrais
Route::get('/coordenacao/notas/notas', [cont_notas::class, 'index']);
Route::post('/coordenacao/notas/notas_pesq', [cont_notas::class, 'notas_pesq']);
Route::get('/coordenacao/notas/notas_filtro', [cont_notas::class, 'notas_filtro']);
Route::get('/coordenacao/notas_bimestre_1/{id}', [cont_notas::class, 'bimestre_1']);
Route::get('/coordenacao/notas_bimestre_2/{id}', [cont_notas::class, 'bimestre_2']);
Route::get('/coordenacao/notas_bimestre_3/{id}', [cont_notas::class, 'bimestre_3']);
Route::get('/coordenacao/notas_bimestre_4/{id}', [cont_notas::class, 'bimestre_4']);
Route::get('/coordenacao/notas_rp_rf/{id}', [cont_notas::class, 'rp_rf']);
Route::post('/coordenacao/salva_nota_1bim_inf', [cont_notas::class, 'salva_nota_1bim_inf']);
Route::post('/coordenacao/salva_nota_2bim_inf', [cont_notas::class, 'salva_nota_2bim_inf']);
Route::post('/coordenacao/salva_nota_3bim_inf', [cont_notas::class, 'salva_nota_3bim_inf']);
Route::post('/coordenacao/salva_nota_4bim_inf', [cont_notas::class, 'salva_nota_4bim_inf']);
Route::post('/coordenacao/salva_nota_1bim_fun1', [cont_notas::class, 'salva_nota_1bim_fun1']);
Route::post('/coordenacao/salva_nota_2bim_fun1', [cont_notas::class, 'salva_nota_2bim_fun1']);
Route::post('/coordenacao/salva_nota_3bim_fun1', [cont_notas::class, 'salva_nota_3bim_fun1']);
Route::post('/coordenacao/salva_nota_4bim_fun1', [cont_notas::class, 'salva_nota_4bim_fun1']);
Route::post('/coordenacao/salva_nota_1bim_fun2', [cont_notas::class, 'salva_nota_1bim_fun2']);
Route::post('/coordenacao/salva_nota_2bim_fun2', [cont_notas::class, 'salva_nota_2bim_fun2']);
Route::post('/coordenacao/salva_nota_3bim_fun2', [cont_notas::class, 'salva_nota_3bim_fun2']);
Route::post('/coordenacao/salva_nota_4bim_fun2', [cont_notas::class, 'salva_nota_4bim_fun2']);
Route::post('/coordenacao/salva_nota_rp_rf', [cont_notas::class, 'salva_nota_rp_rf']);

// Módulo Pedagógico — Boletins
Route::get('/coordenacao/boletins/boletins', [cont_boletins::class, 'index']);
Route::get('/coordenacao/boletim/{id}', [cont_boletins::class, 'boletim']);
Route::post('/coordenacao/boletim_pesq', [cont_boletins::class, 'boletim_pesq']);
Route::get('/coordenacao/boletim_filtro', [cont_boletins::class, 'boletim_filtro']);

// Módulo Pedagógico — Frequências Escolares
Route::get('/coordenacao/frequencia/frequencias', [cont_frequencias::class, 'index']);
Route::post('/coordenacao/frequencias_pesq', [cont_frequencias::class, 'frequencias_pesq']);
Route::get('/coordenacao/frequencias_filtro', [cont_frequencias::class, 'frequencias_filtro']);
Route::get('/coordenacao/frequencia_virtual/{id}', [cont_frequencias::class, 'frequencia_virtual']);
Route::get('/coordenacao/frequencia/frequencia_virtual/{id}', [cont_frequencias::class, 'frequencia_virtual']);
Route::post('/coordenacao/postnovafrequencia', [cont_frequencias::class, 'postnovafrequencia']);
Route::get('/coordenacao/frequencia_relatorio/{id}', [cont_frequencias::class, 'frequencia_relatorio']);
Route::get('/coordenacao/frequencia/frequencia_relatorio/{id}', [cont_frequencias::class, 'frequencia_relatorio']);
Route::get('/coordenacao/frequencia_mensal/{id}', [cont_frequencias::class, 'frequencia_mensal']);
Route::get('/coordenacao/frequencia/frequencia_mensal/{id}', [cont_frequencias::class, 'frequencia_mensal']);
Route::get('/coordenacao/frequencia_edfisica/{id}', [cont_frequencias::class, 'frequencia_edfisica']);
Route::get('/coordenacao/frequencia/frequencia_edfisica/{id}', [cont_frequencias::class, 'frequencia_edfisica']);
Route::get('/coordenacao/frequencia_entrega/{id}', [cont_frequencias::class, 'frequencia_entrega']);

// Módulo Pedagógico — Declarações Oficiais
Route::get('/coordenacao/declaracoes/cursando/{id}', [cont_declaracoes::class, 'cursando']);
Route::get('/coordenacao/declaracoes/apto/{id}', [cont_declaracoes::class, 'apto']);
Route::get('/coordenacao/declaracoes/transferencia/{id}', [cont_declaracoes::class, 'transferencia']);
Route::get('/coordenacao/declaracoes/quitacao/{id}', [cont_declaracoes::class, 'quitacao']);
Route::get('/coordenacao/declaracoes/inapto/{id}', [cont_declaracoes::class, 'inapto']);

// Módulo Pedagógico — Gabaritos
Route::get('/coordenacao/gabarito/gabaritos', [cont_gabarito::class, 'index']);
Route::get('/coordenacao/gabaritos', [cont_gabarito::class, 'index']);
Route::post('/coordenacao/gabarito_pesq', [cont_gabarito::class, 'gabarito_pesq']);
Route::get('/coordenacao/gabarito_filtro', [cont_gabarito::class, 'gabarito_filtro']);
Route::get('/coordenacao/gabarito_08/{id}', [cont_gabarito::class, 'gabarito_08']);
Route::get('/coordenacao/gabarito_10/{id}', [cont_gabarito::class, 'gabarito_10']);
// Módulo Pedagógico — Resultados Acadêmicos
Route::get('/coordenacao/resultados', [cont_resultados::class, 'index']);
Route::get('/coordenacao/resultado/resultados', [cont_resultados::class, 'index']);
Route::post('/coordenacao/resultados_pesq', [cont_resultados::class, 'resultados_pesq']);
Route::post('/coordenacao/resultados_filtro', [cont_resultados::class, 'resultados_filtro']);
Route::get('/coordenacao/resultados_parcial/{id}', [cont_resultados::class, 'resultado_parcial']);
Route::get('/coordenacao/resultados_final/{id}', [cont_resultados::class, 'resultado_final']);
Route::get('/coordenacao/resultados_aprovados_1semestre/{id}', [cont_resultados::class, 'aprovados_1semestre']);
Route::get('/coordenacao/resultados_aprovados_2semestre/{id}', [cont_resultados::class, 'aprovados_2semestre']);

Route::get('/coordenacao/{pasta}/{pagina}', function ($pasta, $pagina) {
    $viewName = "telasCoordenacao.{$pasta}.{$pagina}";
    if (view()->exists($viewName)) {
        return view($viewName);
    }

    $title = ucwords(str_replace(['_', '-'], ' ', $pagina));
    return view('telasCoordenacao.construcao', compact('title'));
})->name('coordenacao.pagina');
