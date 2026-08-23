<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_funcionario;
use App\Models\modelCoordenacao\tb_endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE Dde funcionário
class cont_funcionario extends Controller {

    private $request;
    private $validator;
    private $tb_funcionario;
    private $tb_endereco;

    public function __construct(Request $dadosForm, tb_funcionario $tb_funcionario, tb_endereco $tb_endereco, Validator $validator) {
        $this->request = request();
        $this->validator = $validator;
        $this->tb_funcionario = $tb_funcionario;
        $this->tb_endereco = $tb_endereco;
    }

//Metodo Para Direcionar ao cadastro de novo funcionario
    public function novofuncionario() {
        return view('telasCoordenacao.funcionarios.funcionario_cad');
    }

//Metodo para salva uma nova escola
    //Metodo para salva uma nova escola
    public function postnovofuncionario() {
        $dadosForm = request()->all();
        //dd($dadosForm);
        $validando = Validator::make($dadosForm, tb_funcionario::$camposObg);

        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
       // Chama o metodo que verifica se o funcionario existem
        $verificar = tb_funcionario::verificarSeFuncionarioExiste($dadosForm)->isEmpty();

        if ($verificar == true) {
            $salvarFuncionario = tb_funcionario::salvaFuncionario($dadosForm);

            // Se for Docente ou Coordenador e informou senha, cria o usuario correspondente
            $funcaoUpper = mb_strtoupper($dadosForm['Funcao'] ?? '', 'UTF-8');
            if ((str_contains($funcaoUpper, 'DOCENTE') || str_contains($funcaoUpper, 'COORDENAD') || str_contains($funcaoUpper, 'COORDENAC')) && !empty($dadosForm['password'])) {
                $cpf = $dadosForm['CPFFuncionario'] ?? '';
                $funcCreated = tb_funcionario::where('CPFFuncionario', $cpf)->first();
                if ($funcCreated) {
                    $nivel = str_contains($funcaoUpper, 'DOCENTE') ? 'DOCENTE' : 'COORDENACÃO';
                    $userExist = \App\Models\modelCoordenacao\tb_usuario::where('CPFUsuario', $cpf)->first();
                    if (!$userExist) {
                        $newUser = new \App\Models\modelCoordenacao\tb_usuario();
                        $newUser->CPFUsuario = $cpf;
                        $newUser->password = bcrypt($dadosForm['password']);
                        $newUser->Nivel = $nivel;
                        $newUser->Situacao = 'ATIVO';
                        $newUser->tb_funcionarios_idFuncionarios = $funcCreated->idFuncionarios;
                        $newUser->save();
                    } else {
                        $userExist->password = bcrypt($dadosForm['password']);
                        $userExist->Nivel = $nivel;
                        $userExist->Situacao = 'ATIVO';
                        $userExist->save();
                    }
                }
            }

            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/novofuncionario')->with('success', 'Funcionário cadastrado com sucesso!');
            }
            return $salvarFuncionario;
        } else {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Desculpe, funcionário já cadastrado!')->withInput();
            }
            return 'Desculpe, Funcionário já cadastrada !';
        }
    }

    // Metodo para busca valores da tabela do bando de dados:    
    public function funcionario_inf() {
        $Funcionarios = tb_funcionario::informacaoFuncionario();
        return view('telasCoordenacao.funcionarios.funcionario_inf', compact('Funcionarios'));
    }

    //Metodo que busca os dados para edição e direciona ao seu formulario.
    public function editar($idFuncionarios) {
        $funcionario = $this->tb_funcionario->find($idFuncionarios);
        $endereco = $funcionario->endFuncionario;
        $usuario = \App\Models\modelCoordenacao\tb_usuario::where('tb_funcionarios_idFuncionarios', $idFuncionarios)->first();
        $titulo = 'Editar Funcionário';
        return view('telasCoordenacao.funcionarios.funcionario_cad', compact('funcionario', 'endereco', 'usuario', 'titulo'));
    }

    // Metodo que realizar o update com os novos dados
    public function editando($idFuncionarios) {
        $dadosForm = request()->all();
        $validando = Validator::make($dadosForm, tb_funcionario::$camposObg);
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
        // Chamando o metodo para realizar a atualização passando os parametros necessarios
        $updateFuncionario = tb_funcionario::editandofuncionario($dadosForm, $idFuncionarios);

        // Se a funcao for Docente ou Coordenador e informou senha, cria ou atualiza usuario
        $funcaoUpper = mb_strtoupper($dadosForm['Funcao'] ?? '', 'UTF-8');
        if ((str_contains($funcaoUpper, 'DOCENTE') || str_contains($funcaoUpper, 'COORDENAD') || str_contains($funcaoUpper, 'COORDENAC')) && !empty($dadosForm['password'])) {
            $func = tb_funcionario::find($idFuncionarios);
            if ($func) {
                $cpf = $func->CPFFuncionario;
                $nivel = str_contains($funcaoUpper, 'DOCENTE') ? 'DOCENTE' : 'COORDENACÃO';
                $userExist = \App\Models\modelCoordenacao\tb_usuario::where('CPFUsuario', $cpf)
                    ->orWhere('tb_funcionarios_idFuncionarios', $idFuncionarios)
                    ->first();
                if (!$userExist) {
                    $newUser = new \App\Models\modelCoordenacao\tb_usuario();
                    $newUser->CPFUsuario = $cpf;
                    $newUser->password = bcrypt($dadosForm['password']);
                    $newUser->Nivel = $nivel;
                    $newUser->Situacao = 'ATIVO';
                    $newUser->tb_funcionarios_idFuncionarios = $idFuncionarios;
                    $newUser->save();
                } else {
                    $userExist->password = bcrypt($dadosForm['password']);
                    $userExist->Nivel = $nivel;
                    $userExist->Situacao = 'ATIVO';
                    $userExist->save();
                }
            }
        }

        if ($updateFuncionario) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/funcionario_inf')->with('success', 'Funcionário atualizado com sucesso!');
            }
            return 'FuncionarioAtualizado';
        } else {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Erro ao atualizar funcionário.');
            }
            return 'ErroAoAtualizar';
        }
    }

    //Metodo para deletar funcionario com verificação de lotações
    public function deletar($idFuncionarios) {
        $lotacoesCount = DB::table('tb_turmas_disciplinas')->where('tb_funcionarios_idFuncionarios', $idFuncionarios)->count();
        if ($lotacoesCount > 0) {
            return redirect('/coordenacao/funcionario_inf')->with('error', "Não é possível excluir o funcionário: vinculado a {$lotacoesCount} turma(s)/disciplina(s).");
        }
        $func = tb_funcionario::find($idFuncionarios);
        if ($func) {
            $idEndereco = $func->tb_endereco_idEndereco;
            $func->delete();
            if ($idEndereco) DB::table('tb_endereco')->where('idEndereco', $idEndereco)->delete();
            return redirect('/coordenacao/funcionario_inf')->with('success', 'Funcionário excluído com sucesso!');
        }
        return redirect('/coordenacao/funcionario_inf')->with('error', 'Funcionário não encontrado.');
    }

// Metodo para vizualizar o perfil do funcionario
    public function perfil($idFuncionarios) {
        $Funcionario = tb_funcionario::perfilFuncionario($idFuncionarios);
        $Turmas = tb_funcionario::TurmasdoProfessor($idFuncionarios);

        return view('telasCoordenacao.funcionarios.funcionario_perfil', compact('Funcionario', 'Turmas'));
    }

//Metodo pesquisar Funcionario por palavra chave
    public function funcionario_pesq() {
        $palavrachave = $this->request->get('pesquisar');
        $Funcionarios = tb_funcionario::pesquisar($palavrachave);
        return view('telasCoordenacao.funcionarios.funcionario_inf', compact('Funcionarios'));
    }

//FIM DA CLASSE CONTROLE DA ESCOLA  
}
