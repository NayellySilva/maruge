@extends('layouts.app')  
@section('content')
<div class="titulo-endereco">
    <a href="#">
    Secretaria / Lançar Notas 
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="SituacaoAluno">Localizar aluno:</label>
        <form class="form-search pesquisar" method="post" action="/coordenacao/notas_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Aluno"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
<div class="col-md-3">
    <div class="form-group">
        <label for="NomeTurma">Filtrar por turma:</label>
        <form class="form-search pesquisar" method="post" action="/coordenacao/notas_filtro">
            {!! csrf_field() !!}
            <div class="relative" id="dropdown-container-turma-notas-pesq">
                <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">

                @php
                    $selectedTurmaNotasPesq = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                @endphp

                <!-- Trigger Box -->
                <div onclick="toggleMultiDropdown('dropdown-menu-turma-notas-pesq', 'chevron-turma-notas-pesq')" 
                     class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-turma-notas-pesq" class="text-sm font-medium truncate {{ $selectedTurmaNotasPesq ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $selectedTurmaNotasPesq ? $selectedTurmaNotasPesq->NomeTurma : 'Filtrar por turma' }}
                    </span>
                    <div id="chevron-turma-notas-pesq" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Dropdown Flutuante -->
                <div id="dropdown-menu-turma-notas-pesq" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                    <!-- Campo de Busca -->
                    <div class="relative shrink-0">
                        <input type="text" onkeyup="filterDropdownOptions('search-turma-notas-pesq', 'option-turma-notas-pesq')" id="search-turma-notas-pesq" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                        <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>

                    <!-- Lista de Opções com Rolagem -->
                    <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                        <div onclick="selectSingleOption('', 'Todas as Turmas', 'idTurmas', 'label-turma-notas-pesq', 'dropdown-menu-turma-notas-pesq', 'chevron-turma-notas-pesq', true)"
                             class="option-turma-notas-pesq flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                            <span class="option-title font-medium">Todas as Turmas</span>
                        </div>
                        @foreach($turmas as $turma)
                            <div onclick="selectSingleOption('{{ $turma->idTurmas }}', '{{ $turma->NomeTurma }}', 'idTurmas', 'label-turma-notas-pesq', 'dropdown-menu-turma-notas-pesq', 'chevron-turma-notas-pesq', true)"
                                 class="option-turma-notas-pesq flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                <span class="option-title font-medium">{{ $turma->NomeTurma }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button class="btn-filtro" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-4">
    <div class="quant-alunos">
        <h2 class="quant-alunos">Alunos Cadastrados: ({{$Alunos->count()}})</h2>
    </div> 
</div>
<div class="caminho-din">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>NOME DO ALUNO</th>
                <th>RA</th>
                <th><center>TURMA</center></th>
        <th><center>1º BIM.</center></th>
        <th><center>2º BIM.</center></th>
        <th><center>3º BIM.</center></th>
        <th><center>4º BIM.</center></th>
        <th><center>REC.</center></th>
        </tr>
        </thead>   
        <!-- Recebendo valores na vareavel escolas e passando para escola-->
        @forelse($Alunos as $Aluno)  
        <center>
            <tr>
                <td>{{$Aluno->NomeAluno}}</td>
                <td>{{$Aluno->RA}}</td>
                <td><center>{{$Aluno->NomeTurma}}</td>             
                <td> <a href="{{url("/coordenacao/lancamentos_notas_1bim/$Aluno->idAluno")}}"target="_blank" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="1º Bimestre"</center></td>
                <td> <a href="{{url("/coordenacao/lancamentos_notas_2bim/$Aluno->idAluno")}}" target="_blank" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="2º Bimestre"</center></td>
                <td> <a href="{{url("/coordenacao/lancamentos_notas_3bim/$Aluno->idAluno")}}" target="_blank"><center> <img src="{{url('imgs/icones/editar.png')}}" alt="3º Bimestre"</center></td>
                <td> <a href="{{url("/coordenacao/lancamentos_notas_4bim/$Aluno->idAluno")}}" target="_blank" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="4º Bimestre"</center></td>
                <td> <a href="{{url("/coordenacao/lancamentos_notas_rec/$Aluno->idAluno")}}" target="_blank" ><center> <img src="{{url('imgs/icones/editar.png')}}" alt="5º Bimestre"</center></td>

                </tr>         
                @empty
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Desculpe ! </strong> Mas nenhuma turma foi informada, por favor digite o nome do aluno ou selecione uma turma.
                </div>
                <tr>
                    <td colspan="500"> Nenhum alunos encontrado !</td>
                </tr>
                @endforelse
                </table> 


                </div>
                </div> <!--Fim do caminho-din-->
                @endsection