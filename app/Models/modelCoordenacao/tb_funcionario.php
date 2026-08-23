<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_funcionario extends Model {

    protected $table = 'tb_funcionarios';
    protected $primaryKey = 'idFuncionarios';
    public $timestamps = false;
    protected $fillable = [
        'NomeFuncionario', 'CPFFuncionario', 'RGFuncionario', 'Funcao',
        'Salario', 'EmailFuncionario', 'Formacao'
    ];
    // Campos Obrigatorios
    static $camposObg = [
        'NomeFuncionario' => 'required',
        'CPFFuncionario' => 'required',
        'Funcao' => 'required',
        'EmailFuncionario' => 'email|required',
    ];

    public function endFuncionario() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_endereco', 'idEndereco', 'tb_endereco_idEndereco');
    }

    public static function salvaFuncionario($dadosForm) {
        $novoEndereco = new tb_endereco($dadosForm);
        $novoEndereco->save();
        $novoFuncionario = new tb_funcionario($dadosForm);
        if (empty($novoFuncionario->RGFuncionario)) {
            $novoFuncionario->RGFuncionario = $dadosForm['RG'] ?? '0000000';
        }
        if (!isset($novoFuncionario->Salario)) {
            $novoFuncionario->Salario = $dadosForm['Salario'] ?? 0;
        }
        if (!isset($novoFuncionario->Formacao)) {
            $novoFuncionario->Formacao = $dadosForm['Formacao'] ?? '';
        }
        $novoFuncionario->tb_endereco_idEndereco = $novoEndereco->idEndereco;
        $novoFuncionario->save();
        return 1;
    }

    // Puxando todas as informações sobre o funcionario   
    public static function informacaoFuncionario() {
        return tb_funcionario::orderBy('NomeFuncionario')
                        ->leftJoin('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_funcionarios.tb_endereco_idEndereco')
                        ->select('tb_funcionarios.idFuncionarios', 'tb_funcionarios.NomeFuncionario', 'tb_funcionarios.Funcao', 'tb_funcionarios.tb_endereco_idEndereco', 'tb_endereco.Fone1', 'tb_endereco.Fone2')
                        ->paginate(15);
    }

    public static function funcionarioCadastrados() {
        return tb_funcionario::select('NomeFuncionario', 'idFuncionarios', 'CPFFuncionario')
                        ->orderBy('NomeFuncionario')
                        ->get();
    }

    //Listagem de funcionario Docentes (Professores)
    public static function funcionarioDocentes() {
        return tb_funcionario::select('NomeFuncionario', 'idFuncionarios')
                        ->orderBy('NomeFuncionario')
                        ->where('Funcao', 'DOCENTE')
                        ->get();
    }

// Atualizando os dados dos funcionarios
    public static function editandofuncionario($dadosForm, $idFuncionarios) {
        $Funcionario = tb_funcionario::select()->find($idFuncionarios);
        $updateFuncionario = $Funcionario->update($dadosForm);
        $idEndereco = $Funcionario->tb_endereco_idEndereco;
        $endereco = tb_endereco::select()->find($idEndereco);
        $updateEndereco = $endereco->update($dadosForm);
        return $updateFuncionario;
    }

// Metodo que mostra o perfil do Funcionario
    public static function perfilFuncionario($idFuncionarios) {
        $Funcionario = tb_funcionario::select()->find($idFuncionarios)
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_funcionarios.tb_endereco_idEndereco')
                ->select('tb_funcionarios.*', 'tb_endereco.*')
                ->where('idFuncionarios', $idFuncionarios)
                ->get();
        return $Funcionario;
    }


    // Metodo que pesquisa funcionarios pos palavra chave
    public static function pesquisar($palavrachave) {
        $Funcionarios = tb_funcionario::select()
                ->orderBy('NomeFuncionario')
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_funcionarios.tb_endereco_idEndereco')
                ->select('tb_funcionarios.idFuncionarios', 'tb_funcionarios.NomeFuncionario', 'tb_funcionarios.Funcao', 'tb_funcionarios.tb_endereco_idEndereco', 'tb_endereco.Fone1', 'tb_endereco.Fone2')
                ->where('NomeFuncionario', 'LIKE', "%$palavrachave%")
                ->paginate(10);
        return $Funcionarios;
    }

    // Metodo que fas uma listagem de todos os professores em suas turmas com suas determinada disciplina(turma_disciplina_cad)    
    public static function TurmasdoProfessor($idFuncionarios) {
        return tb_turmas_disciplinas::select()
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
                        ->orderBy('NomeTurma')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_turmas_disciplinas.tb_turmas_idTurmas')
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios')
                        ->select('tb_funcionarios.NomeFuncionario', 'tb_turmas.NomeTurma','tb_turmas.idTurmas')
                        ->groupby('NomeTurma')
                        ->get();
    }

    // Metodo que busca as disciplinas do professor sobre seu id e o id da turma
    public static function DisciplinasdoProfessor($idFuncionarios, $idTurmas) {
        return tb_turmas_disciplinas::select()
                   
                ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
                ->where('tb_turmas_disciplinas.tb_turmas_idTurmas', '=', $idTurmas)
                ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                ->select('tb_disciplinas.NomeDisciplina')
                ->groupby('NomeDisciplina')
                ->orderBy('NomeDisciplina')
                ->get();
    }
    // Metodo que busca as disciplinas do professor sobre seu id e o id da turma
    public static function DisciplinasdoProfessorX($idFuncionarios, $idTurmas) {
        return tb_turmas_disciplinas::select()
                       
                        ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', $idFuncionarios)
                        ->join('tb_funcionarios', 'tb_funcionarios.idFuncionarios', '=', $idFuncionarios)
                        ->join('tb_disciplinas', 'tb_disciplinas.idDisciplinas', '=', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas')
                        ->join('tb_turmas', 'tb_turmas.idTurmas', '=', $idTurmas)
                        ->join('tb_turmas_disciplinas', 'tb_turmas.idTurmas', '=', $idTurmas)
                        ->select('tb_disciplinas.NomeDisciplina')
                        ->groupby('NomeDisciplina')
                        ->orderBy('NomeDisciplina')
                        ->get();
    }
        // Verificando se já existe o funcionario cadastrado
    public static function verificarSeFuncionarioExiste($dadosForm) {
        $verificar = tb_funcionario::select()
                ->where('NomeFuncionario', '=', $dadosForm['NomeFuncionario'])
                ->where('CPFFuncionario', '=', $dadosForm['CPFFuncionario'])
                ->get();
        return $verificar;
    }
    
    
    
    // METODO USADOS NO MODULO DO DOCENTE
    // Metodo que busca dados do funcionario para declaração
    public static function declaracaoFuncionario($idFuncionarios) {
        $Funcionario = tb_funcionario::select()->find($idFuncionarios)
                ->join('tb_endereco', 'tb_endereco.idEndereco', '=', 'tb_funcionarios.tb_endereco_idEndereco')
                ->select('tb_funcionarios.*')
                ->where('idFuncionarios', $idFuncionarios)
                ->get();
        return $Funcionario;
    }
// Fechando a classe principal
}
