@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-8">
        
        <!-- Cabeçalho Principal -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-[#0a241e]">Bem-vinda, Nayana</h1>
            </div>
            <button class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-sm cursor-pointer">
                <i data-lucide="plus" class="w-5 h-5"></i>
                <span>Nova Matrícula</span>
            </button>
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
                <!-- Card do Calendário Escolar -->
                <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-bold text-[#0a241e]">Calendário Escolar</h2>
                        <a href="#" class="text-xs font-bold text-[#008a4b] hover:underline">Ver calendário completo</a>
                    </div>

                    <!-- Visualização de Mês Duplo -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Junho -->
                        <div>
                            <div class="flex justify-center mb-4">
                                <span class="bg-[#0a241e] text-white text-xs font-semibold px-4 py-1.5 rounded-full">Junho</span>
                            </div>
                            <div class="grid grid-cols-7 text-center text-xs font-semibold text-gray-400 mb-2">
                                <span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sab</span><span>Dom</span>
                            </div>
                            <div class="grid grid-cols-7 text-center text-xs gap-y-3 text-gray-700">
                                <span class="text-gray-300">26</span><span class="text-gray-300">27</span><span class="text-gray-300">28</span><span>1</span><span>2</span><span>3</span><span>4</span>
                                <span>5</span><span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span>
                                <span>12</span><span>13</span><span>14</span><span>15</span><span>16</span><span>17</span><span>18</span>
                                <span>19</span><span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span>
                                <span class="bg-[#0a241e] text-white rounded-full w-6 h-6 flex items-center justify-center mx-auto">26</span><span>27</span><span>28</span><span>29</span><span>30</span><span class="text-gray-300">1</span><span class="text-gray-300">2</span>
                            </div>
                        </div>

                        <!-- Julho -->
                        <div>
                            <div class="flex justify-center mb-4">
                                <span class="bg-[#008a4b] text-white text-xs font-semibold px-4 py-1.5 rounded-full">Julho</span>
                            </div>
                            <div class="grid grid-cols-7 text-center text-xs font-semibold text-gray-400 mb-2">
                                <span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sab</span><span>Dom</span>
                            </div>
                            <div class="grid grid-cols-7 text-center text-xs gap-y-3 text-gray-700">
                                <span class="text-gray-300">29</span><span class="text-gray-300">30</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                                <span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span><span>12</span>
                                <span>13</span><span>14</span><span>15</span><span>16</span><span>17</span><span>18</span><span>19</span>
                                <span>20</span><span>21</span><span>22</span><span>23</span><span>24</span><span>25</span><span>26</span>
                                <span>27</span><span>28</span><span>29</span><span>30</span><span>31</span><span class="text-[#008a4b] font-semibold">1</span><span class="text-[#008a4b] font-semibold">2</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card de Gráficos de Indicadores Escolares -->
                <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-[#0a241e]">Indicadores Escolares</h2>
                        </div>
                        <!-- Abas de Alternância do Menu -->
                        <div class="bg-[#f0f4f2] p-1 rounded-full flex gap-1 text-xs font-semibold text-gray-500">
                            <button id="tab-matriculas" onclick="switchChart('matriculas')" class="bg-white text-[#008a4b] px-4 py-1.5 rounded-full shadow-xs flex items-center gap-1.5 cursor-pointer">
                                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                                <span>Matrículas</span>
                            </button>
                            <button id="tab-notas" onclick="switchChart('notas')" class="px-4 py-1.5 rounded-full text-gray-500 hover:text-[#0a241e] transition-colors flex items-center gap-1.5 cursor-pointer">
                                <i data-lucide="bar-chart-2" class="w-3.5 h-3.5"></i>
                                <span>Notas</span>
                            </button>
                            <button id="tab-mensalidades" onclick="switchChart('mensalidades')" class="px-4 py-1.5 rounded-full text-gray-500 hover:text-[#0a241e] transition-colors flex items-center gap-1.5 cursor-pointer">
                                <i data-lucide="dollar-sign" class="w-3.5 h-3.5"></i>
                                <span>Mensalidades</span>
                            </button>
                        </div>
                    </div>

                    <!-- Gráfico de Matrículas (Linhas) -->
                    <div id="chart-matriculas" class="relative w-full mt-4">
                        <div class="relative w-full h-[240px]">
                            <canvas id="canvas-matriculas"></canvas>
                        </div>
                    </div>

                    <!-- Gráfico de Notas (Barras) -->
                    <div id="chart-notas" class="relative w-full mt-4 hidden">
                        <div class="relative w-full h-[240px]">
                            <canvas id="canvas-notas"></canvas>
                        </div>
                    </div>

                    <!-- Gráfico de Mensalidades (Rosca) -->
                    <div id="chart-mensalidades" class="relative w-full mt-4 hidden">
                        <div class="flex flex-col md:flex-row items-center justify-center gap-16 h-[220px]">
                            <!-- Donut Chart Canvas -->
                            <div class="w-[180px] h-[180px] relative">
                                <canvas id="canvas-mensalidades"></canvas>
                            </div>
                            
                            <!-- Legenda Lateral -->
                            <div class="flex flex-col gap-5 text-sm font-semibold text-gray-700 select-none pr-12">
                                <div class="flex items-center gap-3">
                                    <span class="w-4 h-4 rounded-full bg-[#09492f] shrink-0"></span>
                                    <span class="text-base text-gray-800">Pagas em Dia</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="w-4 h-4 rounded-full bg-[#ffb300] shrink-0"></span>
                                    <span class="text-base text-gray-800">Atrasadas (&lt; 30 dias)</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="w-4 h-4 rounded-full bg-[#f43f5e] shrink-0"></span>
                                    <span class="text-base text-gray-800">Inadimplentes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
            </div>
        </div>        </div>

        </div>

    </div>

    <!-- Script de Inicialização e Alternância dos Gráficos com Chart.js -->
    <script>
        (function() {
            let chartMatriculas = null;
            let chartNotas = null;
            let chartMensalidades = null;

            function initCharts() {
                if (chartMatriculas) chartMatriculas.destroy();
                if (chartNotas) chartNotas.destroy();
                if (chartMensalidades) chartMensalidades.destroy();

                const ctxMatriculas = document.getElementById('canvas-matriculas');
                const ctxNotas = document.getElementById('canvas-notas');
                const ctxMensalidades = document.getElementById('canvas-mensalidades');

                if (ctxMatriculas) {
                    const ctx = ctxMatriculas.getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 240);
                    gradient.addColorStop(0, 'rgba(0, 138, 75, 0.15)');
                    gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');

                    chartMatriculas = new Chart(ctxMatriculas, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                            datasets: [{
                                label: 'Matrículas',
                                data: [1936, 1950, 1973, 1991, 2009, 2053, 2050, 2053, 2059, 2068, 2077, 2091],
                                borderColor: '#008a4b',
                                borderWidth: 3,
                                pointBackgroundColor: '#008a4b',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 1.5,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                fill: true,
                                backgroundColor: gradient,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#0a241e',
                                    titleFont: { family: 'Instrument Sans', size: 13, weight: 'bold' },
                                    bodyFont: { family: 'Instrument Sans', size: 12 },
                                    padding: 10,
                                    cornerRadius: 8,
                                    displayColors: false
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        color: '#9ca3af',
                                        font: { family: 'Instrument Sans', size: 11, weight: '600' }
                                    }
                                },
                                y: {
                                    min: 1900,
                                    max: 2100,
                                    ticks: {
                                        stepSize: 50,
                                        color: '#9ca3af',
                                        font: { family: 'Instrument Sans', size: 11, weight: '600' }
                                    },
                                    grid: {
                                        color: '#f0f4f2',
                                        lineWidth: 1.5,
                                        drawBorder: false
                                    }
                                }
                            }
                        }
                    });
                }

                if (ctxNotas) {
                    chartNotas = new Chart(ctxNotas, {
                        type: 'bar',
                        data: {
                            labels: ['6a', '6b', '7a', '7b', '8', '9', '1', '2', '3', '4', '5a', '5b'],
                            datasets: [{
                                label: 'Média de Notas',
                                data: [6.0, 7.5, 5.2, 8.2, 9.5, 4.5, 3.5, 9.0, 7.2, 8.2, 4.5, 6.0],
                                backgroundColor: [
                                    '#cce3db', '#cce3db', '#cce3db', '#cce3db', 
                                    '#09492f',
                                    '#cce3db', '#cce3db', '#cce3db', '#cce3db', '#cce3db', '#cce3db', '#cce3db'
                                ],
                                borderRadius: 6,
                                borderSkipped: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#0a241e',
                                    padding: 10,
                                    cornerRadius: 8
                                }
                            },
                            scales: {
                                x: {
                                    grid: { display: false },
                                    ticks: {
                                        color: '#9ca3af',
                                        font: { family: 'Instrument Sans', size: 11, weight: '600' }
                                    }
                                },
                                y: {
                                    min: 0,
                                    max: 10,
                                    ticks: {
                                        stepSize: 2,
                                        color: '#9ca3af',
                                        font: { family: 'Instrument Sans', size: 11, weight: '600' }
                                    },
                                    grid: {
                                        color: '#f0f4f2',
                                        lineWidth: 1.5,
                                        drawBorder: false
                                    }
                                }
                            }
                        }
                    });
                }

                if (ctxMensalidades) {
                    chartMensalidades = new Chart(ctxMensalidades, {
                        type: 'doughnut',
                        data: {
                            labels: ['Pagas em Dia', 'Atrasadas (< 30 dias)', 'Inadimplentes'],
                            datasets: [{
                                data: [35, 40, 25],
                                backgroundColor: ['#09492f', '#ffb300', '#f43f5e'],
                                borderWidth: 0,
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%',
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    backgroundColor: '#0a241e',
                                    padding: 10,
                                    cornerRadius: 8
                                }
                            }
                        }
                    });
                }
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initCharts);
            } else {
                initCharts();
            }

            window.switchChart = function(type) {
                document.getElementById('chart-matriculas').classList.add('hidden');
                document.getElementById('chart-notas').classList.add('hidden');
                document.getElementById('chart-mensalidades').classList.add('hidden');
                
                document.getElementById('chart-' + type).classList.remove('hidden');
                
                const tabs = ['matriculas', 'notas', 'mensalidades'];
                tabs.forEach(tab => {
                    const btn = document.getElementById('tab-' + tab);
                    if (btn) {
                        btn.className = "px-4 py-1.5 rounded-full text-gray-500 hover:text-[#0a241e] transition-colors flex items-center gap-1.5 cursor-pointer";
                    }
                });
                
                const activeBtn = document.getElementById('tab-' + type);
                if (activeBtn) {
                    activeBtn.className = "bg-white text-[#008a4b] px-4 py-1.5 rounded-full shadow-xs flex items-center gap-1.5 cursor-pointer";
                }

                if (type === 'matriculas' && chartMatriculas) chartMatriculas.resize();
                if (type === 'notas' && chartNotas) chartNotas.resize();
                if (type === 'mensalidades' && chartMensalidades) chartMensalidades.resize();
            };
        })();
    </script>
@endsection
