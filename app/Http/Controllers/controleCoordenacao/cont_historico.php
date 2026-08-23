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
use App\Models\modelCoordenacao\tb_turmas_disciplinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//INICIO DA CLASSE CONTROLE DAS DECLARAÇÕES
class cont_historico extends Controller {
    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_endereco;
    private $tb_turma;
    private $tb_turmas_disciplinas;
    private $tb_pais;
    private $tb_matricula;
    private $tb_escola;
    public function __construct(Request $dadosForm, tb_escola $tb_escola, 
            tb_matricula $tb_matricula, tb_pais $tb_pais, tb_aluno $tb_aluno, tb_endereco $tb_endereco, tb_turma $tb_turma, tb_turmas_disciplinas $tb_turmas_disciplinas, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_endereco;
        $this->tb_turma = $tb_turma;
        $this->tb_turmas_disciplinas = $tb_turmas_disciplinas;
        $this->tb_pais = $tb_pais;
        $this->tb_matricula = $tb_matricula;
        $this->tb_escola = $tb_escola;
    }
//Metodo chama a view principal para solicitar o boletim do aluno
    public function index() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_aluno::listagemAluno();
        return view('telasCoordenacao.historico.historico', compact('Alunos', 'turmas'));
    }
    //Metodo pesquisar aluno por palavra chave
    public function historico_pesq() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesquisar($palavrachave);
        return view('telasCoordenacao.historico.historico_pesq', compact('Alunos', 'turmas'));
    }
    //Metodo pesquisar aluno por filtro de turma
    public function historico_filtro() {
        $idTurma = $this->request->get('idTurmas');
        $turmas = tb_turma::turmasAtivas();
        if ($idTurma == null) {
        }
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        return view('telasCoordenacao.historico.historico', compact('Alunos', 'turmas'));
    }    
    // Metodo que gera o boletim do aluno
    public function historico($idAluno){
         // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $DataNascimento = $aluno->DataNascimento;
        $CidadeCartorio = $aluno->CidadeCartorio;
        $turma = $aluno->turmaAluno;
        $Pais = $aluno->paisAluno;     
        $idTurmas = $turma['idTurmas'];
        $Ano2016 = $this->tb_turma->turma2016($idAluno);
        $Ano2017 = $this->tb_turma->turma2017($idAluno);
        $anoletivo = tb_turma::infTurma($idTurmas);
        
    //dd($anoletivo);
        
        
        $disciplinas2016 = $this->tb_turmas_disciplinas->disciplinaTurma2016($idAluno);
        $disciplinas2017 = $this->tb_turmas_disciplinas->disciplinaTurma2017($idAluno);
        $disciplinas = tb_turmas_disciplinas::disciplinaTurma($idTurmas);

          
        
        $quantidade_disciplinas = tb_turmas_disciplinas::QuantidadeDisciplinasNaTurma($idTurmas);
        $titulo = 'Histórico Escolar:';
        
        
        
        
        
        
        if ($quantidade_disciplinas <= 7) {
            return view('telasCoordenacao.historico.historico_inf', compact('turma', 'aluno', 'Pais','Ano2016', 'Ano2017','disciplinas2016','disciplinas2017', 'disciplinas','CidadeCartorio', 'titulo', 'escolas', 'DataNascimento',  'anoletivo'));
        } else if ($quantidade_disciplinas <= 14) {
            return view('telasCoordenacao.historico.historico_fun1', compact('turma', 'aluno', 'Pais','Ano2016', 'Ano2017','disciplinas2016','disciplinas2017', 'disciplinas','CidadeCartorio', 'titulo', 'escolas', 'DataNascimento',  'anoletivo'));
        } else if ($quantidade_disciplinas > 14) {
            return view('telasCoordenacao.historico.historico_fun2', compact('turma', 'aluno', 'Pais','Ano2016', 'Ano2017','disciplinas2016','disciplinas2017', 'disciplinas','CidadeCartorio', 'titulo', 'escolas', 'DataNascimento',  'anoletivo'));
        }
    }
// Chava da class principal  
}