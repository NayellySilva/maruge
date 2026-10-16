@extends('layouts.app')  
@section('content')
<div class="titulo-endereco">
    <a href="#">
    Relatórios / Gabarito
    </a>
</div>
<div class="col-md-5">
    <div class="form-group">
        <label for="Localizar Turma">Localizar Turma:</label>
        <form class="form-search pesquisar" method="post" action="/coordenacao/gabarito_pesq">
            {!! csrf_field() !!}
            <input type="texto" name="pesquisar" placeholder="Pesquisar Turma"  class="form-control">
            <button class="btn-pesquisar"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<div class="col-md-3">
    <div class="form-group">
        <label for="Filtrar Turma">Filtrar por Situação:</label>
        <form class="form-search pesquisar"method="post" action="/coordenacao/gabarito_filtro">
            {!! csrf_field() !!}
            <div class="relative" id="dropdown-container-sit-gabaritos-pesq">
                <input type="hidden" id="SituacaoTurma" name="SituacaoTurma" value="{{ request()->input('SituacaoTurma', '') }}">

                @php
                    $valSitGabPesq = request()->input('SituacaoTurma', '');
                    $sitGabPesqLabel = $valSitGabPesq ? ucfirst(strtolower($valSitGabPesq)) : 'Filtrar por Situação';
                @endphp

                <!-- Trigger Box -->
                <div onclick="toggleMultiDropdown('dropdown-menu-sit-gabaritos-pesq', 'chevron-sit-gabaritos-pesq')" 
                     class="w-full flex items-center justify-between bg-white border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                    <span id="label-sit-gabaritos-pesq" class="text-sm font-medium truncate {{ $valSitGabPesq ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                        {{ $sitGabPesqLabel }}
                    </span>
                    <div id="chevron-sit-gabaritos-pesq" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Dropdown Flutuante -->
                <div id="dropdown-menu-sit-gabaritos-pesq" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-1.5 flex flex-col gap-0.5">
                    <div onclick="selectSingleOption('', 'Todos', 'SituacaoTurma', 'label-sit-gabaritos-pesq', 'dropdown-menu-sit-gabaritos-pesq', 'chevron-sit-gabaritos-pesq', true)"
                         class="option-sit-gabaritos-pesq flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">Todos</span>
                    </div>
                    <div onclick="selectSingleOption('ATIVO', 'Ativo', 'SituacaoTurma', 'label-sit-gabaritos-pesq', 'dropdown-menu-sit-gabaritos-pesq', 'chevron-sit-gabaritos-pesq', true)"
                         class="option-sit-gabaritos-pesq flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">Ativo</span>
                    </div>
                    <div onclick="selectSingleOption('INATIVO', 'Inativo', 'SituacaoTurma', 'label-sit-gabaritos-pesq', 'dropdown-menu-sit-gabaritos-pesq', 'chevron-sit-gabaritos-pesq', true)"
                         class="option-sit-gabaritos-pesq flex items-center p-2.5 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                        <span class="option-title font-medium">Inativo</span>
                    </div>
                </div>
            </div>


            <button class="btn-filtro" type="submit" > <i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
    </div>
</div>

<div class="col-md-4">
    <div class="quant-alunos">                           
        <h2 class="quant-alunos">Turmas Cadastradas:  ({{$turmas->total()}})</h2>

    </div> 
</div>





<div class="caminho-din">

    <table class="table table-hover">
<thead>
        <tr>
        <th>CÓD</th>
        <th>NOME TURMA</th>
        <th><center>08 Questões</center></th>
        <th><center>10 Questões</center></th>
        <th><center>10 + 1 Bônus</center></th>
              
        </tr>
    </thead>  
        <!-- Recebendo valores na vareavel escolas e passando para escola-->

        @forelse($turmas as $turma ) 
        <center>
            <tr>
                <td>{{$turma->idTurmas}}</td>
                <td>{{$turma->NomeTurma}}</td>
                <td> <a href="{{url("/coordenacao/resultados_parcial/$turma->idTurmas")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="resultado parcial"</center></td>
                <td> <a href="{{url("/coordenacao/resultados_final/$turma->idTurmas")}}"><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="resultado final"</center></td>
                <td> <a href="{{url("/coordenacao/resultados_aprovados_1semestre/$turma->idTurmas")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="aprovados 1 semestre"</center></td>
                <td> <a href="{{url("/coordenacao/resultados_aprovados_2semestre/$turma->idTurmas")}}" ><center> <img src="{{url('imgs/icones/imprimir.png')}}" alt="aprovados 2 semestre"</center></td>
  
                    </tr>
                                        
                                        
                                        
                                        
                                        
                                        
                                        @empty
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <strong>Desculpe ! </strong> Nenhuma turma cadastrada, para cadastras<a href="/coordenacao/turma_cad" class="alert-link"> Clique aqui.</a>
                                        </div>
                                        <tr>
                                            <td colspan="500"> Nenhuma turma cadastrada !</td>
                                        </tr>
                                        @endforelse
                                        </table> 
                                        <div>{!! $turmas->render()!!} </div>



                                        </div>
                                        </div> <!--Fim do caminho-din-->
                                        @endsection