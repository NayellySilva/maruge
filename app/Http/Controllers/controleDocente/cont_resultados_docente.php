<?php

namespace App\Http\Controllers\controleDocente;
use App\Models\modelDocente\tb_funcionario_docente;
use App\Models\modelDocente\tb_usuario_docente;
use App\Models\modelDocente\tb_turma_docente;
use App\Models\modelDocente\tb_aluno_docente;
use App\Models\modelDocente\tb_disciplina_docente;
use App\Models\modelDocente\tb_matricula_docente;
use App\Models\modelDocente\tb_turmas_disciplinas_docente;
use App\Models\modelDocente\tb_notas_docente;
use App\Models\modelDocente\tb_escola_docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DO ALUNO
class cont_resultados_docente extends Controller {

    private $request;
    private $validator;
    private $tb_turma;
    private $tb_aluno;
    private $tb_matricula;
    private $tb_notas;
    private $tb_escola;

    public function __construct(Request $dadosForm, tb_escola_docente $tb_escola, tb_matricula_docente $tb_matricula, tb_aluno_docente $tb_aluno, tb_notas_docente $tb_notas, tb_turma_docente $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
        $this->tb_aluno = $tb_aluno;
        $this->tb_matricula = $tb_matricula;
        $this->tb_notas = $tb_notas;
        $this->tb_escola = $tb_escola;
    }
// Metodo para busca as turmas ativas cadastradas
    public function index() {       
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $turmas = tb_turma_docente::ListaTuramsdoProfessor($idFuncionarios); // Buscando as turmas do professor     
        return view('telasCoordenacao.resultado.resultados', compact('turmas'));
    }
    //Metodo que faz o levantamento de todos os alunos de um determinada turma que estão em recuperação parcial
    public function resultado_parcial($idTurmas) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Recuperação Parcial';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        $professores = tb_turmas_disciplinas_docente::ProfessoreSuasDisciplinas($idTurmas);
        if ($quantidade_disciplinas <= 7) {
            return view('telasCoordenacao.resultado.resultado_inf_parcial_final');
        } else if ($quantidade_disciplinas <= 14) {
            return view('telasCoordenacao.resultado.resultado_fund1_parcial', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else if ($quantidade_disciplinas > 14) {
            return view('telasCoordenacao.resultado.resultado_fund2_parcial', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        }
    }
    //Metodo que faz o levantamento de todos os alunos de um determinada turma que estão em recuperação parcial
    public function resultado_final($idTurmas) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Recuperação Final';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        $professores = tb_turmas_disciplinas_docente::ProfessoreSuasDisciplinas($idTurmas);
        if ($quantidade_disciplinas <= 7) {
            return view('telasCoordenacao.resultado.resultado_inf_parcial_final');
        } else if ($quantidade_disciplinas <= 14) {
            return view('telasCoordenacao.resultado.resultado_fund1_final', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else if ($quantidade_disciplinas > 14) {
            return view('telasCoordenacao.resultado.resultado_fund2_final', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        }
    }
    //Metodo que faz o levantamento de todos os alunos de um determinada turma que estão em recuperação parcial
    public function aprovados_1semestre($idTurmas) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Aprovados 1º Semestre';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        $professores = tb_turmas_disciplinas_docente::ProfessoreSuasDisciplinas($idTurmas);
        if ($quantidade_disciplinas <= 7) {
            return view('telasCoordenacao.resultado.resultado_inf_aprovados_1sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else if ($quantidade_disciplinas <= 14) {
            return view('telasCoordenacao.resultado.resultado_fund1_aprovados_1sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else if ($quantidade_disciplinas > 14) {
            return view('telasCoordenacao.resultado.resultado_fund2_aprovados_1sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        }
    }
    //Metodo que faz o levantamento de todos os alunos de um determinada turma que estão em recuperação parcial
    public function aprovados_2semestre($idTurmas) {
        // Dados para forma o timbre (cabeçario)  
        $escolas = tb_escola_docente::informacaoEscolar();
        $titulo = 'Aprovados 2º Semestre';
        $turma = $this->tb_turma->find($idTurmas);
        $idTurma = $idTurmas;
        $Alunos = tb_turma_docente::alunosdaturma($idTurma);
        $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
        $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        $professores = tb_turmas_disciplinas_docente::ProfessoreSuasDisciplinas($idTurmas);
        if ($quantidade_disciplinas <= 7) {
            return view('telasCoordenacao.resultado.resultado_inf_aprovados_2sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else if ($quantidade_disciplinas <= 14) {
            return view('telasCoordenacao.resultado.resultado_fund1_aprovados_2sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        } else if ($quantidade_disciplinas > 14) {
            return view('telasCoordenacao.resultado.resultado_fund2_aprovados_2sem', compact('titulo', 'escolas', 'turma', 'Alunos', 'disciplinas', 'professores'));
        }
    }
// Chava da class principal  
}
