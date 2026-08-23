<?php

// Esse controle possue todos os metodos para a emissão de relatórios do sistema modulo coordenação

namespace App\Http\Controllers\controleCoordenacao;

use App;
use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_endereco;
use App\Models\modelCoordenacao\tb_pais;
use App\Models\modelCoordenacao\tb_notas;
use App\Models\modelCoordenacao\tb_turmas_disciplinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\controleCoordenacao\cont_relatorios;
//INICIO DA CLASSE CONTROLE DAS DECLARAÇÕES
class cont_boletins extends Controller {

    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_endereco;
    private $tb_turma;
    private $tb_pais;
    private $tb_matricula;
    private $tb_escola;
    private $tb_notas;

    public function __construct(Request $dadosForm, tb_notas $tb_notas, tb_escola $tb_escola, tb_matricula $tb_matricula, tb_pais $tb_pais, tb_aluno $tb_aluno, tb_endereco $tb_endereco, tb_turma $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_endereco;
        $this->tb_turma = $tb_turma;
        $this->tb_pais = $tb_pais;
        $this->tb_matricula = $tb_matricula;
        $this->tb_escola = $tb_escola;
        $this->tb_notas= $tb_notas;
    }

//Metodo chama a view principal para solicitar o boletim do aluno
    public function index() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_aluno::listagemAluno();
        return view('telasCoordenacao.boletins.boletins', compact('Alunos', 'turmas'));
    }

 
    //Metodo pesquisar aluno por palavra chave
    public function boletim_pesq() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesquisar($palavrachave);
        return view('telasCoordenacao.boletins.boletim_pesq', compact('Alunos', 'turmas'));
    }
     
    //Metodo pesquisar aluno por filtro de turma
    public function boletim_filtro() {
        $idTurma = $this->request->get('idTurmas');
        $turmas = tb_turma::turmasAtivas();
        if ($idTurma == null) {
           
        }
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        return view('telasCoordenacao.boletins.boletins', compact('Alunos', 'turmas'));
    }

    
    
    // Metodo que gera o boletim do aluno
    
    public function boletim($idAluno){
        $aluno = $this->tb_aluno->find($idAluno);
        if (!$aluno) {
            return redirect('/coordenacao/boletins/boletins')->with('error', 'Aluno não encontrado.');
        }
        $turma = $aluno->turmaAluno;
        if (!$turma) {
            return redirect('/coordenacao/boletins/boletins')->with('error', 'Turma não vinculada ao aluno.');
        }

        $escolas = tb_escola::informacaoEscolar();
        $matricula = $aluno->matriculaAluno;
        $dia = date('Y');
        $Pais = $aluno->paisAluno;
        $idTurmas = $turma->idTurmas;    
        $anoletivo = \DB::table('tb_turmas')->where('idTurmas', $idTurmas)->get();
        $disciplinas = tb_turmas_disciplinas::disciplinaTurma($idTurmas);
        $notasgraficos = tb_notas::busca_notas_do_aluno_grafico($idAluno);
        $titulo = 'Boletim Escolar: ';

        $nivel = cont_relatorios::determinarNivelTurma($turma->NomeTurma ?? '');
        
        if ($nivel === 'inf') {
            return view('telasCoordenacao.boletins.boletim_inf', compact('turma', 'aluno', 'Pais', 'matricula', 'disciplinas', 'notasgraficos', 'titulo', 'escolas', 'anoletivo'));
        } else if ($nivel === 'fun2') {
            return view('telasCoordenacao.boletins.boletim_fun2', compact('turma', 'aluno', 'Pais', 'matricula', 'disciplinas', 'notasgraficos', 'titulo', 'escolas', 'anoletivo'));
        } else {
            return view('telasCoordenacao.boletins.boletim_fun1', compact('turma', 'aluno', 'Pais', 'matricula', 'disciplinas', 'notasgraficos', 'titulo', 'escolas', 'anoletivo'));
        }
    }

    
    
    /*coloquei aqui
    //Metodo RELATÓIO BIMESTRAL 1º BIMESTRE
    public function bimestre_1($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%Y', strtotime('today'));
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $idTurmas = $turma['idTurmas'];
        $anoletivo = tb_turma::infTurma($idTurmas);
        //dd($anoletivo);
        $disciplinas = tb_turmas_disciplinas::disciplinaTurma($idTurmas);
        $quantidade_disciplinas = tb_turmas_disciplinas::QuantidadeDisciplinasNaTurma($idTurmas);
        $titulo = 'Boletim de Acompanhamento 1º Bimestre';
        $pdf = \App::make('dompdf.wrapper');
        if ($quantidade_disciplinas <= 7) {
            //return view('telasCoordenacao.relatorios.relatorio_inf_1bim', compact('turma', 'aluno', 'matricula', 'disciplinas', 'titulo','escolas','dia','anoletivo' ));
            $pdf->loadHTML(view('telasCoordenacao.relatorios.relatorio_inf_1bim', compact('turma', 'aluno', 'matricula', 'disciplinas', 'titulo', 'escolas', 'dia', 'anoletivo')));
            return $pdf->stream();
        } else if ($quantidade_disciplinas <= 17) {
            return view('telasCoordenacao.relatorios.relatorio_fun1_1bim', compact('turma', 'aluno', 'matricula', 'disciplinas', 'titulo', 'escolas', 'dia', 'anoletivo'));
        } else if ($quantidade_disciplinas > 17) {
            return view('telasCoordenacao.relatorios.relatorio_fun2_1bim', compact('turma', 'aluno', 'matricula', 'disciplinas', 'titulo', 'escolas', 'dia', 'anoletivo'));
        }
    }
*/
// Chava da class principal  
}
