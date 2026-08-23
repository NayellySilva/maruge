<?php

namespace App\Http\Controllers\controleCoordenacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\loginPrincipalRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class navegacaoCoordenacao extends Controller {

    // Metodo que direciona a página de cadastrar(principal)
    public function cadastrar() {
        return view('telasCoordenacao.cadastrar');
    }
    // Metodo que direciona a página de secretaria
    public function secretaria() {
        return view('telasCoordenacao.secretaria');
    }
    // Metodo que direciona a página de relatorios
    public function relatorios() {
        return view('telasCoordenacao.relatorios.relatorios');
    }
    // Metodo que direciona a página do financeiro
    public function financeiro() {
        return view('telasCoordenacao.financeiro.financeiro');
    }
     //Metodo Para Direcionar o usuario para pagina de ajuda
    public function ajuda() {
        $titulo = 'Ajuda';
        return view('telasCoordenacao.ajuda', compact('titulo'));
    }
}