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
    
    $holidays = [];

    try {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Accept' => 'application/json, text/event-stream',
            'Content-Type' => 'application/json'
        ])->post('https://mcp.feriadosapi.com/api/mcp', [
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
                    
                    // Match DD/MM/YYYY — Name (Type) or similar patterns
                    preg_match_all('/(\d{2})\/(\d{2})\/(\d{4})\s*(?:—|–|â€”|-)\s*([^\n(]+)(?:\(([^)]+)\))?/', $contentText, $matches, PREG_SET_ORDER);
                    
                    foreach ($matches as $match) {
                        $day = (int)$match[1];
                        $month = (int)$match[2] - 1; // 0-indexed month for JS compatibility
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
        // Fallback to empty list or proceed to custom events
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

Route::get('/coordenacao/{pagina}', function ($pagina) {
    $viewName = "telasCoordenacao.{$pagina}";
    if (view()->exists($viewName)) {
        return view($viewName);
    }
    
    $title = ucwords(str_replace(['_', '-'], ' ', $pagina));
    return view('telasCoordenacao.construcao', compact('title'));
})->name('coordenacao.pagina');
