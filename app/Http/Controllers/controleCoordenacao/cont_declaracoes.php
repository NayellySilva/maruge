<?php
// Esse controle possue todos os metodos para a emissão de declarações do sistema modulo coordenação
namespace App\Http\Controllers\controleCoordenacao;
use App;
use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_endereco;
use App\Models\modelCoordenacao\tb_pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Jenssegers\Date\Date;

//INICIO DA CLASSE CONTROLE DAS DECLARAÇÕES
class cont_declaracoes extends Controller {

    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_endereco;
    private $tb_turma;
    private $tb_pais;
    private $tb_matricula;
    private $tb_escola;
 
    
 
    public function __construct(Request $dadosForm, tb_escola $tb_escola,  tb_matricula $tb_matricula, tb_pais $tb_pais, tb_aluno $tb_aluno, tb_endereco $tb_endereco, tb_turma $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_endereco;
        $this->tb_turma = $tb_turma;
        $this->tb_pais = $tb_pais;
        $this->tb_matricula = $tb_matricula;
        $this->tb_escola = $tb_escola;              
    }

//Metodo Para Direcionar ao cadastro de um novo aluno
    public function index() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_aluno::listagemAluno();
        return view('telasCoordenacao.declaracoes.declaracoes', compact('Alunos', 'turmas'));
    }

    //Metodo pesquisar aluno por filtro de turma para declarações
    public function declaracao_filtro() {
        $idTurma = $this->request->get('idTurmas');
        $turmas = tb_turma::turmasAtivas();
        if ($idTurma == null) {
            
        }
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        return view('telasCoordenacao.declaracoes.declaracoes', compact('Alunos', 'turmas'));
    }

    //Metodo pesquisar aluno por palavra chave para declarações
    public function declaracao_pesq() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesquisar($palavrachave);
        return view('telasCoordenacao.declaracoes.declaracoes_pesq', compact('Alunos', 'turmas'));
    }

    // Metodo pra imprimir declaração cursando
    public function cursando($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        $mes = cont_datas::mes();
        $dia = ' ' . Carbon::now()->format('d') . ' de '. $mes .' de ' . Carbon::now()->format('Y');    
         //$dia = Carbon::now()->formatLocalized('%A %d de %B de %Y');    
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
                    
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Aluno Cursando';
        
        return view('telasCoordenacao.declaracoes.declaracoes_cursando', compact('titulo','escolas','dia','aluno','turma','matricula','pais'));
        
                
              /*  
                // Gerando o PDF
        $pdf = \App::make('dompdf.wrapper');    
        $pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_cursando', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
        return $pdf->stream();
        
               */ 
                
      
        
    }

    // Metodo pra imprimir declaração apto
    public function apto($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        $mes = cont_datas::mes();
        $dia = ' ' . Carbon::now()->format('d') . ' de '. $mes .' de ' . Carbon::now()->format('Y');  
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
         $titulo = 'Aluno Apto';
       
         
return view('telasCoordenacao.declaracoes.declaracoes_apto', compact('titulo','escolas','dia','aluno','turma','matricula','pais'));


// Gerando o PDF
//        $pdf = \App::make('dompdf.wrapper');
 //       $pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_apto', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
 //       return $pdf->stream();
        
        
        
        
        
    }
    // Metodo pra imprimir declaração transferencia
    public function transferencia ($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        $mes = cont_datas::mes();
        $dia = Carbon::now()->format('d/m/Y');  
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Aluno Transferido';
       
         return view('telasCoordenacao.declaracoes.declaracoes_transferencia', compact('titulo','escolas','dia','aluno','turma','matricula','pais'));


// Gerando o PDF
      //  $pdf = \App::make('dompdf.wrapper');
     //   $pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_transferencia', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
     //   return $pdf->stream();
        
        
        
        
    }
    // Metodo pra imprimir declaração transferencia
    public function quitacao ($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        $mes = cont_datas::mes();
        $dia = ' ' . Carbon::now()->format('d') . ' de '. $mes .' de ' . Carbon::now()->format('Y');  
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Quitação';
        
        return view('telasCoordenacao.declaracoes.declaracoes_quitacao', compact('titulo','escolas','dia','aluno','turma','matricula','pais'));

        
        
        
        
        // Gerando o PDF
      //  $pdf = \App::make('dompdf.wrapper');
        //$pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_quitacao', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
       // return $pdf->stream();
    }
    // Metodo pra imprimir declaração transferencia
    public function inapto ($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        $mes = cont_datas::mes();
        $dia = ' ' . Carbon::now()->format('d') . ' de '. $mes .' de ' . Carbon::now()->format('Y');  
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Aluno Inapto';
        
        return      view('telasCoordenacao.declaracoes.declaracoes_inapto', compact('titulo','escolas','dia','aluno','turma','matricula','pais'));

        
        
      // Gerando o PDF
      //  $pdf = \App::make('dompdf.wrapper');
      //  $pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_inapto', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
      //  return $pdf->stream();
    }
// Chava da class principal da classe
}

// 
