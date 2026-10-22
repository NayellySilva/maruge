@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-8">
    @php
        $nomeDocente = 'Professor(a)';
        if (auth()->guard('guardLogin')->check()) {
            $cpf = auth()->guard('guardLogin')->user()->CPFUsuario;
            $dadosFunc = \App\Models\modelCoordenacao\tb_usuario::infUsuario($cpf)->first();
            if ($dadosFunc && !empty($dadosFunc->NomeFuncionario)) {
                $partes = explode(' ', trim($dadosFunc->NomeFuncionario));
                $nomeDocente = ucfirst(mb_strtolower($partes[0]));
            }
        }
    @endphp

    <!-- Cabeçalho Principal -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-semibold text-[#0a241e]">Bem-vindo(a), {{ $nomeDocente }}</h1>
            <p class="text-sm text-[#5c706b] mt-1">Acompanhe suas turmas, disciplinas e lançamento de notas</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ url('/docente/notas') }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
                <i data-lucide="clipboard-pen" class="w-5 h-5"></i>
                <span>Lançar Notas</span>
            </a>
            <a href="{{ url('/docente/mapas_notas') }}" class="bg-white hover:bg-[#f8faf9] text-[#0a241e] border border-[#e3e8e6] font-medium px-5 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-2xs cursor-pointer">
                <i data-lucide="map" class="w-5 h-5 text-[#5c706b]"></i>
                <span>Mapas</span>
            </a>
        </div>
    </div>

    <!-- Grade de Cards de Métricas -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
            <div class="flex items-center justify-between">
                <div class="text-3xl font-bold text-[#008a4b]">{{ $Alunos ?? 0 }}</div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#008a4b] flex items-center justify-center">
                    <i data-lucide="graduation-cap" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="text-sm font-semibold text-[#7fa398] mt-2">Total de Alunos</div>
            <p class="text-xs text-[#5c706b] mt-1">Alunos vinculados às suas turmas</p>
        </div>

        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
            <div class="flex items-center justify-between">
                <div class="text-3xl font-bold text-[#008a4b]">{{ $quantTurmasDocente ?? 0 }}</div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#008a4b] flex items-center justify-center">
                    <i data-lucide="layout-grid" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="text-sm font-semibold text-[#7fa398] mt-2">Total de Turmas</div>
            <p class="text-xs text-[#5c706b] mt-1">Turmas ativas sob sua regência</p>
        </div>

        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
            <div class="flex items-center justify-between">
                <div class="text-3xl font-bold text-[#008a4b]">{{ $quantDisciplinaDocente ?? 0 }}</div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#008a4b] flex items-center justify-center">
                    <i data-lucide="book-marked" class="w-6 h-6"></i>
                </div>
            </div>
            <div class="text-sm font-semibold text-[#7fa398] mt-2">Total de Disciplinas</div>
            <p class="text-xs text-[#5c706b] mt-1">Disciplinas atribuídas ao seu perfil</p>
        </div>
    </div>

    <!-- Seção de Ações Rápidas & Calendário -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Coluna Esquerda: Calendário Escolar -->
        <div class="lg:col-span-2 flex flex-col gap-6">
            <x-dashboard-calendar />
        </div>

        <!-- Coluna Direita: Atalhos Rápidos Docente -->
        <div class="flex flex-col gap-4">
            <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-4">
                <h3 class="text-lg font-semibold text-[#0a241e]">Acesso Rápido</h3>
                
                <a href="{{ url('/docente/notas') }}" class="flex items-center gap-3 p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b] hover:bg-[#f8faf9] transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                        <i data-lucide="clipboard-pen" class="w-5 h-5"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-[#0a241e] group-hover:text-[#008a4b]">Lançar Notas</span>
                        <span class="text-xs text-[#5c706b]">Lançamento por bimestre</span>
                    </div>
                </a>

                <a href="{{ url('/docente/mapas_notas') }}" class="flex items-center gap-3 p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b] hover:bg-[#f8faf9] transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                        <i data-lucide="map" class="w-5 h-5"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-[#0a241e] group-hover:text-[#008a4b]">Mapas de Notas</span>
                        <span class="text-xs text-[#5c706b]">Impressão de mapas</span>
                    </div>
                </a>

                <a href="{{ url('/docente/resultados') }}" class="flex items-center gap-3 p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b] hover:bg-[#f8faf9] transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                        <i data-lucide="award" class="w-5 h-5"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-[#0a241e] group-hover:text-[#008a4b]">Resultados</span>
                        <span class="text-xs text-[#5c706b]">Parcial e final</span>
                    </div>
                </a>

                <a href="{{ url('/docente/declaracoes') }}" class="flex items-center gap-3 p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b] hover:bg-[#f8faf9] transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                        <i data-lucide="file-check" class="w-5 h-5"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-[#0a241e] group-hover:text-[#008a4b]">Declaração Funcional</span>
                        <span class="text-xs text-[#5c706b]">Emitir declaração</span>
                    </div>
                </a>

                <a href="{{ url('/docente/funcionario_perfil') }}" class="flex items-center gap-3 p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b] hover:bg-[#f8faf9] transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                        <i data-lucide="user-round" class="w-5 h-5"></i>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-semibold text-[#0a241e] group-hover:text-[#008a4b]">Meu Perfil</span>
                        <span class="text-xs text-[#5c706b]">Dados e turmas</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection