<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_endereco;
use App\Models\modelCoordenacao\tb_notas;
use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_turmas_disciplinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DO ALUNO
class cont_gabarito extends Controller {

    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_endereco;
    private $tb_turma;
    private $tb_escola;
    private $tb_notas;
    private $tb_matricula;

    public function __construct(Request $dadosForm, tb_matricula $tb_matricula, tb_escola $tb_escola, tb_aluno $tb_aluno, tb_notas $tb_notas, tb_endereco $tb_endereco, tb_turma $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_endereco;
        $this->tb_turma = $tb_turma;
        $this->tb_escola = $tb_escola;
        $this->tb_notas = $tb_notas;
        $this->tb_matricula = $tb_matricula;
    }
// Metodo para busca as turmas ativas cadastradas
    public function index() {
        $turmas = tb_turma::listandoTurmasAtivas();
        return view('telasCoordenacao.gabaritos.gabaritos', compact('turmas'));
    }
//Metodo pesquisar turma por palavra chave
    public function gabarito_pesq() {
        $palavrachave = $this->request->get('pesquisar');
        $turmas = tb_turma::pesquisar($palavrachave);
        return view('telasCoordenacao.gabaritos.gabarito_pesq', compact('turmas'));
    }
//Metodo pesquisar turma por filtro Situação
    public function gabarito_filtro() {
        $SituacaoTurma = $this->request->get('SituacaoTurma');
        if ($SituacaoTurma == null) {
            return redirect('/coordenacao/gabarito');
        }
        $turmas = tb_turma::filtroporSituacaoTurma($SituacaoTurma);
        return view('telasCoordenacao.gabaritos.gabarito_filtro', compact('turmas'));
    }
           public function gabarito_08 ($idTurmas){           
        // Dados para forma o timbre (cabeçario)  
       $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
       setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
       date_default_timezone_set('America/Sao_Paulo');
       $dia = date('d/m/Y');
       $mes = date('d / m / y');
       $titulo = 'Gabaritos';
       $turma = $this->tb_turma->find($idTurmas);
       $idTurma = $idTurmas;
       $Alunos = tb_aluno::alunosPorTurma($idTurma);
       return view('telasCoordenacao.gabaritos.gabarito_08', compact('titulo','escolas','mes','turma','Alunos'));
       }
        public function gabarito_10 ($idTurmas){           
        // Dados para forma o timbre (cabeçario)  
       $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
       setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
       date_default_timezone_set('America/Sao_Paulo');
       $dia = date('d/m/Y');
       $mes = date('d / m / y');
       $titulo = 'Gabaritos';
       $turma = $this->tb_turma->find($idTurmas);
       $idTurma = $idTurmas;
       $Alunos = tb_aluno::alunosPorTurma($idTurma);
       return view('telasCoordenacao.gabaritos.gabarito_10', compact('titulo','escolas','mes','turma','Alunos'));
       }
// Chava da class principal  
}
