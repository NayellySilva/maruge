<?php

namespace App\Http\Controllers\controleDocente;
use App\Models\modelDocente\tb_funcionario_docente;
use App\Models\modelDocente\tb_usuario_docente;
use App\Models\modelDocente\tb_turma_docente;
use App\Models\modelDocente\tb_aluno_docente;
use App\Models\modelDocente\tb_disciplina_docente;
use App\Models\modelDocente\tb_escola_docente;
use App\Models\modelDocente\tb_matricula_docente;
use App\Models\modelDocente\tb_turmas_disciplinas_docente;
use App\Models\modelDocente\tb_notas_docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DO ALUNO
class cont_mapas_docente extends Controller {

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
        $this->tb_escola = $tb_escola;
        $this->tb_notas = $tb_notas;
    }
//Metodo faz solicitação dos relatorios bimestrais dos alunos
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
        return view('telasCoordenacao.mapa.mapas_notas', compact('turmas'));
    }
    
    
    
//Metodo faz solicitação dos relatorios bimestrais dos alunos
    public function index_por_docente() {
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $turmas = tb_turma_docente::ListaTuramsdoProfessor($idFuncionarios); // Buscando as turmas do professor     
        return view('telasCoordenacao.mapa.mapas_notas', compact('turmas'));
    }
 


//Metodo do primeiro bismestre que direciona o aluno para a view apropriada 
    public function bimestre_1($idTurmas) {
       // Dados para forma o timbre (cabeçario)  
       $escolas = tb_escola_docente::informacaoEscolar();
       $titulo = 'Mapa de Nota 1º Bimestre';
       $turma = $this->tb_turma->find($idTurmas);
       $idTurma = $idTurmas;
       $Alunos = tb_turma_docente::alunosdaturma($idTurma);    
       $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
       $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
       if ($quantidade_disciplinas <= 7) {
        return view('telasCoordenacao.mapa.mapa_inf_1bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas <= 14) {
        return view('telasCoordenacao.mapa.mapa_fund1_1bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas > 14) {
        return view('telasCoordenacao.mapa.mapa_fund2_1bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }   
       }
            
       //Metodo do segunda bismestre que direciona o aluno para a view apropriada 
    public function bimestre_2($idTurmas) {
       // Dados para forma o timbre (cabeçario)  
       $escolas = tb_escola_docente::informacaoEscolar();
       $titulo = 'Mapa de Nota 2º Bimestre';
       $turma = $this->tb_turma->find($idTurmas);
       $idTurma = $idTurmas;
       $Alunos = tb_turma_docente::alunosdaturma($idTurma);    
       $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
       $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
       if ($quantidade_disciplinas <= 7) {
        return view('telasCoordenacao.mapa.mapa_inf_2bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas <= 14) {
        return view('telasCoordenacao.mapa.mapa_fund1_2bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas > 14) {
        return view('telasCoordenacao.mapa.mapa_fund2_2bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }   
       }  
    //Metodo do terceiro bismestre que direciona o aluno para a view apropriada 
    public function bimestre_3($idTurmas) {
       // Dados para forma o timbre (cabeçario)  
       $escolas = tb_escola_docente::informacaoEscolar();
       $titulo = 'Mapa de Nota 3º Bimestre';
       $turma = $this->tb_turma->find($idTurmas);
       $idTurma = $idTurmas;
       $Alunos = tb_turma_docente::alunosdaturma($idTurma);    
       $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
       $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
       if ($quantidade_disciplinas <= 7) {
        return view('telasCoordenacao.mapa.mapa_inf_3bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas <= 14) {
        return view('telasCoordenacao.mapa.mapa_fund1_3bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas > 14) {
        return view('telasCoordenacao.mapa.mapa_fund2_3bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }   
       }  
    //Metodo do quarto bismestre que direciona o aluno para a view apropriada 
    public function bimestre_4($idTurmas) {
       // Dados para forma o timbre (cabeçario)  
       $escolas = tb_escola_docente::informacaoEscolar();
       $titulo = 'Mapa de Nota 4º Bimestre';
       $turma = $this->tb_turma->find($idTurmas);
       $idTurma = $idTurmas;
       $Alunos = tb_turma_docente::alunosdaturma($idTurma);    
       $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
       $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        if ($quantidade_disciplinas <= 7) {
        return view('telasCoordenacao.mapa.mapa_inf_4bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas <= 14) {
        return view('telasCoordenacao.mapa.mapa_fund1_4bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas > 14) {
        return view('telasCoordenacao.mapa.mapa_fund2_4bim', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }   
       }  
    //Metodo do mapa global que direciona o aluno para a view apropriada 
    public function mapa_global($idTurmas) {
       // Dados para forma o timbre (cabeçario)  
       $escolas = tb_escola_docente::informacaoEscolar();
       $titulo = 'Mapa de Nota Global';
       $turma = $this->tb_turma->find($idTurmas);
       $idTurma = $idTurmas;
      $Alunos = tb_turma_docente::alunosdaturma($idTurma);    
       $disciplinas = tb_turmas_disciplinas_docente::disciplinaTurma($idTurmas);
       $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        if ($quantidade_disciplinas <= 7) {
        return view('telasCoordenacao.mapa.mapa_inf_global', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas <= 14) {
        return view('telasCoordenacao.mapa.mapa_fund1_global', compact('titulo','escolas','turma','Alunos','disciplinas'));
        } else if ($quantidade_disciplinas > 14) {
        return view('telasCoordenacao.mapa.mapa_fund2_global', compact('titulo','escolas','turma','Alunos','disciplinas'));
        }   
       } 
       
       
 // Fecha a classe principal      
}