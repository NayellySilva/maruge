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
class cont_mapas extends Controller {

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
        return view('telasCoordenacao.mapa.mapas_notas', compact('turmas'));
    }  
//Metodo pesquisar turma por palavra chave
    public function mapas_pesq() {
       $palavrachave = $this->request->get('pesquisar');
        $turmas = tb_turma::pesquisar($palavrachave);
        return view('telasCoordenacao.mapa.mapas_pesq', compact('turmas'));
    }

//Metodo pesquisar turma por filtro Situação
    public function mapas_filtro() {
        $SituacaoTurma = $this->request->get('SituacaoTurma');
        if ($SituacaoTurma == null) {
            return redirect('/coordenacao/mapas_notas');
        }
        $turmas = tb_turma::filtroporSituacaoTurma($SituacaoTurma);
        return view('telasCoordenacao.mapa.mapas_filtro', compact('turmas'));
    }
    public static function determinarNivelTurma($nomeTurma) {
        return cont_relatorios::determinarNivelTurma($nomeTurma);
    }

    private function renderizarMapa($idTurmas, $tipo) {
        $turma = $this->tb_turma->find($idTurmas);
        if (!$turma) {
            return redirect()->back()->with('error', 'Turma não encontrada.');
        }

        $escolas = tb_escola::informacaoEscolar();
        $Alunos = tb_turma::alunosdaturmaParaMapas($idTurmas);
        $alunos = $Alunos;
        $disciplinas = tb_turmas_disciplinas::disciplinaTurma($idTurmas);

        $nomeTurma = $turma->NomeTurma ?? '';
        $rawNivel = self::determinarNivelTurma($nomeTurma);
        $nivel = ($rawNivel === 'fun1') ? 'fund1' : (($rawNivel === 'fun2') ? 'fund2' : 'inf');

        $titulos = [
            '1bim' => 'Mapa de Nota 1º Bimestre',
            '2bim' => 'Mapa de Nota 2º Bimestre',
            '3bim' => 'Mapa de Nota 3º Bimestre',
            '4bim' => 'Mapa de Nota 4º Bimestre',
            'global' => 'Mapa de Nota Global',
        ];
        $titulo = $titulos[$tipo] ?? "Mapa de Notas ({$tipo})";

        $viewName = "telasCoordenacao.mapa.mapa_{$nivel}_{$tipo}";
        return view($viewName, compact('titulo', 'escolas', 'turma', 'Alunos', 'alunos', 'disciplinas'));
    }

    //Metodo do primeiro bimestre
    public function bimestre_1($idTurmas) {
        return $this->renderizarMapa($idTurmas, '1bim');
    }

    //Metodo do segundo bimestre
    public function bimestre_2($idTurmas) {
        return $this->renderizarMapa($idTurmas, '2bim');
    }

    //Metodo do terceiro bimestre
    public function bimestre_3($idTurmas) {
        return $this->renderizarMapa($idTurmas, '3bim');
    }

    //Metodo do quarto bimestre
    public function bimestre_4($idTurmas) {
        return $this->renderizarMapa($idTurmas, '4bim');
    }

    //Metodo do mapa global
    public function mapa_global($idTurmas) {
        return $this->renderizarMapa($idTurmas, 'global');
    }

    //Metodo para suporte a rotas dinamicas {tipo}
    public function mapa_dinamico($tipo, $idTurmas) {
        $tiposValidos = ['1bim', '2bim', '3bim', '4bim', 'global'];
        if (!in_array($tipo, $tiposValidos)) {
            abort(404);
        }
        return $this->renderizarMapa($idTurmas, $tipo);
    }
}
    