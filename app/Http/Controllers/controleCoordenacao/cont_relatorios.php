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
use App\Models\modelCoordenacao\tb_reserva;
use App\Models\modelCoordenacao\tb_notas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
//INICIO DA CLASSE CONTROLE DAS DECLARAÇÕES
class cont_relatorios extends Controller {
    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_endereco;
    private $tb_turma;
    private $tb_pais;
    private $tb_matricula;
    private $tb_escola;
    private $tb_reserva;
    private  $tb_notas;


    public function __construct(Request $dadosForm,tb_reserva $tb_reserva, tb_escola $tb_escola,tb_notas $tb_notas, tb_matricula $tb_matricula, tb_pais $tb_pais, tb_aluno $tb_aluno, tb_endereco $tb_endereco, tb_turma $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_endereco;
        $this->tb_turma = $tb_turma;
        $this->tb_pais = $tb_pais;
        $this->tb_matricula = $tb_matricula;
        $this->tb_escola = $tb_escola;
        $this->tb_reserva = $tb_reserva;
        $this->tb_notas = $tb_notas;
    }

//Metodo faz solicitação dos relatorios bimestrais dos alunos
    public function relatorios_bimestrais() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_aluno::listagemAluno();
        return view('telasCoordenacao.relatorios.relatorios_bimestrais', compact('Alunos', 'turmas'));
    }

//Metodo pesquisar aluno por filtro de turma
    public function relatorios_filtro() {
        $idTurma = $this->request->get('idTurmas');
        $turmas = tb_turma::turmasAtivas();
        if ($idTurma == null) {
            
        }
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        return view('telasCoordenacao.relatorios.relatorios_bimestrais', compact('Alunos', 'turmas'));
    }

    //Metodo pesquisar aluno por palavra chave
    public function relatorios_pesq() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesquisar($palavrachave);
        return view('telasCoordenacao.relatorios.relatorios_pesq', compact('Alunos', 'turmas'));
    }
//Metodo que gerar um relatório em pdf cos alunos matriculados
    public function alunosMatriculados() {
        $escolas = tb_escola::informacaoEscolar(); // Dados para forma o timbre (cabeçario)  
        $alunos = tb_aluno::alunoMatriculados(); // Buscando os alunos matriculados
        // Buscando o dia mes e ano 
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%d de %B de %Y', strtotime('today'));
        $titulo = 'Alunos Matriculados';
        // Gerando o PDF
        // $pdf = \App::make('dompdf.wrapper');
        //$pdf->loadHTML(view('telasCoordenacao.relatorios.relatorio_alunos_matriculados', compact('titulo','escolas','dia','alunos')));
        //return $pdf->stream();
        return view('telasCoordenacao.relatorios.relatorio_alunos_matriculados', compact('titulo', 'escolas', 'dia', 'alunos'));
    }
//Metodo que gerar um relatório em pdf cos alunos transferidos ou desistente (INATIVOS)
    public function alunosTransferidos() {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        $alunos = tb_aluno::alunoTransferidos();
        $titulo = 'Alunos Transferidos';
        return view('telasCoordenacao.relatorios.relatorio_alunos_transferidos', compact('titulo', 'escolas','alunos'));
    }
  // Metodo que lista as turmas ativas para solicitação de relatórios de alunos matriculados    
    public function listagem_turmas() {
        $turmas = tb_turma::relatorioTurmasAtivas();
        $turmas_Inativas = tb_turma::AnoLetivoTurmasInativas();
        return view('telasCoordenacao.relatorios.relatorio_alunos_turmas', compact('turmas','turmas_Inativas'));
    }
//Metodo que gerar um relatório de alunos por turma
    public function alunosPorTurma($idturmas = null) {
        if (!$idturmas) {
            $idturmas = request()->query('idTurmas') ?? request()->input('idTurmas');
        }
        if (!$idturmas) {
            $primeiraTurma = DB::table('tb_turmas')->first();
            $idturmas = $primeiraTurma ? $primeiraTurma->idTurmas : 1;
        }
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        $alunos = tb_aluno::alunosPorTurma($idturmas);
        $turma = $this->tb_turma->find($idturmas);
        $titulo = 'Alunos Por Turma';
        return view('telasCoordenacao.relatorios.relatorio_alunos_por_turma', compact('titulo', 'escolas', 'turma', 'alunos'));
    }
//Metodo que gerar um relatório em pdf com alunos e seus endereços
    public function alunosPorTurmaEndereco($idturmas) {
        
      
        
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola::informacaoEscolar();
        $alunos = tb_aluno::alunosPorTurmaEndereco($idturmas);
        $turma = $this->tb_turma->find($idturmas);
        $titulo = 'Alunos Por Turma';
        return view('telasCoordenacao.relatorios.relatorio_alunos_por_turma_endereco', compact('titulo', 'escolas', 'turma', 'alunos'));
    }
    
    
    
    
//Metodo que lista os alunos que estão pré-matrículados em formato 
    public function pre_matriculados() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_reserva::prematriculados();
        $escolas = tb_escola::informacaoEscolar();
        $titulo = 'Lista de Alunos Pré-Matriculados';
        return view('telasCoordenacao.relatorios.relatorio_pre_matriculado', compact('Alunos', 'turmas','titulo','escolas'));
       

    }
    //Metodo pesquisar uma turma por palavra chave
    public function turma_pesq() {
        $palavrachave = $this->request->get('pesquisar');
        $turmas = tb_turma::pesquisadoRelatorio($palavrachave);
        $turmas_Inativas = tb_turma::AnoLetivoTurmasInativas();
        return view('telasCoordenacao.relatorios.relatorio_alunos_turmas', compact('turmas','turmas_Inativas'));
    }

    //Metodo pesquisar turmas inativas pelo filtro
    public function turma_filtro() {
        $AnoLetivo = $this->request->get('AnoLetivo');
        $turmas = tb_turma::pesquisarAnoletivo($AnoLetivo);
        $turmas_Inativas = tb_turma::AnoLetivoTurmasInativas();
        return view('telasCoordenacao.relatorios.relatorio_alunos_turmas', compact('turmas','turmas_Inativas'));
    }

    public static function determinarNivelTurma($nomeTurma) {
        $nome = strtoupper($nomeTurma ?? '');
        if (str_contains($nome, 'INFANTIL') || str_contains($nome, 'INF')) {
            return 'inf';
        } elseif (str_contains($nome, '6') || str_contains($nome, '7') || str_contains($nome, '8') || str_contains($nome, '9') || str_contains($nome, 'FUNDAMENTAL II')) {
            return 'fun2';
        }
        return 'fun1';
    }

    private function renderizarRelatorioBimestral($idAluno, $bimestreNum) {
        $escolas = tb_escola::informacaoEscolar();
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $dia = strftime('%Y', strtotime('today'));

        $aluno = $this->tb_aluno->find($idAluno);
        if (!$aluno) {
            return redirect()->back()->with('error', 'Aluno não encontrado.');
        }

        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        if (!$turma || !$matricula) {
            return redirect()->back()->with('error', 'Aluno sem turma/matrícula vinculada para gerar o relatório.');
        }

        $idTurmas = is_array($turma) ? ($turma['idTurmas'] ?? 0) : ($turma->idTurmas ?? 0);
        $nomeTurma = is_array($turma) ? ($turma['NomeTurma'] ?? '') : ($turma->NomeTurma ?? '');

        $anoletivo = \DB::table('tb_turmas')->where('idTurmas', $idTurmas)->get();
        $disciplinas = tb_turmas_disciplinas::disciplinaTurma($idTurmas);
        $notasgraficos = tb_notas::busca_notas_do_aluno_grafico_bimestres($idAluno);

        $titulo = "Boletim de Acompanhamento {$bimestreNum}º Bimestre";
        $nivel = self::determinarNivelTurma($nomeTurma);

        $viewName = "telasCoordenacao.relatorios.relatorio_{$nivel}_{$bimestreNum}bim";
        return view($viewName, compact('turma', 'aluno', 'matricula', 'disciplinas', 'titulo', 'escolas', 'dia', 'anoletivo', 'notasgraficos'));
    }

    //Metodo RELATÓIO BIMESTRAL 1º BIMESTRE
    public function bimestre_1($idAluno) {
        return $this->renderizarRelatorioBimestral($idAluno, 1);
    }

    //Metodo RELATÓIO BIMESTRAL 2º BIMESTRE
    public function bimestre_2($idAluno) {
        return $this->renderizarRelatorioBimestral($idAluno, 2);
    }

    //Metodo RELATÓIO BIMESTRAL 3º BIMESTRE
    public function bimestre_3($idAluno) {
        return $this->renderizarRelatorioBimestral($idAluno, 3);
    }

    //Metodo RELATÓIO BIMESTRAL 4º BIMESTRE
    public function bimestre_4($idAluno) {
        return $this->renderizarRelatorioBimestral($idAluno, 4);
    }

// Chave da classe principal  
}
