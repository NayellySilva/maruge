<?php

namespace App\Http\Controllers\controleCoordenacao;

// Usando
use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_aulas;


//Não usando
use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_endereco;
use App\Models\modelCoordenacao\tb_pais;
use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DO ALUNO
class cont_aulas extends Controller {

    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_endereco;
    private $tb_turma;
    private $tb_aulas;
    private $tb_pais;
    private $tb_matricula;
    private $tb_escola;
    private $tb_reserva;

    public function __construct(Request $dadosForm, tb_reserva $tb_reserva, tb_escola $tb_escola, tb_aulas $tb_aulas, tb_matricula $tb_matricula, tb_pais $tb_pais, tb_aluno $tb_aluno, tb_endereco $tb_endereco, tb_turma $tb_turma, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_endereco;
        $this->tb_turma = $tb_turma;
        $this->tb_aulas = $tb_aulas;
        $this->tb_pais = $tb_pais;
        $this->tb_matricula = $tb_matricula;
        $this->tb_escola = $tb_escola;
        $this->tb_reserva = $tb_reserva;
    }

//Metodo que direcionar para view de um novo cadastro
    public function novaAula() {
        $turmas = tb_turma::turmasAtivas();
        return view('telasCoordenacao.aulas.aula_cad', compact('turmas'));
    }
    
    
    
//Metodo para salva uma nova aula
    public function postnovaaula() {
// recebendo dados informados
        $dadosForm = $this->request->all();
        $validando = Validator::make($dadosForm, tb_aulas::$camposObg);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
             foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $verificar = tb_aulas::verificarSeAulaExistem($dadosForm)->isEmpty();
        if ($verificar == true) {
            tb_aulas::create($dadosForm);
            return 1;
        } else {
            return 'aulajacadastrada';
        }
        }
     // Metodo para busca as turmas ativas cadastradas para exibir as aulas
    public function aulas_inf() {
        $turmas = tb_turma::listandoTurmasAtivasAulas();
        $titulo = 'Atividades em Vídeo' ;
        return view('telasCoordenacao.aulas.aulas_inf', compact('turmas', 'titulo'));
    }
    // Metodo que direciona o aulo para a sua turma com todos os videos para assistir
    public function assistir($idTurmas) {
        $turmaAula = $this->tb_turma->find($idTurmas);
        $titulo = 'Aulas da Turma :' ;
        $Aulas = tb_aulas::BuscaAulas($idTurmas);  
        return view('telasCoordenacao.aulas.aulas_assistir', compact('turmaAula', 'titulo', 'Aulas' ));
    }
  
    
    
    
     //Metodo que editar uma informação de aula
    
 public function editar($idAula) {
        $aula = $this->tb_aulas->find($idAula);
        $titulo = 'Editar Aula';
        $turmas = tb_turma::turmasAtivas();
        return view('telasCoordenacao.aulas.aula_cad', compact('aula', 'titulo','turmas'));
    }
    
 
    
   // Metodo que atualiza os dados de uma aula
    public function editando($idAula) {
        // recebendo dados informados
        $dadosForm = $this->request->all();
        $validando = Validator::make($dadosForm, tb_aulas::$camposObg);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $aula = $this->tb_aulas->find($idAula); // buscando a aula o qual deseja atualizar      
        $updateAula = $aula->update($dadosForm); // Atualizando o dados da tabela aula           
        if ($updateAula) {
            return 'Aulaatualizada';
        } else {
            return 'Desculpe, Aula já Existe !';
        }
        // Chama o metodo verificar se a AULA existem passado o parametro para consultar e ja verifica se esta vazio
        //   $verificar = tb_aulas::verificarSeAulaExistem($dadosForm)->isEmpty();
        //   if ($verificar == true) {
        //     $updateAula = tb_aulas::editandoAula($idAula, $dadosForm);
        // Condição que mostra messagem caso a atualização ocorra perfeitamente
        //    if ($updateAula) {
        //        return 'Aulaatualizada';
        //  } else {
        //  }
// caso  a aula consultada esteja no banco retorna a messagem.
        //    } else {
        //     return 'Desculpe, Aula já Existe !';
        //  }
    }

    // metodo deletar uma aula
     public function deletar($idAula) {
        tb_aulas::find($idAula)->delete();
        $turmas = tb_turma::listandoTurmasAtivasAulas();
        return view('telasCoordenacao.aulas.aulas_inf', compact('turmas'));
    }
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//Metodo que lista os alunos 
    public function aluno_inf() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_aluno::listagemAluno();
        return view('telasCoordenacao.alunos.aluno_inf', compact('Alunos', 'turmas'));
    }
//Metodo que lista os alunos que estão pré-matrículados
    public function pre_matriculados() {
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_reserva::prematriculados();
        return view('telasCoordenacao.alunos_pre.aluno_pre_matriculado', compact('Alunos', 'turmas'));
    }
//Metodo que lista os alunos para rematricular
    public function aluno_rematricula() {
        $turmas = tb_turma::turmasAtivas();
        // $Alunos = tb_aluno::listagemAluno();
        $Alunos = tb_aluno::alunoInativos();

        return view('telasCoordenacao.alunos.aluno_rematricula', compact('Alunos', 'turmas'));
    }
//Metodo que lista os alunos para uma reserva
    public function pre_matricula() {
        $turmas = tb_turma::turmasAtivas();
        // $Alunos = tb_aluno::listagemAluno();
        $Alunos = tb_aluno::todosAlunos();
        return view('telasCoordenacao.alunos_pre.aluno_pre_matricula_lista', compact('Alunos', 'turmas'));
    }

//Metodo pesquisar aluno por palavra chave
    public function aluno_pesq() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesquisar($palavrachave);
        return view('telasCoordenacao.alunos.aluno_pesq', compact('Alunos', 'turmas'));
    }

//Metodo pesquisar aluno por palavra chave para rematricular
    public function aluno_pesq_rematricula() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesquisarInativos($palavrachave);
        return view('telasCoordenacao.alunos.aluno_rematricula', compact('Alunos', 'turmas'));
    }

//Metodo pesquisar aluno por palavra chave para reserva
    public function aluno_pesq_reserva() {
        $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $Alunos = tb_aluno::pesqTodosAlunos($palavrachave);
        return view('telasCoordenacao.alunos_pre.aluno_pre_matricula_lista', compact('Alunos', 'turmas'));
    }

//Metodo pesquisar aluno por filtro de turma
    public function aluno_filtro() {
        $idTurma = $this->request->get('idTurmas');
        $turmas = tb_turma::turmasAtivas();
        if ($idTurma == null) {
            
        }
        $Alunos = tb_aluno::filtroporTurma($idTurma);
        return view('telasCoordenacao.alunos.aluno_inf', compact('Alunos', 'turmas'));
    }



    //Metodo que busca os dados para edição e direciona ao seu formulario.
    public function transferir($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turmas = tb_turma::turmasAtivas();
        $turma = $aluno->turmaAluno;
        $titulo = 'Transferir Aluno';
        return view('telasCoordenacao.alunos.aluno_transferir', compact('aluno', 'matricula', 'turmas', 'titulo', 'turma'));
    }

    //Metodo que busca os dados para reserva matricula de aluno
    public function reservar($idAluno) {
        $aluno = $this->tb_aluno->find($idAluno);
        $matricula = $aluno->matriculaAluno;
        $turmas = tb_turma::turmasAtivas();
        $turma = $aluno->turmaAluno;
        $titulo = 'Reserva Vaga';
        return view('telasCoordenacao.alunos_pre.aluno_pre_matricula', compact('aluno', 'matricula', 'turmas', 'titulo', 'turma'));
    }

    public function transferindo($idAluno) {
        $dadosForm = $this->request->all();
        // Validando dados
        $validando = Validator::make($dadosForm, tb_aluno::$camposObgTransferindo);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $aluno = $this->tb_aluno->find($idAluno); // buscando o Aluno o qual deseja atualizar      
        $updateDadosAluno = $aluno->update($dadosForm); // Atualizando o dados da tabela aluno            
        $idMatriculas = $aluno->tb_matriculas_idMatriculas;   // Recebendo o id de matricula do aluno 
        $matricula = $this->tb_matricula->find($idMatriculas); // buscando a matricula do aluno
        $updateMatricula = $matricula->update($dadosForm); //Atualizando os dados de matricula do aluno   
        if ($updateDadosAluno) {
            return 'AlunoTransferido';
        } else {
            
        }
    }

    // Fazendo reserva do aluno
    public function reservando() {
        $dadosForm = $this->request->all();
// Validando dados
        $validando = Validator::make($dadosForm, tb_reserva::$camposObg);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }


        if (tb_reserva::verificar_preMatricula($dadosForm)) {
            return 'jaexistereserva';
        } else {
            $novaReseva = tb_reserva::salvandoReserva($dadosForm);
            if ($novaReseva) {
                return 'ReservaAluno';
            }
        }
    }

    //Metodo que busca os dados para edição e direciona ao seu formulario.
    public function ficha($idAluno) {
        $escolas = tb_escola::informacaoEscolar();
        $aluno = $this->tb_aluno->find($idAluno);
        $endereco = $aluno->endAluno;
        $matricula = $aluno->matriculaAluno;
        $turmas = tb_turma::turmasAtivas();
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Ficha de Matricula';
        return view('telasCoordenacao.alunos.aluno_ficha', compact('escolas', 'aluno', 'endereco', 'matricula', 'turmas', 'pais', 'titulo', 'turma'));

        //    return View::make('telasCoordenacao.aluno_ficha', compact('escolas','aluno', 'endereco', 'matricula', 'turmas', 'pais', 'titulo', 'turma'))->nest('telasCoordenacao.aluno_ficha', compact('escolas','aluno', 'endereco', 'matricula', 'turmas', 'pais', 'titulo', 'turma'));
    }

    

    
    
    
    

// metodo deletar uma pré-matricula
    public function pre_matriculado_deletar($idReservas) {

        tb_reserva::find($idReservas)->delete();
        $turmas = tb_turma::turmasAtivas();
        $Alunos = tb_reserva::prematriculados();
        return view('telasCoordenacao.alunos_pre.aluno_pre_matriculado', compact('Alunos', 'turmas'));
    }

// Chava da class principal  
}
