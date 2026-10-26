<?php

namespace Tests\Unit;

use App\Http\Controllers\controleLogin\loginPrincipal;
use ReflectionMethod;
use Tests\TestCase;

class LoginIntendedUrlTest extends TestCase
{
    public function test_intended_url_must_belong_to_the_authenticated_area(): void
    {
        $controller = new loginPrincipal();
        $method = new ReflectionMethod($controller, 'intendedPertenceAArea');

        $this->assertTrue($method->invoke($controller, '/docente/notas', 'docente'));
        $this->assertFalse($method->invoke($controller, '/docenteevil', 'docente'));
        $this->assertFalse($method->invoke($controller, '//example.org/docente', 'docente'));
        $this->assertTrue($method->invoke($controller, '/', 'coordenacao'));
        $this->assertFalse($method->invoke($controller, '/docente/notas', 'coordenacao'));
    }
}
