<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Exibe o painel principal (dashboard) com métricas consolidadas.
     */
    public function index(): View
    {
        $counters = $this->dashboardService->getCounters();
        $chartMatriculas = $this->dashboardService->getMonthlyEnrollments();
        $grades = $this->dashboardService->getClassGradeAverages();
        $chartMensalidades = $this->dashboardService->getTuitionStatus();

        return view('welcome', array_merge($counters, [
            'chartMatriculas' => $chartMatriculas,
            'chartNotasLabels' => $grades['labels'],
            'chartNotasValues' => $grades['values'],
            'chartMensalidades' => $chartMensalidades,
        ]));
    }

    /**
     * Retorna os aniversariantes do mês em formato JSON.
     */
    public function aniversariantes(Request $request): JsonResponse
    {
        $targetMonth = (int)$request->query('month', (int)date('n') - 1);
        $aniversariantes = $this->dashboardService->getBirthdaysByMonth($targetMonth);

        // Informa ao card quantos funcionários ativos ainda estão sem data de nascimento
        $pendencias = $this->dashboardService->getFuncionariosSemDataNascimento();

        return response()->json($aniversariantes, 200, [
            'X-Funcionarios-Coluna-Nascimento' => $pendencias['coluna'] ? '1' : '0',
            'X-Funcionarios-Sem-Data' => (string) $pendencias['sem_data'],
        ], JSON_INVALID_UTF8_SUBSTITUTE);
    }
}
