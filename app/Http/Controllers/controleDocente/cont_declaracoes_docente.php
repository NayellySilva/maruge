<?php
// Esse controle possue todos os metodos para a emissão de declarações do sistema modulo coordenação
namespace App\Http\Controllers\controleDocente;
use App;
use App\Models\modelCoordenacao\tb_usuario;
use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//INICIO DA CLASSE CONTROLE DAS DECLARAÇÕES
class cont_declaracoes_docente extends Controller {

    private $request;
    private $tb_usuario;
    private $tb_funcionario;
    private $tb_escola;
  

    public function __construct(Request $dadosForm, tb_usuario $tb_usuario, tb_funcionario $tb_funcionario,tb_escola $tb_escola) {
        $this->request = $dadosForm;
        $this->tb_usuario = $tb_usuario;
        $this->tb_funcionario = $tb_funcionario;
        $this->tb_escola = $tb_escola;
    }

//Metodo Para Direcionar ao cadastro de um novo aluno
    public function index() {
// Pegando o CPF do usuario e buscando seus dados
$CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
           $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }   
        // Buscando o dia mes e ano 
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%d de %B de %Y', strtotime('today'));
        $titulo = 'Declaração do Funcionário';
        $Funcionario = tb_funcionario::declaracaoFuncionario($idFuncionarios);
        $escolas = tb_escola::informacaoEscolar();
        return view('telasDocente.declaracoes_funcionario', compact('Funcionario', 'dia', 'titulo','escolas'));
    }

    
    
    
    // Metodo pra imprimir declaração cursando
    public function cursando($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%d de %B de %Y', strtotime('today'));
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Aluno Cursando';
        // Gerando o PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_cursando', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
        return $pdf->stream();
    }
    // Metodo pra imprimir declaração apto
    public function apto($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%d de %B de %Y', strtotime('today'));
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
         $titulo = 'Aluno Apto';
        // Gerando o PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_apto', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
        return $pdf->stream();
    }
    // Metodo pra imprimir declaração transferencia
    public function transferencia ($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%d de %B de %Y', strtotime('today'));
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Aluno Transferido';
        // Gerando o PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_transferencia', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
        return $pdf->stream();
    }
    // Metodo pra imprimir declaração transferencia
    public function quitacao ($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%d de %B de %Y', strtotime('today'));
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Quitação';
        // Gerando o PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_quitacao', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
        return $pdf->stream();
    }
    // Metodo pra imprimir declaração transferencia
    public function inapto ($idAluno) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        // Buscando o dia mes e ano 
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%d de %B de %Y', strtotime('today'));
        // Informações sobre o aluno 
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Aluno Inapto';
        // Gerando o PDF
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML(view('telasCoordenacao.declaracoes.declaracoes_inapto', compact('titulo','escolas','dia','aluno','turma','matricula','pais')));
        return $pdf->stream();
    }
// Chava da class principal da classe
}
