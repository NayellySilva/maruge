<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_endereco;
use App\Models\modelCoordenacao\tb_disciplina;
use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_funcionario;
use App\Models\modelCoordenacao\tb_usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DA ESCOLA
class cont_escola extends Controller {

    private $request;
    private $validator;
    private $tb_escola;
    private $tb_endereco;

    public function __construct(Request $dadosForm, tb_escola $tb_escola, tb_endereco $tb_endereco, tb_disciplina $tb_disciplina, tb_aluno $tb_aluno, tb_matricula $tb_matricula, tb_turma $tb_turma, tb_funcionario $tb_funcionario, tb_usuario $tb_usuario, Validator $validator) {

        $this->request = request();
        $this->validator = $validator;
        $this->tb_escola = $tb_escola;
        $this->tb_endereco = $tb_endereco;
        $this->tb_disciplina = $tb_disciplina;
        $this->tb_aluno = $tb_aluno;
        $this->tb_matricula = $tb_matricula;
        $this->tb_turma = $tb_turma;
        $this->tb_funcionario = $tb_funcionario;
        $this->tb_usuario = $tb_usuario;
    }

//Metodo Para Direcionar ao cadastro de Escola (FormEscola)
    public function novaescola() {
        return view('telasCoordenacao.escola.escola_cad');
    }

//Metodo para salva uma nova escola
    public function postnovaescola() {
        $dadosForm = request()->all();
        $validando = Validator::make($dadosForm, tb_escola::$camposObg);
        if ($validando->fails()) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->withErrors($validando)->withInput();
            }
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $escola = tb_escola::count();
        if ($escola >= 1) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/escola/escola_inf')->with('error', 'Desculpe, já existe uma escola cadastrada!');
            }
            return 'escolaExistente';
        } else {
            $novoEndereco = new tb_endereco($dadosForm);
            $novoEndereco->save();
            $novaEscola = new tb_escola($dadosForm);
            if (empty($novaEscola->NumeroInep)) {
                $novaEscola->NumeroInep = $dadosForm['NumeroInep'] ?? $dadosForm['INEP'] ?? $dadosForm['Inep'] ?? '00000000';
            }
            $novaEscola->tb_endereco_idEndereco = $novoEndereco->idEndereco;
            $novaEscola->save();
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/escola/escola_inf')->with('success', 'Escola cadastrada com sucesso!');
            }
            return 1;
        }
    }

// Metodo para busca valores da tabela do bando de dados:    
    public function escola_inf() {
        $escolas = tb_escola::informacaoEscolar();
        return view('telasCoordenacao.escola.escola_inf', compact('escolas'));
    }

//Metodo que busca os dados para edição e direciona ao seu formulario.
    public function editar($idEscola) {
        $escolas = $this->tb_escola->find($idEscola);
        $endereco = $escolas ? $escolas->endEscola : null;
        $titulo = 'Editar dados da escola';
        return view('telasCoordenacao.escola.escola_cad', compact('escolas', 'endereco', 'titulo'));
    }

// Metodo para vizualizar informações da escola
    public function perfil($idEscola) {
        $escolas = $this->tb_escola->find($idEscola);
        $idEndereco = $escolas ? $escolas->tb_endereco_idEndereco : null;
        $endereco = $idEndereco ? $this->tb_endereco->find($idEndereco) : null;
        return view('telasCoordenacao.escola.escola_vis', compact('escolas', 'endereco'));
    }

// Metodo que realizar o update com os novos dados
    public function editando($idEscola) {
        $dadosForm = request()->all();
        $validando = Validator::make($dadosForm, tb_escola::$camposObg);
        if ($validando->fails()) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->withErrors($validando)->withInput();
            }
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $escolas = $this->tb_escola->find($idEscola);
        if ($escolas) {
            $escolas->update($dadosForm);
            $idEndereco = $escolas->tb_endereco_idEndereco;
            $endereco = $this->tb_endereco->find($idEndereco);
            if ($endereco) {
                $endereco->update($dadosForm);
            }
        }
        if (!request()->ajax() && !request()->wantsJson()) {
            return redirect('/coordenacao/escola/escola_inf')->with('success', 'Dados da escola atualizados com sucesso!');
        }
        return 'EscolaAtualizada';
    }

    // Metodo que Gera o PDF da Ficha completa da Escola
    public function impressao($idEscola) {

        // Dados para forma o timbre (cabeçario)  
        $escolas = $this->tb_escola->find($idEscola);
        $idEndereco = $escolas->tb_endereco_idEndereco;
        $endereco = $this->tb_endereco->find($idEndereco);
        // Informações escolar como quantidade de alunos ativos e inativos, professores , disciplinas.
        $quantDisciplina = tb_disciplina::quantDisciplinasCadastradas();
        $quantAlunosCadastrados = tb_aluno::quantAlunosCadastrados();
        $quantMatriculasAtivas = tb_matricula::quantMatriculasAtivas();
        $quantMatriculasInativas = tb_matricula::quantMatriculasInativas();
        $quantTurmasAtivas = tb_turma::turmasAtivas()->count();
        $quantFuncionariosCadastrados = tb_funcionario::funcionarioCadastrados()->count();
        $quantUsuarioCadastrados = tb_usuario::listagemUsuarios()->count();
        // Gerando o PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('telasCoordenacao.escola.escola_imp', compact('escolas', 'endereco', 'quantDisciplina', 'quantAlunosCadastrados', 'quantMatriculasAtivas', 'quantMatriculasInativas', 'quantTurmasAtivas', 'quantFuncionariosCadastrados', 'quantUsuarioCadastrados')));
        return $pdf->stream();
    }

    //FIM DA CLASSE CONTROLE DA ESCOLA  
}
