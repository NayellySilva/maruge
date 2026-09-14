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

        return response()->json($aniversariantes, 200, [], JSON_INVALID_UTF8_SUBSTITUTE);
    }
}
