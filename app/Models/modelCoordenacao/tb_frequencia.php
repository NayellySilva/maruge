<?php

namespace App\Models\modelCoordenacao;

use Illuminate\Database\Eloquent\Model;

class tb_frequencia extends Model {
    protected $table = 'tb_frequencia';
    protected $primaryKey = 'idfrequencia';
    public $timestamps = false;

    // Campos que podem ser preenchidos com informação do usuário
    protected $fillable = [
        'tb_turmas_idTurmas',
        'tb_aluno_idAluno',
        'DataFrequencia',
        'Dia',
        'Mes',
        'Ano',
        'Presenca',
        'inf_dia',
        'dia',
        'mes',
        'ano',
        'situacao',
        'RA'
    ];

    // Relacionamento com a tabela turma
    public function turmaAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_turma', 'idTurmas', 'tb_turmas_idTurmas');
    }

    // Relacionamento com a tabela Aluno
    public function RfrequenciaAluno() {
        return $this->hasOne('App\Models\modelCoordenacao\tb_aluno', 'idAluno', 'tb_aluno_idAluno');
    }

    // Salva a frequência em lote/matriz no estilo planilha
    public static function salvarMatrizFrequencia($idTurma, $mes, $ano, array $matrix) {
        $mesStr = str_pad($mes, 2, '0', STR_PAD_LEFT);
        $anoStr = (string)$ano;

        \DB::transaction(function() use ($idTurma, $mesStr, $anoStr, $matrix) {
            foreach ($matrix as $idAluno => $dias) {
                if (!is_array($dias)) continue;

                // Verifica se o aluno realmente existe na tabela tb_aluno para evitar erro de chave estrangeira
                $alunoExiste = \DB::table('tb_aluno')->where('idAluno', $idAluno)->exists();
                if (!$alunoExiste) continue;

                foreach ($dias as $dia => $situacao) {
                    $diaStr = str_pad($dia, 2, '0', STR_PAD_LEFT);
                    $dataFreq = "{$diaStr}/{$mesStr}/{$anoStr}";
                    $val = trim((string)$situacao);

                    if ($val === '') {
                        \DB::table('tb_frequencia')
                            ->where('tb_turmas_idTurmas', $idTurma)
                            ->where('tb_aluno_idAluno', $idAluno)
                            ->where(function($q) use ($diaStr) {
                                $q->where('Dia', $diaStr)->orWhere('dia', $diaStr);
                            })
                            ->where(function($q) use ($mesStr) {
                                $q->where('Mes', $mesStr)->orWhere('mes', $mesStr);
                            })
                            ->delete();
                    } else {
                        $exists = \DB::table('tb_frequencia')
                            ->where('tb_turmas_idTurmas', $idTurma)
                            ->where('tb_aluno_idAluno', $idAluno)
                            ->where(function($q) use ($diaStr) {
                                $q->where('Dia', $diaStr)->orWhere('dia', $diaStr);
                            })
                            ->where(function($q) use ($mesStr) {
                                $q->where('Mes', $mesStr)->orWhere('mes', $mesStr);
                            })
                            ->first();

                        if ($exists) {
                            \DB::table('tb_frequencia')
                                ->where('tb_turmas_idTurmas', $idTurma)
                                ->where('tb_aluno_idAluno', $idAluno)
                                ->where(function($q) use ($diaStr) {
                                    $q->where('Dia', $diaStr)->orWhere('dia', $diaStr);
                                })
                                ->where(function($q) use ($mesStr) {
                                    $q->where('Mes', $mesStr)->orWhere('mes', $mesStr);
                                })
                                ->update([
                                    'DataFrequencia' => $dataFreq,
                                    'Presenca'       => $val,
                                    'Dia'            => $diaStr,
                                    'Mes'            => $mesStr,
                                    'Ano'            => $anoStr,
                                ]);
                        } else {
                            \DB::table('tb_frequencia')->insert([
                                'tb_turmas_idTurmas' => $idTurma,
                                'tb_aluno_idAluno'   => $idAluno,
                                'DataFrequencia'     => $dataFreq,
                                'Dia'                => $diaStr,
                                'Mes'                => $mesStr,
                                'Ano'                => $anoStr,
                                'Presenca'           => $val,
                            ]);
                        }
                    }
                }
            }
        });

        return true;
    }

    // Metodo pra salvar formulário tradicional de chamada
    public static function salvandoFrequencia($dadosForm) {
        $count = count($dadosForm["RA"] ?? []);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                if (!empty($dadosForm["RA"][$i])) {
                    $idTurma = $dadosForm["tb_turmas_idTurmas"][$i] ?? null;
                    $idAluno = $dadosForm["tb_aluno_idAluno"][$i] ?? null;
                    
                    $diaRaw = is_array($dadosForm["dia"] ?? null) ? ($dadosForm["dia"][$i] ?? date('d')) : ($dadosForm["dia"] ?? date('d'));
                    $mesRaw = is_array($dadosForm["mes"] ?? null) ? ($dadosForm["mes"][$i] ?? date('m')) : ($dadosForm["mes"] ?? date('m'));
                    $anoRaw = is_array($dadosForm["ano"] ?? null) ? ($dadosForm["ano"][$i] ?? date('Y')) : ($dadosForm["ano"] ?? date('Y'));

                    $diaStr = str_pad((string)$diaRaw, 2, '0', STR_PAD_LEFT);
                    $mesStr = str_pad((string)$mesRaw, 2, '0', STR_PAD_LEFT);
                    $anoStr = (string)$anoRaw;
                    $situacao = $dadosForm["situacao"][$i] ?? 'PRESENTE';

                    if ($idTurma && $idAluno) {
                        self::salvarMatrizFrequencia($idTurma, $mesStr, $anoStr, [
                            $idAluno => [
                                $diaStr => $situacao
                            ]
                        ]);
                    }
                }
            }
            return "FrequenciaRealizada";
        }
    }

    // Buscando a frequencia do aluno, referente ao mes informado
    public static function Busca_Frequencia_do_Aluno($idAluno, $mes) {
        $mesStr = str_pad($mes, 2, '0', STR_PAD_LEFT);
        return tb_frequencia::where('tb_aluno_idAluno', '=', $idAluno)
            ->where(function($q) use ($mesStr) {
                $q->where('mes', '=', $mesStr)->orWhere('Mes', '=', $mesStr);
            })
            ->get();
    }

    // Buscando as presenças do aluno
    public static function Busca_Presenca($idAluno, $mes) {
        $mesStr = str_pad($mes, 2, '0', STR_PAD_LEFT);
        return tb_frequencia::where('tb_aluno_idAluno', '=', $idAluno)
            ->where(function($q) use ($mesStr) {
                $q->where('mes', '=', $mesStr)->orWhere('Mes', '=', $mesStr);
            })
            ->where(function($q) {
                $q->whereIn('situacao', ['PRESENTE', 'P'])
                  ->orWhereIn('Presenca', ['PRESENTE', 'P']);
            })
            ->count();
    }

    // Buscando as faltas do aluno
    public static function Busca_Falta($idAluno, $mes) {
        $mesStr = str_pad($mes, 2, '0', STR_PAD_LEFT);
        return tb_frequencia::where('tb_aluno_idAluno', '=', $idAluno)
            ->where(function($q) use ($mesStr) {
                $q->where('mes', '=', $mesStr)->orWhere('Mes', '=', $mesStr);
            })
            ->where(function($q) {
                $q->whereIn('situacao', ['FALTA', 'F'])
                  ->orWhereIn('Presenca', ['FALTA', 'F']);
            })
            ->count();
    }

    // Buscando as justificativas do aluno
    public static function Busca_Justificado($idAluno, $mes) {
        $mesStr = str_pad($mes, 2, '0', STR_PAD_LEFT);
        return tb_frequencia::where('tb_aluno_idAluno', '=', $idAluno)
            ->where(function($q) use ($mesStr) {
                $q->where('mes', '=', $mesStr)->orWhere('Mes', '=', $mesStr);
            })
            ->where(function($q) {
                $q->whereIn('situacao', ['JUSTIFICADO', 'FJ', 'ATESTADO', 'A'])
                  ->orWhereIn('Presenca', ['JUSTIFICADO', 'FJ', 'ATESTADO', 'A']);
            })
            ->count();
    }

    // Buscando os atestados do aluno
    public static function Busca_Atestado($idAluno, $mes) {
        $mesStr = str_pad($mes, 2, '0', STR_PAD_LEFT);
        return tb_frequencia::where('tb_aluno_idAluno', '=', $idAluno)
            ->where(function($q) use ($mesStr) {
                $q->where('mes', '=', $mesStr)->orWhere('Mes', '=', $mesStr);
            })
            ->where(function($q) {
                $q->whereIn('situacao', ['ATESTADO', 'A'])
                  ->orWhereIn('Presenca', ['ATESTADO', 'A']);
            })
            ->count();
    }

    public static function buscandoFrequenciadoAluno($idTurma) {
        return tb_frequencia::join('tb_aluno', 'tb_aluno.idAluno', '=', 'tb_frequencia.tb_aluno_idAluno')
            ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_frequencia.tb_turmas_idTurmas')
            ->select('tb_frequencia.*')
            ->where('tb_frequencia.tb_turmas_idTurmas', $idTurma)
            ->get();
    }

    public static function buscandoFrequenciadoAluno2($idTurma) {
        return tb_aluno::orderBy('NomeAluno')
            ->join('tb_matriculas', 'tb_matriculas.idMatriculas', '=', 'tb_aluno.tb_matriculas_idMatriculas')
            ->join('tb_turmas', 'tb_turmas.idTurmas', '=', 'tb_aluno.tb_turmas_idTurmas')
            ->select('tb_aluno.idAluno', 'tb_aluno.NomeAluno', 'tb_aluno.DataNascimento', 'tb_matriculas.RA', 'tb_matriculas.SituacaoAluno', 'tb_turmas.NomeTurma')
            ->where('tb_matriculas.SituacaoAluno', 'ATIVO')
            ->get();
    }
}