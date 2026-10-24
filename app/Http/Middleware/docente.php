<?php

//Middleware propria para os docentes, acompanha todas as rotas que exigem nível docente

namespace App\Http\Middleware;

use Closure;
use App\Support\NivelUsuario;

class docente {

    public function handle($request, Closure $next) {
        if (!auth()->guard('guardLogin')->check()) {
            return redirect('/login');
        }

        $nivel = NivelUsuario::normalizar(auth()->guard('guardLogin')->user()->Nivel);

        if ($nivel === 'docente') {
            return $next($request);
        }

        // Usuário logado mas com nível errado → manda para a área correta (sem loop)
        if ($nivel === 'coordenacao') {
            return redirect('/');
        }

        // Nível desconhecido → desloga e notifica
        auth()->guard('guardLogin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->withErrors(['SEMPERMISSOES' => 'Usuário sem Permissão!']);
    }

}
