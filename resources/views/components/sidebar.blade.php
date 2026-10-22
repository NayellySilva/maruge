@php
    $authUser = auth()->guard('guardLogin')->user();
    $isDocente = ($authUser && $authUser->Nivel === 'DOCENTE') || request()->is('docente*');
    
    $nomeUsuario = 'Nayana Roberta';
    $roleUsuario = $isDocente ? 'Docente' : 'Coordenação';
    
    if ($authUser) {
        $cpf = $authUser->CPFUsuario;
        $dadosFunc = \App\Models\modelCoordenacao\tb_usuario::infUsuario($cpf)->first();
        if ($dadosFunc && !empty($dadosFunc->NomeFuncionario)) {
            $nomeUsuario = $dadosFunc->NomeFuncionario;
        } elseif ($isDocente) {
            $nomeUsuario = 'Professor(a)';
        }
    } elseif ($isDocente) {
        $nomeUsuario = 'Docente';
    }

    $iniciais = collect(explode(' ', trim($nomeUsuario)))
        ->filter()
        ->map(fn($part) => mb_substr($part, 0, 1))
        ->take(2)
        ->implode('');
    if (empty($iniciais)) {
        $iniciais = $isDocente ? 'DC' : 'NR';
    }
@endphp

<aside class="sidebar" id="sidebar">
    <!-- Área da Marca/Logotipo -->
    <div class="sidebar-brand">
        <a href="{{ $isDocente ? url('/docente') : url('/') }}" class="flex items-center">
            <img src="{{ asset('logo-Painel3.png') }}" alt="Maruge Logo" style="height: 52px; width: auto;">
        </a>
    </div>

    <!-- Lista de Navegação -->
    <nav class="sidebar-menu">
        @if($isDocente)
            <!-- Dashboard Docente -->
            <div class="sidebar-item" data-menu="dashboard">
                <a href="{{ url('/docente') }}" class="sidebar-link {{ request()->is('docente') ? 'active' : '' }}">
                    <span class="sidebar-link-content">
                        <i data-lucide="layout-grid"></i>
                        <span>Dashboard</span>
                    </span>
                </a>
            </div>

            <!-- Secretaria Docente -->
            <div class="sidebar-item" data-menu="secretaria">
                <button class="sidebar-link" onclick="toggleDropdown(this)">
                    <span class="sidebar-link-content">
                        <i data-lucide="book-open"></i>
                        <span>Secretaria</span>
                    </span>
                    <i data-lucide="chevron-right" class="sidebar-chevron"></i>
                </button>
                <div class="submenu">
                    <div class="submenu-list">
                        <a href="{{ url('/docente/funcionario_perfil') }}" class="submenu-link">Perfil</a>
                        <a href="{{ url('/docente/declaracoes') }}" class="submenu-link">Declarações</a>
                        <a href="{{ url('/docente/notas') }}" class="submenu-link">Lançar Notas</a>
                    </div>
                </div>
            </div>

            <!-- Relatórios Docente -->
            <div class="sidebar-item" data-menu="relatorios">
                <button class="sidebar-link" onclick="toggleDropdown(this)">
                    <span class="sidebar-link-content">
                        <i data-lucide="file-text"></i>
                        <span>Relatórios</span>
                    </span>
                    <i data-lucide="chevron-right" class="sidebar-chevron"></i>
                </button>
                <div class="submenu">
                    <div class="submenu-list">
                        <a href="{{ url('/docente/mapas_notas') }}" class="submenu-link">Mapas de Notas</a>
                        <a href="{{ url('/docente/resultados') }}" class="submenu-link">Resultados</a>
                        <a href="{{ url('/docente/relatorio_alunos_turmas') }}" class="submenu-link">Alunos Por Turma</a>
                    </div>
                </div>
            </div>

            <!-- Ajuda Docente -->
            <div class="sidebar-item" data-menu="ajuda">
                <a href="{{ url('/docente/ajuda') }}" class="sidebar-link {{ request()->is('docente/ajuda*') ? 'active' : '' }}">
                    <span class="sidebar-link-content">
                        <i data-lucide="circle-help"></i>
                        <span>Ajuda</span>
                    </span>
                </a>
            </div>
        @else
            <!-- Dashboard Coordenação -->
            <div class="sidebar-item" data-menu="dashboard">
                <a href="/" class="sidebar-link active">
                    <span class="sidebar-link-content">
                        <i data-lucide="layout-grid"></i>
                        <span>Dashboard</span>
                    </span>
                </a>
            </div>

            <!-- Secretaria -->
            <div class="sidebar-item" data-menu="secretaria">
                <button class="sidebar-link" onclick="toggleDropdown(this)">
                    <span class="sidebar-link-content">
                        <i data-lucide="book-open"></i>
                        <span>Secretaria</span>
                    </span>
                    <i data-lucide="chevron-right" class="sidebar-chevron"></i>
                </button>
                <div class="submenu">
                    <div class="submenu-list">
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'turma', 'pagina' => 'turma_inf']) }}" class="submenu-link">Turmas</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'disciplinas', 'pagina' => 'disciplina_inf']) }}" class="submenu-link">Disciplinas</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'turma_disc', 'pagina' => 'turma_disciplina_inf']) }}" class="submenu-link">Turma x Disciplina</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'funcionarios', 'pagina' => 'funcionario_inf']) }}" class="submenu-link">Funcionários</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'alunos', 'pagina' => 'aluno_inf']) }}" class="submenu-link">Alunos</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'escola', 'pagina' => 'escola_inf']) }}" class="submenu-link">Escola</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'acordo', 'pagina' => 'acordo_cad']) }}" class="submenu-link">Novo Acordo</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'historico', 'pagina' => 'historico']) }}" class="submenu-link">Histórico</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'declaracoes', 'pagina' => 'declaracoes']) }}" class="submenu-link">Declarações</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'frequencia', 'pagina' => 'frequencias']) }}" class="submenu-link">Frequência</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'boletins', 'pagina' => 'boletins']) }}" class="submenu-link">Boletins</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'notas', 'pagina' => 'notas']) }}" class="submenu-link">Lançar Notas</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'carne', 'pagina' => 'carne_inf']) }}" class="submenu-link">Recibos / Carnês</a>
                    </div>
                </div>
            </div>

            <!-- Relatórios -->
            <div class="sidebar-item" data-menu="relatorios">
                <button class="sidebar-link" onclick="toggleDropdown(this)">
                    <span class="sidebar-link-content">
                        <i data-lucide="file-text"></i>
                        <span>Relatórios</span>
                    </span>
                    <i data-lucide="chevron-right" class="sidebar-chevron"></i>
                </button>
                <div class="submenu">
                    <div class="submenu-list">
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'relatorios', 'pagina' => 'relatorios_bimestrais']) }}" class="submenu-link">Relatórios Bim.</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'mapa', 'pagina' => 'mapas_notas']) }}" class="submenu-link">Mapas de Notas</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'resultado', 'pagina' => 'resultados']) }}" class="submenu-link">Resultados</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'gabaritos', 'pagina' => 'gabaritos']) }}" class="submenu-link">Gabaritos</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'relatorios', 'pagina' => 'relatorio_alunos_matriculados']) }}" class="submenu-link">Alunos Matriculados</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'relatorios', 'pagina' => 'relatorio_alunos_transferidos']) }}" class="submenu-link">Alunos Inativos / Transf.</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'relatorios', 'pagina' => 'relatorio_alunos_turmas']) }}" class="submenu-link">Alunos Por Turma</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'relatorios', 'pagina' => 'relatorio_pre_matriculado']) }}" class="submenu-link">Alunos Pré-Matriculados</a>
                    </div>
                </div>
            </div>

            <!-- Financeiro -->
            <div class="sidebar-item" data-menu="financeiro">
                <button class="sidebar-link" onclick="toggleDropdown(this)">
                    <span class="sidebar-link-content">
                        <i data-lucide="dollar-sign"></i>
                        <span>Financeiro</span>
                    </span>
                    <i data-lucide="chevron-right" class="sidebar-chevron"></i>
                </button>
                <div class="submenu">
                    <div class="submenu-list">
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'financeiro', 'pagina' => 'financeiro_receber']) }}" class="submenu-link">Receber</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'financeiro', 'pagina' => 'financeiro_receitas_e_despesas']) }}" class="submenu-link">Receitas e Despesas</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'financeiro', 'pagina' => 'financeiro_estatistica']) }}" class="submenu-link">Estatística</a>
                        <a href="{{ route('coordenacao.pagina', ['pasta' => 'financeiro', 'pagina' => 'financeiro_relatorios']) }}" class="submenu-link">Relatórios</a>
                    </div>
                </div>
            </div>

            <!-- Ajuda -->
            <div class="sidebar-item" data-menu="ajuda">
                <a href="{{ url('/coordenacao/ajuda') }}" class="sidebar-link">
                    <span class="sidebar-link-content">
                        <i data-lucide="circle-help"></i>
                        <span>Ajuda</span>
                    </span>
                </a>
            </div>
        @endif
    </nav>

    <!-- Seção do Perfil no Rodapé -->
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ $iniciais }}
            </div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name" title="{{ $nomeUsuario }}">{{ $nomeUsuario }}</span>
                <span class="sidebar-user-role" title="{{ $roleUsuario }}">{{ $roleUsuario }}</span>
            </div>
        </div>
        <a href="{{ url('/logout') }}" class="sidebar-logout flex items-center justify-center text-[#5c706b] hover:text-red-600 transition-colors" title="Sair">
            <i data-lucide="log-out" style="width: 20px; height: 20px;"></i>
        </a>
    </div>
</aside>
