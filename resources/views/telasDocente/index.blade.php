@extends('layouts.app')

@section('content')
<div class="flex flex-col gap-8">

    <!-- Cabecalho Principal -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-[#008a4b]">
                <i data-lucide="sparkles" class="w-4 h-4"></i>
                <span>Painel do Docente · {{ $bimestreAtual }}º Bimestre</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-[#0a241e] mt-1">{{ $saudacao }}</h1>
            <p class="text-sm text-[#5c706b] mt-1">Gerencie suas turmas, acompanhe pendências e lance notas com agilidade.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ url('/docente/notas') }}" class="inline-flex items-center gap-2 bg-[#008a4b] hover:bg-[#00703c] text-white text-sm font-semibold px-5 py-2.5 rounded-full transition-all shadow-xs">
                <i data-lucide="clipboard-pen" class="w-4 h-4"></i>
                <span>Lançar Notas</span>
            </a>
            <a href="{{ url('/docente/mapas_notas') }}" class="inline-flex items-center gap-2 bg-white hover:bg-[#f8faf9] text-[#0a241e] border border-[#e3e8e6] text-sm font-semibold px-5 py-2.5 rounded-full transition-all shadow-2xs">
                <i data-lucide="map" class="w-4 h-4 text-[#5c706b]"></i>
                <span>Mapas de Notas</span>
            </a>
        </div>
    </div>

    <!-- Cards de Resumo Metrico -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Minhas Turmas</span>
                <div class="text-3xl font-bold text-[#0a241e] mt-1">{{ $totalTurmas }}</div>
                <span class="text-xs text-[#5c706b] mt-0.5 inline-block">Turmas ativas vinculadas</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                <i data-lucide="layout-grid" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Disciplinas</span>
                <div class="text-3xl font-bold text-[#0a241e] mt-1">{{ $totalDisciplinas }}</div>
                <span class="text-xs text-[#5c706b] mt-0.5 inline-block">Disciplinas distintas sob sua regência</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                <i data-lucide="book-marked" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex items-center justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-wider text-[#5c706b]">Total de Alunos</span>
                <div class="text-3xl font-bold text-[#0a241e] mt-1">{{ $totalAlunos }}</div>
                <span class="text-xs text-[#5c706b] mt-0.5 inline-block">Alunos ativos em suas turmas</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#008a4b] flex items-center justify-center shrink-0">
                <i data-lucide="graduation-cap" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    @if($turmas->isEmpty())
        <!-- Alerta amigavel quando nao ha turmas vinculadas -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl p-8 sm:p-12 text-center shadow-2xs flex flex-col items-center gap-4 max-w-2xl mx-auto">
            <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                <i data-lucide="alert-circle" class="w-8 h-8"></i>
            </div>
            <h2 class="text-xl sm:text-2xl font-bold text-[#0a241e]">Nenhuma turma vinculada ao seu perfil</h2>
            <p class="text-sm text-[#5c706b] max-w-md leading-relaxed">
                Você ainda não possui turmas ou disciplinas atribuídas neste ano letivo. Entre em contato com a coordenação pedagógica para realizar a vinculação.
            </p>
            <div class="flex gap-3 mt-2">
                <a href="{{ url('/docente/ajuda') }}" class="inline-flex items-center gap-2 rounded-lg border border-[#d8e5df] px-4 py-2 text-sm font-medium text-[#5c706b] hover:bg-[#f8faf9] transition-colors">
                    <i data-lucide="help-circle" class="w-4 h-4"></i> Ajuda
                </a>
                <a href="{{ url('/docente/funcionario_perfil') }}" class="inline-flex items-center gap-2 rounded-lg bg-[#008a4b] hover:bg-[#00703c] text-white px-5 py-2 text-sm font-semibold transition-colors">
                    <i data-lucide="user" class="w-4 h-4"></i> Meu Perfil
                </a>
            </div>
        </div>
    @else
        <!-- Grid Principal: Minhas Turmas + Lateral com Pendencias e Aniversariantes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Coluna Principal (2/3): Minhas Turmas -->
            <div class="lg:col-span-2 flex flex-col gap-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-[#0a241e]">Minhas Turmas</h2>
                        <p class="text-xs text-[#5c706b]">Selecione uma turma para lançar notas ou emitir mapas</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-[#f8faf9] border border-[#e3e8e6] text-[#5c706b]">
                        {{ $turmas->count() }} {{ $turmas->count() === 1 ? 'turma ativa' : 'turmas ativas' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($turmas as $t)
                        @php
                            $badgeNivel = match($t->nivel) {
                                'inf' => ['bg' => 'bg-pink-50', 'text' => 'text-pink-700', 'label' => 'Educação Infantil'],
                                'fun2' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => 'Fundamental II'],
                                default => ['bg' => 'bg-sky-50', 'text' => 'text-sky-700', 'label' => 'Fundamental I'],
                            };
                        @endphp
                        <div class="bg-white border border-[#e3e8e6] hover:border-[#008a4b]/40 rounded-2xl p-5 shadow-2xs hover:shadow-xs transition-all flex flex-col justify-between gap-4">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="text-base font-bold text-[#0a241e] leading-snug">{{ $t->NomeTurma }}</h3>
                                    <span class="text-[11px] font-semibold px-2 py-0.5 rounded-md {{ $badgeNivel['bg'] }} {{ $badgeNivel['text'] }} shrink-0">
                                        {{ $badgeNivel['label'] }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-[#5c706b]">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="users" class="w-3.5 h-3.5"></i>
                                        {{ $t->totalAlunos }} alunos
                                    </span>
                                    <span>·</span>
                                    <span>{{ $t->Turno }}</span>
                                    <span>·</span>
                                    <span>Ano {{ $t->AnoLetivo }}</span>
                                </div>

                                <!-- Disciplinas que o professor leciona nesta turma -->
                                <div class="mt-2 flex flex-wrap gap-1.5">
                                    @forelse($t->disciplinas as $d)
                                        <a href="{{ url('/docente/lancar_turma/' . $t->idTurmas . '/' . $d->tb_disciplinas_idDisciplinas . '/' . $bimestreAtual . 'bim') }}"
                                           class="text-xs bg-[#f8faf9] hover:bg-[#ecfdf5] border border-[#e3e8e6] hover:border-[#008a4b] text-[#0a241e] hover:text-[#008a4b] px-2 py-0.5 rounded-md font-medium transition-colors inline-flex items-center gap-1"
                                           title="Lançar notas de {{ $d->NomeDisciplina }} (Turma inteira)">
                                            <span>{{ $d->NomeDisciplina }}</span>
                                            <i data-lucide="edit-3" class="w-3 h-3 text-[#5c706b]"></i>
                                        </a>
                                    @empty
                                        <span class="text-xs text-[#5c706b] italic">Sem disciplinas vinculadas</span>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Acoes Rapidas da Turma -->
                            <div class="pt-3 border-t border-[#f0f4f2] flex flex-wrap items-center justify-between gap-2">
                                @if($t->disciplinas->count() === 1)
                                    <a href="{{ url('/docente/lancar_turma/' . $t->idTurmas . '/' . $t->disciplinas->first()->tb_disciplinas_idDisciplinas . '/' . $bimestreAtual . 'bim') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#008a4b] hover:text-[#00703c] transition-colors">
                                        <i data-lucide="clipboard-pen" class="w-3.5 h-3.5"></i>
                                        <span>Lançar por Turma</span>
                                    </a>
                                @else
                                    <a href="{{ url('/docente/notas_filtro?idTurmas=' . $t->idTurmas) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#008a4b] hover:text-[#00703c] transition-colors">
                                        <i data-lucide="clipboard-pen" class="w-3.5 h-3.5"></i>
                                        <span>Lançar Notas</span>
                                    </a>
                                @endif
                                <div class="flex items-center gap-2">
                                    <a href="{{ url('/docente/mapa_' . $bimestreAtual . 'bim/' . $t->idTurmas) }}" target="_blank" class="text-xs text-[#5c706b] hover:text-[#0a241e] font-medium flex items-center gap-1 transition-colors" title="Mapa {{ $bimestreAtual }}º Bimestre">
                                        <i data-lucide="map" class="w-3.5 h-3.5"></i>
                                        <span>Mapa</span>
                                    </a>
                                    <span class="text-[#e3e8e6]">|</span>
                                    <a href="{{ url('/docente/relatorio_alunos_por_turma/' . $t->idTurmas) }}" class="text-xs text-[#5c706b] hover:text-[#0a241e] font-medium flex items-center gap-1 transition-colors" title="Lista de Alunos">
                                        <i data-lucide="list" class="w-3.5 h-3.5"></i>
                                        <span>Alunos</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Coluna Lateral (1/3): Notas Pendentes e Aniversariantes -->
            <div class="flex flex-col gap-6">

                <!-- Card: Notas Pendentes -->
                <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-[#008a4b] flex items-center justify-center">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                            </div>
                            <h3 class="text-base font-bold text-[#0a241e]">Notas Pendentes</h3>
                        </div>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-[#f8faf9] text-[#5c706b] border border-[#e3e8e6]">
                            {{ $bimestreAtual }}º Bimestre
                        </span>
                    </div>

                    @if(empty($notasPendentes))
                        <div class="p-4 rounded-xl bg-emerald-50/60 border border-emerald-100 flex items-start gap-3">
                            <i data-lucide="check-circle" class="w-5 h-5 text-[#008a4b] shrink-0 mt-0.5"></i>
                            <div>
                                <h4 class="text-xs font-bold text-[#087443]">Tudo em dia!</h4>
                                <p class="text-xs text-[#0a5c3a] mt-0.5">Todas as notas do {{ $bimestreAtual }}º bimestre estão devidamente lançadas em suas turmas.</p>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col divide-y divide-[#f0f4f2]">
                            @foreach($notasPendentes as $pend)
                                <div class="py-3 first:pt-0 last:pb-0 flex items-center justify-between gap-3">
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-xs font-bold text-[#0a241e] truncate">{{ $pend->nomeTurma }}</span>
                                        <span class="text-[11px] text-[#5c706b] truncate">{{ $pend->nomeDisciplina }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <span class="text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                            {{ $pend->pendentes }} {{ $pend->pendentes === 1 ? 'pendente' : 'pendentes' }}
                                        </span>
                                        <a href="{{ url('/docente/lancar_turma/' . $pend->idTurma . '/' . $pend->idDisciplina . '/' . $bimestreAtual . 'bim') }}" class="text-[#008a4b] hover:text-[#00703c] p-1" title="Lançar notas agora">
                                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Card: Aniversariantes do Mes -->
                <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center">
                                <i data-lucide="cake" class="w-4 h-4"></i>
                            </div>
                            <h3 class="text-base font-bold text-[#0a241e]">Aniversariantes</h3>
                        </div>
                        <span class="text-xs font-semibold text-[#5c706b]">Mês atual</span>
                    </div>

                    @if(empty($aniversariantesDoMes))
                        <p class="text-xs text-[#5c706b] italic py-2">Nenhum aniversariante registrado neste mês em suas turmas.</p>
                    @else
                        <div class="flex flex-col divide-y divide-[#f0f4f2] max-h-72 overflow-y-auto custom-scroll pr-1">
                            @foreach($aniversariantesDoMes as $aniver)
                                <div class="py-2.5 first:pt-0 last:pb-0 flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-7 h-7 rounded-full bg-pink-50 text-pink-700 font-bold text-[11px] flex items-center justify-center shrink-0">
                                            {{ $aniver->dia }}
                                        </div>
                                        <div class="flex flex-col min-w-0">
                                            <span class="text-xs font-semibold text-[#0a241e] truncate">{{ $aniver->nome }}</span>
                                            <span class="text-[11px] text-[#5c706b] truncate">{{ $aniver->turma }}</span>
                                        </div>
                                    </div>
                                    <span class="text-[11px] text-[#5c706b] shrink-0 font-medium">Dia {{ sprintf('%02d', $aniver->dia) }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Card: Atalhos Rapidos -->
                <div class="bg-white border border-[#e3e8e6] rounded-2xl p-6 shadow-2xs flex flex-col gap-3">
                    <h3 class="text-sm font-bold text-[#0a241e]">Acesso Rápido</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ url('/docente/relatorios') }}" class="p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b] hover:bg-[#f8faf9] transition-all flex flex-col items-center text-center gap-1 group">
                            <i data-lucide="file-text" class="w-5 h-5 text-[#5c706b] group-hover:text-[#008a4b] transition-colors"></i>
                            <span class="text-xs font-semibold text-[#0a241e]">Relatórios</span>
                        </a>
                        <a href="{{ url('/docente/resultados') }}" class="p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b] hover:bg-[#f8faf9] transition-all flex flex-col items-center text-center gap-1 group">
                            <i data-lucide="award" class="w-5 h-5 text-[#5c706b] group-hover:text-[#008a4b] transition-colors"></i>
                            <span class="text-xs font-semibold text-[#0a241e]">Resultados</span>
                        </a>
                        <a href="{{ url('/docente/declaracoes') }}" class="p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b] hover:bg-[#f8faf9] transition-all flex flex-col items-center text-center gap-1 group">
                            <i data-lucide="file-check" class="w-5 h-5 text-[#5c706b] group-hover:text-[#008a4b] transition-colors"></i>
                            <span class="text-xs font-semibold text-[#0a241e]">Declaração</span>
                        </a>
                        <a href="{{ url('/docente/funcionario_perfil') }}" class="p-3 rounded-xl border border-[#e3e8e6] hover:border-[#008a4b] hover:bg-[#f8faf9] transition-all flex flex-col items-center text-center gap-1 group">
                            <i data-lucide="user" class="w-5 h-5 text-[#5c706b] group-hover:text-[#008a4b] transition-colors"></i>
                            <span class="text-xs font-semibold text-[#0a241e]">Meu Perfil</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    @endif

</div>
@endsection