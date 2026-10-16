(function () {
    // 1. Controle das Abas (Tabs) exposto globalmente
    window.switchTab = function (event, tabId) {
        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.add('hidden');
        });
        const targetPanel = document.getElementById(tabId);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('tab-active');
            btn.classList.add('tab-inactive');
        });

        if (event && event.currentTarget) {
            const clickedBtn = event.currentTarget;
            clickedBtn.classList.remove('tab-inactive');
            clickedBtn.classList.add('tab-active');
        }

        // Re-inicializa máscaras para a aba exibida
        if (window.initAlunoMasks) {
            window.initAlunoMasks();
        }
    };

    // 2. Formatar CPF (000.000.000-00)
    const applyCpfMask = (value) => {
        if (!value) return '';
        return value.replace(/\D/g, '')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d{1,2})/, '$1-$2')
            .replace(/(-\d{2})\d+?$/, '$1');
    };

    // 3. Formatar CNPJ (00.000.000/0000-00)
    const applyCnpjMask = (value) => {
        if (!value) return '';
        return value.replace(/\D/g, '')
            .replace(/^(\d{2})(\d)/, '$1.$2')
            .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
            .replace(/\.(\d{3})(\d)/, '.$1/$2')
            .replace(/(\d{4})(\d)/, '$1-$2')
            .replace(/(-\d{2})\d+?$/, '$1');
    };

    // 4. Formatar Telefone / Celular ((00) 0000-0000 ou (00) 00000-0000)
    const applyPhoneMask = (value) => {
        if (!value) return '';
        const digits = value.replace(/\D/g, '');
        if (digits.length <= 10) {
            return digits.replace(/(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{4})(\d)/, '$1-$2')
                .replace(/(-\d{4})\d+?$/, '$1');
        } else {
            return digits.replace(/(\d{2})(\d)/, '($1) $2')
                .replace(/(\d{5})(\d)/, '$1-$2')
                .replace(/(-\d{4})\d+?$/, '$1');
        }
    };

    // 5. Formatar CEP (00000-000)
    const applyCepMask = (value) => {
        if (!value) return '';
        return value.replace(/\D/g, '')
            .replace(/(\d{5})(\d)/, '$1-$2')
            .replace(/(-\d{3})\d+?$/, '$1');
    };

    // 6. Formatar Data (00/00/0000)
    const applyDateMask = (value) => {
        if (!value) return '';
        if (value.includes('-')) return value; // Data tipo YYYY-MM-DD
        return value.replace(/\D/g, '')
            .replace(/(\d{2})(\d)/, '$1/$2')
            .replace(/(\d{2})(\d)/, '$1/$2')
            .replace(/(\/\d{4})\d+?$/, '$1');
    };

    // 6b. Formatar RG (Somente números, limite de 12 dígitos)
    const applyRgMask = (value) => {
        if (!value) return '';
        return value.replace(/\D/g, '').slice(0, 12);
    };

    // 6c. Formatar Moeda / Valor (0,00)
    const applyCurrencyMask = (value) => {
        if (!value) return '';
        let clean = value.replace(/\D/g, '');
        if (!clean) return '';
        let number = (parseInt(clean, 10) / 100).toFixed(2);
        let parts = number.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        return parts.join(',');
    };

    // 7. Funções de Validação de CPF
    function validateCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf === '' || cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

        let add = 0;
        for (let i = 0; i < 9; i++) {
            add += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let rev = 11 - (add % 11);
        if (rev === 10 || rev === 11) rev = 0;
        if (rev !== parseInt(cpf.charAt(9))) return false;

        add = 0;
        for (let i = 0; i < 10; i++) {
            add += parseInt(cpf.charAt(i)) * (11 - i);
        }
        rev = 11 - (add % 11);
        if (rev === 10 || rev === 11) rev = 0;
        if (rev !== parseInt(cpf.charAt(10))) return false;

        return true;
    }

    function validateCPFField(input) {
        const rawValue = input.value.replace(/\D/g, '');
        if (rawValue.length === 0) {
            input.classList.remove('border-emerald-500', 'bg-emerald-50/10', 'border-red-400', 'bg-red-50/10');
            return;
        }

        if (rawValue.length === 11) {
            if (validateCPF(rawValue)) {
                input.classList.remove('border-red-400', 'bg-red-50/10');
                input.classList.add('border-emerald-500', 'bg-emerald-50/10');
            } else {
                input.classList.remove('border-emerald-500', 'bg-emerald-50/10');
                input.classList.add('border-red-400', 'bg-red-50/10');
            }
        } else {
            input.classList.remove('border-emerald-500', 'bg-emerald-50/10', 'border-red-400', 'bg-red-50/10');
        }
    }

    // Helper para identificar a intenção do campo
    const isMatch = (el, keywords) => {
        const name = (el.getAttribute('name') || '').toLowerCase();
        const id = (el.getAttribute('id') || '').toLowerCase();
        const cls = (el.getAttribute('class') || '').toLowerCase();
        return keywords.some(k => name.includes(k) || id.includes(k) || cls.includes(k));
    };

    // 8. Event Listener Global de Entrada para Máscaras Instantâneas (Event Delegation)
    document.addEventListener('input', (e) => {
        const target = e.target;
        if (!target || target.tagName !== 'INPUT') return;
        const type = (target.getAttribute('type') || 'text').toLowerCase();
        if (type === 'hidden' || type === 'password' || type === 'file' || type === 'checkbox' || type === 'radio') return;

        // CPF
        if (isMatch(target, ['cpf'])) {
            target.value = applyCpfMask(target.value);
            validateCPFField(target);
        }

        // CNPJ
        if (isMatch(target, ['cnpj'])) {
            target.value = applyCnpjMask(target.value);
        }

        // Telefone / Celular
        if (isMatch(target, ['fone', 'celular', 'telefone', 'whatsapp'])) {
            target.value = applyPhoneMask(target.value);
        }

        // CEP
        if (isMatch(target, ['cep'])) {
            target.value = applyCepMask(target.value);
            // Dispara a busca ViaCEP automaticamente se tiver 8 dígitos digitados
            const cleanCep = target.value.replace(/\D/g, '');
            if (cleanCep.length === 8 && !target.dataset.fetching && target.dataset.lastFetchedCep !== cleanCep) {
                fetchViaCep(target);
            }
        }

        // Data
        if (type === 'text' && isMatch(target, ['data', 'nascimento', 'emissao', 'matricula'])) {
            target.value = applyDateMask(target.value);
        }

        // RG (apenas números)
        if (type === 'text' && isMatch(target, ['rg', 'rgfuncionario', 'rgaluno'])) {
            target.value = applyRgMask(target.value);
        }

        // Salário / Mensalidade / Valores Monetários
        if (type === 'text' && isMatch(target, ['salario', 'mensalidade', 'valor', 'renda', 'preco'])) {
            target.value = applyCurrencyMask(target.value);
        }
    });

    // 9. Função Universal do ViaCEP (Validador e Autocompletar por API)
    function fetchViaCep(cepInput) {
        const cep = cepInput.value.replace(/\D/g, '');
        if (cep.length !== 8) return;

        if (cepInput.dataset.lastFetchedCep === cep || cepInput.dataset.fetching === "true") return;

        cepInput.dataset.fetching = "true";
        cepInput.dataset.lastFetchedCep = cep;
        const form = cepInput.closest('form') || document;

        const rua = form.querySelector('input[name="Rua"], input[id="Rua"], input[name="logradouro"], input[id="logradouro"], input[name="Endereco"]');
        const bairro = form.querySelector('input[name="Bairro"], input[id="Bairro"]');
        const cidade = form.querySelector('input[name="Cidade"], input[id="Cidade"], select[name="Cidade"], select[id="Cidade"]');
        const estado = form.querySelector('select[name="Estado"], select[id="Estado"], input[name="Estado"], input[id="Estado"], select[name="UF"], select[id="UF"], select[id="EstadoCartorio"]');
        const numero = form.querySelector('input[name="Numero"], input[id="Numero"]');

        const origRua = rua ? rua.value : '';
        const origBairro = bairro ? bairro.value : '';
        const origCidade = cidade ? cidade.value : '';

        if (rua) { rua.value = 'Buscando endereço...'; rua.classList.add('animate-pulse'); }
        if (bairro) { bairro.value = 'Buscando bairro...'; bairro.classList.add('animate-pulse'); }
        if (cidade && cidade.tagName === 'INPUT') { cidade.value = 'Buscando cidade...'; cidade.classList.add('animate-pulse'); }

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(res => res.json())
            .then(data => {
                if (!data.erro) {
                    if (rua) rua.value = data.logradouro || '';
                    if (bairro) bairro.value = data.bairro || '';

                    // Preencher Cidade
                    if (cidade) {
                        if (cidade.tagName === 'SELECT') {
                            let found = false;
                            Array.from(cidade.options).forEach(opt => {
                                if (opt.value.toUpperCase() === (data.localidade || '').toUpperCase() || opt.text.toUpperCase() === (data.localidade || '').toUpperCase()) {
                                    opt.selected = true;
                                    found = true;
                                }
                            });
                            if (!found && data.localidade) {
                                const opt = document.createElement('option');
                                opt.value = data.localidade.toUpperCase();
                                opt.textContent = data.localidade.toUpperCase();
                                opt.selected = true;
                                cidade.appendChild(opt);
                            }
                        } else {
                            cidade.value = data.localidade || '';
                        }
                        cidade.dispatchEvent(new Event('change', { bubbles: true }));
                    }

                    // Preencher Estado (UF)
                    if (estado) {
                        if (estado.tagName === 'SELECT') {
                            Array.from(estado.options).forEach(opt => {
                                if (opt.value.toUpperCase() === (data.uf || '').toUpperCase() || opt.text.toUpperCase().includes((data.uf || '').toUpperCase())) {
                                    opt.selected = true;
                                }
                            });
                        } else {
                            estado.value = data.uf || '';
                        }
                        estado.dispatchEvent(new Event('change', { bubbles: true }));
                    }

                    // Focar no campo Número
                    if (numero) {
                        setTimeout(() => numero.focus(), 100);
                    }
                } else {
                    alert('CEP não encontrado. Por favor, verifique o número do CEP digitado.');
                    if (rua) rua.value = origRua;
                    if (bairro) bairro.value = origBairro;
                    if (cidade && cidade.tagName === 'INPUT') cidade.value = origCidade;
                }
            })
            .catch(() => {
                alert('Erro ao consultar o CEP. Verifique sua conexão com a internet.');
                if (rua) rua.value = origRua;
                if (bairro) bairro.value = origBairro;
                if (cidade && cidade.tagName === 'INPUT') cidade.value = origCidade;
            })
            .finally(() => {
                delete cepInput.dataset.fetching;
                if (rua) rua.classList.remove('animate-pulse');
                if (bairro) bairro.classList.remove('animate-pulse');
                if (cidade && cidade.tagName === 'INPUT') cidade.classList.remove('animate-pulse');
            });
    }

    // Bind no evento blur para garantir consulta de CEP se alterado
    document.addEventListener('blur', (e) => {
        const target = e.target;
        if (!target || target.tagName !== 'INPUT') return;
        if (isMatch(target, ['cep'])) {
            const cleanCep = target.value.replace(/\D/g, '');
            if (cleanCep.length === 8 && !target.dataset.fetching) {
                fetchViaCep(target);
            }
        }
    }, true);

    // 10. API IBGE: Carregador Automático de Estados e Cidades
    const BRAZIL_UFS = [
        { uf: 'AC', name: 'Acre' }, { uf: 'AL', name: 'Alagoas' }, { uf: 'AP', name: 'Amapá' },
        { uf: 'AM', name: 'Amazonas' }, { uf: 'BA', name: 'Bahia' }, { uf: 'CE', name: 'Ceará' },
        { uf: 'DF', name: 'Distrito Federal' }, { uf: 'ES', name: 'Espírito Santo' }, { uf: 'GO', name: 'Goiás' },
        { uf: 'MA', name: 'Maranhão' }, { uf: 'MT', name: 'Mato Grosso' }, { uf: 'MS', name: 'Mato Grosso do Sul' },
        { uf: 'MG', name: 'Minas Gerais' }, { uf: 'PA', name: 'Pará' }, { uf: 'PB', name: 'Paraíba' },
        { uf: 'PR', name: 'Paraná' }, { uf: 'PE', name: 'Pernambuco' }, { uf: 'PI', name: 'Piauí' },
        { uf: 'RJ', name: 'Rio de Janeiro' }, { uf: 'RN', name: 'Rio Grande do Norte' }, { uf: 'RS', name: 'Rio Grande do Sul' },
        { uf: 'RO', name: 'Rondônia' }, { uf: 'RR', name: 'Roraima' }, { uf: 'SC', name: 'Santa Catarina' },
        { uf: 'SP', name: 'São Paulo' }, { uf: 'SE', name: 'Sergipe' }, { uf: 'TO', name: 'Tocantins' }
    ];

    const setupIbgeLocation = () => {
        const estadoSelects = document.querySelectorAll('select[name="Estado"], select[id="Estado"], select[id="EstadoCartorio"], select[name="EstadoCartorio"], select[name="UF"], select[id="UF"]');

        estadoSelects.forEach(estadoSelect => {
            const form = estadoSelect.closest('form') || document;
            const cidadeSelect = form.querySelector('select[name="Cidade"], select[id="Cidade"], select[id="CidadeCartorio"], select[name="CidadeCartorio"]');

            const preSelectedState = estadoSelect.dataset.value || estadoSelect.value || '';
            const preSelectedCity  = cidadeSelect ? (cidadeSelect.dataset.value || cidadeSelect.value || '') : '';

            // Se o select de estado possuir apenas 1 opcao ("Selecione..."), popula todas as 27 UFs!
            if (estadoSelect.options.length <= 1) {
                BRAZIL_UFS.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.uf;
                    opt.textContent = `${item.name} (${item.uf})`;
                    if (preSelectedState && preSelectedState.toUpperCase() === item.uf.toUpperCase()) {
                        opt.selected = true;
                    }
                    estadoSelect.appendChild(opt);
                });
            }

            if (cidadeSelect) {
                const loadCities = (uf, restoreCity = '') => {
                    cidadeSelect.innerHTML = '<option value="">Selecione a cidade...</option>';
                    if (!uf) return;

                    fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${uf}/municipios`)
                        .then(res => res.json())
                        .then(cities => {
                            cities.forEach(city => {
                                const opt = document.createElement('option');
                                opt.value = city.nome.toUpperCase();
                                opt.textContent = city.nome.toUpperCase();
                                if (restoreCity && city.nome.toUpperCase() === restoreCity.toUpperCase()) {
                                    opt.selected = true;
                                }
                                cidadeSelect.appendChild(opt);
                            });
                        })
                        .catch(() => {
                            console.warn('Erro ao carregar cidades do IBGE.');
                        });
                };

                estadoSelect.addEventListener('change', () => {
                    const val = estadoSelect.value;
                    loadCities(val);
                });

                const currentState = estadoSelect.value || preSelectedState;
                if (currentState && currentState.length <= 2) {
                    loadCities(currentState, preSelectedCity);
                }
            }
        });
    };

    // 11. Inicializador Exposto Globalmente (Suporta SPA e Modais)
    window.initAlunoMasks = function () {
        document.querySelectorAll('input').forEach(input => {
            if (!input.value) return;
            const type = (input.getAttribute('type') || 'text').toLowerCase();
            if (type === 'hidden' || type === 'password' || type === 'file' || type === 'checkbox' || type === 'radio') return;

            if (isMatch(input, ['cpf'])) {
                input.value = applyCpfMask(input.value);
                validateCPFField(input);
            }
            if (isMatch(input, ['cnpj'])) {
                input.value = applyCnpjMask(input.value);
            }
            if (isMatch(input, ['fone', 'celular', 'telefone', 'whatsapp'])) {
                input.value = applyPhoneMask(input.value);
            }
            if (isMatch(input, ['cep'])) {
                input.value = applyCepMask(input.value);
            }
            if (type === 'text' && isMatch(input, ['data', 'nascimento', 'emissao', 'matricula'])) {
                input.value = applyDateMask(input.value);
            }
        });

        setupIbgeLocation();
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', window.initAlunoMasks);
    } else {
        window.initAlunoMasks();
    }
})();
