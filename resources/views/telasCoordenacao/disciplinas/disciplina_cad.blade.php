@extends('layouts.app')

@section('content')
@php
    // Garante que a variável esteja definida para evitar erros em PHP 8.x
    $disciplina = $disciplina ?? null;

    // Tenta carregar as turmas do banco de dados de forma resiliente
    try {
        $turmasList = \DB::table('tb_turmas')->orderBy('NomeTurma')->get();
    } catch (\Exception $e) {
        $turmasList = collect();
    }
@endphp

<div class="flex flex-col gap-6 w-full">
    <!-- Localização (Breadcrumb de fundo) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao/disciplinas/disciplina_inf') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/disciplinas/disciplina_inf') }}" class="hover:text-[#008a4b] transition-colors">Disciplinas</a>
        <span class="mx-2">/</span>
        <span class="text-[#0a241e] font-medium">{{ isset($disciplina) ? 'Editar Disciplina' : 'Nova Disciplina' }}</span>
    </div>

    <!-- Título de Fundo -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">Disciplinas</h1>
            <p class="text-sm text-[#5c706b]">Gerenciamento de disciplinas do sistema</p>
        </div>
    </div>

    <!-- Modal Overlay -->
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <!-- Backdrop com desfoque (blur) sutil para destacar o modal -->
        <a href="{{ url('/coordenacao/disciplinas/disciplina_inf') }}" class="fixed inset-0 bg-black/20 backdrop-blur-sm transition-opacity cursor-default"></a>
        
        <!-- Conteúdo do Modal (Card nítido e destacado) -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all z-10 border border-[#e3e8e6]">
            <!-- Cabeçalho do Modal -->
            <div class="px-6 py-4 border-b border-[#e3e8e6] flex justify-between items-center bg-[#f8faf9]">
                <h3 class="text-lg font-semibold text-[#0a241e]">
                    {{ isset($disciplina) ? 'Editar Disciplina' : 'Nova Disciplina' }}
                </h3>
                <a href="{{ url('/coordenacao/disciplinas/disciplina_inf') }}" class="text-[#5c706b] hover:text-[#0a241e] transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </a>
            </div>

            <!-- Corpo do Modal / Formulário -->
            @if(isset($disciplina))
                <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/disciplina_editar/{{$disciplina->idDisciplinas}}" method="POST">
            @else
                <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/disciplina_cad" method="POST" send="/maruge/public/coordenacao/disciplina_cad">
            @endif
                {!! csrf_field() !!}
                
                <div class="px-6 py-6 flex flex-col gap-4">
                    <!-- Alertas e Preloader (Manipulados via Ajax no painel.blade.php) -->
                    <div class="preloader bg-emerald-50 text-emerald-700 text-sm p-3 rounded-xl border border-emerald-100 text-center font-medium animate-pulse" style="display: none">
                        Enviando os dados...
                    </div>  
                    <div class="alert alert-success msg-exito bg-emerald-50 text-emerald-700 text-sm p-3 rounded-xl border border-emerald-100 text-center font-medium" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro bg-red-50 text-red-700 text-sm p-3 rounded-xl border border-red-100 text-center font-medium" role="alert" style="display: none"></div> 

                    @if(count($errors) > 0)
                        <div class="bg-red-50 text-red-600 text-sm p-3 rounded-xl border border-red-100">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Campo Nome da Disciplina -->
                    <div class="flex flex-col gap-1.5">
                        <label for="NomeDisciplina" class="text-sm font-medium text-[#0a241e]">Nome de disciplina:</label>
                        <input type="text" id="NomeDisciplina" name="NomeDisciplina" placeholder="Digite o nome da disciplina" 
                               class="w-full bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] placeholder-[#95aba5] focus:outline-none focus:border-[#008a4b] transition-all" 
                               value="{{ $disciplina ? ($disciplina->NomeDisciplina ?? old('NomeDisciplina')) : old('NomeDisciplina') }}" required>
                    </div>

                    <!-- Acordeão para Vincular Turmas -->
                    <details class="group bg-[#f8faf9] border border-[#e3e8e6] rounded-xl overflow-hidden">
                        <summary class="flex justify-between items-center px-4 py-3.5 font-medium text-sm text-[#0a241e] cursor-pointer select-none list-none [&::-webkit-details-marker]:hidden">
                            <span>Vincular a Turmas (Opcional)</span>
                            <div class="text-[#5c706b] transition-transform duration-200 group-open:rotate-180">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </summary>
                        <div class="px-4 pb-4 pt-2 border-t border-[#e3e8e6] bg-white">
                            <!-- Checkboxes de Turmas -->
                            <div class="grid grid-cols-2 gap-2 max-h-40 overflow-y-auto pr-1">
                                @foreach($turmasList as $turmaItem)
                                    <label class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-[#f8faf9] transition-all cursor-pointer border border-[#e3e8e6]/50 hover:border-[#e3e8e6]">
                                        <input type="checkbox" name="turmas[]" value="{{ $turmaItem->idTurmas }}" 
                                               class="w-4 h-4 text-[#008a4b] border-[#e3e8e6] rounded-sm focus:ring-[#008a4b] focus:ring-2">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-semibold text-[#0a241e]">{{ $turmaItem->NomeTurma }}</span>
                                            <span class="text-[10px] text-[#5c706b]">Ano: {{ $turmaItem->AnoLetivo }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </details>
                </div>

                <!-- Rodapé do Modal / Botões -->
                <div class="px-6 py-4 bg-[#f8faf9] border-t border-[#e3e8e6] flex justify-end gap-3">
                    <a href="{{ url('/coordenacao/disciplinas/disciplina_inf') }}" 
                       class="inline-flex items-center justify-center border border-[#e3e8e6] text-[#5c706b] hover:bg-[#f8faf9] font-medium px-5 py-2.5 rounded-full text-sm transition-all cursor-pointer">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full text-sm transition-all shadow-sm cursor-pointer">
                        {{ isset($disciplina) ? 'Atualizar' : 'Salvar' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
