<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "==================== INICIO DOS TESTES ====================\n\n";

// -------------------------------------------------------------
// TESTE 1: GET /coordenacao/alunos/aluno_cad
// -------------------------------------------------------------
echo "### TESTE 1: GET /coordenacao/alunos/aluno_cad\n";
$req1 = Illuminate\Http\Request::create('/coordenacao/alunos/aluno_cad', 'GET');
$resp1 = $kernel->handle($req1);
$status1 = $resp1->getStatusCode();
$body1 = $resp1->getContent();
$hasTurma = (strpos($body1, '1º ANO') !== false || strpos($body1, 'ANO') !== false || strpos($body1, 'INFANTIL') !== false);
$hasTurma1Ano = strpos($body1, '1º ANO') !== false;
$hasNenhumaTurma = strpos($body1, 'Nenhuma turma ativa encontrada') !== false;

echo "Status: $status1\n";
echo "Contém '1º ANO': " . ($hasTurma1Ano ? 'SIM' : 'NÃO') . "\n";
echo "Contém 'Nenhuma turma ativa encontrada': " . ($hasNenhumaTurma ? 'SIM (ERRO)' : 'NÃO (CORRETO)') . "\n\n";

// -------------------------------------------------------------
// TESTE 2: GET /coordenacao/relatorios/relatorios_bimestrais
// -------------------------------------------------------------
echo "### TESTE 2: GET /coordenacao/relatorios/relatorios_bimestrais\n";
$req2 = Illuminate\Http\Request::create('/coordenacao/relatorios/relatorios_bimestrais', 'GET');
$resp2 = $kernel->handle($req2);
$status2 = $resp2->getStatusCode();
$body2 = $resp2->getContent();

// Tentar extrair o total de alunos da view
preg_match('/Total.*?(\d+)/i', $body2, $matchesTotal);
$totalAlunosRel = $matchesTotal[1] ?? 'não identificado por regex';

// Contar quantas linhas de alunos na tabela da primeira página
$countRows = substr_count($body2, 'boletim_acompanhamento_1bim/');

echo "Status: $status2\n";
echo "Alunos exibidos na página atual: $countRows\n";
echo "Total encontrado no texto/badge: $totalAlunosRel\n\n";

// -------------------------------------------------------------
// TESTE 4: GET /coordenacao/boletim_acompanhamento_1bim/{id}
// -------------------------------------------------------------
echo "### TESTE 4: GET /coordenacao/boletim_acompanhamento_1bim/{id}\n";
$alunoAtivo = \DB::table('tb_aluno')
    ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
    ->whereIn('tb_matriculas.SituacaoAluno', ['ATIVO', 'MATRICULADO'])
    ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno')
    ->first();

if ($alunoAtivo) {
    $idAluno = $alunoAtivo->idAluno;
    $nomeAluno = $alunoAtivo->NomeAluno;
    $url4 = "/coordenacao/boletim_acompanhamento_1bim/$idAluno";
    $req4 = Illuminate\Http\Request::create($url4, 'GET');
    $resp4 = $kernel->handle($req4);
    $status4 = $resp4->getStatusCode();
    $body4 = $resp4->getContent();
    $hasBase64 = strpos($body4, 'data:image/png;base64') !== false;

    echo "Aluno testado: ID $idAluno - $nomeAluno\n";
    echo "Status: $status4\n";
    echo "Contém 'data:image/png;base64': " . ($hasBase64 ? 'SIM (CORRETO)' : 'NÃO (ERRO)') . "\n\n";
} else {
    echo "Nenhum aluno ativo encontrado no banco.\n\n";
}

// -------------------------------------------------------------
// TESTE 5: GET carne_inf e acordo_cad
// -------------------------------------------------------------
echo "### TESTE 5: GET carne_inf e acordo_cad\n";

// Buscar uma turma ativa para teste de filtro
$turmaAtiva = \App\Models\modelCoordenacao\tb_turma::turmasAtivas()->first();
$idTurmaTeste = $turmaAtiva ? $turmaAtiva->idTurmas : 1;
$nomeTurmaTeste = $turmaAtiva ? $turmaAtiva->NomeTurma : 'N/A';

// Parte de um nome para teste
$parteNome = 'MARIA';

// 5.1 Carne
$req5Carne = Illuminate\Http\Request::create('/coordenacao/carne/carne_inf', 'GET');
$resp5Carne = $kernel->handle($req5Carne);
$status5Carne = $resp5Carne->getStatusCode();
$body5Carne = $resp5Carne->getContent();
preg_match('/Alunos cadastrados:\s*\(\s*(\d+)\s*\)/i', $body5Carne, $mCarneTotal);
$totalCarne = $mCarneTotal[1] ?? 'N/D';

$req5CarnePesq = Illuminate\Http\Request::create("/coordenacao/carne/carne_inf?pesquisar=$parteNome", 'GET');
$resp5CarnePesq = $kernel->handle($req5CarnePesq);
$body5CarnePesq = $resp5CarnePesq->getContent();
preg_match('/Alunos cadastrados:\s*\(\s*(\d+)\s*\)/i', $body5CarnePesq, $mCarnePesq);
$totalCarnePesq = $mCarnePesq[1] ?? 'N/D';

$req5CarneTurma = Illuminate\Http\Request::create("/coordenacao/carne/carne_inf?idTurmas=$idTurmaTeste", 'GET');
$resp5CarneTurma = $kernel->handle($req5CarneTurma);
$body5CarneTurma = $resp5CarneTurma->getContent();
preg_match('/Alunos cadastrados:\s*\(\s*(\d+)\s*\)/i', $body5CarneTurma, $mCarneTurma);
$totalCarneTurma = $mCarneTurma[1] ?? 'N/D';

echo "Carne (carne_inf):\n";
echo " - Status base: $status5Carne | Total Alunos: $totalCarne\n";
echo " - Filtro ?pesquisar=$parteNome: Status {$resp5CarnePesq->getStatusCode()} | Total: $totalCarnePesq\n";
echo " - Filtro ?idTurmas=$idTurmaTeste ($nomeTurmaTeste): Status {$resp5CarneTurma->getStatusCode()} | Total: $totalCarneTurma\n";

// 5.2 Acordo
$req5Acordo = Illuminate\Http\Request::create('/coordenacao/acordo/acordo_cad', 'GET');
$resp5Acordo = $kernel->handle($req5Acordo);
$status5Acordo = $resp5Acordo->getStatusCode();
$body5Acordo = $resp5Acordo->getContent();
preg_match('/Alunos cadastrados:\s*\(\s*(\d+)\s*\)/i', $body5Acordo, $mAcordoTotal);
$totalAcordo = $mAcordoTotal[1] ?? 'N/D';

$req5AcordoPesq = Illuminate\Http\Request::create("/coordenacao/acordo/acordo_cad?pesquisar=$parteNome", 'GET');
$resp5AcordoPesq = $kernel->handle($req5AcordoPesq);
$body5AcordoPesq = $resp5AcordoPesq->getContent();
preg_match('/Alunos cadastrados:\s*\(\s*(\d+)\s*\)/i', $body5AcordoPesq, $mAcordoPesq);
$totalAcordoPesq = $mAcordoPesq[1] ?? 'N/D';

$req5AcordoTurma = Illuminate\Http\Request::create("/coordenacao/acordo/acordo_cad?idTurmas=$idTurmaTeste", 'GET');
$resp5AcordoTurma = $kernel->handle($req5AcordoTurma);
$body5AcordoTurma = $resp5AcordoTurma->getContent();
preg_match('/Alunos cadastrados:\s*\(\s*(\d+)\s*\)/i', $body5AcordoTurma, $mAcordoTurma);
$totalAcordoTurma = $mAcordoTurma[1] ?? 'N/D';

echo "Acordo (acordo_cad):\n";
echo " - Status base: $status5Acordo | Total Alunos: $totalAcordo\n";
echo " - Filtro ?pesquisar=$parteNome: Status {$resp5AcordoPesq->getStatusCode()} | Total: $totalAcordoPesq\n";
echo " - Filtro ?idTurmas=$idTurmaTeste ($nomeTurmaTeste): Status {$resp5AcordoTurma->getStatusCode()} | Total: $totalAcordoTurma\n\n";

// -------------------------------------------------------------
// TESTE 6: POST nas rotas especificadas
// -------------------------------------------------------------
echo "### TESTE 6: POST nas rotas especificadas\n";
$postRoutes = [
    '/coordenacao/notas_pesq' => ['pesquisar' => 'A'],
    '/coordenacao/declaracoes_pesq' => ['pesquisar' => 'A'],
    '/coordenacao/gabarito_filtro' => ['idTurmas' => $idTurmaTeste],
    '/coordenacao/boletim_filtro' => ['idTurmas' => $idTurmaTeste],
    '/coordenacao/lanche_pesq' => ['pesquisar' => 'A'],
    '/coordenacao/relatorio_alunos_turmas_pesq' => ['pesquisar' => 'A'],
];

foreach ($postRoutes as $uri => $params) {
    try {
        $reqPost = Illuminate\Http\Request::create($uri, 'POST', $params);
        $respPost = $kernel->handle($reqPost);
        $statusPost = $respPost->getStatusCode();
        echo "POST $uri -> Status: $statusPost";
        if ($statusPost >= 500) {
            echo " [ERRO 500: " . substr(strip_tags($respPost->getContent()), 0, 150) . "]";
        }
        echo "\n";
    } catch (\Throwable $e) {
        echo "POST $uri -> EXCEÇÃO: " . $e->getMessage() . "\n";
    }
}
echo "\n";

// -------------------------------------------------------------
// TESTE 7: Exportar funcionários sem data de nascimento
// -------------------------------------------------------------
echo "### TESTE 7: Exportar funcionários ativos sem DataNascimento\n";

$service = new \App\Services\DashboardService();
$semDataQuery = \DB::table('tb_funcionarios')
    ->where('NomeFuncionario', 'not like', '%(SAIU)%')
    ->where('NomeFuncionario', 'not like', '%(INATIVO)%');

if (\Illuminate\Support\Facades\Schema::hasColumn('tb_funcionarios', 'Situacao')) {
    $semDataQuery->where(function ($q) {
        $q->whereNull('Situacao')
          ->orWhere('Situacao', '')
          ->orWhereNotIn('Situacao', ['INATIVO', 'INATIVA', '[INATIVO]']);
    });
}

$funcionariosAtivos = $semDataQuery->select('idFuncionario', 'NomeFuncionario', 'Funcao', 'DataNascimento')->get();

$semDataLista = [];
foreach ($funcionariosAtivos as $f) {
    $d = trim((string)$f->DataNascimento);
    $valida = false;
    if ($d !== '') {
        if (preg_match('/^(\d{4})[-\/.](\d{1,2})[-\/.](\d{1,2})/', $d) || preg_match('/^(\d{1,2})[-\/.](\d{1,2})[-\/.](\d{2}|\d{4})\b/', $d)) {
            $valida = true;
        }
    }
    if (!$valida) {
        $semDataLista[] = [
            'id' => $f->idFuncionario,
            'nome' => trim($f->NomeFuncionario),
            'funcao' => trim($f->Funcao ?? 'Funcionário'),
        ];
    }
}

echo "Total de funcionários ativos sem data de nascimento: " . count($semDataLista) . "\n";

$csvPath = storage_path('app/funcionarios_sem_nascimento.csv');
$fp = fopen($csvPath, 'w');
fputcsv($fp, ['ID', 'NomeFuncionario', 'Funcao'], ';');
foreach ($semDataLista as $item) {
    fputcsv($fp, [$item['id'], $item['nome'], $item['funcao']], ';');
}
fclose($fp);

echo "Arquivo CSV salvo com sucesso em: $csvPath\n";
echo "Tamanho do arquivo: " . filesize($csvPath) . " bytes\n";

echo "\n==================== FIM DOS TESTES ====================\n";
