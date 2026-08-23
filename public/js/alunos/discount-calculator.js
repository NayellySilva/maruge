(function () {
    'use strict';

    // ─── Utilitários de formatação ────────────────────────────────────────────

    /**
     * Converte string monetária "R$ 1.234,56" → número 1234.56
     */
    function parseMoney(str) {
        if (!str) return 0;
        const cleaned = String(str)
            .replace(/R\$\s*/g, '')
            .replace(/\./g, '')
            .replace(',', '.');
        const num = parseFloat(cleaned);
        return isNaN(num) ? 0 : num;
    }

    /**
     * Converte número → "R$ 1.234,56"
     */
    function formatMoney(num) {
        return 'R$ ' + num.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    /**
     * Converte string percentual "12,5" → número 12.5
     */
    function parsePercent(str) {
        if (!str) return 0;
        const cleaned = String(str).replace('%', '').replace(',', '.').trim();
        const num = parseFloat(cleaned);
        return isNaN(num) ? 0 : num;
    }

    /**
     * Converte número → "12,50"
     */
    function formatPercent(num) {
        return num.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    // ─── Elementos do DOM ────────────────────────────────────────────────────

    function getEls() {
        return {
            valorMatricula:  document.getElementById('ValorPGTO'),
            percentual:      document.getElementById('DescontoPercentual'),
            valorDesconto:   document.getElementById('DescontoValor'),
            motivo:          document.getElementById('MotivoDesconto'),
            validade:        document.getElementById('ValidadeDesconto'),
            dataEspecifica:  document.getElementById('DataValidadeDesconto'),
            dataWrapper:     document.getElementById('DataValidadeWrapper'),
            // Resumo
            resumoMatricula: document.getElementById('resumo-valor-matricula'),
            resumoDesconto:  document.getElementById('resumo-desconto'),
            resumoFinal:     document.getElementById('resumo-valor-final'),
            // Mensagens de erro
            erroPercentual:  document.getElementById('erro-percentual'),
            erroValor:       document.getElementById('erro-valor'),
        };
    }

    // ─── Validação ───────────────────────────────────────────────────────────

    function clearErrors(els) {
        [els.percentual, els.valorDesconto].forEach(el => {
            if (!el) return;
            el.classList.remove('border-red-400', 'bg-red-50/10');
            el.classList.add('border-[#e3e8e6]');
        });
        if (els.erroPercentual) els.erroPercentual.textContent = '';
        if (els.erroValor)      els.erroValor.textContent = '';
    }

    function validate(els, pct, val, matricula) {
        clearErrors(els);
        let valid = true;

        if (pct < 0) {
            markError(els.percentual, els.erroPercentual, 'O percentual não pode ser negativo.');
            valid = false;
        } else if (pct > 100) {
            markError(els.percentual, els.erroPercentual, 'O percentual não pode ultrapassar 100%.');
            valid = false;
        }

        if (val < 0) {
            markError(els.valorDesconto, els.erroValor, 'O valor do desconto não pode ser negativo.');
            valid = false;
        } else if (matricula > 0 && val > matricula) {
            markError(els.valorDesconto, els.erroValor, 'O desconto não pode ser maior que o valor da matrícula.');
            valid = false;
        }

        return valid;
    }

    function markError(input, msgEl, msg) {
        if (input) {
            input.classList.remove('border-[#e3e8e6]');
            input.classList.add('border-red-400', 'bg-red-50/10');
        }
        if (msgEl) msgEl.textContent = msg;
    }

    // ─── Resumo financeiro ───────────────────────────────────────────────────

    function updateSummary(els, matricula, desconto) {
        const final = Math.max(0, matricula - desconto);
        if (els.resumoMatricula) els.resumoMatricula.textContent = formatMoney(matricula);
        if (els.resumoDesconto)  els.resumoDesconto.textContent  = '- ' + formatMoney(desconto);
        if (els.resumoFinal)     els.resumoFinal.textContent     = formatMoney(final);
    }

    // ─── Lógica principal ─────────────────────────────────────────────────────

    let updating = false; // flag anti-loop

    function onPercentualChange(els) {
        if (updating) return;
        updating = true;

        const matricula = parseMoney(els.valorMatricula?.value);
        const pct       = parsePercent(els.percentual?.value);
        const val       = (matricula * pct) / 100;

        if (els.valorDesconto) els.valorDesconto.value = formatMoney(val);

        const ok = validate(els, pct, val, matricula);
        if (ok) updateSummary(els, matricula, val);

        updating = false;
    }

    function onValorDescontoChange(els) {
        if (updating) return;
        updating = true;

        const matricula = parseMoney(els.valorMatricula?.value);
        const val       = parseMoney(els.valorDesconto?.value);
        const pct       = matricula > 0 ? (val / matricula) * 100 : 0;

        if (els.percentual) els.percentual.value = formatPercent(pct);

        const ok = validate(els, pct, val, matricula);
        if (ok) updateSummary(els, matricula, val);

        updating = false;
    }

    function onMatriculaChange(els) {
        if (updating) return;
        updating = true;

        const matricula = parseMoney(els.valorMatricula?.value);
        const pct       = parsePercent(els.percentual?.value);
        const val       = (matricula * pct) / 100;

        if (els.valorDesconto) els.valorDesconto.value = formatMoney(val);

        const ok = validate(els, pct, val, matricula);
        if (ok) updateSummary(els, matricula, val);

        updating = false;
    }

    // ─── Validade: exibir/ocultar data específica ────────────────────────────

    function onValidadeChange(els) {
        if (!els.validade || !els.dataWrapper) return;
        if (els.validade.value === 'data_especifica') {
            els.dataWrapper.classList.remove('hidden');
        } else {
            els.dataWrapper.classList.add('hidden');
        }
    }

    // ─── Inicialização ───────────────────────────────────────────────────────

    function init() {
        const els = getEls();

        // Só inicializa se a seção de desconto existir na página
        if (!els.percentual && !els.valorDesconto) return;

        // Eventos dos campos calculados
        if (els.percentual) {
            els.percentual.addEventListener('input',  () => onPercentualChange(els));
            els.percentual.addEventListener('change', () => onPercentualChange(els));
        }

        if (els.valorDesconto) {
            els.valorDesconto.addEventListener('input',  () => onValorDescontoChange(els));
            els.valorDesconto.addEventListener('change', () => onValorDescontoChange(els));
        }

        if (els.valorMatricula) {
            els.valorMatricula.addEventListener('input',  () => onMatriculaChange(els));
            els.valorMatricula.addEventListener('change', () => onMatriculaChange(els));
        }

        if (els.validade) {
            els.validade.addEventListener('change', () => onValidadeChange(els));
            // Estado inicial
            onValidadeChange(els);
        }

        // Dispara o resumo com os valores já preenchidos (edição de aluno)
        const matricula = parseMoney(els.valorMatricula?.value);
        const pct       = parsePercent(els.percentual?.value);
        const val       = parseMoney(els.valorDesconto?.value) || (matricula * pct) / 100;
        updateSummary(els, matricula, val);
    }

    // Expõe init para ser chamado também após navegação SPA
    window.initDiscountCalculator = init;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
