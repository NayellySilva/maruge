@extends('layouts.app')

@section('content')
@php
    try {
        $turmas = \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) {
        $turmas = collect();
    }

    try {
        $disciplinas = \DB::table('tb_disciplinas')->orderBy('NomeDisciplina')->get();
    } catch (\Exception $e) {
        $disciplinas = collect();
    }

    try {
        $professores = \DB::table('tb_funcionarios')->orderBy('NomeFuncionario')->get();
    } catch (\Exception $e) {
        $professores = collect();
    }

    try {
        $turmasLocadas = \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) {
        $turmasLocadas = collect();
    }

    try {
        $disciplinasDoProfessor = \DB::table('tb_turmas_disciplinas')
            ->join('tb_disciplinas', 'tb_turmas_disciplinas.tb_disciplinas_idDisciplinas', '=', 'tb_disciplinas.idDisciplinas')
            ->join('tb_funcionarios', 'tb_turmas_disciplinas.tb_funcionarios_idFuncionarios', '=', 'tb_funcionarios.idFuncionarios')
            ->select('tb_turmas_disciplinas.*', 'tb_disciplinas.NomeDisciplina', 'tb_funcionarios.NomeFuncionario')
            ->get();
    } catch (\Exception $e) {
        $disciplinasDoProfessor = collect();
    }
@endphp

<div class="flex flex-col gap-6 w-full">
    <!-- Localização-->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/turma_disc/turma_disciplina_inf') }}" class="hover:text-[#008a4b] transition-colors">Lotação de Professor</a>
        <span class="mx-2">/</span>
        <span class="text-[#0a241e] font-medium">Cadastrar Lotação</span>
    </div>

    <!-- Card Principal-->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs w-full">
        
        <!-- Cabeçalho do Card -->
        <div class="mb-6 border-b border-[#f1f3f2] pb-6">
            <h1 class="text-2xl font-semibold text-[#0a241e]">Cadastrar Nova Lotação</h1>
            <p class="text-sm text-[#5c706b] mt-1">Selecione os campos abaixo para associar disciplinas e professores às turmas correspondentes.</p>
        </div>

        <!-- Alertas e Preloader (Requeridos pelo JS do painel) -->
        <div class="preloader" style="display: none"> Enviando os dados...</div>  
        <div class="alert alert-success msg-exito bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6 text-sm" role="alert" style="display: none"></div>
        <div class="alert alert-warning msg-erro bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-xl mb-6 text-sm" role="alert" style="display: none"></div> 

        <!-- Alert de Erros de Validação -->
        @if(count($errors) > 0)
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm flex gap-3 items-start">
                <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                <div>
                    <strong class="font-semibold block mb-1">Por favor, corrija os erros abaixo:</strong>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Formulário -->
        <form class="form form-search form-Nu formularios flex flex-col gap-6" method="POST" action="{{ url('/coordenacao/turma_disciplina_cad') }}" send="{{ url('/coordenacao/turma_disciplina_cad') }}">
            {!! csrf_field() !!}

            <!-- Primeira Linha: Campos de Lotação -->
            <div style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: flex-end;">
                
                <!-- Nome da Turma -->
                <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="idTurmas" class="text-sm font-medium text-[#0a241e]">Nome da Turma:</label>
                    <div class="w-full flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 focus-within:border-gray-400 transition-all">
                        <select id="idTurmas" name="idTurmas" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6" required>
                            <option value="" disabled selected>Selecione</option>
                            @foreach($turmas as $turma)
                                <option value="{{ $turma->idTurmas }}">{{ $turma->NomeTurma }}</option>
                            @endforeach
                        </select>
                        <div class="text-[#95aba5] pointer-events-none -ml-4">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Nome da Disciplina -->
                <div style="flex: 1 1 25%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="idDisciplinas" class="text-sm font-medium text-[#0a241e]">Nome da Disciplina:</label>
                    <div class="w-full flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 focus-within:border-gray-400 transition-all">
                        <select id="idDisciplinas" name="idDisciplinas" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6" required>
                            <option value="" disabled selected>Selecione</option>
                            @foreach($disciplinas as $disciplina)
                                <option value="{{ $disciplina->idDisciplinas }}">{{ $disciplina->NomeDisciplina }}</option>
                            @endforeach
                        </select>
                        <div class="text-[#95aba5] pointer-events-none -ml-4">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Nome do Professor -->
                <div style="flex: 2 1 50%; min-width: 0; display: flex; flex-direction: column; gap: 6px;">
                    <label for="idFuncionarios" class="text-sm font-medium text-[#0a241e]">Nome do Professor:</label>
                    <div class="w-full flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 focus-within:border-gray-400 transition-all">
                        <select id="idFuncionarios" name="idFuncionarios" class="w-full bg-transparent text-sm text-[#0a241e] focus:outline-none appearance-none cursor-pointer pr-6" required>
                            <option value="" disabled selected>Selecione o Professor</option>
                            @foreach($professores as $professore)
                                <option value="{{ $professore->idFuncionarios }}">{{ $professore->NomeFuncionario }}</option>
                            @endforeach
                        </select>
                        <div class="text-[#95aba5] pointer-events-none -ml-4">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Segunda Linha: Botões de Ação  -->
            <div class="flex gap-3 mt-4">
                <button type="submit" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full text-sm transition-all shadow-sm cursor-pointer">
                    SALVAR
                </button>
                <button type="reset" class="border border-[#e3e8e6] text-[#5c706b] hover:bg-[#f8faf9] font-medium px-6 py-2.5 rounded-full text-sm transition-all cursor-pointer">
                    LIMPAR
                </button>
            </div>
        </form>
    </div>

</div>
@endsection