<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_usuario;
use App\Models\modelCoordenacao\tb_funcionario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DA USUARIO
class cont_usuario extends Controller {

    private $request;
    private $validator;
    private $tb_usuario;
    private $tb_funcionario;

    public function __construct(Request $dadosForm, tb_usuario $tb_usuario, tb_funcionario $tb_funcionario, Validator $validator) {
        $this->request = request();
        $this->validator = $validator;
        $this->tb_usuario = $tb_usuario;
        $this->tb_funcionario = $tb_funcionario;
    }

   
    //Metodo Para Direcionar ao cadastro de um novo usuario 
    public function novousuario() {
        $funcionarios = tb_funcionario::funcionarioCadastrados();
        $titulo = 'Novo Usuário';
        return view('telasCoordenacao.usuarios.usuario_cad', compact('funcionarios','titulo'));
    }

    //Metodo para criar um novo usuario:  
    public function postnovousuario() {
        // Recebendo todos os valores enviados pelo view usuario_cad   
        $dadosForm = request()->all();
        //Validando os dados informados
        $validando = Validator::make($dadosForm, tb_usuario::$camposObg);
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
        // criptografa a senha do usuario
        $dadosForm['password'] = bcrypt($dadosForm['password']);
        // armazenando idFuncionarios na vareavel para buscar seu cpf
        $idFuncionarios = $this->request->get('Usuario');
        // Atribuindo o CPF a sua vareavel
        $Funcionario = $this->tb_funcionario->find($idFuncionarios);
        $CPFfuncionario = $Funcionario['CPFFuncionario'];
        // Buscando usuario que tenha o mesmo cpf
        $usuario = tb_usuario::verificarUsuarioExistente($CPFfuncionario);
        // Se exitem algum cpf igual ao informado entra na seguinte condição
        if (count($usuario) > 0) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Desculpe! Mas o usuário já existe!')->withInput();
            }
            return 'Desculpe! Mas o usuário já existem';
        } else {
            $salvandoUsuario = tb_usuario::salvandoUsuario($dadosForm, $CPFfuncionario, $idFuncionarios);
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/novousuario')->with('success', 'Usuário cadastrado com sucesso!');
            }
            return $salvandoUsuario;
        }
    }
    //Metodo que lista todos os usuarios
    public function usuario_inf() {
        $Usuarios = tb_usuario::listagemUsuarios();
        return view('telasCoordenacao.usuarios.usuario_inf', compact('Usuarios'));
    }
    //Metodo pesquisar usuario
    public function usuario_pesq() {
        $palavrachave = $this->request->get('pesquisar');
        $Usuarios = tb_usuario::pesquisarUsuario($palavrachave);
        return view('telasCoordenacao.usuarios.usuario_inf', compact('Usuarios'));
    }
    //Metodo que busca os dados para edição e direciona ao seu formulario.
    public function editar($idUsuario) {
              
       $usuario = $this->tb_usuario->find($idUsuario);
       $idFuncionario = $usuario->tb_funcionarios_idFuncionarios;
       $funcionario = $this->tb_funcionario->find($idFuncionario);
       $titulo = 'Alterar Usuário';
       return view('telasCoordenacao.usuarios.usuario_cad', compact('usuario','funcionario','titulo'));
    }  
        // Metodo que realizar o update com os novos dados
    public function editando($idUsuario) {
        $dadosForm = request()->all();  
        $validando = Validator::make($dadosForm, tb_funcionario::$camposObg);  
        //Validando os dados informados
        $validando = Validator::make($dadosForm, tb_usuario::$camposObg);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }        
        // criptografa a senha do usuario
        $dadosForm['password'] = bcrypt($dadosForm['password']);
        $updateUsuario = tb_usuario::editandoUsuario($dadosForm, $idUsuario);
        if ($updateUsuario) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/usuario_inf')->with('success', 'Usuário atualizado com sucesso!');
            }
            return 'UsuarioAtualizado';
        } else {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Erro ao atualizar usuário.');
            }
            return 'ErroAoAtualizar';
        }
    }

    public function deletar($idUsuario) {
        $deleted = DB::table('tb_usuario')->where('idUsuario', $idUsuario)->delete();
        if (!request()->ajax() && !request()->wantsJson()) {
            return redirect('/coordenacao/usuario_inf')->with('success', 'Usuário excluído com sucesso!');
        }
        return $deleted ? 1 : 0;
    }
//Fecha classe principal 
}
