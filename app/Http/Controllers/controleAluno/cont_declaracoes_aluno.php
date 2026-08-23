<?php
// Esse controle possue todos os metodos para a emissão de declarações do sistema modulo coordenação
namespace App\Http\Controllers\controleAluno;
use App;
use App\Models\modelAluno\tb_escola_aluno;
use App\Models\modelAluno\tb_aluno_aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//INICIO DA CLASSE CONTROLE DAS DECLARAÇÕES
class cont_declaracoes_aluno extends Controller {
    private $request;
    private $tb_escola;
    public function __construct(Request $dadosForm,  tb_escola_aluno $tb_escola) {
        $this->request = $dadosForm;
        $this->tb_escola = $tb_escola;
    }    
    //Metodo que traz  pagina inicial das declarações 
    public function index(){
        $RA = auth()->guard('guardLoginAluno')->user()->RA; // Recuperando o RA do aluno para busca os resto de informações sobre ele
        $nomedoaluno = tb_aluno_aluno::infAluno($RA);   //Buscando nome e id desse usuario 
        return view('telasCoordenacao.declaracoes.declaracoes', compact('nomedoaluno'));       
    }
    // Metodo pra imprimir declaração cursando
    public function cursando($idAluno) {
    $escolas = tb_escola_aluno::informacaoEscolar();// Dados para forma o timbre (cabeçario)  
    setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');// Buscando o dia mes e ano 
    date_default_timezone_set('America/Sao_Paulo');
    $dia = strftime('%d de %B de %Y', strtotime('today'));
    $aluno = tb_aluno_aluno::perfilParaDeclaraçãoAluno($idAluno);// Informações sobre o aluno 
    $titulo = 'Aluno Cursando';
    return view('telasCoordenacao.declaracoes.declaracoes_cursando', compact('titulo','escolas','dia','aluno'));
    }

// Chava da class principal da classe
}
