@extends('layouts.app')

@section('content')
@php
    $func = is_iterable($Funcionario) ? $Funcionario->first() : $Funcionario;
@endphp

@if($func)
<div class="flex flex-col gap-6">
    <!-- Localização (Breadcrumb) & Botões -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="text-sm text-[#5c706b] flex items-center gap-2">
            <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
            <span>/</span>
            <a href="{{ url('/coordenacao/funcionarios/funcionario_inf') }}" class="hover:text-[#008a4b] transition-colors">Funcionários</a>
            <span>/</span>
            <span class="font-semibold text-[#0a241e]">Perfil</span>
        </div>
        
        <!-- Botões de Ação no Topo -->
        <div class="flex items-center gap-2 print:hidden">
            <button onclick="window.print()" class="bg-[#f8faf9] hover:bg-[#e3e8e6] border border-[#e3e8e6] text-[#0a241e] font-medium px-4 py-2 rounded-xl text-xs flex items-center gap-2 transition-all cursor-pointer shadow-2xs">
                <i data-lucide="printer" class="w-4 h-4 text-[#5c706b]"></i>
                <span>Imprimir</span>
            </button>
            <a href="{{ url('/coordenacao/funcionario_editar/' . $func->idFuncionarios) }}" class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-4 py-2 rounded-xl text-xs flex items-center gap-2 transition-all shadow-sm cursor-pointer">
                <i data-lucide="pencil" class="w-4 h-4"></i>
                <span>Editar</span>
            </a>
            <a href="{{ url('/coordenacao/funcionarios/funcionario_inf') }}" class="border border-[#e3e8e6] text-[#5c706b] hover:bg-[#f8faf9] font-medium px-4 py-2 rounded-xl text-xs flex items-center gap-2 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Voltar</span>
            </a>
        </div>
    </div>

    <!-- Layout Proporcional 50% / 50% (Meio a Meio) -->
    <div style="display: flex; flex-direction: row; gap: 24px; width: 100%; align-items: stretch;" class="perfil-flex-wrap">
        
        <!-- COLUNA ESQUERDA: Perfil do Funcionário (50% de largura) -->
        <div style="flex: 1 1 0%; min-width: 0;" class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-6">
            
            <!-- Topo do Perfil: Avatar, Nome e Função com Gap da Linha Divisória -->
            <div style="padding-bottom: 24px; margin-bottom: 8px;" class="flex items-center gap-4 border-b border-[#e3e8e6]">
                <div class="w-16 h-16 rounded-2xl bg-[#ecfdf5] border border-[#008a4b]/20 flex items-center justify-center text-[#008a4b] font-bold text-2xl shrink-0 shadow-2xs">
                    {{ strtoupper(substr($func->NomeFuncionario ?? 'F', 0, 1)) }}
                </div>
                <div class="flex flex-col gap-1.5 min-w-0">
                    <h2 class="text-lg font-bold text-[#0a241e] truncate" title="{{ $func->NomeFuncionario }}">{{ $func->NomeFuncionario }}</h2>
                    <span class="inline-self-start px-3 py-1 rounded-full text-xs font-semibold bg-[#f0fdf4] text-[#166534] border border-[#008a4b]/20 w-max">
                        {{ $func->Funcao }}
                    </span>
                </div>
            </div>

            <!-- Dados Detalhados em Lista Aberta, Limpa e sem Bordas Internas -->
            <div class="flex flex-col gap-5 pt-1">
                
                <!-- 1. CPF / RG -->
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 rounded-xl bg-[#ecfdf5] flex items-center justify-center shrink-0">
                        <i data-lucide="credit-card" class="w-4.5 h-4.5 text-[#008a4b]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[11px] font-semibold uppercase tracking-wider text-[#95aba5] mb-0.5">CPF / RG</span>
                        <span class="text-sm font-medium text-[#0a241e]">{{ $func->CPFFuncionario ?: '-' }} / {{ $func->RGFuncionario ?: '-' }}</span>
                    </div>
                </div>

                <!-- 2. E-mail -->
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 rounded-xl bg-[#ecfdf5] flex items-center justify-center shrink-0">
                        <i data-lucide="mail" class="w-4.5 h-4.5 text-[#008a4b]"></i>
                    </div>
                    <div class="min-w-0 flex-1 truncate">
                        <span class="block text-[11px] font-semibold uppercase tracking-wider text-[#95aba5] mb-0.5">E-mail</span>
                        <span class="text-sm font-medium text-[#0a241e] truncate block" title="{{ $func->EmailFuncionario }}">{{ $func->EmailFuncionario ?: '-' }}</span>
                    </div>
                </div>

                <!-- 3. Telefones -->
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 rounded-xl bg-[#ecfdf5] flex items-center justify-center shrink-0">
                        <i data-lucide="phone" class="w-4.5 h-4.5 text-[#008a4b]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[11px] font-semibold uppercase tracking-wider text-[#95aba5] mb-0.5">Telefones</span>
                        <span class="text-sm font-medium text-[#0a241e]">
                            {{ $func->Fone1 ?: '-' }} @if($func->Fone2) / {{ $func->Fone2 }} @endif
                        </span>
                    </div>
                </div>

                <!-- 4. Formação -->
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 rounded-xl bg-[#ecfdf5] flex items-center justify-center shrink-0">
                        <i data-lucide="graduation-cap" class="w-4.5 h-4.5 text-[#008a4b]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[11px] font-semibold uppercase tracking-wider text-[#95aba5] mb-0.5">Formação</span>
                        <span class="text-sm font-medium text-[#0a241e]">{{ $func->Formacao ?: '-' }}</span>
                    </div>
                </div>

                <!-- 5. Salário -->
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 rounded-xl bg-[#ecfdf5] flex items-center justify-center shrink-0">
                        <i data-lucide="dollar-sign" class="w-4.5 h-4.5 text-[#008a4b]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[11px] font-semibold uppercase tracking-wider text-[#95aba5] mb-0.5">Salário</span>
                        <span class="text-sm font-medium text-[#0a241e]">{{ $func->Salario ? 'R$ ' . $func->Salario : '-' }}</span>
                    </div>
                </div>

                <!-- 6. Endereço Completo -->
                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl bg-[#ecfdf5] flex items-center justify-center shrink-0 mt-0.5">
                        <i data-lucide="map-pin" class="w-4.5 h-4.5 text-[#008a4b]"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <span class="block text-[11px] font-semibold uppercase tracking-wider text-[#95aba5] mb-0.5">Endereço</span>
                        <span class="text-sm font-medium text-[#0a241e] leading-relaxed block">
                            {{ $func->Rua ?: '' }}{{ $func->Numero ? ', ' . $func->Numero : '' }}
                            @if($func->Bairro)<br>{{ $func->Bairro }}@endif
                            @if($func->Cidade) - {{ $func->Cidade }}@endif{{ $func->Estado ? '/' . $func->Estado : '' }}
                            @if($func->CEP)<br><span class="text-xs text-[#5c706b]">CEP: {{ $func->CEP }}</span>@endif
                        </span>
                    </div>
                </div>

            </div>
        </div>

        <!-- COLUNA DIREITA: Relação Institucional (50% de largura) -->
        <div style="flex: 1 1 0%; min-width: 0;" class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-4">
            <div class="flex items-center justify-between border-b border-[#f1f3f2] pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#ecfdf5] border border-[#008a4b]/20 flex items-center justify-center text-[#008a4b] shrink-0 shadow-2xs">
                        <i data-lucide="book-open" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-[#0a241e]">Relação Institucional</h3>
                        <p class="text-xs text-[#5c706b]">Turmas e disciplinas sob responsabilidade do funcionário</p>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto w-full grow flex flex-col">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-[#f8faf9] border-b border-[#e3e8e6] h-10">
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b] w-2/5">Turma</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Disciplinas Ministradas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e3e8e6]">
                        @forelse($Turmas ?? [] as $Turma)
                            <tr class="hover:bg-[#f8faf9]/50 transition-colors">
                                <td class="px-5 py-4 text-xs font-semibold text-[#0a241e] whitespace-nowrap">
                                    {{ $Turma->NomeTurma }}
                                </td>
                                <td class="px-5 py-4 text-xs text-[#0a241e]">
                                    @php
                                        $disciplinadoprofessor = \App\Models\modelCoordenacao\tb_funcionario::DisciplinasdoProfessor($func->idFuncionarios, $Turma->idTurmas);
                                    @endphp
                                    <div class="flex flex-wrap gap-1.5">
                                        @forelse($disciplinadoprofessor as $disciplina)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-[#ecfdf5] text-[#008a4b] border border-[#008a4b]/20">
                                                {{ $disciplina->NomeDisciplina }}
                                            </span>
                                        @empty
                                            <span class="text-xs text-[#95aba5]">Nenhuma disciplina vinculada</span>
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-5 py-12 text-center text-xs text-[#5c706b]">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-10 h-10 rounded-full bg-[#f8faf9] flex items-center justify-center text-[#95aba5]">
                                            <i data-lucide="info" class="w-5 h-5"></i>
                                        </div>
                                        <span class="font-medium text-[#0a241e]">Nenhuma turma vinculada a este funcionário.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@else
<div class="bg-white border border-[#e3e8e6] rounded-2xl p-12 text-center flex flex-col items-center gap-3">
    <i data-lucide="user-x" class="w-12 h-12 text-[#95aba5]"></i>
    <h2 class="text-lg font-semibold text-[#0a241e]">Funcionário não encontrado</h2>
    <a href="{{ url('/coordenacao/funcionarios/funcionario_inf') }}" class="bg-[#008a4b] text-white px-5 py-2 rounded-xl text-sm font-medium mt-2">Voltar para Funcionários</a>
</div>
@endif

<style>
@media (max-width: 991px) {
    .perfil-flex-wrap {
        flex-direction: column !important;
    }
    .perfil-flex-wrap > div {
        max-width: 100% !important;
        flex: 1 1 100% !important;
    }
}
@media print {
    .print\:hidden, nav, sidebar, header, .sidebar, #sidebar {
        display: none !important;
    }
    body {
        background: white !important;
        color: black !important;
    }
}
</style>
@endsection