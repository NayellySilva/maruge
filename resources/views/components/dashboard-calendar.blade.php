<!-- Card do Calendário Escolar -->
<div id="calendar-card" data-csrf="{{ csrf_token() }}" class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-6">
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold text-[#0a241e]">Calendário Escolar</h2>
        <div class="flex items-center gap-3">
            <button id="calendar-prev" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 transition hover:border-[#008a4b] hover:text-[#008a4b] cursor-pointer">
                <i data-lucide="chevron-left" class="h-4 w-4"></i>
            </button>
            <button id="calendar-next" type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 transition hover:border-[#008a4b] hover:text-[#008a4b] cursor-pointer">
                <i data-lucide="chevron-right" class="h-4 w-4"></i>
            </button>
        </div>
    </div>

    <!-- Calendário funcional de 2 meses -->
    <div class="rounded-2xl border border-gray-200 bg-white/90 p-6 shadow-sm">
        <!-- Grid principal de dois meses -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative">
            <!-- Divisor vertical para telas md e maiores -->
            <div class="hidden md:block absolute left-1/2 top-0 bottom-0 border-r border-[#e3e8e6] transform -translate-x-1/2"></div>
            
            <!-- Mês 1 (Esquerda) -->
            <div class="flex flex-col">
                <div class="flex justify-center mb-6 h-8 items-center">
                    <span id="calendar-month-left-label" class="tracking-wide">
                        <!-- Preenchido por JS -->
                    </span>
                </div>
                <div class="grid grid-cols-7 text-center text-[11px] font-semibold uppercase tracking-[0.2em] text-gray-400 mb-4">
                    <span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sab</span><span>Dom</span>
                </div>
                <div id="calendar-grid-left" class="grid grid-cols-7 gap-y-2 gap-x-1 text-center">
                    <!-- Preenchido por JS -->
                </div>
            </div>
            
            <!-- Mês 2 (Direita) -->
            <div class="flex flex-col">
                <div class="flex justify-center mb-6 h-8 items-center">
                    <span id="calendar-month-right-label" class="tracking-wide">
                        <!-- Preenchido por JS -->
                    </span>
                </div>
                <div class="grid grid-cols-7 text-center text-[11px] font-semibold uppercase tracking-[0.2em] text-gray-400 mb-4">
                    <span>Seg</span><span>Ter</span><span>Qua</span><span>Qui</span><span>Sex</span><span>Sab</span><span>Dom</span>
                </div>
                <div id="calendar-grid-right" class="grid grid-cols-7 gap-y-2 gap-x-1 text-center">
                    <!-- Preenchido por JS -->
                </div>
            </div>
        </div>
        
        <!-- Legenda e botão Hoje -->
        <div class="mt-6 flex flex-wrap items-center justify-between gap-3 text-[11px] text-gray-600 border-t border-gray-100 pt-4">
            <div class="flex flex-wrap gap-4 select-none">
                <span class="inline-flex items-center gap-2 font-semibold">
                    <span class="h-2.5 w-2.5 rounded-full bg-[#008a4b]"></span>
                    Feriado Oficial
                </span>
                <span class="inline-flex items-center gap-2 font-semibold">
                    <span class="h-2 w-2 rounded-full border-2 border-[#008a4b]"></span>
                    Evento Customizado
                </span>
                <span class="inline-flex items-center gap-2 font-semibold">
                    <span class="h-2.5 w-2.5 rounded-full bg-[#09492f]"></span>
                    Hoje
                </span>
            </div>
            <button id="calendar-today" type="button" class="rounded-full border border-[#008a4b]/20 bg-[#008a4b]/10 px-4 py-1.5 text-xs font-bold text-[#008a4b] transition hover:bg-[#008a4b]/20 cursor-pointer">
                Hoje
            </button>
        </div>
    </div>
</div>

<!-- Modal para Adicionar/Editar Evento -->
<div id="event-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
    <!-- Backdrop com blur -->
    <div class="fixed inset-0 bg-[#0a241e]/40 backdrop-blur-xs transition-opacity duration-300"></div>

    <!-- Modal Content -->
    <div class="relative bg-white rounded-2xl max-w-md w-full p-6 shadow-xl transform transition-all duration-300 scale-95 opacity-0 border border-gray-100 flex flex-col gap-5">
        <div class="flex justify-between items-center pb-2 border-b border-gray-100">
            <h3 id="modal-title" class="text-lg font-bold text-[#0a241e]">Adicionar Evento</h3>
            <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600 cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form id="event-form" class="flex flex-col gap-4">
            <!-- Campo Data (Somente Leitura) -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Data</label>
                <input type="text" id="event-date-display" readonly class="w-full bg-[#f0f4f2] text-[#09492f] border-none rounded-xl px-4 py-2.5 text-sm font-bold focus:ring-0 focus:outline-none">
                <input type="hidden" id="event-date-raw">
            </div>

            <!-- Campo Nome -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Nome do Evento</label>
                <input type="text" id="event-name" required placeholder="Ex: Feira de Ciências, Conselho..." class="w-full bg-white border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 text-sm font-semibold focus:border-[#008a4b] focus:ring-1 focus:ring-[#008a4b] focus:outline-none">
            </div>

            <!-- Campo Tipo -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Tipo de Evento</label>
                <div class="select-wrapper">
    <select id="event-type" class="w-full bg-white border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 text-sm font-semibold focus:border-[#008a4b] focus:ring-1 focus:ring-[#008a4b] focus:outline-none maruge-select">
                    <option value="Feriado Escolar">Feriado Escolar</option>
                    <option value="Recesso Escolar">Recesso Escolar</option>
                    <option value="Evento Escolar">Evento Escolar</option>
                    <option value="Outros">Outros</option>
                </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
            </div>

            <div class="flex justify-between items-center mt-2 gap-3 pt-3 border-t border-gray-100">
                <!-- Botão Excluir (Oculto por padrão, aparece ao editar) -->
                <button type="button" id="delete-event-btn" class="hidden text-xs font-bold text-red-500 hover:text-red-700 cursor-pointer">
                    Excluir Evento
                </button>
                <div class="flex gap-3 ml-auto">
                    <button type="button" id="cancel-modal-btn" class="rounded-full border border-gray-200 bg-white px-5 py-2 text-xs font-bold text-gray-600 transition hover:bg-gray-50 cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit" class="rounded-full bg-[#008a4b] text-white px-5 py-2 text-xs font-bold transition hover:bg-[#00703c] cursor-pointer shadow-xs">
                        Salvar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    (function() {
        let calendarView = new Date();
        let calendarSelectedDate = new Date();
        let holidaysCache = {};
        let renderCalendarFn = null;

        const modal = document.getElementById('event-modal');
        const modalContent = modal ? modal.querySelector('.relative') : null;
        const dateDisplay = document.getElementById('event-date-display');
        const dateRaw = document.getElementById('event-date-raw');
        const eventNameInput = document.getElementById('event-name');
        const eventTypeSelect = document.getElementById('event-type');
        const deleteBtn = document.getElementById('delete-event-btn');
        const modalTitle = document.getElementById('modal-title');

        async function fetchHolidays(year) {
            if (holidaysCache[year]) {
                return holidaysCache[year];
            }

            try {
                const response = await fetch(`/api/feriados?ano=${year}`);
                const holidays = await response.json();
                holidaysCache[year] = holidays;
                return holidays;
            } catch (err) {
                console.error("Erro ao carregar feriados:", err);
                return [];
            }
        }

        function initCalendar() {
            const gridLeft = document.getElementById('calendar-grid-left');
            const gridRight = document.getElementById('calendar-grid-right');
            const labelLeft = document.getElementById('calendar-month-left-label');
            const labelRight = document.getElementById('calendar-month-right-label');
            const prevButton = document.getElementById('calendar-prev');
            const nextButton = document.getElementById('calendar-next');
            const todayButton = document.getElementById('calendar-today');

            if (!gridLeft || !gridRight || !labelLeft || !labelRight || !prevButton || !nextButton || !todayButton) {
                return;
            }

            const monthNames = [
                "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
                "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
            ];

            function renderMonth(year, month, gridElement, isLeft) {
                const firstDay = (new Date(year, month, 1).getDay() + 6) % 7; // Segunda é 0, Domingo é 6
                const today = new Date();
                
                const cells = [];
                for (let cellIndex = 0; cellIndex < 42; cellIndex++) {
                    const cellDate = new Date(year, month, 1 - firstDay + cellIndex);
                    const cellYear = cellDate.getFullYear();
                    const cellMonth = cellDate.getMonth();
                    const cellDay = cellDate.getDate();

                    const isCurrentMonth = cellMonth === month;
                    const isToday = cellYear === today.getFullYear() && cellMonth === today.getMonth() && cellDay === today.getDate();
                    const isSelected = cellYear === calendarSelectedDate.getFullYear() && cellMonth === calendarSelectedDate.getMonth() && cellDay === calendarSelectedDate.getDate();
                    
                    const holidays = holidaysCache[cellYear] || [];
                    const holiday = holidays.find(h => h.day === cellDay && h.month === cellMonth);
                    const hasEvent = !!holiday;

                    const dateStr = `${cellYear}-${cellMonth}-${cellDay}`;

                    if (!isCurrentMonth) {
                        if (hasEvent) {
                            if (holiday.custom) {
                                cells.push(`
                                    <div class="flex flex-col h-10 w-10 items-center justify-center text-sm font-bold mx-auto select-none text-[#008a4b]/40 cursor-help" title="${holiday.name} (${holiday.type})">
                                        <span class="leading-none">${cellDay}</span>
                                        <span class="w-1 h-1 rounded-full border border-[#008a4b]/40 bg-transparent mt-0.5"></span>
                                    </div>
                                `);
                            } else {
                                cells.push(`
                                    <div class="flex h-10 w-10 items-center justify-center text-sm font-bold mx-auto select-none text-[#008a4b]/40 cursor-help" title="${holiday.name} (${holiday.type})">
                                        ${cellDay}
                                    </div>
                                `);
                            }
                        } else {
                            cells.push(`
                                <div class="flex h-10 w-10 items-center justify-center text-sm text-gray-300 font-semibold mx-auto select-none">
                                    ${cellDay}
                                </div>
                            `);
                        }
                    } else {
                        if (isSelected) {
                            if (hasEvent && holiday.custom) {
                                cells.push(`
                                    <button type="button" data-date="${dateStr}" title="${holiday.name} (${holiday.type})" class="flex flex-col h-10 w-10 items-center justify-center rounded-lg text-sm font-bold mx-auto transition cursor-pointer bg-[#09492f] text-white shadow-sm hover:bg-[#073622]">
                                        <span class="leading-none">${cellDay}</span>
                                        <span class="w-1 h-1 rounded-full bg-white mt-0.5"></span>
                                    </button>
                                `);
                            } else {
                                cells.push(`
                                    <button type="button" data-date="${dateStr}" ${hasEvent ? `title="${holiday.name} (${holiday.type})"` : ''} class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-bold mx-auto transition cursor-pointer bg-[#09492f] text-white shadow-sm hover:bg-[#073622]">
                                        ${cellDay}
                                    </button>
                                `);
                            }
                        } else if (isToday) {
                            if (hasEvent && holiday.custom) {
                                cells.push(`
                                    <button type="button" data-date="${dateStr}" title="${holiday.name} (${holiday.type})" class="flex flex-col h-10 w-10 items-center justify-center rounded-lg text-sm font-bold mx-auto transition cursor-pointer border border-[#09492f]/30 bg-[#09492f]/5 text-[#09492f]">
                                        <span class="leading-none">${cellDay}</span>
                                        <span class="w-1 h-1 rounded-full bg-[#008a4b] mt-0.5"></span>
                                    </button>
                                `);
                            } else {
                                cells.push(`
                                    <button type="button" data-date="${dateStr}" ${hasEvent ? `title="${holiday.name} (${holiday.type})"` : ''} class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-bold mx-auto transition cursor-pointer border border-[#09492f]/30 bg-[#09492f]/5 text-[#09492f]">
                                        ${cellDay}
                                    </button>
                                `);
                            }
                        } else if (hasEvent) {
                            if (holiday.custom) {
                                cells.push(`
                                    <button type="button" data-date="${dateStr}" title="${holiday.name} (${holiday.type})" class="flex flex-col h-10 w-10 items-center justify-center rounded-lg text-sm font-bold mx-auto transition cursor-pointer text-[#008a4b] hover:bg-[#008a4b]/10">
                                        <span class="leading-none">${cellDay}</span>
                                        <span class="w-1 h-1 rounded-full bg-[#008a4b] mt-0.5"></span>
                                    </button>
                                `);
                            } else {
                                cells.push(`
                                    <button type="button" data-date="${dateStr}" title="${holiday.name} (${holiday.type})" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-bold mx-auto transition cursor-pointer text-[#008a4b] hover:bg-[#008a4b]/10 cursor-help">
                                        ${cellDay}
                                    </button>
                                `);
                            }
                        } else {
                            cells.push(`
                                <button type="button" data-date="${dateStr}" class="flex h-10 w-10 items-center justify-center rounded-lg text-sm font-semibold mx-auto transition cursor-pointer text-[#0a241e] hover:bg-gray-100 hover:text-[#008a4b]">
                                    ${cellDay}
                                </button>
                            `);
                        }
                    }
                }

                gridElement.innerHTML = cells.join('');
            }

            async function renderCalendar() {
                const monthLeft = calendarView.getMonth();
                const yearLeft = calendarView.getFullYear();

                const dateRight = new Date(yearLeft, monthLeft + 1, 1);
                const monthRight = dateRight.getMonth();
                const yearRight = dateRight.getFullYear();

                labelLeft.textContent = `${monthNames[monthLeft]} ${yearLeft}`;
                labelRight.textContent = `${monthNames[monthRight]} ${yearRight}`;

                const today = new Date();
                const currentMonth = today.getMonth();
                const currentYear = today.getFullYear();

                const isLeftCurrent = (monthLeft === currentMonth && yearLeft === currentYear);
                const isRightCurrent = (monthRight === currentMonth && yearRight === currentYear);

                if (isLeftCurrent) {
                    labelLeft.className = "bg-[#09492f] text-white px-5 py-1.5 rounded-full text-xs font-bold tracking-wide";
                    labelRight.className = "text-[#09492f] text-sm font-bold tracking-wide py-1.5";
                } else if (isRightCurrent) {
                    labelRight.className = "bg-[#09492f] text-white px-5 py-1.5 rounded-full text-xs font-bold tracking-wide";
                    labelLeft.className = "text-[#09492f] text-sm font-bold tracking-wide py-1.5";
                } else {
                    labelLeft.className = "text-[#09492f] text-sm font-bold tracking-wide py-1.5";
                    labelRight.className = "text-[#09492f] text-sm font-bold tracking-wide py-1.5";
                }

                // Disparar evento para outros componentes saberem qual é o mês ativo
                const monthEvent = new CustomEvent('calendar-month-changed', {
                    detail: { month: monthLeft, year: yearLeft }
                });
                window.dispatchEvent(monthEvent);

                gridLeft.classList.add('opacity-50', 'transition-opacity', 'duration-200');
                gridRight.classList.add('opacity-50', 'transition-opacity', 'duration-200');

                const yearsToFetch = [yearLeft];
                if (yearRight !== yearLeft) {
                    yearsToFetch.push(yearRight);
                }
                await Promise.all(yearsToFetch.map(year => fetchHolidays(year)));

                gridLeft.classList.remove('opacity-50');
                gridRight.classList.remove('opacity-50');

                renderMonth(yearLeft, monthLeft, gridLeft, true);
                renderMonth(yearRight, monthRight, gridRight, false);

                if (window.lucide) window.lucide.createIcons();
            }

            prevButton.addEventListener('click', () => {
                calendarView = new Date(calendarView.getFullYear(), calendarView.getMonth() - 1, 1);
                renderCalendar();
            });

            nextButton.addEventListener('click', () => {
                calendarView = new Date(calendarView.getFullYear(), calendarView.getMonth() + 1, 1);
                renderCalendar();
            });

            todayButton.addEventListener('click', () => {
                calendarView = new Date();
                calendarSelectedDate = new Date();
                renderCalendar();
            });

            function openEventModal(dateStr, holiday) {
                if (!modal) return;
                const parts = dateStr.split('-');
                dateDisplay.value = `${parts[2].padStart(2, '0')}/${parts[1].padStart(2, '0')}/${parts[0]}`;
                dateRaw.value = dateStr;

                if (holiday) {
                    modalTitle.textContent = "Editar Evento";
                    eventNameInput.value = holiday.name;
                    eventTypeSelect.value = holiday.type || 'Evento Escolar';
                    deleteBtn.classList.remove('hidden');
                } else {
                    modalTitle.textContent = "Adicionar Evento";
                    eventNameInput.value = '';
                    eventTypeSelect.value = 'Feriado Escolar';
                    deleteBtn.classList.add('hidden');
                }

                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.querySelector('.fixed.inset-0').classList.add('opacity-100');
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function handleGridClick(event) {
                const button = event.target.closest('button[data-date]');
                if (!button) return;
                const dateParts = button.getAttribute('data-date').split('-');
                const clickedYear = Number(dateParts[0]);
                const clickedMonth = Number(dateParts[1]);
                const clickedDay = Number(dateParts[2]);

                calendarSelectedDate = new Date(clickedYear, clickedMonth, clickedDay);
                renderCalendar();

                const holidays = holidaysCache[clickedYear] || [];
                const holiday = holidays.find(h => h.day === clickedDay && h.month === clickedMonth);

                if (holiday && !holiday.custom) {
                    return; // Feriado oficial: não abre formulário
                }

                const formattedMonth = (clickedMonth + 1).toString().padStart(2, '0');
                const formattedDay = clickedDay.toString().padStart(2, '0');
                const dateStr = `${clickedYear}-${formattedMonth}-${formattedDay}`;

                openEventModal(dateStr, holiday);
            }

            gridLeft.addEventListener('click', handleGridClick);
            gridRight.addEventListener('click', handleGridClick);

            renderCalendarFn = renderCalendar;
            renderCalendar();
        }

        function closeEventModal() {
            if (!modal) return;
            modal.querySelector('.fixed.inset-0').classList.remove('opacity-100');
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        if (modal) {
            document.getElementById('close-modal-btn')?.addEventListener('click', closeEventModal);
            document.getElementById('cancel-modal-btn')?.addEventListener('click', closeEventModal);
            modal.querySelector('.fixed.inset-0')?.addEventListener('click', closeEventModal);

            document.getElementById('event-form')?.addEventListener('submit', async (e) => {
                e.preventDefault();
                const card = document.getElementById('calendar-card');
                const csrfToken = card ? card.getAttribute('data-csrf') : '';
                const date = dateRaw.value;
                const name = eventNameInput.value;
                const type = eventTypeSelect.value;

                try {
                    const response = await fetch('/api/eventos', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ date, name, type })
                    });

                    if (response.ok) {
                        closeEventModal();
                        const parts = date.split('-');
                        const year = Number(parts[0]);
                        delete holidaysCache[year];
                        
                        if (renderCalendarFn) await renderCalendarFn();
                    } else {
                        alert("Erro ao salvar o evento.");
                    }
                } catch (err) {
                    console.error("Erro:", err);
                    alert("Erro ao salvar o evento.");
                }
            });

            deleteBtn?.addEventListener('click', async () => {
                if (!confirm("Tem certeza que deseja excluir este evento?")) return;
                const card = document.getElementById('calendar-card');
                const csrfToken = card ? card.getAttribute('data-csrf') : '';
                const date = dateRaw.value;

                try {
                    const response = await fetch('/api/eventos', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ date })
                    });

                    if (response.ok) {
                        closeEventModal();
                        const parts = date.split('-');
                        const year = Number(parts[0]);
                        delete holidaysCache[year];
                        
                        if (renderCalendarFn) await renderCalendarFn();
                    } else {
                        alert("Erro ao excluir o evento.");
                    }
                } catch (err) {
                    console.error("Erro:", err);
                    alert("Erro ao excluir o evento.");
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCalendar);
        } else {
            initCalendar();
        }
    })();
</script>
