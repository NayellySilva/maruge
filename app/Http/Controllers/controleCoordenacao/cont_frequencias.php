<?php
namespace App\Http\Controllers\controleCoordenacao;
use App;
use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_frequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\modelCoordenacao\tb_escola;

// Controle (metodos) do modulo turma.
class cont_frequencias extends Controller {

    private $request;
    private $validator;
    private $tb_turma;
    private $tb_escola;
    private $tb_aluno;
    private $tb_frequencia;

    public function __construct(Request $dadosForm,tb_aluno $tb_aluno,tb_escola $tb_escola, tb_turma $tb_turma, tb_frequencia $tb_frequencia, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
        $this->tb_escola = $tb_escola;
        $this->tb_aluno = $tb_aluno;
        $this->tb_frequencia = $tb_frequencia;
    }
//Metodo Para Direcionar página inicial das frequencias
    public function index() {  
      $turmas = tb_turma::listandoTurmasAtivas();
      $turmasSelecte = tb_turma::listandoTurmasAtivasNoSelect();
      return view('telasCoordenacao.frequencia.frequencias', compact('turmas','turmasSelecte'));   
    }
    
    
    
    
    
    
    
    
       
    
//Metodo Para Direcionar página inicial das frequencias
    public function frequencia_relatorio($idTurma) { 
        
        $titulo = 'Relatório de Frequência';
        $escolas = tb_escola::informacaoEscolar();
        $turma = $this->tb_turma->find($idTurma);
        $alunos = tb_aluno::alunosPorTurma($idTurma);
        

        
        $frequencias = tb_frequencia::buscandoFrequenciadoAluno($idTurma);
        
        
    return view('telasCoordenacao.frequencia.frequencia_relatorio', compact('titulo','escolas','turma','alunos','frequencias'));   
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
      //Metodo pesquisar uma turma por palavra chave
    public function frequencias_pesq() {
        $palavrachave = $this->request->get('pesquisar');
        $turmas = tb_turma::pesquisar($palavrachave);
        $turmasSelecte = tb_turma::listandoTurmasAtivasNoSelect();
        return view('telasCoordenacao.frequencia.frequencias', compact('turmas','turmasSelecte'));
    }

    //Metodo pesquisar frequencias da turma por filtro Turma
    public function frequencias_filtro() {
        $idTurmas = $this->request->get('idTurmas');
        if ($idTurmas == null) {
            return redirect('/coordenacao/frequencias');
        }   
        $turmas = tb_turma::filtroporidTurmas($idTurmas);
        $turmasSelecte = tb_turma::listandoTurmasAtivasNoSelect();
        return view('telasCoordenacao.frequencia.frequencias', compact('turmas','turmasSelecte'));
    }
    
    // Metodo que exibe a frequencia mensal de uma determinada turma
    
    public function frequencia_virtual ($idTurmas){
        $escolas = tb_escola::informacaoEscolar();
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $ano = strftime('%Y', strtotime('today'));
        $inf_dia = strftime('%d %B de %Y', strtotime('today'));
        $titulo = 'Frequência';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        $alunos = $Alunos;
        return view('telasCoordenacao.frequencia.frequencia_virtual', compact('titulo','escolas','ano','inf_dia','turma','Alunos','alunos'));
    }

    public function postnovafrequencia() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["RA"] ?? []);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["RA"][$i])) {
                tb_frequencia::salvandoFrequencia($dadosForm);
                $turmas = tb_turma::listandoTurmasAtivas();
                $turmasSelecte = tb_turma::listandoTurmasAtivasNoSelect();
                return view('telasCoordenacao.frequencia.frequencias', compact('turmas','turmasSelecte'));
            }
        }
        return redirect('/coordenacao/frequencia/frequencias')->with('success', 'Frequência registrada com sucesso!');
    }

    public function frequencia_mensal ($idTurmas){
        $escolas = tb_escola::informacaoEscolar();
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%d %B de %Y', strtotime('today'));
        $mes = date('m /y');
        $titulo = 'Frequencia Mensal';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        $alunos = $Alunos;
        return view('telasCoordenacao.frequencia.frequencia_mensal', compact('titulo','escolas','mes','turma','Alunos','alunos'));
    }

    public function frequencia_edfisica ($idTurmas){
        $escolas = tb_escola::informacaoEscolar();
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime(' %B de %Y', strtotime('today'));   
        $mes = date('m /y');
        $titulo = 'Frequencia Ed.Física';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        $alunos = $Alunos;
        return view('telasCoordenacao.frequencia.frequencia_edfisica', compact('titulo','dia','mes','escolas','turma','Alunos','alunos'));
    }

    public function frequencia_entrega ($idTurmas){
        $escolas = tb_escola::informacaoEscolar();
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%B de %Y', strtotime('today'));
        $mes = date('m /y');
        $titulo = 'Frequencia Entrega';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        $alunos = $Alunos;
        return view('telasCoordenacao.frequencia.frequencia_entrega', compact('titulo','dia','mes','escolas','turma','Alunos','alunos'));
    }   
//FIM DA CLASSE CONTROLE DA TURMA 
}
