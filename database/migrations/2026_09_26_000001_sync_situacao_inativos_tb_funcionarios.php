<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Atualiza funcionarios que tem SAIU no nome para INATIVO
        DB::table('tb_funcionarios')
            ->where('NomeFuncionario', 'LIKE', '%SAIU%')
            ->update(['Situacao' => 'INATIVO']);

        // 2. Atualiza funcionarios que tem indicacao de falecido/atestado no nome
        DB::table('tb_funcionarios')
            ->where(function($q) {
                $q->where('NomeFuncionario', 'LIKE', '%FALECID%')
                  ->orWhere('NomeFuncionario', 'LIKE', '%ATESTADO%');
            })
            ->update(['Situacao' => 'INATIVO']);

        // 3. Atualiza funcionarios cujo usuario associado esteja INATIVO (e nao tenha usuario ATIVO)
        $inativoUserFuncIds = DB::table('tb_usuario')
            ->where('Situacao', 'INATIVO')
            ->where('tb_funcionarios_idFuncionarios', '>', 0)
            ->pluck('tb_funcionarios_idFuncionarios')
            ->toArray();

        $ativoUserFuncIds = DB::table('tb_usuario')
            ->where('Situacao', 'ATIVO')
            ->where('tb_funcionarios_idFuncionarios', '>', 0)
            ->pluck('tb_funcionarios_idFuncionarios')
            ->toArray();

        $idsToInactivate = array_diff($inativoUserFuncIds, $ativoUserFuncIds);

        if (!empty($idsToInactivate)) {
            DB::table('tb_funcionarios')
                ->whereIn('idFuncionarios', $idsToInactivate)
                ->update(['Situacao' => 'INATIVO']);
        }
    }

    public function down(): void
    {
        // No-op
    }
};
