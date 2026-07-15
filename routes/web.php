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

Route::get('/coordenacao/{pagina}', function ($pagina) {
    $viewName = "telasCoordenacao.{$pagina}";
    if (view()->exists($viewName)) {
        return view($viewName);
    }
    
    $title = ucwords(str_replace(['_', '-'], ' ', $pagina));
    return view('telasCoordenacao.construcao', compact('title'));
})->name('coordenacao.pagina');
