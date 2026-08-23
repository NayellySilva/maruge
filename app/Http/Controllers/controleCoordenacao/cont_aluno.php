<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_aluno;
use App\Models\modelCoordenacao\tb_matricula;
use App\Models\modelCoordenacao\tb_turma;
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
class cont_aluno extends Controller {

    private $request;
    private $validator;
    private $tb_aluno;
    private $tb_endereco;
    private $tb_turma;
    private $tb_pais;
    private $tb_matricula;
    private $tb_escola;
    private $tb_reserva;

    public function __construct(Request $dadosForm, tb_reserva $tb_reserva, tb_escola $tb_escola, tb_matricula $tb_matricula, tb_pais $tb_pais, tb_aluno $tb_aluno, tb_endereco $tb_endereco, tb_turma $tb_turma, Validator $validator) {
        $this->request = request();
        $this->validator = $validator;
        $this->tb_aluno = $tb_aluno;
        $this->tb_endereco = $tb_endereco;
        $this->tb_turma = $tb_turma;
        $this->tb_pais = $tb_pais;
        $this->tb_matricula = $tb_matricula;
        $this->tb_escola = $tb_escola;
        $this->tb_reserva = $tb_reserva;
    }

//Metodo Para Direcionar ao cadastro de um novo aluno
    public function novoaluno() {
       
        $turmas = tb_turma::turmasAtivas();
        return view('telasCoordenacao.alunos.aluno_cad', compact('turmas'));
    }

//Metodo para salva um novo aluno    
    public function postnovoaluno() {
// recebendo dados informados
$dadosForm = request()->all();

// Validando dados
        $validando = Validator::make($dadosForm, tb_aluno::$camposObg);
        if ($validando->fails()) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->withErrors($validando)->withInput();
            }
            $messages = $validando->messages();
            $displayErros = '';
             foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
      if (tb_aluno::verificarAluno($dadosForm)) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Desculpe, aluno já cadastrado!')->withInput();
            }
            return 'alunojacadastrado';
        } else {
//criando o RA do aluno atravez do metodo RA
            $RA = tb_matricula::novoRA();
            $salvarAluno = tb_aluno::salvandoAluno($dadosForm, $RA);
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/aluno_cad')->with('success', 'Aluno cadastrado com sucesso!');
            }
            return $salvarAluno;
        }
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
    public function editar($idAluno) {
        
     
        
        
        $aluno = $this->tb_aluno->find($idAluno);
        $endereco = $aluno->endAluno;
        $matricula = $aluno->matriculaAluno;
        $turmas = tb_turma::turmasAtivas();
        $turma = $aluno->turmaAluno;
        $pais = $aluno->paisAluno;
        $titulo = 'Editar dados aluno';
        return view('telasCoordenacao.alunos.aluno_cad', compact('aluno', 'endereco', 'matricula', 'turmas', 'pais', 'titulo', 'turma'));
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
        $dadosForm = request()->all();
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
        $dadosForm = request()->all();
        $validando = Validator::make($dadosForm, tb_reserva::$camposObg);
        if ($validando->fails()) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->withErrors($validando)->withInput();
            }
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }

        if (tb_reserva::verificar_preMatricula($dadosForm)) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Desculpe, aluno já possui pré-matrícula cadastrada!')->withInput();
            }
            return 'jaexistereserva';
        } else {
            $novaReseva = tb_reserva::salvandoReserva($dadosForm);
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/aluno_pre_matriculado')->with('success', 'Pré-matrícula realizada com sucesso!');
            }
            return 'ReservaAluno';
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

    /*
    
// Metodo que realizar o update com os novos dados
    public function editando($idAluno) {
// recebendo dados informados    
        $dadosForm = request()->all();
// Validando dados
        $validando = Validator::make($dadosForm, tb_aluno::$camposObg);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $aluno = $this->tb_aluno->find($idAluno); // buscando o Aluno o qual deseja atualizar      
        $updateDadosAluno = $aluno->update($dadosForm); // Atualizando o dados da tabela aluno            
        $idEndereco = $aluno->tb_endereco_idEndereco;   // Recebendo o id do endereço do aluno 
        $endereco = $this->tb_endereco->find($idEndereco); // Buscando os dados de endereço do aluno
        $updateEndereco = $endereco->update($dadosForm); // Atualizando o endereço
        $idMatriculas = $aluno->tb_matriculas_idMatriculas;   // Recebendo o id de matricula do aluno 
        $BuscaRA = tb_matricula::BuscaRA($idMatriculas);
        foreach($BuscaRA as $item){
        $RA = $item->RA;
        }       
        //Criando o email dos alunos na rematricula e na atualizaão
        $CriandoEmail = tb_matricula::Email($dadosForm, $RA);
        //Adicionando um novo campo no ARRAY FORME , DANDO UM EMAIL NESSE CAMPO
        $dadosForm["Email"] = $CriandoEmail;
        $CriandoEmail;      
        //dd($CriandoEmail);      
        $novaMatricula = new tb_matricula($CriandoEmail);
        $novaMatricula->Email = $CriandoEmail;
        $novaMatricula->update();
 // dd($teste);
   //     $disciplina = $this->tb_disciplina->find($idAluno);
//   $updateDisciplina = $disciplina->update($teste);
        $SalvaEmail = $this->tb_matricula->find($idAluno);
        $updateDisciplina = $SalvaEmail->update($dadosForm);
        $matricula = $this->tb_matricula->find($idMatriculas); // buscando a matricula do aluno
        $updateMatricula = $matricula->update($dadosForm); //Atualizando os dados de matricula do aluno   
        $idPais = $aluno->tb_pais_idPais;   // Recebendo o id de matricula do aluno 
        $matricula = $this->tb_pais->find($idPais); // buscando a matricula do aluno
        $updateMatricula = $matricula->update($dadosForm); //Atualizando os dados de matricula do aluno
        if ($updateDadosAluno) {
            return 'AlunoAtualizado';
        } else {
            
        }
    }
    
    */
    
        public function editando($idAluno) {
// recebendo dados informados    
        $dadosForm = request()->all();
// Validando dados

        $validando = Validator::make($dadosForm, tb_aluno::$camposObg);
        if ($validando->fails()) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->withErrors($validando)->withInput();
            }
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $aluno = $this->tb_aluno->find($idAluno); // buscando o Aluno o qual deseja atualizar      
        $updateDadosAluno = $aluno->update($dadosForm); // Atualizando o dados da tabela aluno            
        $idEndereco = $aluno->tb_endereco_idEndereco;   // Recebendo o id do endereço do aluno 
        $endereco = $this->tb_endereco->find($idEndereco); // Buscando os dados de endereço do aluno
        if ($endereco) $endereco->update($dadosForm); // Atualizando o endereço
        $idMatriculas = $aluno->tb_matriculas_idMatriculas;   // Recebendo o id de matricula do aluno   
        $matricula = $this->tb_matricula->find($idMatriculas); // buscando a matricula do aluno   
        if ($matricula) {
            $RA = $matricula['RA'];    // Pegando o RA PARA GERAR PARTE DO EMAIL 
            $Email = tb_matricula::Email($dadosForm, $RA); // Criando o Email
            $dadosForm['Email'] = $Email;
            $matricula->update($dadosForm); //Atualizando os dados de matricula do aluno   
        }
        $idPais = $aluno->tb_pais_idPais;   // Recebendo o id de matricula do aluno 
        $paisObj = $this->tb_pais->find($idPais); // buscando os dados dos pais
        if ($paisObj) $paisObj->update($dadosForm);
        
        if ($updateDadosAluno) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/aluno_inf')->with('success', 'Aluno atualizado com sucesso!');
            }
            return 'AlunoAtualizado';
        } else {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Erro ao atualizar aluno.');
            }
            return 'ErroAoAtualizar';
        }
    }

// metodo deletar um aluno e seus relacionamentos
    public function deletar($idAluno) {
        $aluno = tb_aluno::find($idAluno);
        if ($aluno) {
            $idMatricula = $aluno->tb_matriculas_idMatriculas;
            $idEndereco = $aluno->tb_endereco_idEndereco;
            $idPais = $aluno->tb_pais_idPais;
            
            $aluno->delete();
            if ($idMatricula) DB::table('tb_matriculas')->where('idMatriculas', $idMatricula)->delete();
            if ($idEndereco) DB::table('tb_endereco')->where('idEndereco', $idEndereco)->delete();
            if ($idPais) DB::table('tb_pais')->where('idPais', $idPais)->delete();
            
            return redirect('/coordenacao/aluno_inf')->with('success', 'Aluno excluído com sucesso!');
        }
        return redirect('/coordenacao/aluno_inf')->with('error', 'Aluno não encontrado.');
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
