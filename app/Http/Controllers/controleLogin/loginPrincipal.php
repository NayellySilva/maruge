<?php

namespace App\Http\Controllers\controleLogin;

use Illuminate\Http\Request;
use App\Models\modelCoordenacao\tb_disciplina;
use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_funcionario;
use App\Models\modelCoordenacao\tb_usuario;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\loginPrincipalRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class loginPrincipal extends Controller {

    // Metodo que direciona ao painel da coordenacao
    public function coordenacaoIndex() {
        $quantDisciplina = tb_disciplina::quantDisciplinasCadastradas();
       // $quantAlunosCadastrados = tb_aluno::quantAlunosCadastrados();
        $quantAlunosCadastrados = tb_matricula::quantAlunosCadastrados();
        $quantMatriculasAtivas = tb_matricula::quantMatriculasAtivas();
        $quantMatriculasInativas = tb_matricula::quantMatriculasInativas();
        $quantTurmasAtivas = tb_turma::turmasAtivas()->count();
        $quantFuncionariosCadastrados = tb_funcionario::funcionarioCadastrados()->count();
        $quantUsuarioCadastrados = tb_usuario::listagemUsuarios()->count();
        return view('telasCoordenacao.index', compact('quantDisciplina', 'quantAlunosCadastrados', 'quantMatriculasAtivas', 'quantMatriculasInativas', 'quantTurmasAtivas', 'quantFuncionariosCadastrados', 'quantUsuarioCadastrados'));
    }

    // Metodo que direciona ao painel do docente
    public function docenteIndex() {
        $idFuncionarios = null;
        if (auth()->guard('guardLogin')->check()) {
            $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
            $nomedeusuario = tb_usuario::infUsuario($CPFfuncionario);
            foreach ($nomedeusuario as $item) {
                $idFuncionarios = $item->idFuncionarios ?? $item['idFuncionarios'] ?? null;
            }
        }

        $quantTurmasDocente = $idFuncionarios ? \App\Models\modelDocente\tb_turma_docente::quantidadeDeTurmaDoProfessor($idFuncionarios)->count() : 0;
        $quantDisciplinaDocente = $idFuncionarios ? \App\Models\modelDocente\tb_disciplina_docente::quantidadeDeDisciplinasDoProfessor($idFuncionarios)->count() : 0;       
        $Alunos = $idFuncionarios ? \App\Models\modelDocente\tb_aluno_docente::AlunosdoProfessorTotal($idFuncionarios)->count() : 0;

        return view('telasDocente.index', compact('quantTurmasDocente','quantDisciplinaDocente','Alunos'));
    }

    // Metodo que direciona para tela de login
    public function login() {
        if (Auth::guard('guardLogin')->check()) {
            $nivelNormalizado = \App\Support\NivelUsuario::normalizar(Auth::guard('guardLogin')->user()->Nivel);
            if ($nivelNormalizado === 'docente') {
                return redirect('/docente');
            }
            return redirect('/');
        }

        return view('telasLogin.loginPrincipal');
    }

    /* Metodo de solicitacao de acesso, nesse metodos e validado o tipo de usuario 
      que esta solicitando o acesso e direcionado para a rota principal do mesmo.
     */

    public function postlogin(loginPrincipalRequest $inf_valores) {
        // atribuindo valores digitados para uma validação
        $validacao = ['CPFUsuario' => $inf_valores->get('CPF'), 'password' => $inf_valores->get('password')];

        if (Auth::guard('guardLogin')->attempt($validacao)) {  // Validando as informações.
            $Situacao = auth()->guard('guardLogin')->user()->Situacao; // Atribuindo o valor do campo situação para uma variavel

            if ($Situacao == "ATIVO") {
                request()->session()->regenerate();
                $nivelNormalizado = \App\Support\NivelUsuario::normalizar(auth()->guard('guardLogin')->user()->Nivel);

                if ($nivelNormalizado === 'coordenacao') {
                    // Só respeita a URL pretendida se for da área de coordenação
                    $intended = session()->pull('url.intended', '/');
                    $segura = $this->intendedPertenceAArea($intended, 'coordenacao');
                    return redirect($segura ? $intended : '/');
                } else if ($nivelNormalizado === 'docente') {
                    // Só respeita a URL pretendida se for da área do docente
                    $intended = session()->pull('url.intended', '/docente');
                    $segura = $this->intendedPertenceAArea($intended, 'docente');
                    return redirect($segura ? $intended : '/docente');
                } else {
                    auth()->guard('guardLogin')->logout();
                    request()->session()->invalidate();
                    request()->session()->regenerateToken();

                    return redirect('/login')
                                    ->withErrors(['SEMPERMISSOES' => 'Usuário sem Permissão!'])
                                    ->withInput();
                }
            } else {
                auth()->guard('guardLogin')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                return redirect('/login')
                                ->withErrors(['Inativo' => 'Usuário Inativo!'])
                                ->withInput();
            }
        } else {
            return redirect('/login')
                            ->withErrors(['ERRO-LOGIN' => 'CPF ou Senha Inválidos!'])
                            ->withInput();
        }
    }

    private function intendedPertenceAArea(?string $url, string $area): bool
    {
        if (!$url || str_starts_with($url, '//') || preg_match('/[\x00-\x1F\x7F]/', $url)) {
            return false;
        }

        $partes = parse_url($url);
        if ($partes === false || isset($partes['user']) || isset($partes['pass'])) {
            return false;
        }

        if (isset($partes['scheme']) || isset($partes['host'])) {
            if (!isset($partes['host']) || strcasecmp($partes['host'], request()->getHost()) !== 0) {
                return false;
            }
            if (isset($partes['scheme']) && strtolower($partes['scheme']) !== strtolower(request()->getScheme())) {
                return false;
            }
            if (isset($partes['port']) && $partes['port'] !== request()->getPort()) {
                return false;
            }
        }

        $path = $partes['path'] ?? '';
        if (preg_match('/%(?:2f|5c)/i', $path)) {
            return false;
        }

        $path = rawurldecode($path);
        if (str_contains($path, '\\') || preg_match('/(^|\/)\.\.?($|\/)/', $path)) {
            return false;
        }

        return ($area === 'coordenacao' && $path === '/')
            || $path === "/{$area}"
            || str_starts_with($path, "/{$area}/");
    }

    public function logout() {
        auth()->guard('guardLogin')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }
}
