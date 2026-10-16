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



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DO ALUNO
class cont_notas_docente extends Controller {

    private $request;
    private $validator;
    private $tb_turma;
    private $tb_aluno;
    private $tb_matricula;
    private $tb_notas;

    public function __construct(Request $dadosForm, tb_matricula_docente $tb_matricula, tb_aluno_docente $tb_aluno, tb_notas_docente $tb_notas, tb_turma_docente $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
        $this->tb_aluno = $tb_aluno;
        $this->tb_matricula = $tb_matricula;
        $this->tb_notas = $tb_notas;
    }

//Metodo que lista os alunos  
    public function index() {
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $Alunos = tb_aluno_docente::AlunosdoProfessor($idFuncionarios); // Buscando os alunos do professor   
        $turmas = tb_turma_docente::TurmasdoProfessor($idFuncionarios); // Buscando as turmas do professor
        return view('telasCoordenacao.notas.notas', compact('Alunos', 'turmas'));
    }

    //Metodo pesquisar aluno por filtro de turma
    public function notas_filtro() {
        $idTurma = $this->request->get('idTurmas');
        // Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $turmas = tb_turma_docente::TurmasdoProfessor($idFuncionarios); // Buscando as turmas do professor
        if ($idTurma == null) {
            
        }
        $Alunos = tb_aluno_docente::filtroporTurma($idTurma);
        return view('telasCoordenacao.notas.notas', compact('Alunos', 'turmas'));
    }

//Metodo pesquisar aluno por palavra chave
    public function notas_pesq() {
        $idTurma = $this->request->get('idTurmas');
        // Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $turmas = tb_turma_docente::TurmasdoProfessor($idFuncionarios); // Buscando as turmas do professor
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno_docente::pesquisar($palavrachave, $idFuncionarios);
        return view('telasCoordenacao.notas.notas_pesq', compact('Alunos', 'turmas'));
    }

    //Metodo do primeiro bismestre que direciona o aluno para a view apropriada 
    public function bimestre_1($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $idTurmas = $turma['idTurmas'];
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $disciplinas = tb_disciplina_docente::disciplinaTurmadoProfessor($idTurmas, $idFuncionarios);
        $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        if ($quantidade_disciplinas <= 7) {
            return view('telasCoordenacao.notas.notas_inf_1bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        } else if ($quantidade_disciplinas <= 14) {
            return view('telasCoordenacao.notas.notas_fund1_1bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        } else if ($quantidade_disciplinas > 14) {
            return view('telasCoordenacao.notas.notas_fund2_1bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        }
    }

    //Metodo do primeiro bismestre que direciona o aluno para a view apropriada 
    public function bimestre_2($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $idTurmas = $turma['idTurmas'];
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $disciplinas = tb_disciplina_docente::disciplinaTurmadoProfessor($idTurmas, $idFuncionarios);
        $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        if ($quantidade_disciplinas <= 7) {
            return view('telasCoordenacao.notas.notas_inf_2bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        } else if ($quantidade_disciplinas <= 14) {
            return view('telasCoordenacao.notas.notas_fund1_2bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        } else if ($quantidade_disciplinas > 14) {
            return view('telasCoordenacao.notas.notas_fund2_2bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        }
    }

    //Metodo do primeiro bismestre que direciona o aluno para a view apropriada 
    public function bimestre_3($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $idTurmas = $turma['idTurmas'];
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $disciplinas = tb_disciplina_docente::disciplinaTurmadoProfessor($idTurmas, $idFuncionarios);
        $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        if ($quantidade_disciplinas <= 7) {
            return view('telasCoordenacao.notas.notas_inf_3bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        } else if ($quantidade_disciplinas <= 14) {
            return view('telasCoordenacao.notas.notas_fund1_3bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        } else if ($quantidade_disciplinas > 14) {
            return view('telasCoordenacao.notas.notas_fund2_3bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        }
    }

    //Metodo do primeiro bismestre que direciona o aluno para a view apropriada 
    public function bimestre_4($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $idTurmas = $turma['idTurmas'];
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $disciplinas = tb_disciplina_docente::disciplinaTurmadoProfessor($idTurmas, $idFuncionarios);
        $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        if ($quantidade_disciplinas <= 7) {
            return view('telasCoordenacao.notas.notas_inf_4bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        } else if ($quantidade_disciplinas <= 14) {
            return view('telasCoordenacao.notas.notas_fund1_4bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        } else if ($quantidade_disciplinas > 14) {
            return view('telasCoordenacao.notas.notas_fund2_4bim', compact('turma', 'aluno', 'matricula', 'disciplinas'));
        }
    }

    /**
     * ********************************************
     * *******************************************
      Metodos para uso exclusivo para turma do Infantl
     * ********************************************
     * *******************************************
     * */
//Metodo para salva as notas do primeiro 1bim educação infantil.
    public function salva_nota_1bim_inf() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["AB1"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB1"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_1bim_inf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

//Metodo para salva as notas do primeiro 2bim educação infantil.
    public function salva_nota_2bim_inf() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["AB2"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB2"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_2bim_inf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

//Metodo para salva as notas do primeiro 3bim educação infantil.
    public function salva_nota_3bim_inf() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["AB3"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB3"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_3bim_inf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

//Metodo para salva as notas do primeiro 3bim educação infantil.
    public function salva_nota_4bim_inf() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["AB4"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB4"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_4bim_inf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    /**
     * ********************************************
     * *******************************************
      Metodos para uso exclusivo para turma do Fundamental I
     * ********************************************
     * *******************************************
     * */
//Metodo para salva as notas do primeiro 1bimes Fundamente I.
    public function salva_nota_1bim_fun1() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["AB1"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB1"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_1bim_fun1($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

//Metodo para salva as notas do 2 bim Fundamente I.
    public function salva_nota_2bim_fun1() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["AB2"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB2"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_2bim_fun1($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

//Metodo para salva as notas do 3 bim Fundamente I.
    public function salva_nota_3bim_fun1() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["AB3"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB3"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_3bim_fun1($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

//Metodo para salva as notas do 4 bim Fundamente I.
    public function salva_nota_4bim_fun1() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["AB4"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AB4"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_4bim_fun1($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    // Salvar nota do primeiro bimestres fundamental II  
    public function salva_nota_1bim_fun2() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["RA"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AM1"][$i]) or ( $dadosForm["AB1"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_1bim_fun2($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    // Salvar nota do segundo bimestres fundamental II  
    public function salva_nota_2bim_fun2() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["RA"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AM2"][$i]) or ( $dadosForm["AB2"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_2bim_fun2($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    // Salvar nota do segundo bimestres fundamental II  
    public function salva_nota_3bim_fun2() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["RA"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AM3"][$i]) or ( $dadosForm["AB3"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_3bim_fun2($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    // Salvar nota do segundo bimestres fundamental II  
    public function salva_nota_4bim_fun2() {
        $dadosForm = $this->request->all();
        $count = count($dadosForm["RA"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["AM4"][$i]) or ( $dadosForm["AB4"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_4bim_fun2($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    //Metodo recuperações do aluno para a view apropriada 
    public function rp_rf($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $idTurmas = $turma['idTurmas'];
        // Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $disciplinas = tb_disciplina_docente::disciplinaTurmadoProfessor($idTurmas, $idFuncionarios);
        return view('telasCoordenacao.notas.notas_rp_rf', compact('turma', 'aluno', 'matricula', 'disciplinas'));
    }

    // Salvar nota DE RECUPERAÇÃO PARCIAL E FINAL 
    public function salva_nota_rp_rf() {
        $dadosForm = $this->request->all();

        $count = count($dadosForm["RA"]);
        for ($i = 0; $i < $count; $i++) {
            if (!empty($dadosForm["RP"][$i]) or ( $dadosForm["RF"][$i])) {
                $salvandoNotas = tb_notas_docente::salva_nota_rp_rf($dadosForm);
                return $salvandoNotas;
            }
        }
        return "notaNaoInformada";
    }

    //Edita Nota
    public function editarNota() {
        $dadosForm = $this->request->all();
        $idAluno = $dadosForm["tb_aluno_idAluno"];
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turma = $aluno->turmaAluno;
        $idTurmas = $turma['idTurmas'];
// Pegando o CPF do usuario e buscando seus dados
        $CPFfuncionario = auth()->guard('guardLogin')->user()->CPFUsuario;
// Criando um array de dados com Nome e id do funcionario
        $nomedeusuario = tb_usuario_docente::infUsuario($CPFfuncionario);
// Atribuindo o id do funcionario na vareavel idFuncionario para assim buscar suas turmas        
        foreach ($nomedeusuario as $idFuncionarios) {
            $idFuncionarios = $idFuncionarios['idFuncionarios'];
        }
        $disciplinas = tb_disciplina_docente::disciplinaTurmadoProfessor($idTurmas, $idFuncionarios);
        $quantidade_disciplinas = tb_disciplina_docente::QuantidadeDisciplinasNaTurma($idTurmas);
        $updateNota = tb_notas_docente::editandoNotas($dadosForm);
        if ($updateNota) {
            return 'notaAtualizada';
        } else {
            return 'erroAoAtualizarNota';
        }
    }

// Fechando a Classe principal.
}
