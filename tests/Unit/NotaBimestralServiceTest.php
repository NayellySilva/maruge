<?php

namespace Tests\Unit;

use App\Services\NotaBimestralService;
use InvalidArgumentException;
use Tests\TestCase;

class NotaBimestralServiceTest extends TestCase
{
    private NotaBimestralService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new NotaBimestralService();
    }

    public function test_recovery_replaces_only_an_insufficient_average(): void
    {
        $this->assertSame(7.5, $this->service->calcularMediaFinal(5.5, 7.5));
        $this->assertSame(5.5, $this->service->calcularMediaFinal(5.5, 5.5));
        $this->assertSame(8.0, $this->service->calcularMediaFinal(8.0, 9.5));
    }

    public function test_recovery_is_enabled_only_below_minimum(): void
    {
        $this->assertTrue($this->service->deveHabilitarRecuperacao(6.9));
        $this->assertFalse($this->service->deveHabilitarRecuperacao(7.0));
        $this->assertFalse($this->service->deveHabilitarRecuperacao(null));
    }

    public function test_partial_average_ignores_empty_assessments(): void
    {
        $this->assertSame(7.5, $this->service->calcularMediaParcial([7, null, '', 8]));
    }

    public function test_final_average_uses_monthly_and_bimonthly_assessments(): void
    {
        $this->assertSame(8.0, $this->service->calcularMediaFinalComRecuperacao([10, 6], null));
        $this->assertSame(7.5, $this->service->calcularMediaFinalComRecuperacao([8, 4], 7));
        $this->assertSame(6.0, $this->service->calcularMediaFinalComRecuperacao([8, 4], 2));
    }

    public function test_bimonthly_payload_normalizes_values_and_removes_ineligible_recovery(): void
    {
        $payload = $this->service->normalizarFormularioBimestre([
            'tb_disciplinas_idDisciplinas' => [10, 11],
            'AB1' => ['8,0', '5'],
            'RB1' => ['9', '6,5'],
            'AM1' => ['7', '6'],
        ], 1);

        $this->assertSame(8.0, $payload['AB1'][0]);
        $this->assertNull($payload['RB1'][0]);
        $this->assertSame(6.5, $payload['RB1'][1]);
    }

    public function test_invalid_note_is_rejected(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->service->normalizarNota(11);
    }
}
