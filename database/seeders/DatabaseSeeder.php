<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Desativar restrições de chave estrangeira durante o seeding no SQLite
        DB::statement('PRAGMA foreign_keys = OFF;');

        // Limpar tabelas existentes para evitar duplicidade
        DB::table('tb_notas')->truncate();
        DB::table('tb_frequencia')->truncate();
        DB::table('tb_turmas_disciplinas')->truncate();
        DB::table('tb_aluno')->truncate();
        DB::table('tb_matriculas')->truncate();
        DB::table('tb_turmas')->truncate();
        DB::table('tb_disciplinas')->truncate();
        DB::table('tb_usuario')->truncate();
        DB::table('tb_funcionarios')->truncate();
        DB::table('tb_escola')->truncate();
        DB::table('tb_pais')->truncate();
        DB::table('tb_endereco')->truncate();

        DB::statement('PRAGMA foreign_keys = ON;');

        // 1. Criar Endereços
        $idEnderecoEscola = DB::table('tb_endereco')->insertGetId([
            'Fone1' => '(11) 99999-0001',
            'Numero' => '100',
            'Rua' => 'Rua Principal',
            'Bairro' => 'Centro',
            'CEP' => '01000-000',
            'Cidade' => 'São Paulo',
            'Estado' => 'SP'
        ]);

        $idEnderecoCoord = DB::table('tb_endereco')->insertGetId([
            'Fone1' => '(11) 99999-0002',
            'Numero' => '200',
            'Rua' => 'Rua das Flores',
            'Bairro' => 'Jardins',
            'CEP' => '02000-000',
            'Cidade' => 'São Paulo',
            'Estado' => 'SP'
        ]);

        $idEnderecoDocente = DB::table('tb_endereco')->insertGetId([
            'Fone1' => '(11) 99999-0003',
            'Numero' => '300',
            'Rua' => 'Av. Brasil',
            'Bairro' => 'Pinheiros',
            'CEP' => '03000-000',
            'Cidade' => 'São Paulo',
            'Estado' => 'SP'
        ]);

        $idEnderecoAluno1 = DB::table('tb_endereco')->insertGetId([
            'Fone1' => '(11) 98888-1111',
            'Numero' => '400',
            'Rua' => 'Rua dos Estudantes',
            'Bairro' => 'Vila Nova',
            'CEP' => '04000-000',
            'Cidade' => 'São Paulo',
            'Estado' => 'SP'
        ]);

        // 2. Criar Escola
        DB::table('tb_escola')->insert([
            'tb_endereco_idEndereco' => $idEnderecoEscola,
            'NomeEscola' => 'Escola Maruge',
            'CNPJ' => '12.345.678/0001-99',
            'EmailColegio' => 'contato@escolamaruge.edu.br',
            'NumeroInep' => '12345678'
        ]);

        // 3. Criar Funcionários (Coordenação e Docente)
        $idFuncCoord = DB::table('tb_funcionarios')->insertGetId([
            'tb_endereco_idEndereco' => $idEnderecoCoord,
            'NomeFuncionario' => 'Coordenador Principal',
            'CPFFuncionario' => '111.111.111-11',
            'RGFuncionario' => '12.345.678-9',
            'Funcao' => 'Coordenador',
            'Salario' => '5000',
            'EmailFuncionario' => 'coordenacao@maruge.com',
            'Formacao' => 'Pedagogia'
        ]);

        $idFuncDocente = DB::table('tb_funcionarios')->insertGetId([
            'tb_endereco_idEndereco' => $idEnderecoDocente,
            'NomeFuncionario' => 'Professor João Silva',
            'CPFFuncionario' => '222.222.222-22',
            'RGFuncionario' => '98.765.432-1',
            'Funcao' => 'Docente',
            'Salario' => '3500',
            'EmailFuncionario' => 'docente@maruge.com',
            'Formacao' => 'Licenciatura em Matemática'
        ]);

        // 4. Criar Usuários para Login (Coordenação e Docente)
        $idUsuarioCoord = DB::table('tb_usuario')->insertGetId([
            'tb_funcionarios_idFuncionarios' => $idFuncCoord,
            'password' => Hash::make('11111111'),
            'CPFUsuario' => '111.111.111-11',
            'Nivel' => 'COORDENACÃO',
            'Situacao' => 'ATIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $idUsuarioDocente = DB::table('tb_usuario')->insertGetId([
            'tb_funcionarios_idFuncionarios' => $idFuncDocente,
            'password' => Hash::make('11111111'),
            'CPFUsuario' => '222.222.222-22',
            'Nivel' => 'DOCENTE',
            'Situacao' => 'ATIVO',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 5. Criar Pais/Responsáveis
        $idPais1 = DB::table('tb_pais')->insertGetId([
            'NomePai' => 'Carlos Oliveira',
            'ProfPai' => 'Engenheiro',
            'FonePai1' => '(11) 97777-1111',
            'CPFPai' => '333.333.333-33',
            'RGPai' => '11.222.333-4',
            'NomeMae' => 'Maria Oliveira',
            'ProfMae' => 'Advogada',
            'CPFMae' => '444.444.444-44',
            'RGMae' => '44.333.222-1',
            'FoneMae1' => '(11) 97777-2222',
            'Responsavel' => 'Maria Oliveira',
            'CPFResponsavel' => '444.444.444-44',
            'RGResponsavel' => '44.333.222-1'
        ]);

        // 6. Criar Turmas (Usar nomes compatíveis com determinarNivelTurma)
        $idTurma1 = DB::table('tb_turmas')->insertGetId([
            'NomeTurma' => '1º Ano A',
            'Mensalidade' => '500,00',
            'SituacaoTurma' => 'ATIVO',
            'AnoLetivo' => '2026'
        ]);

        $idTurma2 = DB::table('tb_turmas')->insertGetId([
            'NomeTurma' => '6º Ano A',
            'Mensalidade' => '550,00',
            'SituacaoTurma' => 'ATIVO',
            'AnoLetivo' => '2026'
        ]);

        // 7. Criar Disciplinas
        $idDiscMat = DB::table('tb_disciplinas')->insertGetId([
            'NomeDisciplina' => 'Matemática'
        ]);

        $idDiscPort = DB::table('tb_disciplinas')->insertGetId([
            'NomeDisciplina' => 'Língua Portuguesa'
        ]);

        $idDiscHist = DB::table('tb_disciplinas')->insertGetId([
            'NomeDisciplina' => 'História'
        ]);

        $idDiscGeog = DB::table('tb_disciplinas')->insertGetId([
            'NomeDisciplina' => 'Geografia'
        ]);

        $idDiscCien = DB::table('tb_disciplinas')->insertGetId([
            'NomeDisciplina' => 'Ciências'
        ]);

        // 8. Vincular Turmas x Disciplinas x Docente
        $turmasDisciplinasList = [
            ['tb_turmas_idTurmas' => $idTurma1, 'tb_disciplinas_idDisciplinas' => $idDiscMat, 'tb_funcionarios_idFuncionarios' => $idFuncDocente],
            ['tb_turmas_idTurmas' => $idTurma1, 'tb_disciplinas_idDisciplinas' => $idDiscPort, 'tb_funcionarios_idFuncionarios' => $idFuncDocente],
            ['tb_turmas_idTurmas' => $idTurma1, 'tb_disciplinas_idDisciplinas' => $idDiscHist, 'tb_funcionarios_idFuncionarios' => $idFuncDocente],
            ['tb_turmas_idTurmas' => $idTurma1, 'tb_disciplinas_idDisciplinas' => $idDiscGeog, 'tb_funcionarios_idFuncionarios' => $idFuncDocente],
            ['tb_turmas_idTurmas' => $idTurma1, 'tb_disciplinas_idDisciplinas' => $idDiscCien, 'tb_funcionarios_idFuncionarios' => $idFuncDocente],

            ['tb_turmas_idTurmas' => $idTurma2, 'tb_disciplinas_idDisciplinas' => $idDiscMat, 'tb_funcionarios_idFuncionarios' => $idFuncDocente],
            ['tb_turmas_idTurmas' => $idTurma2, 'tb_disciplinas_idDisciplinas' => $idDiscPort, 'tb_funcionarios_idFuncionarios' => $idFuncDocente],
            ['tb_turmas_idTurmas' => $idTurma2, 'tb_disciplinas_idDisciplinas' => $idDiscHist, 'tb_funcionarios_idFuncionarios' => $idFuncDocente],
        ];

        foreach ($turmasDisciplinasList as $td) {
            DB::table('tb_turmas_disciplinas')->insert($td);
        }

        // 9. Criar Alunos e Matrículas (SituacaoAluno = 'ATIVO')
        $alunosData = [
            [
                'nome' => 'Lucas Oliveira Silva',
                'ra' => '2026001',
                'mac' => 'MAC2026001',
                'ra_num' => 2026001,
                'turma_id' => $idTurma1,
                'nasc' => '15/05/2015',
                'sexo' => 'Masculino',
                'cpf' => '555.555.555-55'
            ],
            [
                'nome' => 'Beatriz Oliveira Silva',
                'ra' => '2026002',
                'mac' => 'MAC2026002',
                'ra_num' => 2026002,
                'turma_id' => $idTurma1,
                'nasc' => '20/08/2016',
                'sexo' => 'Feminino',
                'cpf' => '666.666.666-66'
            ],
            [
                'nome' => 'Gabriel Santos Lima',
                'ra' => '2026003',
                'mac' => 'MAC2026003',
                'ra_num' => 2026003,
                'turma_id' => $idTurma2,
                'nasc' => '10/03/2014',
                'sexo' => 'Masculino',
                'cpf' => '777.777.777-77'
            ],
            [
                'nome' => 'Mariana Souza Rocha',
                'ra' => '2026004',
                'mac' => 'MAC2026004',
                'ra_num' => 2026004,
                'turma_id' => $idTurma2,
                'nasc' => '05/11/2014',
                'sexo' => 'Feminino',
                'cpf' => '888.888.888-88'
            ]
        ];

        $disciplinasIds = [$idDiscMat, $idDiscPort, $idDiscHist, $idDiscGeog, $idDiscCien];

        foreach ($alunosData as $aData) {
            $idMatricula = DB::table('tb_matriculas')->insertGetId([
                'Foto' => null,
                'Registro' => $aData['ra'],
                'ValorPGTO' => '500,00',
                'FormaPGTO' => 'PIX',
                'RA' => $aData['ra'],
                'Email' => 'aluno' . $aData['ra'] . '@escola.com',
                'Situacao' => 'ATIVO',
                'SituacaoAluno' => 'ATIVO',
                'Nivel' => 'ALUNO',
                'password' => Hash::make('11111111'),
                'DataMatricula' => '01/02/2026'
            ]);

            $idAluno = DB::table('tb_aluno')->insertGetId([
                'tb_matriculas_idMatriculas' => $idMatricula,
                'tb_turmas_idTurmas' => $aData['turma_id'],
                'tb_endereco_idEndereco' => $idEnderecoAluno1,
                'tb_pais_idPais' => $idPais1,
                'NomeAluno' => $aData['nome'],
                'DataNascimento' => $aData['nasc'],
                'Sexo' => $aData['sexo'],
                'CPFAluno' => $aData['cpf'],
                'NumeroMac' => $aData['mac'],
                'ObsAluno' => 'Aluno matriculado regularmente',
                'Ultima_Turma' => 'Turma Anterior',
                'Acompanhamento' => 'Regular'
            ]);

            // 10. Criar Notas de Teste para o Aluno em cada Disciplina
            foreach ($disciplinasIds as $discId) {
                // Verificar se a disciplina faz parte da turma do aluno
                $hasDisc = DB::table('tb_turmas_disciplinas')
                    ->where('tb_turmas_idTurmas', $aData['turma_id'])
                    ->where('tb_disciplinas_idDisciplinas', $discId)
                    ->exists();

                if ($hasDisc) {
                    DB::table('tb_notas')->insert([
                        'tb_turmas_idTurmas' => $aData['turma_id'],
                        'tb_disciplinas_idDisciplinas' => $discId,
                        'tb_aluno_idAluno' => $idAluno,
                        'tb_usuario_idUsuario' => $idUsuarioDocente,
                        'RA' => $aData['ra_num'],
                        'AM1' => rand(7, 10),
                        'AB1' => rand(7, 10),
                        'RB1' => 0,
                        'AM2' => rand(7, 10),
                        'AB2' => rand(7, 10),
                        'RB2' => 0,
                        'AM3' => rand(7, 10),
                        'AB3' => rand(7, 10),
                        'RB3' => 0,
                        'AM4' => rand(7, 10),
                        'AB4' => rand(7, 10),
                        'RB4' => 0,
                        'RP' => 0,
                        'RF' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // 11. Criar Frequência de Teste para o Aluno
            DB::table('tb_frequencia')->insert([
                'tb_turmas_idTurmas' => $aData['turma_id'],
                'tb_aluno_idAluno' => $idAluno,
                'DataFrequencia' => '02/09/2026',
                'Dia' => '02',
                'Mes' => '09',
                'Ano' => '2026',
                'Presenca' => 'PRESENTE'
            ]);
        }
    }
}
