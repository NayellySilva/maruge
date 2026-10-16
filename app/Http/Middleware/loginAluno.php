<?php
namespace App\Http\Middleware;
use Closure;

use Illuminate\Support\Facades\Auth;
class loginAluno {
    /*
      | Classe de autenticação, Antes de cada redirecionamento a classe
      | é chamada para verificar se o usuario tem permisão para
      | o acesso, caso não tenha permisão é direcionado para o diretorio de login
     */

public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('loginaluno');
            }
        }
        return $next($request);
    }

}