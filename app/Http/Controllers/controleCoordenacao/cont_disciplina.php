<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_disciplina;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;
//Controle (metodos) principais do modulo disciplina
class cont_disciplina extends Controller {

    private $request;
    private $validator;
    private $tb_disciplina;
    private $NomesDisciplinas;
    private $NomeDisciplina;

    public function __construct(tb_disciplina $tb_disciplina = null) {
        $this->request = request();
        $this->tb_disciplina = $tb_disciplina ?? new tb_disciplina();
    }

//Metodo Para Direcionar ao cadastro de uma nova disciplina
    public function novadisciplina() {
        return view('telasCoordenacao.disciplinas.disciplina_cad');
    }

//Metodo para salva uma nova disciplina
    public function postnovadisciplina() {
        $req = request();
        $nome = $req->input('NomeDisciplina');
        $disciplinas = $req->input('Disciplinas');

        if (empty($nome) && empty($disciplinas)) {
            return 'DesciplinaNaoinformada';
        } else if (!empty($nome) && !empty($disciplinas)) {
            return '2campos';
        } else if (!empty($nome) && empty($disciplinas)) {
            $verificar = DB::table('tb_disciplinas')->where('NomeDisciplina', '=', $nome)->first();
            if (!$verificar) {
                tb_disciplina::create(['NomeDisciplina' => $nome]);
                if (!request()->ajax() && !request()->wantsJson()) {
                    return redirect('/coordenacao/novadisciplina')->with('success', 'Disciplina cadastrada com sucesso!');
                }
                return 1;
            } else {
                if (!request()->ajax() && !request()->wantsJson()) {
                    return redirect()->back()->with('error', 'Desculpe, disciplina já cadastrada!')->withInput();
                }
                return 'Desculpe, disciplina já cadastrada !';
            }
        } else if (empty($nome) && !empty($disciplinas)) {
            if (is_array($disciplinas)) {
                foreach ($disciplinas as $discItem) {
                    $verificar = DB::table('tb_disciplinas')->where('NomeDisciplina', '=', $discItem)->first();
                    if (!$verificar) {
                        tb_disciplina::create(['NomeDisciplina' => $discItem]);
                    }
                }
            }
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/novadisciplina')->with('success', 'Disciplinas cadastradas com sucesso!');
            }
            return 1;
        }
        if (!request()->ajax() && !request()->wantsJson()) {
            return redirect('/coordenacao/novadisciplina')->with('success', 'Operação realizada com sucesso!');
        }
        return 1;
    }

// Metodo para busca valores da tabela do bando de dados:    
    public function disciplina_inf() {      
        $disciplinas = tb_disciplina::disciplinasCadastradas();     
        return view('telasCoordenacao.disciplinas.disciplina_inf', compact('disciplinas'));
    }
//Metodo que busca os dados para edição e direciona ao seu formulario.
    public function editar($idDisciplinas) {
        $disciplina = DB::table('tb_disciplinas')->where('idDisciplinas', $idDisciplinas)->first();
        $titulo = 'Editar disciplina';
        return view('telasCoordenacao.disciplinas.disciplina_cad', compact('disciplina', 'titulo'));
    }
// Metodo que realizar o update com os novos dados informados.
    public function editando($idDisciplinas) {
        $dadosForm = request()->all();
        $nome = $dadosForm['NomeDisciplina'] ?? null;
        if (empty($nome)) {
            return 'novaDesciplinaNaoinformada';
        }

        $jaExiste = DB::table('tb_disciplinas')
            ->where('NomeDisciplina', '=', $nome)
            ->where('idDisciplinas', '!=', $idDisciplinas)
            ->exists();

        if (!$jaExiste) {
            DB::table('tb_disciplinas')->where('idDisciplinas', $idDisciplinas)->update(['NomeDisciplina' => $nome]);
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect('/coordenacao/disciplina_inf')->with('success', 'Disciplina atualizada com sucesso!');
            }
            return 'disciplinaatualizada';
        } else {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Desculpe, disciplina já cadastrada!')->withInput();
            }
            return 'Desculpe, disciplina já cadastrada !';
        }
    }

    //Metodo para deletar disciplina com verificação de vinculos
    public function deletar($idDisciplinas) {
        $vinculosCount = DB::table('tb_turmas_disciplinas')->where('tb_disciplinas_idDisciplinas', $idDisciplinas)->count();
        if ($vinculosCount > 0) {
            return redirect('/coordenacao/disciplina_inf')->with('error', "Não é possível excluir a disciplina: vinculada a {$vinculosCount} turma(s).");
        }
        DB::table('tb_disciplinas')->where('idDisciplinas', $idDisciplinas)->delete();
        return redirect('/coordenacao/disciplina_inf')->with('success', 'Disciplina excluída com sucesso!');
    }

// Fechando o controle principal
}
