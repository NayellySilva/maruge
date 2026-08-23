<?php

namespace App\Http\Controllers\controleCoordenacao;
use App\Models\modelCoordenacao\tb_lanches;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
//Controle (metodos) principais do modulo Lanche
class cont_lanche extends Controller {

    private $request;
    private $validator;
    private $tb_lanches;
   

    public function __construct(Request $dadosForm, tb_lanches $tb_lanches, Validator $validator) {
        $this->request = request();
        $this->validator = $validator;
        $this->tb_lanches = $tb_lanches;
    }

//Metodo Para Direcionar ao cadastro de uma nova opção de lanche 
    public function novolanche_cad() {
        return view('telasCoordenacao.lanche.lanche_cad');
    }
//Metodo para salva um novo lanche
    public function postnovalanche() {
        $dadosForm = request()->all();
         $validando = Validator::make($dadosForm, tb_lanches::$camposObg);
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
// Chama o metodo verificar se o lanche digitado já exite. o parametro para consultar e ja verifica se esta vazio
        $verificar = tb_lanches::verificarSeLancheExistem($dadosForm)->isEmpty();
        if ($verificar == true) {
            tb_lanches::create($dadosForm);
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/novolanche_cad')->with('success', 'Lanche cadastrado com sucesso!');
            }
            return 1;
        } else {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Desculpe, esse lanche já está cadastrado!')->withInput();
            }
            return 'Desculpe, esse lanche já está cadastrado !';
        }
    }
// Metodo para buscar informações de todos os lanches cadastrados.
    public function lanche_inf() {  
        $lanches = tb_lanches::lanche_inf();     
        return view('telasCoordenacao.lanche.lanche_inf', compact('lanches'));
    } 
 //Metodo que busca os dados para edição e direciona ao seu formulario.
    public function editar($idlanche){
        
        $lanche = $this->tb_lanches->find($idlanche); 
        $titulo = 'Editar Lanche';
        return view('telasCoordenacao.lanche.lanche_cad', compact('lanche', 'titulo'));
    }
   
// Metodo que realizar o update com os novos dados informados.
    public function editando($idlanche) {
      $dadosForm = request()->all();
      $nome = $dadosForm['NomeLanche'] ?? null;
      if (empty($nome)) {
          return 'novaDesciplinaNaoinformada';
      }
      $jaExiste = DB::table('tb_lanches')->where('NomeLanche', $nome)->where('idlanche', '!=', $idlanche)->exists();
      if (!$jaExiste) {
          $lanche = $this->tb_lanches->find($idlanche);
          if ($lanche) $lanche->update($dadosForm);
          if (!request()->ajax() && !request()->wantsJson()) {
              return redirect('/coordenacao/lanche_inf')->with('success', 'Lanche atualizado com sucesso!');
          }
          return 'LancheAtualizado';
      } else {
          if (!request()->ajax() && !request()->wantsJson()) {
              return redirect()->back()->with('error', 'Desculpe, lanche já cadastrado!')->withInput();
          }
          return 'Desculpe, lanche já cadastrada !';
      }
    }     
// Metodo que deleta um lanche (Produto)
    public function deletar($idlanche) {   
        $l = tb_lanches::find($idlanche);
        if ($l) $l->delete();
        if (!request()->ajax() && !request()->wantsJson()) {
            return redirect('/coordenacao/lanche_inf')->with('success', 'Lanche excluído com sucesso!');
        }
        $lanches = tb_lanches::lanche_inf();     
        return view('telasCoordenacao.lanche.lanche_inf', compact('lanches'));
    }
    
    
    
    
    //Metodo pesquisar lanche por palavra chave
    public function lanche_pesq() {
     
      //  $lanches = tb_lanches::
       // $turmas = tb_turma::turmasAtivas();
        $palavrachave = $this->request->get('pesquisar');
        $lanches = tb_lanches::pesquisar($palavrachave);
        return view('telasCoordenacao.lanche.lanche_pesq', compact('lanches'));
    }

// Fechando o controle principal
}
