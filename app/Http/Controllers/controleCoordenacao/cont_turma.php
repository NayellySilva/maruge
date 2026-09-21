<?php

namespace App\Http\Controllers\controleCoordenacao;
use App\Models\modelCoordenacao\tb_turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\modelCoordenacao\tb_escola;

// Controle (metodos) do modulo turma.
class cont_turma extends Controller {

    private $request;
    private $validator;
    private $tb_turma;

    public function __construct(Request $dadosForm, tb_turma $tb_turma, Validator $validator) {
        $this->request = request();
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
    }

//Metodo Para Direcionar ao cadastro de Turma (turma_form)
    public function novaturma() {
        return view('telasCoordenacao.turma.turma_cad');
    }

//Metodo para salva uma nova turma
    public function postnovaturma() {
        $dadosForm = request()->all();
        $validando = Validator::make($dadosForm, tb_turma::$camposObg);
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
// Chama o metodo verificar se a turma existem passado o parametro para consultar e ja verifica se esta vazio
        $verificar = tb_turma::verificarSeTurmaExistem($dadosForm)->isEmpty();
        if ($verificar == true) {
            tb_turma::create($dadosForm);
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/cadturma')->with('success', 'Turma cadastrada com sucesso!');
            }
            return 1;
        } else {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Desculpe, turma já cadastrada!')->withInput();
            }
            return 'Desculpe, turma já cadastrada !';
        }
    }

// Metodo para busca as turmas (padrao: ATIVAS) com suporte a filtros combinados
    public function turma_inf() {
        $pesquisar = $this->request->get('pesquisar');
        $SituacaoTurma = $this->request->get('SituacaoTurma', 'ATIVO');
        if (empty($SituacaoTurma)) {
            $SituacaoTurma = 'ATIVO';
        }

        $query = tb_turma::orderBy('NomeTurma');

        if ($SituacaoTurma === 'ATIVO') {
            $query->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA']);
        } elseif ($SituacaoTurma === 'INATIVO') {
            $query->whereIn('SituacaoTurma', ['INATIVO', 'INATIVA', '[INATIVO]']);
        } elseif ($SituacaoTurma === 'TODOS') {
            // Sem filtro de situacao
        }

        if (!empty($pesquisar)) {
            $query->where(function($q) use ($pesquisar) {
                $q->where('NomeTurma', 'LIKE', "%{$pesquisar}%")
                  ->orWhere('AnoLetivo', 'LIKE', "%{$pesquisar}%");
            });
        }

        $turmas = $query->paginate(15)->appends($this->request->query());

        return view('telasCoordenacao.turma.turma_inf', compact('turmas', 'SituacaoTurma', 'pesquisar'));
    }

//Metodo que busca os dados para edição e direciona ao seu formulario.
    public function editar($idTurmas) {
        $turma = $this->tb_turma->find($idTurmas);
        $titulo = 'Editar Turma';
        return view('telasCoordenacao.turma.turma_cad', compact('turma', 'titulo'));
    }

// Metodo que realizar o update com os novos dados informados.
    public function editando($idTurmas) {
        $dadosForm = request()->all();
        $validando = Validator::make($dadosForm, tb_turma::$camposObg);
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

        $jaExiste = DB::table('tb_turmas')
            ->where('NomeTurma', $dadosForm['NomeTurma'])
            ->where('AnoLetivo', $dadosForm['AnoLetivo'])
            ->where('idTurmas', '!=', $idTurmas)
            ->exists();

        if (!$jaExiste) {
            $dataToUpdate = array_intersect_key($dadosForm, array_flip(['NomeTurma', 'Mensalidade', 'SituacaoTurma', 'AnoLetivo']));
            \Schema::disableForeignKeyConstraints();
            DB::table('tb_turmas')->where('idTurmas', $idTurmas)->update($dataToUpdate);
            \Schema::enableForeignKeyConstraints();
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/turma_inf')->with('success', 'Turma atualizada com sucesso!');
            }
            return 'turmaatualizada';
        } else {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Desculpe, Turma já Existe !')->withInput();
            }
            return 'Desculpe, Turma já Existe !';
        }
    }

    //Metodo pesquisar uma turma por palavra chave
    public function turma_pesq() {
        return $this->turma_inf();
    }

    //Metodo pesquisar turma por filtro Situação
    public function turma_filtro() {
        return $this->turma_inf();
    }

    //Metodo para deletar turma com verificação de vinculos
    public function deletar($idTurmas) {
        $alunosCount = DB::table('tb_aluno')->where('tb_turmas_idTurmas', $idTurmas)->count();
        if ($alunosCount > 0) {
            return redirect('/coordenacao/turma_inf')->with('error', "Não é possível excluir a turma: existem {$alunosCount} aluno(s) vinculados.");
        }
        \Schema::disableForeignKeyConstraints();
        DB::table('tb_turmas')->where('idTurmas', $idTurmas)->delete();
        \Schema::enableForeignKeyConstraints();
        return redirect('/coordenacao/turma_inf')->with('success', 'Turma excluída com sucesso!');
    }

//FIM DA CLASSE CONTROLE DA TURMA 
}
