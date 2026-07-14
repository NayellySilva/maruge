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
                            <svg viewBox="0 0 1000 240" class="w-full h-full overflow-visible">
                                <!-- Eixo Y com Valores -->
                                <text x="35" y="15" text-anchor="end" fill="#9ca3af" class="text-xs font-semibold select-none">2.100</text>
                                <text x="35" y="70" text-anchor="end" fill="#9ca3af" class="text-xs font-semibold select-none">2.050</text>
                                <text x="35" y="125" text-anchor="end" fill="#9ca3af" class="text-xs font-semibold select-none">2.000</text>
                                <text x="35" y="180" text-anchor="end" fill="#9ca3af" class="text-xs font-semibold select-none">1.950</text>

                                <!-- Linhas de Grade do Gráfico (De x=50 a x=980) -->
                                <line x1="50" y1="10" x2="980" y2="10" stroke="#f0f4f2" stroke-width="1.5" />
                                <line x1="50" y1="65" x2="980" y2="65" stroke="#f0f4f2" stroke-width="1.5" />
                                <line x1="50" y1="120" x2="980" y2="120" stroke="#f0f4f2" stroke-width="1.5" />
                                <line x1="50" y1="175" x2="980" y2="175" stroke="#f0f4f2" stroke-width="1.5" />
                                
                                <!-- Curva Bezier Verde Suave (Perfeitamente esticada horizontalmente) -->
                                <path d="M 50 190 L 134.5 175 L 219.1 150 L 303.6 130 L 388.2 110 L 472.7 62 L 557.3 65 L 641.8 62 L 726.4 55 L 810.9 45 L 895.5 35 L 980 20" fill="none" stroke="#008a4b" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                
                                <!-- Degradê abaixo da curva -->
                                <path d="M 50 190 L 134.5 175 L 219.1 150 L 303.6 130 L 388.2 110 L 472.7 62 L 557.3 65 L 641.8 62 L 726.4 55 L 810.9 45 L 895.5 35 L 980 20 L 980 175 L 50 175 Z" fill="url(#chart-grad)" opacity="0.05" />

                                <!-- Pontos com contorno branco e brilho -->
                                <circle cx="50" cy="190" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="134.5" cy="175" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="219.1" cy="150" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="303.6" cy="130" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="388.2" cy="110" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="472.7" cy="62" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="557.3" cy="65" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="641.8" cy="62" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="726.4" cy="55" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="810.9" cy="45" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="895.5" cy="35" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />
                                <circle cx="980" cy="20" r="5" fill="#008a4b" stroke="#ffffff" stroke-width="1.5" />

                                <!-- Eixo X com Valores (Rótulos dos Meses alinhados perfeitamente) -->
                                <text x="50" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Jan</text>
                                <text x="134.5" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Fev</text>
                                <text x="219.1" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Mar</text>
                                <text x="303.6" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Abr</text>
                                <text x="388.2" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Mai</text>
                                <text x="472.7" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Jun</text>
                                <text x="557.3" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Jul</text>
                                <text x="641.8" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Ago</text>
                                <text x="726.4" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Set</text>
                                <text x="810.9" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Out</text>
                                <text x="895.5" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Nov</text>
                                <text x="980" y="215" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">Dez</text>

                                <!-- Definições de Gradiente SVG -->
                                <defs>
                                    <linearGradient id="chart-grad" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#008a4b" />
                                        <stop offset="100%" stop-color="#ffffff" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                    </div>

                    <!-- Gráfico de Notas (Barras) -->
                    <div id="chart-notas" class="relative w-full mt-4 hidden">
                        <div class="relative w-full h-[240px]">
                            <svg viewBox="0 0 1000 240" class="w-full h-full overflow-visible">
                                <!-- Barras (Alinhadas de x=50 a x=950 com espaçamento de 82px) -->
                                <rect x="32" y="90" width="36" height="110" rx="6" fill="#cce3db" />
                                <rect x="114" y="60" width="36" height="140" rx="6" fill="#cce3db" />
                                <rect x="196" y="110" width="36" height="90" rx="6" fill="#cce3db" />
                                <rect x="278" y="45" width="36" height="155" rx="6" fill="#cce3db" />
                                <rect x="360" y="15" width="36" height="185" rx="6" fill="#09492f" />
                                <rect x="442" y="130" width="36" height="70" rx="6" fill="#cce3db" />
                                <rect x="524" y="145" width="36" height="55" rx="6" fill="#cce3db" />
                                <rect x="606" y="30" width="36" height="170" rx="6" fill="#cce3db" />
                                <rect x="688" y="65" width="36" height="135" rx="6" fill="#cce3db" />
                                <rect x="770" y="45" width="36" height="155" rx="6" fill="#cce3db" />
                                <rect x="852" y="130" width="36" height="70" rx="6" fill="#cce3db" />
                                <rect x="934" y="90" width="36" height="110" rx="6" fill="#cce3db" />

                                <!-- Eixo X com Valores (Rótulos das Turmas alinhados perfeitamente abaixo de cada barra) -->
                                <text x="50" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">6a</text>
                                <text x="132" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">6b</text>
                                <text x="214" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">7a</text>
                                <text x="296" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">7b</text>
                                <text x="378" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">8</text>
                                <text x="460" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">9</text>
                                <text x="542" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">1</text>
                                <text x="624" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">2</text>
                                <text x="706" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">3</text>
                                <text x="788" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">4</text>
                                <text x="870" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">5a</text>
                                <text x="952" y="225" text-anchor="middle" fill="#9ca3af" class="text-xs font-semibold select-none">5b</text>
                            </svg>
                        </div>
                    </div>

                    <!-- Gráfico de Mensalidades (Rosca) -->
                    <div id="chart-mensalidades" class="relative w-full mt-4 hidden">
                        <div class="flex flex-col md:flex-row items-center justify-center gap-16 h-[220px]">
                            <!-- Donut Chart SVG -->
                            <svg width="180" height="180" viewBox="0 0 220 220" class="overflow-visible select-none">
                                <g transform="rotate(-90 110 110)">
                                    <!-- Pagas em Dia (Verde Escuro) - 35% (dasharray 154 de 440) -->
                                    <circle cx="110" cy="110" r="70" fill="transparent" stroke="#09492f" stroke-width="35" stroke-dasharray="154 440" stroke-dashoffset="0" />
                                    <!-- Atrasadas (Amarelo) - 40% (dasharray 176 de 440) -->
                                    <circle cx="110" cy="110" r="70" fill="transparent" stroke="#ffb300" stroke-width="35" stroke-dasharray="176 440" stroke-dashoffset="-154" />
                                    <!-- Inadimplentes (Vermelho) - 25% (dasharray 110 de 440) -->
                                    <circle cx="110" cy="110" r="70" fill="transparent" stroke="#f43f5e" stroke-width="35" stroke-dasharray="110 440" stroke-dashoffset="-330" />
                                </g>
                            </svg>
                            
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

    <!-- Script de Alternância dos Gráficos -->
    <script>
        function switchChart(type) {
            // Oculta todos os wrappers de gráficos
            document.getElementById('chart-matriculas').classList.add('hidden');
            document.getElementById('chart-notas').classList.add('hidden');
            document.getElementById('chart-mensalidades').classList.add('hidden');
            
            // Exibe o gráfico selecionado
            document.getElementById('chart-' + type).classList.remove('hidden');
            
            // Reseta o estilo das abas (texto e ícone cinzas por padrão)
            const tabs = ['matriculas', 'notas', 'mensalidades'];
            tabs.forEach(tab => {
                const btn = document.getElementById('tab-' + tab);
                if (btn) {
                    btn.className = "px-4 py-1.5 rounded-full text-gray-500 hover:text-[#0a241e] transition-colors flex items-center gap-1.5 cursor-pointer";
                }
            });
            
            // Aplica o estilo ativo na aba selecionada (texto e ícone ficam verdes)
            const activeBtn = document.getElementById('tab-' + type);
            if (activeBtn) {
                activeBtn.className = "bg-white text-[#008a4b] px-4 py-1.5 rounded-full shadow-xs flex items-center gap-1.5 cursor-pointer";
            }
        }
    </script>
@endsection
