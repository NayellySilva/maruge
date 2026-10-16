@extends('layouts.app')

@section('content')
@php
    // Inicialização segura de todas as variáveis para evitar Fatal Errors no PHP 8.3
    $aluno = $aluno ?? null;
    $matricula = $matricula ?? null;
    $pais = $pais ?? null;
    $endereco = $endereco ?? null;
    $turmas = $turmas ?? collect();

    // Auxiliar para formatar datas para o formato de input date nativo (YYYY-MM-DD)
    $formatDate = function($date) {
        if (!$date) return '';
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            $parts = explode('/', $date);
            return "{$parts[2]}-{$parts[1]}-{$parts[0]}";
        }
        $ts = strtotime(str_replace('/', '-', $date));
        return $ts ? date('Y-m-d', $ts) : '';
    };
@endphp

<div class="flex flex-col gap-6 w-full">
    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/alunos/aluno_inf') }}" class="hover:text-[#008a4b] transition-colors">Alunos</a>
        <span class="mx-2">/</span>
        <span class="text-[#0a241e] font-semibold">{{ $aluno ? 'Editar Aluno' : 'Nova Matrícula' }}</span>
    </div>

    <!-- Card Principal -->
    <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs">
        <!-- Cabeçalho do Card -->
        <div >
            <h1 class="text-2xl font-semibold text-[#0a241e]">{{ $aluno ? 'Editar Cadastro de Aluno' : 'Nova Matrícula' }}</h1>
            <p class="text-sm text-[#5c706b] mt-1 mb-6">Preencha os dados do aluno, informações dos pais, endereço e observações.</p>
        </div>

        <!-- Alertas e Preloader (Requeridos pelo JS do painel) -->
        <div class="preloader text-sm text-[#008a4b] font-medium mb-4" style="display: none">
            <span class="inline-flex items-center gap-2">
                <span class="w-4 h-4 rounded-full border-2 border-[#008a4b] border-t-transparent animate-spin"></span>
                Enviando os dados...
            </span>
        </div>  
        <div class="alert alert-success msg-exito bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6 text-sm" role="alert" style="display: none"></div>
        <div class="alert alert-warning msg-erro bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-xl mb-6 text-sm" role="alert" style="display: none"></div> 

        <!-- Alert de Erros de Validação -->
        @if((isset($errors) ? count($errors) : 0) > 0)
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm flex gap-3 items-start">
                <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
                <div>
                    <strong class="font-semibold block mb-1">Por favor, corrija os erros abaixo:</strong>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Formulário -->
        @if($aluno)
            <form class="form form-search form-Nu formularios flex flex-col" action="{{ url('/coordenacao/aluno_editar/' . $aluno->idAluno) }}" method="POST">
        @else
            <form class="form form-search form-Nu formularios flex flex-col gap-6" action="{{ url('/coordenacao/aluno_cad') }}" method="POST" send="{{ url('/coordenacao/aluno_cad') }}">
        @endif
            {!! csrf_field() !!}

            <!-- GUIA DE NAVEGAÇÃO (Tabs) -->
            <div class="tab-container">
                <button type="button" class="tab-btn tab-active" onclick="switchTab(event, 'dados_aluno')">
                    DADOS DO ALUNO
                </button>
                <button type="button" class="tab-btn tab-inactive" onclick="switchTab(event, 'dados_pais')">
                    DADOS DOS PAIS
                </button>
                <button type="button" class="tab-btn tab-inactive" onclick="switchTab(event, 'endereco')">
                    ENDEREÇO
                </button>
                <button type="button" class="tab-btn tab-inactive" onclick="switchTab(event, 'financeiro')">
                    FINANCEIRO
                </button>
                <button type="button" class="tab-btn tab-inactive" onclick="switchTab(event, 'obs')">
                    OBSERVAÇÕES
                </button>
            </div>

            <!-- CONTEÚDO DAS GUIAS (Paineis) -->
            <div class="tab-content">
                @include('telasCoordenacao.alunos.partials.tab_aluno')
                @include('telasCoordenacao.alunos.partials.tab_pais')
                @include('telasCoordenacao.alunos.partials.tab_endereco')
                @include('telasCoordenacao.alunos.partials.tab_financeiro')
                @include('telasCoordenacao.alunos.partials.tab_obs')
            </div>

            
        </form> <!-- Fim do formulário -->
    </div>
</div>

<!-- Script de máscaras e interatividades do aluno (externo) -->
<script src="{{ asset('js/alunos/aluno_masks.js') }}"></script>
<!-- Calculadora de descontos -->
<script src="{{ asset('js/alunos/discount-calculator.js') }}"></script>
@endsection