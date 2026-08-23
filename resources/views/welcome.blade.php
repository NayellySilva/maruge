@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-8">
        
        <!-- Cabeçalho Principal -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-[#0a241e]">Bem-vinda, Nayana</h1>
            </div>
            <a href="{{ route('coordenacao.pagina', ['pasta' => 'alunos', 'pagina' => 'aluno_cad']) }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
                <i data-lucide="plus" class="w-5 h-5"></i>
                <span>Nova Matrícula</span>
            </a>
        </div>

        <!-- Grade de Cards de Métricas (Linha Superior) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                <div class="text-3xl font-bold text-[#008a4b]">2057</div>
                <div class="text-sm font-semibold text-[#7fa398] mt-1">Alunos Cadastrados</div>
            </div>
            <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                <div class="text-3xl font-bold text-[#008a4b]">413</div>
                <div class="text-sm font-semibold text-[#7fa398] mt-1">Alunos Ativos</div>
            </div>
            <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                <div class="text-3xl font-bold text-[#008a4b]">1677</div>
                <div class="text-sm font-semibold text-[#7fa398] mt-1">Alunos Inativos</div>
            </div>
            <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                <div class="text-3xl font-bold text-[#008a4b]">8</div>
                <div class="text-sm font-semibold text-[#7fa398] mt-1">Total Usuários</div>
            </div>
        </div>

        <!-- Grade da Seção Intermediária (Calendário e Gráficos Alinhados) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Coluna da Esquerda (Calendário e Gráficos) -->
            <div class="lg:col-span-2 flex flex-col gap-6">
                <!-- Componente do Calendário Escolar -->
                <x-dashboard-calendar />

                <!-- Componente de Gráficos de Indicadores Escolares -->
                <x-dashboard-charts />
            </div>

            <!-- Grade de Cards da Coluna Direita -->
            <div class="flex flex-col gap-6">
                <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="text-3xl font-bold text-[#008a4b]">20</div>
                    <div class="text-sm font-semibold text-[#7fa398] mt-1">Turmas Ativas</div>
                </div>
                <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="text-3xl font-bold text-[#008a4b]">30</div>
                    <div class="text-sm font-semibold text-[#7fa398] mt-1">Disciplinas</div>
                </div>
                <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs hover:shadow-xs transition-shadow">
                    <div class="text-3xl font-bold text-[#008a4b]">73</div>
                    <div class="text-sm font-semibold text-[#7fa398] mt-1">Total de Funcionários</div>
                </div>
                
                <!-- Componente de Aniversariantes do Mês -->
                <x-dashboard-birthdays />
            </div>
        </div>

    </div>
@endsection
