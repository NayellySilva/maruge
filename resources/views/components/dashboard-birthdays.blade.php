<!-- Card de Aniversariantes do Mês -->
<div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-5 select-none min-h-[350px] flex-1">
    <div class="flex justify-between items-center pb-2 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <i data-lucide="cake" class="w-5 h-5 text-[#008a4b]"></i>
            <h2 id="birthdays-title" class="text-base font-bold text-[#0a241e]">Aniversariantes</h2>
        </div>
    </div>

    <!-- Lista de Aniversariantes -->
    <div id="birthdays-list" class="flex flex-col gap-4 overflow-y-auto max-h-[380px] pr-1">
        <!-- Preenchido dinamicamente por JS -->
    </div>
</div>

<script>
    (function() {
        const monthNames = [
            "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
        ];

        // Cache simples em memória para evitar requests repetidas
        const birthdaysCache = {};

        async function updateBirthdays(month, year) {
            const title = document.getElementById('birthdays-title');
            const list = document.getElementById('birthdays-list');
            if (!title || !list) return;

            title.textContent = `Aniversariantes de ${monthNames[month]}`;

            // Indicador de carregamento
            list.innerHTML = `
                <div class="flex items-center justify-center py-10 text-gray-400">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-[#008a4b]"></div>
                </div>
            `;

            try {
                let data = birthdaysCache[month];
                if (!data) {
                    const response = await fetch(`/api/aniversariantes?month=${month}`);
                    if (!response.ok) throw new Error('Falha ao carregar aniversariantes');
                    data = await response.json();
                    birthdaysCache[month] = data;
                }

                if (!Array.isArray(data) || data.length === 0) {
                    list.innerHTML = `
                        <div class="flex flex-col items-center justify-center py-12 text-center text-gray-400">
                            <i data-lucide="gift" class="w-8 h-8 mb-2 stroke-1 text-gray-300"></i>
                            <p class="text-xs font-semibold">Nenhum aniversariante neste mês</p>
                        </div>
                    `;
                } else {
                    list.innerHTML = data.map(p => `
                        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm select-none ${p.color}">
                                ${p.avatar}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-800 truncate">${p.name}</h4>
                                <p class="text-xs font-semibold text-gray-400 truncate">${p.role}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="inline-block text-xs font-bold ${p.tipo === 'docente' ? 'text-[#b45309] bg-[#ffb300]/15' : 'text-[#008a4b] bg-[#008a4b]/5'} px-2.5 py-1 rounded-full">
                                    Dia ${p.day}
                                </span>
                            </div>
                        </div>
                    `).join('');
                }
            } catch (err) {
                list.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 text-center text-gray-400">
                        <i data-lucide="alert-circle" class="w-8 h-8 mb-2 stroke-1 text-red-300"></i>
                        <p class="text-xs font-semibold text-red-400">Erro ao consultar aniversariantes</p>
                    </div>
                `;
            }

            if (window.lucide) window.lucide.createIcons();
        }

        // Escutar eventos de alteração de mês do calendário
        window.addEventListener('calendar-month-changed', (e) => {
            updateBirthdays(e.detail.month, e.detail.year);
        });

        // Inicializar com o mês atual
        const now = new Date();
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => updateBirthdays(now.getMonth(), now.getFullYear()));
        } else {
            updateBirthdays(now.getMonth(), now.getFullYear());
        }
    })();
</script>
