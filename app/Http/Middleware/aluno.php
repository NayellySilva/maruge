<?php

//Middleware propria para os docentes, esse filtro tem que acompanha em todas as rotas que o docente tive direito

namespace App\Http\Middleware;

use Closure;

class aluno {

    public function handle($request, Closure $next) {
        $Nivel = auth()->guard('guardLoginAluno')->user()->Nivel; // Recuperando informaçao de nivel de acesso
        //dd($Nivel);
        if ($Nivel == "ALUNO") { // Condição para continuar com a solicitação da rota
            return $next($request); // Direcionando para a rota solicitada
        }
        return redirect('/loginaluno'); // Caso o nivel de acesso seja diferente , será direcionado para a tela de login
    }

}
