import.meta.glob(['../img/**'], { eager: true, query: '?url', import: 'default' });

const somenteDigitos = (valor) => valor.replace(/\D/g, '');

function mascararCpf(valor) {
    const d = somenteDigitos(valor).slice(0, 11);
    let r = d.slice(0, 3);
    if (d.length > 3) r += '.' + d.slice(3, 6);
    if (d.length > 6) r += '.' + d.slice(6, 9);
    if (d.length > 9) r += '-' + d.slice(9, 11);
    return r;
}

document.querySelectorAll('[data-mascara="cpf"]').forEach((campo) => {
    const aplicar = () => { campo.value = mascararCpf(campo.value); };
    campo.addEventListener('input', aplicar);
    aplicar();
});

document.querySelectorAll('[data-mascara="digitos8"]').forEach((campo) => {
    campo.addEventListener('input', () => { campo.value = somenteDigitos(campo.value).slice(0, 8); });
});

document.querySelectorAll('[data-alternar-senha]').forEach((botao) => {
    const alvo = document.getElementById(botao.dataset.alternarSenha);
    if (!alvo) return;
    botao.addEventListener('click', () => {
        const mostrar = alvo.type === 'password';
        alvo.type = mostrar ? 'text' : 'password';
        botao.setAttribute('aria-label', mostrar ? 'Ocultar senha' : 'Mostrar senha');
        botao.setAttribute('aria-pressed', String(mostrar));
    });
});

document.querySelectorAll('[data-login-form]').forEach((form) => {
    form.addEventListener('submit', () => {
        const botao = form.querySelector('[type="submit"]');
        if (botao) {
            botao.disabled = true;
            botao.textContent = botao.dataset.textoEnviando || 'Entrando...';
        }
    });
});
