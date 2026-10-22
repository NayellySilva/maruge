<?php

namespace App\Http\Controllers\controleDocente;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class navegacaoDocente extends Controller {

    // Metodo que direciona a página principal do docente
    public function cadastrar() {
        return redirect('/docente');
    }

    // Metodo que direciona a página de secretaria
    public function secretaria() {
        return view('telasDocente.secretaria');
    }

    // Metodo que direciona a página de relatorios
    public function relatorios() {
        return view('telasDocente.relatorios.relatorios');
    }

    // Metodo Para Direcionar o usuario para pagina de ajuda
    public function ajuda() {
        $titulo = 'Central de Ajuda';
        return view('telasDocente.ajuda', compact('titulo'));
    }
}