<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/** Quem é o professor logado e o que ele pode acessar. */
class ProfessorLogado
{
    private static ?int $id = null;
    private static ?array $turmas = null;

    /** Reseta o cache estático (útil entre requisições em testes). */
    public static function reset(): void
    {
        self::$id    = null;
        self::$turmas = null;
    }

    /** Retorna o idFuncionarios do professor logado, ou null se não autenticado. */
    public static function id(): ?int
    {
        if (self::$id === null) {
            $u = auth()->guard('guardLogin')->user();
            self::$id = $u ? (int) $u->tb_funcionarios_idFuncionarios : 0;
        }
        return self::$id ?: null;
    }

    /** IDs das turmas em que o professor leciona. */
    public static function idsTurmas(): array
    {
        if (self::$turmas === null) {
            self::$turmas = self::id()
                ? DB::table('tb_turmas_disciplinas')
                    ->where('tb_funcionarios_idFuncionarios', self::id())
                    ->distinct()
                    ->pluck('tb_turmas_idTurmas')
                    ->map(fn ($v) => (int) $v)
                    ->all()
                : [];
        }
        return self::$turmas;
    }

    /** Turmas ativas do professor, ordenadas por nome. */
    public static function turmasAtivas(): Collection
    {
        return DB::table('tb_turmas')
            ->whereIn('idTurmas', self::idsTurmas() ?: [0])
            ->whereIn('SituacaoTurma', ['ATIVO', 'ATIVA'])
            ->orderBy('NomeTurma')
            ->get();
    }

    /** Verifica se o professor pode acessar uma determinada turma. */
    public static function podeAcessarTurma($idTurma): bool
    {
        return in_array((int) $idTurma, self::idsTurmas(), true);
    }

    /** Verifica se o professor pode acessar o aluno (pela turma dele). */
    public static function podeAcessarAluno($idAluno): bool
    {
        $t = DB::table('tb_aluno')->where('idAluno', $idAluno)->value('tb_turmas_idTurmas');
        return $t !== null && self::podeAcessarTurma($t);
    }

    /** Disciplinas do professor nesta turma. */
    public static function disciplinasNaTurma($idTurma): Collection
    {
        return DB::table('tb_turmas_disciplinas')
            ->join(
                'tb_disciplinas',
                'tb_disciplinas.idDisciplinas',
                '=',
                'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas'
            )
            ->where('tb_turmas_disciplinas.tb_turmas_idTurmas', $idTurma)
            ->where('tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', self::id() ?? 0)
            ->select('tb_turmas_disciplinas.*', 'tb_disciplinas.NomeDisciplina')
            ->orderBy('tb_disciplinas.NomeDisciplina')
            ->get();
    }

    /** Verifica se o professor pode lançar notas nesta disciplina nesta turma. */
    public static function podeLancarDisciplina($idTurma, $idDisciplina): bool
    {
        return self::disciplinasNaTurma($idTurma)
            ->contains(fn ($d) => (int) $d->tb_disciplinas_idDisciplinas === (int) $idDisciplina);
    }

    /** Nome completo do professor logado, ou null. */
    public static function nome(): ?string
    {
        if (!self::id()) {
            return null;
        }
        $func = DB::table('tb_funcionarios')->where('idFuncionarios', self::id())->first();
        return $func?->NomeFuncionario ?? null;
    }
}
