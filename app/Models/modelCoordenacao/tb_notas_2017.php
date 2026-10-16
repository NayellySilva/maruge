<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_notas_2017 extends Model {

    protected $table = 'tb_notas_2017';
    protected $primaryKey = 'idNotas';
    //Campos que podem ser preenchido com informação do usuario
    protected $fillable = [
        'RA', 'AM1', 'AB1', 'AM2', 'AB2',
        'AM3', 'AB3', 'AM4', 'AB4', 'RP', 'RF',
        'tb_disciplinas_idDisciplinas', 'tb_usuario_idUsuario',
        'tb_turmas_idTurmas', 'tb_aluno_idAluno'
    ];

    /*     * **************
      Relacionamentos entre as tabelas
     * ************* */

    //Relacionamento com a tabela Aluno
    public function RnotasAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_aluno', 'idAluno', 'tb_aluno_idAluno');
    }

// Buscando a nota do aluno, referente a disciplina informada no parametro
    public static function busca_notas_do_aluno_2017($idAluno, $disciplina) {
        return tb_notas_2017::select()
                        ->select('tb_notas_2017.*')
                        ->where('tb_notas_2017.tb_aluno_idAluno', '=', $idAluno)
                        ->where('tb_notas_2017.tb_disciplinas_idDisciplinas', '=', $disciplina)
                        ->get('AB1');
    }
//Editando nota atravez do seu id principal.
    public static function editandoNotas($dadosForm) {
        $idNotas = tb_notas_2017:: select()->find($dadosForm["idNotas"]);
        $updateNota = $idNotas->update($dadosForm);
        return $updateNota;
    }
    //Metodo pra salva nota dos alunos educação infantil 1bim
    public static function salva_nota_1bim_inf($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["AB1"][$i])) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AB1' => $dadosForm["AB1"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }

    //Metodo pra salva nota dos alunos educação infantil 2bim
    public static function salva_nota_2bim_inf($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["AB2"][$i])) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AB2' => $dadosForm["AB2"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }

    //Metodo pra salva nota dos alunos educação infantil 3bim
    public static function salva_nota_3bim_inf($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["AB3"][$i])) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AB3' => $dadosForm["AB3"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }

    //Metodo pra salva nota dos alunos educação infantil 4bim
    public static function salva_nota_4bim_inf($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["AB4"][$i])) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AB4' => $dadosForm["AB4"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }

    /**
     * ********************************************
     * *******************************************
      Metodos para uso exclusivo para turma do Fundamental I
     * ********************************************
     * *******************************************
     * */
    //Metodo pra salva nota dos alunos  Fundamental I 1bim
    public static function salva_nota_1bim_fun1($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["AB1"][$i])) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AB1' => $dadosForm["AB1"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }

    //Metodo pra salva nota dos alunos Fundamental 1 2bim
    public static function salva_nota_2bim_fun1($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["AB2"][$i])) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AB2' => $dadosForm["AB2"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }

    //Metodo pra salva nota dos alunos Fundamental I 3bim
    public static function salva_nota_3bim_fun1($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["AB3"][$i])) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AB3' => $dadosForm["AB3"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }

    //Metodo pra salva nota dos alunos fundamental I 4bim
    public static function salva_nota_4bim_fun1($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["AB4"][$i])) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AB4' => $dadosForm["AB4"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];


                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();



                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }
        //Metodo pra salva nota dos alunos fundamental II 1bim
    public static function salva_nota_1bim_fun2($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
      if (!empty($dadosForm["AM1"][$i]) or ($dadosForm["AB1"][$i])   ) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AM1' => $dadosForm["AM1"][$i],
                        'AB1' => $dadosForm["AB1"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }
        //Metodo pra salva nota dos alunos fundamental II 2bim
    public static function salva_nota_2bim_fun2($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
      if (!empty($dadosForm["AM2"][$i]) or ($dadosForm["AB2"][$i])   ) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AM2' => $dadosForm["AM2"][$i],
                        'AB2' => $dadosForm["AB2"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }
        //Metodo pra salva nota dos alunos fundamental II 3bim
    public static function salva_nota_3bim_fun2($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
      if (!empty($dadosForm["AM3"][$i]) or ($dadosForm["AB3"][$i])   ) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AM3' => $dadosForm["AM3"][$i],
                        'AB3' => $dadosForm["AB3"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }
        //Metodo pra salva nota dos alunos fundamental II 4bim
    public static function salva_nota_4bim_fun2($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
      if (!empty($dadosForm["AM4"][$i]) or ($dadosForm["AB4"][$i])   ) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'AM4' => $dadosForm["AM4"][$i],
                        'AB4' => $dadosForm["AB4"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }
        //Metodo pra salva notas de recuperação parcial e final
    public static function salva_nota_rp_rf($dadosForm) {
        $count = count($dadosForm["tb_disciplinas_idDisciplinas"]); // CRIANDO UM CONTADO BASIANDO NA QUANTIDADE DE NOTAS
        if ($count > 0) { // SE CONTE FOR MAIOR QUE ZERO ELE ENTRA NO FOR
            $nota = [];   // CRIANDO UM ARRAY NOVO PRA FICA RECEBENDO DADOS DOS ARRAYS
            for ($i = 0; $i < $count; $i++) {
      if (!empty($dadosForm["RP"][$i]) or ($dadosForm["RF"][$i])   ) {
                    $nota = [// ARRAY RECEBENDO OS DADOS DO FOR
                        'RP' => $dadosForm["RP"][$i],
                        'RF' => $dadosForm["RF"][$i],
                        'tb_disciplinas_idDisciplinas' => $dadosForm["tb_disciplinas_idDisciplinas"][$i],
                        'tb_usuario_idUsuario' => $dadosForm["tb_usuario_idUsuario"][$i],
                        'tb_turmas_idTurmas' => $dadosForm["tb_turmas_idTurmas"][$i],
                        'RA' => $dadosForm["RA"][$i],
                        'tb_aluno_idAluno' => $dadosForm["tb_aluno_idAluno"][$i],
                    ];
                    $contador = tb_notas_2017::select()// buscando disciplina/turma e aluno para verificar se é caso de salvar ou atualizar pois cada disciplina tem seus bimestres
                            ->select('tb_notas_2017.*')
                            ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                            ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                            ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                            ->count();
                    if ($contador >= 1) {// se a busca acima retorna verdadeiro, ou seja estive dados ele tem que pegar os dados e atualizar
                        $atualizando[] = tb_notas_2017::select()
                                ->select('tb_notas_2017.*')
                                ->where('tb_disciplinas_idDisciplinas', '=', $dadosForm["tb_disciplinas_idDisciplinas"][$i])
                                ->where('tb_turmas_idTurmas', '=', $dadosForm["tb_turmas_idTurmas"][$i])
                                ->where('tb_aluno_idAluno', '=', $dadosForm["tb_aluno_idAluno"][$i])
                                ->update($nota);
                    } else { // salva as notas caso não exista um disciplina na turma vinculada ao aluno.
                        tb_notas_2017::create($nota); // SALVANDO OS DADOS NO BANCO
                    }
                }
            }
            return "notalancada";
        }
    }
//Fechando a Class Principal
}