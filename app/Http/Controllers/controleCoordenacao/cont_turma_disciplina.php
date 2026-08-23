<?php

namespace App\Http\Controllers\controleCoordenacao;

use App\Models\modelCoordenacao\tb_turma;
use App\Models\modelCoordenacao\tb_disciplina;
use App\Models\modelCoordenacao\tb_funcionario;
use App\Models\modelCoordenacao\tb_turmas_disciplinas;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Http\Controllers\Controller;

// Controle (metodos) do modulo turma.
class cont_turma_disciplina extends Controller {

    private $request;
    private $validator;
    private $tb_turma;
    private $tb_disciplina;
    private $tb_funcionario;
    public function __construct(Request $dadosForm, tb_turma $tb_turma, tb_disciplina $tb_disciplina, tb_funcionario $tb_funcionario, Validator $validator) {
        $this->request = $dadosForm;
        $this->validator = $validator;
        $this->tb_turma = $tb_turma;
        $this->tb_disciplina = $tb_disciplina;
        $this->tb_funcionario = $tb_funcionario;
    }
//Metodo Para ao página de lotação professor -turma-disciplina
    public function vincularProfessor() {
        $turmasLocadas = tb_turma::listandoTurmaslocadas();
        $turmas = tb_turma::turmasAtivas();
        $disciplinas = tb_disciplina::listagemDeDisciplinas();
        $professores = tb_funcionario::funcionarioDocentes();
        $disciplinasDoProfessor = tb_turmas_disciplinas::disciplinasDoProfessor();
        //dd($disciplinasDoProfessor);
        return view('telasCoordenacao.turma_disc.turma_disciplina_cad', compact('turmas','turmasLocadas', 'disciplinas', 'professores','disciplinasDoProfessor'));
    }
// Colocando professor nas turmas com suas disciplinas (Suporte a seleção múltipla)
    public function postvincularProfessor() {
        $idFuncionarios = $this->request->input('idFuncionarios');
        $idTurmasRaw = $this->request->input('idTurmas');
        $idDisciplinasRaw = $this->request->input('idDisciplinas');

        $idTurmas = is_array($idTurmasRaw) ? array_filter($idTurmasRaw) : ($idTurmasRaw ? [$idTurmasRaw] : []);
        $idDisciplinas = is_array($idDisciplinasRaw) ? array_filter($idDisciplinasRaw) : ($idDisciplinasRaw ? [$idDisciplinasRaw] : []);

        if (!$idFuncionarios || empty($idTurmas) || empty($idDisciplinas)) {
            if (!request()->ajax() && !request()->wantsJson()) {
                return redirect()->back()->with('error', 'Por favor, selecione ao menos uma Turma, uma Disciplina e o Professor.')->withInput();
            }
            return 'Por favor, selecione ao menos uma Turma, uma Disciplina e o Professor.';
        }

        $cadastrados = 0;
        $atualizados = 0;

        foreach ($idTurmas as $turmaId) {
            foreach ($idDisciplinas as $disciplinaId) {
                $existe = \DB::table('tb_turmas_disciplinas')
                    ->where('tb_turmas_idTurmas', $turmaId)
                    ->where('tb_disciplinas_idDisciplinas', $disciplinaId)
                    ->exists();

                if (!$existe) {
                    \DB::table('tb_turmas_disciplinas')->insert([
                        'tb_turmas_idTurmas' => $turmaId,
                        'tb_disciplinas_idDisciplinas' => $disciplinaId,
                        'tb_funcionarios_idFuncionarios' => $idFuncionarios,
                    ]);
                    $cadastrados++;
                } else {
                    \DB::table('tb_turmas_disciplinas')
                        ->where('tb_turmas_idTurmas', $turmaId)
                        ->where('tb_disciplinas_idDisciplinas', $disciplinaId)
                        ->update(['tb_funcionarios_idFuncionarios' => $idFuncionarios]);
                    $atualizados++;
                }
            }
        }

        $mensagem = "Lotação cadastrada com sucesso! ({$cadastrados} novo(s) vínculo(s)";
        if ($atualizados > 0) {
            $mensagem .= ", {$atualizados} atualizado(s)";
        }
        $mensagem .= ").";

        if (!request()->ajax() && !request()->wantsJson()) {
            return redirect('/coordenacao/turma_disc/turma_disciplina_inf')->with('success', $mensagem);
        }
        return $mensagem;
    }
    
    //Metodo que chama os metodos da model para página de informações
    public function turmaDisciplinaInf() {
        $turmas = tb_turma::turmasAtivas();                
        $professores = tb_funcionario::funcionarioDocentes();
        $idFuncionarios = request()->get('idFuncionarios');
        $idTurmas = request()->get('idTurmas');

        if ($idFuncionarios) {
            $disciplinasDoProfessor = tb_turmas_disciplinas::professorEscolhido($idFuncionarios);
        } elseif ($idTurmas) {
            $disciplinasDoProfessor = tb_turmas_disciplinas::turmaEscolhida($idTurmas);
        } else {
            $disciplinasDoProfessor = tb_turmas_disciplinas::listadisciplinasDoProfessor();
        }

        return view('telasCoordenacao.turma_disc.turma_disciplina_inf', compact('turmas', 'disciplinasDoProfessor', 'professores'));
    }

    // metodo que chama os medotos de filtrar as disciplinas e as turmas de um determinado professor
    public function turma_disciplina_pesq() {
        return $this->turmaDisciplinaInf();
    }

    // metodo que chama os medotos de filtrar as disciplinas e os professores de uma determinada turma
    public function turma_disciplina_filtro() {
        return $this->turmaDisciplinaInf();
    }

    public function turma_disciplina_deletar($idTurmas_Disciplinas) {    
        try {
            \DB::table('tb_turmas_disciplinas')
                ->where('idTurmas_Disciplinas', $idTurmas_Disciplinas)
                ->orWhere('tb_turmas_idTurmas', $idTurmas_Disciplinas)
                ->delete();
        } catch (\Exception $e) {}
        return redirect('/coordenacao/turma_disc/turma_disciplina_inf')->with('success', 'Vínculo removido com sucesso!');
    }
    
//Fim da classe principal
}
