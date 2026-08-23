<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_escola;
use App\Models\modelCoordenacao\tb_endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

//INICIO DA CLASSE CONTROLE DA ESCOLA
class cont_cadescola extends Controller {

    private $request;
    private $validator;
    private $tb_escola;
    private $tb_endereco;

    public function __construct(Request $dadosForm, tb_escola $tb_escola, tb_endereco $tb_endereco, Validator $validator) {
        $this->request = request();
        $this->validator = $validator;
        $this->tb_escola = $tb_escola;
        $this->tb_endereco = $tb_endereco;
    }

//Metodo Para Direcionar ao cadastro de Escola (FormEscola)
    public function novaescola() {
        return view('telasCoordenacao.escola.escola_form');
    }
//Metodo para salva uma nova escola
    public function postnovaescola() {
        $dadosForm = request()->all();
        $validando = Validator::make($dadosForm, tb_escola::$camposObg);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $escola = tb_escola::count();
        if ($escola >= 1) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/escola/escola_inf')->with('error', 'Desculpa, já existe uma escola cadastrada!');
            }
            return 'escolaExistente';
        } else {
            $novoEndereco = new tb_endereco($dadosForm);
            $novoEndereco->save();
            $novaEscola = new tb_escola($dadosForm);
            if (empty($novaEscola->NumeroInep)) {
                $novaEscola->NumeroInep = $dadosForm['INEP'] ?? $dadosForm['Inep'] ?? '00000000';
            }
            $novaEscola->tb_endereco_idEndereco = $novoEndereco->idEndereco;
            $novaEscola->save();
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/escola/escola_inf')->with('success', 'Escola cadastrada com sucesso!');
            }
            return 1;
        }
    }
// Metodo para busca valores da tabela do bando de dados:    
    public function escola_inf() {
        $escolas = $this->tb_escola
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_escola.tb_endereco_idEndereco')
                ->select('tb_escola.idEscola', 'tb_escola.NomeEscola', 'tb_escola.tb_endereco_idEndereco', 'tb_endereco.Rua', 'tb_endereco.Numero')
                ->get();
        return view('telasCoordenacao.escola.escola_inf', compact('escolas'));
    }

//Metodo que busca os dados para edição e direciona ao seu formulario.
    public function iditar($idEscola) {

        $escolas = $this->tb_escola->find($idEscola);
        $idEndereco = $escolas->tb_endereco_idEndereco;
        $endereco = $this->tb_endereco->find($idEndereco);
        $titulo = 'Editar dados escolares';
        return view('telasCoordenacao.escola.escola_form', compact('escolas', 'endereco','titulo'));
    }
// Metodo para vizualizar informações da escola
    public function vizualizar($idEscola) {
        $escolas = $this->tb_escola->find($idEscola);
        $idEndereco = $escolas->tb_endereco_idEndereco;
        $endereco = $this->tb_endereco->find($idEndereco);
        return view('telasCoordenacao.escola.escola_vis', compact('escolas', 'endereco'));
    }
// Metodo que edita os dados ja cadastrados
    public function iditando($idEscola) {
        $dadosForm = request()->all();
        $validando = Validator::make($dadosForm, tb_escola::$camposObg);
        if ($validando->fails()) {
            $messages = $validando->messages();
            $displayErros = '';
            foreach ($messages->all("<p>:message</p>") as $errors) {
                $displayErros .= $errors;
            } return $displayErros;
        }
        $escolas = $this->tb_escola->find($idEscola);
        $updateEscola = $escolas->update($dadosForm);
        $idEndereco = $escolas->tb_endereco_idEndereco;
        $endereco = $this->tb_endereco->find($idEndereco);
        $updateEndereco = $endereco->update($dadosForm);
        if ($updateEscola) {
            return 'EscolaAtualizada';
        } else {
 }
    }
    //FIM DA CLASSE CONTROLE DA ESCOLA  
}
