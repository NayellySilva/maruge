<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * API do calendário do painel (componente dashboard-calendar).
 *
 * Antes estas três ações eram closures dentro de routes/web.php.
 * O comportamento foi mantido; as mudanças são:
 *  - a consulta à BrasilAPI fica em cache por 1 dia (antes era feita a cada abertura do painel);
 *  - a Páscoa é calculada em PHP puro (easter_date() exige a extensão "calendar",
 *    que nem sempre está instalada e derrubava a rota).
 */
class CalendarioController extends Controller
{
    private const ARQUIVO_EVENTOS = 'app/eventos.json';

    /** GET /api/feriados?ano=2026 */
    public function feriados(Request $request): JsonResponse
    {
        $ano = (int) $request->query('ano', date('Y'));
        if ($ano < 1970 || $ano > 2100) {
            $ano = (int) date('Y');
        }

        $mapa = [];

        // 1. Feriados nacionais via BrasilAPI (com cache de 1 dia)
        foreach ($this->feriadosBrasilApi($ano) as $data => $item) {
            $this->adicionar($mapa, $data, $item['name'], $item['type']);
        }

        // 2. Feriados nacionais fixos (garantia offline)
        $fixos = [
            ['01-01', 'Confraternização Universal', 'Feriado Nacional'],
            ['04-21', 'Tiradentes', 'Feriado Nacional'],
            ['05-01', 'Dia do Trabalho', 'Feriado Nacional'],
            ['09-07', 'Independência do Brasil', 'Feriado Nacional'],
            ['10-12', 'Nossa Senhora Aparecida / Dia das Crianças', 'Feriado Nacional'],
            ['11-02', 'Finados', 'Feriado Nacional'],
            ['11-15', 'Proclamação da República', 'Feriado Nacional'],
            ['11-20', 'Dia da Consciência Negra', 'Feriado Nacional'],
            ['12-25', 'Natal', 'Feriado Nacional'],
            // 3. Estaduais do Ceará
            ['03-19', 'Dia de São José (Padroeiro do Ceará)', 'Feriado Estadual'],
            ['03-25', 'Data Magna do Ceará', 'Feriado Estadual'],
            // 4. Escolares e datas comemorativas fixas
            ['10-15', 'Dia do Professor', 'Feriado Escolar'],
            ['08-11', 'Dia do Estudante', 'Data Comemorativa'],
            ['06-12', 'Dia dos Namorados', 'Data Comemorativa'],
        ];
        foreach ($fixos as [$mesDia, $nome, $tipo]) {
            $this->adicionar($mapa, sprintf('%04d-%s', $ano, $mesDia), $nome, $tipo);
        }

        // 5. Feriados móveis a partir da Páscoa
        $pascoa = $this->pascoa($ano);
        $moveis = [
            [-48, 'Segunda-feira de Carnaval', 'Feriado Escolar'],
            [-47, 'Terça-feira de Carnaval', 'Feriado Escolar'],
            [-46, 'Quarta-feira de Cinzas', 'Ponto Facultativo'],
            [-3,  'Quinta-feira Santa', 'Feriado Escolar'],
            [-2,  'Sexta-feira Santa (Paixão de Cristo)', 'Feriado Nacional'],
            [0,   'Páscoa', 'Data Comemorativa'],
            [60,  'Corpus Christi', 'Feriado Escolar'],
        ];
        foreach ($moveis as [$dias, $nome, $tipo]) {
            $this->adicionar($mapa, $pascoa->modify("{$dias} days")->format('Y-m-d'), $nome, $tipo);
        }

        // 6. Dia das Mães e dos Pais
        $this->adicionar($mapa, date('Y-m-d', strtotime("second sunday of May {$ano}")), 'Dia das Mães', 'Data Comemorativa');
        $this->adicionar($mapa, date('Y-m-d', strtotime("second sunday of August {$ano}")), 'Dia dos Pais', 'Data Comemorativa');

        // 7. Eventos cadastrados pela escola (sobrescrevem os demais na mesma data)
        foreach ($this->lerEventos() as $data => $evento) {
            if ((int) substr($data, 0, 4) === $ano) {
                $this->adicionar($mapa, $data, $evento['name'] ?? '', $evento['type'] ?? '', true);
            }
        }

        ksort($mapa);
        return response()->json(array_values($mapa));
    }

    /** POST /api/eventos */
    public function salvarEvento(Request $request): JsonResponse
    {
        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'name' => 'required|string|max:100',
            'type' => 'required|string|max:50',
        ]);

        $eventos = $this->lerEventos();
        $eventos[$request->date] = ['name' => $request->name, 'type' => $request->type];
        $this->gravarEventos($eventos);

        return response()->json(['success' => true]);
    }

    /** DELETE /api/eventos */
    public function excluirEvento(Request $request): JsonResponse
    {
        $request->validate(['date' => 'required|date_format:Y-m-d']);

        $eventos = $this->lerEventos();
        if (isset($eventos[$request->date])) {
            unset($eventos[$request->date]);
            $this->gravarEventos($eventos);
        }

        return response()->json(['success' => true]);
    }

    // ------------------------------------------------------------------

    private function adicionar(array &$mapa, string $data, string $nome, string $tipo, bool $custom = false): void
    {
        if (!$custom && isset($mapa[$data])) {
            return; // a primeira fonte prevalece, exceto eventos da escola
        }
        $p = explode('-', $data);
        if (count($p) !== 3) {
            return;
        }
        $mapa[$data] = [
            'day' => (int) $p[2],
            'month' => (int) $p[1] - 1,
            'year' => (int) $p[0],
            'name' => $nome,
            'type' => $tipo,
            'custom' => $custom,
        ];
    }

    private function feriadosBrasilApi(int $ano): array
    {
        return Cache::remember("feriados_brasilapi_{$ano}", now()->addDay(), function () use ($ano) {
            try {
                $resposta = Http::timeout(3)->get("https://brasilapi.com.br/api/feriados/v1/{$ano}");
                if (!$resposta->successful() || !is_array($resposta->json())) {
                    return [];
                }
                $lista = [];
                foreach ($resposta->json() as $item) {
                    if (isset($item['date'], $item['name'])) {
                        $lista[$item['date']] = [
                            'name' => $item['name'],
                            'type' => ($item['type'] ?? '') === 'national' ? 'Feriado Nacional' : ($item['type'] ?? 'Feriado'),
                        ];
                    }
                }
                return $lista;
            } catch (\Throwable $e) {
                return []; // sem internet: usa só as datas locais
            }
        });
    }

    /** Domingo de Páscoa (algoritmo de Meeus/Jones/Butcher), sem depender da extensão calendar. */
    private function pascoa(int $ano): \DateTimeImmutable
    {
        $a = $ano % 19;
        $b = intdiv($ano, 100);
        $c = $ano % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $mes = intdiv($h + $l - 7 * $m + 114, 31);
        $dia = (($h + $l - 7 * $m + 114) % 31) + 1;

        return new \DateTimeImmutable(sprintf('%04d-%02d-%02d', $ano, $mes, $dia));
    }

    private function lerEventos(): array
    {
        $caminho = storage_path(self::ARQUIVO_EVENTOS);
        if (!is_file($caminho)) {
            return [];
        }
        $dados = json_decode((string) file_get_contents($caminho), true);
        return is_array($dados) ? $dados : [];
    }

    private function gravarEventos(array $eventos): void
    {
        $caminho = storage_path(self::ARQUIVO_EVENTOS);
        if (!is_dir(dirname($caminho))) {
            mkdir(dirname($caminho), 0755, true);
        }
        file_put_contents($caminho, json_encode($eventos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }
}
