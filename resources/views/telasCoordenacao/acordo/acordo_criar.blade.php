@extends('layouts.app')
@section('content')

<div class="flex flex-col gap-6">

    <!-- Localização (Breadcrumb) -->
    <div class="text-sm text-[#5c706b]">
        <a href="{{ url('/coordenacao') }}" class="hover:text-[#008a4b] transition-colors">Secretaria</a>
        <span class="mx-2">/</span>
        <a href="{{ url('/coordenacao/acordo_cad') }}" class="hover:text-[#008a4b] transition-colors">Acordos Financeiros</a>
        <span class="mx-2">/</span>
        <span class="font-semibold text-[#0a241e]">Novo Acordo</span>
    </div>

    <!-- Cabeçalho Principal -->
    <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-[#0a241e]">{{ $titulo ?? 'Novo Acordo Financeiro' }}</h1>
            <p class="text-sm text-[#5c706b]">Preencha os dados abaixo para gerar o acordo</p>
        </div>
    </div>

    <!-- Erros de Validação -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl px-5 py-4 text-sm text-red-700">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário de Acordo -->
    <form class="flex flex-col gap-6" action="/coordenacao/criaracordo" method="POST">
        @csrf

        <!-- Campos ocultos -->
        <input type="hidden" name="Acordo"    value="S">
        <input type="hidden" name="Carteira"  value="2">
        <input type="hidden" name="idAluno"   value="{{ $aluno->idAluno ?? '' }}">
        <input type="hidden" name="NomeAluno" value="{{ $aluno->NomeAluno ?? '' }}">
        <input type="hidden" name="NomeTurma" value="{{ $turma->NomeTurma ?? '' }}">
        <input type="hidden" name="RA"        value="{{ $matricula->RA ?? '' }}">
        <input type="hidden" name="Ano Letivo" value="{{ $turma->AnoLetivo ?? '' }}">
        <input type="hidden" name="idTurma"   value="{{ $turma->idTurmas ?? '' }}">

        <!-- Card: Dados do Aluno -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl shadow-2xs overflow-hidden">
            <div class="px-6 py-4 border-b border-[#e3e8e6] bg-[#f8faf9] flex items-center gap-2">
                <i data-lucide="user" class="w-4 h-4 text-[#008a4b]"></i>
                <span class="text-sm font-semibold text-[#0a241e]">Dados do Aluno</span>
            </div>
            <div class="px-6 py-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Nome do Aluno -->
                <div class="lg:col-span-2 flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Nome do Aluno</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] font-medium">
                        {{ $aluno->NomeAluno ?? '-' }}
                    </div>
                </div>
                <!-- RA -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">RA</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] font-medium">
                        {{ $matricula->RA ?? '-' }}
                    </div>
                </div>
                <!-- Turma -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Turma</label>
                    <div class="flex items-center bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] font-medium">
                        {{ $turma->NomeTurma ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Card: Dados do Acordo -->
        <div class="bg-white border border-[#e3e8e6] rounded-2xl shadow-2xs overflow-hidden">
            <div class="px-6 py-4 border-b border-[#e3e8e6] bg-[#f8faf9] flex items-center gap-2">
                <i data-lucide="file-signature" class="w-4 h-4 text-[#008a4b]"></i>
                <span class="text-sm font-semibold text-[#0a241e]">Dados do Acordo</span>
            </div>
            <div class="px-6 py-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <!-- Melhor dia de Pagamento -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Melhor Dia de Pagamento</label>
                    <div class="relative" id="dropdown-container-datavenc">
                        <input type="hidden" id="Data_venc" name="Data_venc" value="{{ old('Data_venc', $aluno->Data_venc ?? '') }}">
                        @php $valVenc = old('Data_venc', $aluno->Data_venc ?? ''); @endphp
                        <div onclick="toggleMultiDropdown('dropdown-menu-datavenc', 'chevron-datavenc')"
                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer h-11">
                            <span id="label-datavenc" class="text-sm font-medium truncate {{ $valVenc ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                {{ $valVenc ? str_pad($valVenc, 2, '0', STR_PAD_LEFT) : 'Selecione...' }}
                            </span>
                            <div id="chevron-datavenc" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                        <div id="dropdown-menu-datavenc" class="dropdown-menu-flutuante hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden">
                            <div class="dropdown-lista-opcoes custom-scroll flex flex-col gap-0.5 pr-1">
                                @for($d = 1; $d <= 31; $d++)
                                    @php $dayFormatted = str_pad($d, 2, '0', STR_PAD_LEFT); @endphp
                                    <div onclick="selectSingleOption('{{ $dayFormatted }}', '{{ $dayFormatted }}', 'Data_venc', 'label-datavenc', 'dropdown-menu-datavenc', 'chevron-datavenc', false)"
                                         class="option-datavenc flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                        <span class="option-title font-medium">{{ $dayFormatted }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quantidade de Parcelas -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Qtd. Parcelas</label>
                    <div class="relative" id="dropdown-container-parcelas">
                        <input type="hidden" id="quantidade_parcelas" name="quantidade_parcelas" value="{{ old('quantidade_parcelas', $aluno->quantidade_parcelas ?? '') }}">
                        @php $valParc = old('quantidade_parcelas', $aluno->quantidade_parcelas ?? ''); @endphp
                        <div onclick="toggleMultiDropdown('dropdown-menu-parcelas', 'chevron-parcelas')"
                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer h-11">
                            <span id="label-parcelas" class="text-sm font-medium truncate {{ $valParc ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                {{ $valParc ?: 'Selecione...' }}
                            </span>
                            <div id="chevron-parcelas" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                            </div>
                        </div>
                        <div id="dropdown-menu-parcelas" class="dropdown-menu-flutuante hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden">
                            <div class="dropdown-lista-opcoes custom-scroll flex flex-col gap-0.5 pr-1">
                                @foreach([1,2,3,4,5,6,7,8,9,10,11,12,92] as $pNum)
                                    <div onclick="selectSingleOption('{{ $pNum }}', '{{ $pNum }}', 'quantidade_parcelas', 'label-parcelas', 'dropdown-menu-parcelas', 'chevron-parcelas', false)"
                                         class="option-parcelas flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                        <span class="option-title font-medium">{{ $pNum }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valor do Acordo -->
                <div class="flex flex-col gap-1.5">
                    <label for="valor_Acordo" class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Valor Total do Acordo</label>
                    <input type="text" id="valor_Acordo" name="valor_Acordo" placeholder="R$ 0,00"
                           value="{{ old('valor_Acordo') }}"
                           class="bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] transition-all h-11">
                </div>

                <!-- Valor das Prestações -->
                <div class="flex flex-col gap-1.5">
                    <label for="valor_prestacao" class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Valor das Prestações</label>
                    <input type="text" id="valor_prestacao" name="valor_prestacao" placeholder="R$ 0,00"
                           value="{{ old('valor_prestacao') }}"
                           class="bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-2.5 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] transition-all h-11">
                </div>
            </div>

            <!-- Detalhes do Acordo -->
            <div class="px-6 pb-6 flex flex-col gap-1.5">
                <label for="obs_do_acordo" class="text-xs font-semibold text-[#5c706b] uppercase tracking-wider">Detalhes sobre o Acordo</label>
                <textarea id="obs_do_acordo" name="obs_do_acordo" rows="5" maxlength="30000"
                          placeholder="Descreva todas as informações sobre o acordo, condições, motivações e observações relevantes..."
                          class="bg-[#f8faf9] border border-[#e3e8e6] rounded-xl px-4 py-3 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] transition-all resize-none">{{ old('obs_do_acordo') }}</textarea>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex gap-3 justify-end">
            <a href="{{ url('/coordenacao/acordo_cad') }}"
               class="px-5 py-2.5 rounded-full border border-[#e3e8e6] text-sm font-medium text-[#5c706b] hover:bg-[#f8faf9] transition-all">
                Cancelar
            </a>
            <button type="submit"
                    class="bg-[#008a4b] hover:bg-[#00703c] text-white font-medium px-6 py-2.5 rounded-full flex items-center gap-2 transition-all shadow-2xs text-sm">
                <i data-lucide="file-check" class="w-4 h-4"></i> Gerar Acordo
            </button>
        </div>

    </form>

</div>


<script>
    function toggleMultiDropdown(menuId, chevronId) {
        const menu = document.getElementById(menuId);
        const chevron = document.getElementById(chevronId);
        const isHidden = menu.classList.contains('hidden');

        document.querySelectorAll('[id^="dropdown-menu-"]').forEach(m => m.classList.add('hidden'));
        document.querySelectorAll('[id^="chevron-"]').forEach(c => c.classList.remove('rotate-180'));

        if (isHidden) {
            menu.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        }
    }

    function selectSingleOption(id, name, hiddenInputId, labelId, menuId, chevronId, isPlaceholder) {
        document.getElementById(hiddenInputId).value = id;
        const labelEl = document.getElementById(labelId);
        labelEl.textContent = name;

        if (id === '' || isPlaceholder) {
            labelEl.classList.add('text-[#95aba5]');
            labelEl.classList.remove('text-[#0a241e]', 'font-medium');
        } else {
            labelEl.classList.remove('text-[#95aba5]');
            labelEl.classList.add('text-[#0a241e]', 'font-medium');
        }

        document.getElementById(menuId).classList.add('hidden');
        document.getElementById(chevronId).classList.remove('rotate-180');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#dropdown-container-datavenc') &&
            !e.target.closest('#dropdown-container-parcelas')) {
            document.querySelectorAll('[id^="dropdown-menu-"]').forEach(m => m.classList.add('hidden'));
            document.querySelectorAll('[id^="chevron-"]').forEach(c => c.classList.remove('rotate-180'));
        }
    });
</script>

@endsection