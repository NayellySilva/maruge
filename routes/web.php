<?php

use Illuminate\Support\Facades\Route;
use App\Models\modelCoordenacao\tb_usuario;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/usuarios', function () {
    $Usuarios = tb_usuario::listagemUsuarios();
    return view('telasCoordenacao.usuario_inf', compact('Usuarios'));
})->name('usuarios.info');

Route::get('/api/feriados', function (\Illuminate\Http\Request $request) {
    $ano = $request->query('ano', date('Y'));
    $uf = env('SCHOOL_UF', 'CE');
    $apiKey = env('FERIADOS_API_KEY');
    
    $holidays = [];

    // Tenta primeiro o MCP feriadosapi.com se houver API key configurada
    if ($apiKey) {
        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Accept' => 'application/json, text/event-stream',
                'Content-Type' => 'application/json'
            ])->post("https://mcp.feriadosapi.com/api/mcp?apiKey={$apiKey}", [
                'jsonrpc' => '2.0',
                'method' => 'tools/call',
                'params' => [
                    'name' => 'feriados_por_estado',
                    'arguments' => [
                        'uf' => $uf,
                        'ano' => (string)$ano,
                        'facultativos' => true
                    ]
                ],
                'id' => time()
            ]);
            
            if ($response->successful()) {
                $text = $response->body();
                $lines = explode("\n", $text);
                $dataLine = null;
                foreach ($lines as $line) {
                    if (str_starts_with($line, 'data: ')) {
                        $dataLine = $line;
                        break;
                    }
                }
                
                if ($dataLine) {
                    $jsonData = json_decode(substr($dataLine, 6), true);
                    if (isset($jsonData['result']['content'][0]['text']) && !isset($jsonData['error']) && (!isset($jsonData['result']['isError']) || !$jsonData['result']['isError'])) {
                        $contentText = $jsonData['result']['content'][0]['text'];
                        
                        preg_match_all('/(\d{2})\/(\d{2})\/(\d{4})\s*(?:—|–|â€”|-)\s*([^\n(]+)(?:\(([^)]+)\))?/', $contentText, $matches, PREG_SET_ORDER);
                        
                        foreach ($matches as $match) {
                            $day = (int)$match[1];
                            $month = (int)$match[2] - 1; // 0-indexed month
                            $year = (int)$match[3];
                            $name = trim($match[4]);
                            $type = isset($match[5]) ? trim($match[5]) : '';
                            
                            $holidays[] = [
                                'day' => $day,
                                'month' => $month,
                                'year' => $year,
                                'name' => $name,
                                'type' => $type,
                                'custom' => false
                            ];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Ignora erro e recorre à BrasilAPI
        }
    }

    // Fallback público e gratuito: BrasilAPI (sem necessidade de API Key)
    if (empty($holidays)) {
        try {
            $response = \Illuminate\Support\Facades\Http::get("https://brasilapi.com.br/api/feriados/v1/{$ano}");
            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data)) {
                    foreach ($data as $item) {
                        if (isset($item['date'], $item['name'])) {
                            $parts = explode('-', $item['date']);
                            if (count($parts) === 3) {
                                $holidays[] = [
                                    'day' => (int)$parts[2],
                                    'month' => (int)$parts[1] - 1, // 0-indexed para compatibilidade JS
                                    'year' => (int)$parts[0],
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
            // Segue para os eventos customizados se houver falha de rede
        }
    }

    // Inclusão de Datas Comemorativas importantes (Dia das Mães, Dia dos Pais, etc.)
    $commemorativeDates = [
        [
            'date' => date('Y-m-d', strtotime("second sunday of May {$ano}")),
            'name' => 'Dia das Mães',
            'type' => 'Data Comemorativa'
        ],
        [
            'date' => date('Y-m-d', strtotime("second sunday of August {$ano}")),
            'name' => 'Dia dos Pais',
            'type' => 'Data Comemorativa'
        ],
        [
            'date' => "{$ano}-10-15",
            'name' => 'Dia dos Professores',
            'type' => 'Data Comemorativa'
        ],
        [
            'date' => "{$ano}-06-12",
            'name' => 'Dia dos Namorados',
            'type' => 'Data Comemorativa'
        ],
        [
            'date' => "{$ano}-08-11",
            'name' => 'Dia do Estudante',
            'type' => 'Data Comemorativa'
        ]
    ];

    foreach ($commemorativeDates as $commDate) {
        $parts = explode('-', $commDate['date']);
        $day = (int)$parts[2];
        $month = (int)$parts[1] - 1;
        $year = (int)$parts[0];

        $exists = false;
        foreach ($holidays as $h) {
            if ($h['day'] === $day && $h['month'] === $month && $h['year'] === $year) {
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $holidays[] = [
                'day' => $day,
                'month' => $month,
                'year' => $year,
                'name' => $commDate['name'],
                'type' => $commDate['type'],
                'custom' => false
            ];
        }
    }

    // Merge custom events from storage
    try {
        $path = storage_path('app/eventos.json');
        if (file_exists($path)) {
            $customEvents = json_decode(file_get_contents($path), true) ?: [];
            foreach ($customEvents as $dateStr => $event) {
                $dateParts = date_parse($dateStr);
                if ($dateParts['year'] == $ano) {
                    $holidays[] = [
                        'day' => $dateParts['day'],
                        'month' => $dateParts['month'] - 1, // 0-indexed month
                        'year' => $dateParts['year'],
                        'name' => $event['name'],
                        'type' => $event['type'],
                        'custom' => true
                    ];
                }
            }
        }
    } catch (\Exception $e) {
        // Ignore JSON read errors
    }
    
    return response()->json($holidays);
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

// Gravar/Editar Disciplina
Route::post('/coordenacao/disciplina_cad', function (\Illuminate\Http\Request $request) {
    try {
        \DB::table('tb_disciplinas')->insert([
            'NomeDisciplina' => $request->input('NomeDisciplina')
        ]);
    } catch (\Exception $e) {
        // Ignora erro de inserção no banco local mockado
    }
    return redirect('/coordenacao/disciplinas/disciplina_inf');
});

Route::post('/coordenacao/disciplina_editar/{id}', function (\Illuminate\Http\Request $request, $id) {
    try {
        \DB::table('tb_disciplinas')->where('idDisciplinas', $id)->update([
            'NomeDisciplina' => $request->input('NomeDisciplina')
        ]);
    } catch (\Exception $e) {
        // Ignora erro
    }
    return redirect('/coordenacao/disciplinas/disciplina_inf');
});

// Gravar/Editar Turma
Route::post('/coordenacao/cadturma', function (\Illuminate\Http\Request $request) {
    try {
        $mensalidade = (float) str_replace([',', ' ', 'R$', 'r$'], ['.', '', '', ''], $request->input('Mensalidade'));
        \DB::table('tb_turmas')->insert([
            'NomeTurma' => $request->input('NomeTurma'),
            'Mensalidade' => $mensalidade,
            'SituacaoTurma' => $request->input('SituacaoTurma'),
            'AnoLetivo' => $request->input('AnoLetivo'),
        ]);
    } catch (\Exception $e) {
        // Ignora
    }
    return redirect('/coordenacao/turma/turma_inf');
});

Route::post('/coordenacao/editar_turma/{id}', function (\Illuminate\Http\Request $request, $id) {
    try {
        $mensalidade = (float) str_replace([',', ' ', 'R$', 'r$'], ['.', '', '', ''], $request->input('Mensalidade'));
        \DB::table('tb_turmas')->where('idTurmas', $id)->update([
            'NomeTurma' => $request->input('NomeTurma'),
            'Mensalidade' => $mensalidade,
            'SituacaoTurma' => $request->input('SituacaoTurma'),
            'AnoLetivo' => $request->input('AnoLetivo'),
        ]);
    } catch (\Exception $e) {
        // Ignora
    }
    return redirect('/coordenacao/turma/turma_inf');
});

Route::get('/coordenacao/{pasta}/{pagina}', function ($pasta, $pagina) {
    $viewName = "telasCoordenacao.{$pasta}.{$pagina}";
    if (view()->exists($viewName)) {
        return view($viewName);
    }
    
    $title = ucwords(str_replace(['_', '-'], ' ', $pagina));
    return view('telasCoordenacao.construcao', compact('title'));
})->name('coordenacao.pagina');
