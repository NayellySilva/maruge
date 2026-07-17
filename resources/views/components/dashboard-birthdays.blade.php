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

        const birthdayPeople = [
            { name: "Luana Gomes", day: 5, month: 0, role: "Aluna - 7º Ano B", avatar: "LG", color: "bg-[#09492f]/10 text-[#09492f]" },
            { name: "Prof. Roberto Melo", day: 22, month: 0, role: "Docente - Matemática", avatar: "RM", color: "bg-[#ffb300]/10 text-[#ffb300]" },
            { name: "Thiago Silva", day: 10, month: 1, role: "Aluno - 9º Ano B", avatar: "TS", color: "bg-[#008a4b]/10 text-[#008a4b]" },
            { name: "Amanda Rocha", day: 27, month: 1, role: "Coordenadora Pedagógica", avatar: "AR", color: "bg-[#f43f5e]/10 text-[#f43f5e]" },
            { name: "Lucas Oliveira", day: 8, month: 2, role: "Aluno - 6º Ano A", avatar: "LO", color: "bg-[#008a4b]/10 text-[#008a4b]" },
            { name: "Fernanda Costa", day: 17, month: 2, role: "Aluna - 8º Ano A", avatar: "FC", color: "bg-[#09492f]/10 text-[#09492f]" },
            { name: "Prof. Ricardo Ramos", day: 31, month: 2, role: "Docente - Geografia", avatar: "RR", color: "bg-[#ffb300]/10 text-[#ffb300]" },
            { name: "Camila Araujo", day: 14, month: 3, role: "Aluna - 5º Ano B", avatar: "CA", color: "bg-[#09492f]/10 text-[#09492f]" },
            { name: "Bruno Santos", day: 29, month: 3, role: "Aluno - 7º Ano A", avatar: "BS", color: "bg-[#008a4b]/10 text-[#008a4b]" },
            { name: "Larissa Lima", day: 3, month: 4, role: "Aluna - 9º Ano A", avatar: "LL", color: "bg-[#09492f]/10 text-[#09492f]" },
            { name: "Prof. Sandra Dias", day: 18, month: 4, role: "Docente - Português", avatar: "SD", color: "bg-[#ffb300]/10 text-[#ffb300]" },
            { name: "Gustavo Pinheiro", day: 11, month: 5, role: "Aluno - 6º Ano B", avatar: "GP", color: "bg-[#008a4b]/10 text-[#008a4b]" },
            { name: "Patrícia Rezende", day: 25, month: 5, role: "Diretora Escolar", avatar: "PR", color: "bg-[#f43f5e]/10 text-[#f43f5e]" },
            { name: "Beatriz Nogueira", day: 2, month: 6, role: "Aluna - 9º Ano A", avatar: "BN", color: "bg-[#09492f]/10 text-[#09492f]" },
            { name: "Matheus Silva", day: 14, month: 6, role: "Aluno - 7º Ano A", avatar: "MS", color: "bg-[#008a4b]/10 text-[#008a4b]" },
            { name: "Prof. Marcos Lima", day: 28, month: 6, role: "Docente - Física", avatar: "ML", color: "bg-[#ffb300]/10 text-[#ffb300]" },
            { name: "Gabriela Duarte", day: 7, month: 7, role: "Aluna - 6º Ano B", avatar: "GD", color: "bg-[#09492f]/10 text-[#09492f]" },
            { name: "Pedro Bial Rocha", day: 22, month: 7, role: "Aluno - 5º Ano A", avatar: "PB", color: "bg-[#008a4b]/10 text-[#008a4b]" },
            { name: "Juliana Mendes", day: 15, month: 8, role: "Secretária", avatar: "JM", color: "bg-[#f43f5e]/10 text-[#f43f5e]" },
            { name: "Felipe Rodrigues", day: 30, month: 8, role: "Aluno - 8º Ano A", avatar: "FR", color: "bg-[#008a4b]/10 text-[#008a4b]" },
            { name: "Renata Vasconcelos", day: 12, month: 9, role: "Aluna - 8º Ano B", avatar: "RV", color: "bg-[#09492f]/10 text-[#09492f]" },
            { name: "Prof. Sérgio Ramos", day: 24, month: 9, role: "Docente - Química", avatar: "SR", color: "bg-[#ffb300]/10 text-[#ffb300]" },
            { name: "Daniel Alves", day: 9, month: 10, role: "Aluno - 7º Ano A", avatar: "DA", color: "bg-[#008a4b]/10 text-[#008a4b]" },
            { name: "Paula Teixeira", day: 21, month: 10, role: "Aluna - 6º Ano A", avatar: "PT", color: "bg-[#09492f]/10 text-[#09492f]" },
            { name: "Rodrigo Faro", day: 18, month: 11, role: "Aluno - 9º Ano B", avatar: "RF", color: "bg-[#008a4b]/10 text-[#008a4b]" },
            { name: "Simone Mendes", day: 25, month: 11, role: "Aluna - 5º Ano A", avatar: "SM", color: "bg-[#09492f]/10 text-[#09492f]" }
        ];

        function updateBirthdays(month, year) {
            const title = document.getElementById('birthdays-title');
            const list = document.getElementById('birthdays-list');
            if (!title || !list) return;

            title.textContent = `Aniversariantes de ${monthNames[month]}`;

            const filtered = birthdayPeople.filter(p => p.month === month);

            if (filtered.length === 0) {
                list.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 text-center text-gray-400">
                        <i data-lucide="gift" class="w-8 h-8 mb-2 stroke-1 text-gray-300"></i>
                        <p class="text-xs font-semibold">Nenhum aniversariante neste mês</p>
                    </div>
                `;
            } else {
                // Ordenar por dia de forma crescente
                filtered.sort((a, b) => a.day - b.day);

                list.innerHTML = filtered.map(p => `
                    <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition-colors">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm select-none ${p.color}">
                            ${p.avatar}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-bold text-gray-800 truncate">${p.name}</h4>
                            <p class="text-xs font-semibold text-gray-400 truncate">${p.role}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block text-xs font-bold text-[#008a4b] bg-[#008a4b]/5 px-2.5 py-1 rounded-full">
                                Dia ${p.day}
                            </span>
                        </div>
                    </div>
                `).join('');
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
