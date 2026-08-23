@extends('layouts.app')

@section('content')

<!-- Titulo e Endereco da Pagina -->
<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Financeiro</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Estatísticas</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Estatísticas Financeiras</h1>
            <p class="text-sm text-[#5c706b]">Visão geral de contas a receber, contas a pagar e balanço geral</p>
        </div>
    </div>

    <!-- Cards de Métricas Principais (Contas a Receber e Contas a Pagar lado a lado) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Bloco: Contas a Receber -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-4">
            <div class="flex items-center justify-between border-b border-[#e3e8e6] pb-3">
                <h2 class="text-lg font-semibold text-[#0a241e] flex items-center gap-2">
                    <i data-lucide="trending-up" class="w-5 h-5 text-[#008a4b]"></i>
                    Contas a Receber
                </h2>
                <span class="text-xs font-semibold px-2.5 py-1 bg-emerald-50 text-[#008a4b] rounded-full">Receitas</span>
            </div>
            <!-- /.panel-heading -->

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="bg-[#f8faf9] p-4 rounded-xl flex flex-col gap-1 border border-[#e3e8e6]">
                    <span class="text-xs text-[#5c706b] font-medium">Falta Receber</span>
                    <span class="text-lg font-bold text-[#0a241e]">R$ 0,00</span>
                </div>
                <div class="bg-[#f8faf9] p-4 rounded-xl flex flex-col gap-1 border border-[#e3e8e6]">
                    <span class="text-xs text-[#5c706b] font-medium">Total a Receber</span>
                    <span class="text-lg font-bold text-[#0a241e]">R$ 0,00</span>
                </div>
                <div class="bg-[#f8faf9] p-4 rounded-xl flex flex-col gap-1 border border-[#e3e8e6]">
                    <span class="text-xs text-[#5c706b] font-medium">Total Recebido</span>
                    <span class="text-lg font-bold text-[#008a4b]">R$ 0,00</span>
                </div>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->

        <!-- Bloco: Contas a Pagar -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-4">
            <div class="flex items-center justify-between border-b border-[#e3e8e6] pb-3">
                <h2 class="text-lg font-semibold text-[#0a241e] flex items-center gap-2">
                    <i data-lucide="trending-down" class="w-5 h-5 text-red-500"></i>
                    Contas a Pagar
                </h2>
                <span class="text-xs font-semibold px-2.5 py-1 bg-red-50 text-red-600 rounded-full">Despesas</span>
            </div>
            <!-- /.panel-heading -->

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="bg-[#f8faf9] p-4 rounded-xl flex flex-col gap-1 border border-[#e3e8e6]">
                    <span class="text-xs text-[#5c706b] font-medium">Falta Pagar</span>
                    <span class="text-lg font-bold text-[#0a241e]">R$ 0,00</span>
                </div>
                <div class="bg-[#f8faf9] p-4 rounded-xl flex flex-col gap-1 border border-[#e3e8e6]">
                    <span class="text-xs text-[#5c706b] font-medium">Total a Pagar</span>
                    <span class="text-lg font-bold text-[#0a241e]">R$ 0,00</span>
                </div>
                <div class="bg-[#f8faf9] p-4 rounded-xl flex flex-col gap-1 border border-[#e3e8e6]">
                    <span class="text-xs text-[#5c706b] font-medium">Total Pago</span>
                    <span class="text-lg font-bold text-red-600">R$ 0,00</span>
                </div>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->

    </div>
    <!-- /.panel -->

    <!-- Seção dos 2 Gráficos de Rosca LADO A LADO -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Movimentações de Receitas -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-4">
            <h3 class="text-base font-semibold text-[#0a241e] flex items-center gap-2 border-b border-[#e3e8e6] pb-3">
                <i data-lucide="pie-chart" class="w-4 h-4 text-[#008a4b]"></i>
                Movimentações de Receitas
            </h3>
            <div class="relative w-full h-[240px] flex items-center justify-center">
                <canvas id="chart-receitas"></canvas>
            </div>
        </div>

        <!-- Movimentações de Despesas -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-4">
            <h3 class="text-base font-semibold text-[#0a241e] flex items-center gap-2 border-b border-[#e3e8e6] pb-3">
                <i data-lucide="pie-chart" class="w-4 h-4 text-red-500"></i>
                Movimentações de Despesas
            </h3>
            <div class="relative w-full h-[240px] flex items-center justify-center">
                <canvas id="chart-despesas"></canvas>
            </div>
        </div>

    </div>

    <!-- Gráfico 3: Comparativo Geral de Balanço Mensal (Barras) -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-4">
        <h3 class="text-base font-semibold text-[#0a241e] flex items-center gap-2 border-b border-[#e3e8e6] pb-3">
            <i data-lucide="bar-chart-3" class="w-4 h-4 text-[#008a4b]"></i>
            Balanço Mensal (Receitas vs Despesas)
        </h3>
        <div class="relative w-full h-[260px]">
            <canvas id="chart-balanco"></canvas>
        </div>
    </div>

</div> <!--Fim do caminho-din-->

<!-- Script do Chart.js (mesma biblioteca utilizada na Dashboard) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Gráfico de Receitas (Rosca)
        const ctxReceitas = document.getElementById('chart-receitas');
        if (ctxReceitas) {
            new Chart(ctxReceitas, {
                type: 'doughnut',
                data: {
                    labels: ['Falta Receber', 'Total a Receber', 'Total Recebido'],
                    datasets: [{
                        data: [11, 2, 2],
                        backgroundColor: ['#f59e0b', '#008a4b', '#10b981'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // 2. Gráfico de Despesas (Rosca)
        const ctxDespesas = document.getElementById('chart-despesas');
        if (ctxDespesas) {
            new Chart(ctxDespesas, {
                type: 'doughnut',
                data: {
                    labels: ['Falta Pagar', 'Total a Pagar', 'Total Pago'],
                    datasets: [{
                        data: [5, 8, 3],
                        backgroundColor: ['#ef4444', '#f97316', '#64748b'],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        }

        // 3. Gráfico de Balanço (Barras)
        const ctxBalanco = document.getElementById('chart-balanco');
        if (ctxBalanco) {
            new Chart(ctxBalanco, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    datasets: [
                        {
                            label: 'Receitas (R$)',
                            data: [12000, 15000, 14000, 18000, 16000, 21000, 19000, 22000, 20000, 23000, 25000, 28000],
                            backgroundColor: '#008a4b',
                            borderRadius: 6
                        },
                        {
                            label: 'Despesas (R$)',
                            data: [8000, 9500, 9000, 11000, 10500, 13000, 12000, 14000, 13500, 15000, 16000, 18000],
                            backgroundColor: '#ef4444',
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    });
</script>

@endsection