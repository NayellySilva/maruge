@extends('layouts.app')
@section('content')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo}}</h1>
</div> 
<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-advertencia" role="alert" style="display: none"></div> 
    <div class="alert alert-danger msg-erro" role="alert" style="display: none"></div> 
    <div class="formularios">    
        @if((isset($errors) ? count($errors) : 0)>0)
        @foreach($errors->all() as $error)
        {{$error}}
        @endforeach
        @endif
            <form class="form form-search form-Nu formularios" action="/coordenacao/criaracordo" method="POST" send="/coordenacao/criaracordo">
         <div class="cadForm" > </div>
                        <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (NOME DO ALUNO, SEXO, DATANASCIMENTO, MAC, SITUAÇÃO )-->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="NomeAluno">Nome do Aluno:</label>
                                    <input type="hidden" name="Acordo"  class="form-control" value="S">
                                    <input type="hidden" name="Carteira"  class="form-control" value="2">
                                    <input type="hidden" name="idAluno"  class="form-control" value="{{ $aluno->idAluno ?? old('NomeAluno') }}">
                                    <input type="hidden" name="NomeAluno" placeholder="Nome do Aluno"  class="form-control" value="{{ $aluno->NomeAluno ?? old('NomeAluno') }}">
                                    <input disabled="disabled" name="NomeAluno" placeholder="Nome do Aluno"  class="form-control" value="{{ $aluno->NomeAluno ?? old('NomeAluno') }}">
                                </div>
                            </div>
                            <div class="col-md-2">       
                                <div class="form-group">
                                <label for="NomeTurma">Turma:</label>
                                <input type="hidden" name="NomeTurma" class="form-control" value="{{$turma->NomeTurma}}">
                                <input disabled="disabled" name="NomeTurma" class="form-control" value="{{$turma->NomeTurma}}">
                                   </div>
                            </div>                                          <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Data_venc" class="text-sm font-medium text-[#0a241e]">Melhor dia de Pagamento:</label>
                                    <div class="relative" id="dropdown-container-datavenc">
                                        <input type="hidden" id="Data_venc" name="Data_venc" value="{{ old('Data_venc', $aluno->Data_venc ?? '') }}">
                                        @php
                                            $valVenc = old('Data_venc', $aluno->Data_venc ?? '');
                                        @endphp
                                        <div onclick="toggleMultiDropdown('dropdown-menu-datavenc', 'chevron-datavenc')" 
                                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                                            <span id="label-datavenc" class="text-sm font-medium truncate {{ $valVenc ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                                {{ $valVenc ? str_pad($valVenc, 2, '0', STR_PAD_LEFT) : 'Dia...' }}
                                            </span>
                                            <div id="chevron-datavenc" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                            </div>
                                        </div>
                                        <div id="dropdown-menu-datavenc" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                                            <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                                <div onclick="selectSingleOption('', 'Dia...', 'Data_venc', 'label-datavenc', 'dropdown-menu-datavenc', 'chevron-datavenc', false)"
                                                     class="option-datavenc flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                                    <span class="option-title font-medium text-[#95aba5]">Selecione...</span>
                                                </div>
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
                            </div>v>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="valor_prestacao">Valor do Acordo:</label>
                                   <input type="text" name="valor_Acordo" placeholder="R$ 0,00"  class="form-control">

                                 <!--   <input name="Mensalidade"  class="form-control" value="{{ substr ($turma->Mensalidade ,0,3)}}"> -->
                                </div>
                            </div>
                            <!--FECHANDO A PRIMEIRA LINHA-->
                        </div>
                        <!--SEGUNDA LINHA REFERENTE AOS CAMPOS (TURMA-ALUNO-REGISTRO-PASTA-FOTO)-->
                        <div class="row">
                            <div class="col-md-2">       
                                <div class="form-group">
                                    <label for="RA">RA:</label>
                                    <input type="hidden" name="RA"   class="form-control" value="{{ $matricula->RA ?? old('RA') }}">
                                    <input disabled="disabled" name="RA"  class="form-control" value="{{ $matricula->RA ?? old('RA') }}">
                                </div>
                            </div> 
                            <div class="col-md-2">       
                                <div class="form-group">
                                <label for="AnoLetivo">Ano Letivo:</label>
                                 <input type="hidden" name="Ano Letivo"  class="form-control" value="{{$turma->AnoLetivo}}">
                                 <input disabled="disabled" name="Ano Letivo"  class="form-control" value="{{$turma->AnoLetivo}}">
                                </div>
                            </div>
                           <div class="col-md-2">       
                                <div class="form-group">
                                <label for="idTurma">Turma:</label>
                                <input type="hidden" name="idTurma"  class="form-control" value="{{$turma->idTurmas}}">
                                <input disabled="disabled" name="idTurma"  class="form-control" value="{{$turma->idTurmas}}">
                                </div>
                            </div> 
                          
                                           
                            
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="valor_prestacao">Valor das prestações:</label>
                                   <input type="text" name="valor_prestacao" placeholder="R$ 0,00"  class="form-control">

                                 <!--   <input name="Mensalidade"  class="form-control" value="{{ substr ($turma->Mensalidade ,0,3)}}"> -->
                                </div>
                            </div>
                                                     <div class="col-md-2">
                                <div class="form-group">
                                    <label for="quantidade_parcelas" class="text-sm font-medium text-[#0a241e]">Quant. Parcelas:</label>
                                    <div class="relative" id="dropdown-container-parcelas">
                                        <input type="hidden" id="quantidade_parcelas" name="quantidade_parcelas" value="{{ old('quantidade_parcelas', $aluno->quantidade_parcelas ?? '') }}">
                                        @php
                                            $valParc = old('quantidade_parcelas', $aluno->quantidade_parcelas ?? '');
                                        @endphp
                                        <div onclick="toggleMultiDropdown('dropdown-menu-parcelas', 'chevron-parcelas')" 
                                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                                            <span id="label-parcelas" class="text-sm font-medium truncate {{ $valParc ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                                {{ $valParc ?: 'Parcelas...' }}
                                            </span>
                                            <div id="chevron-parcelas" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                            </div>
                                        </div>
                                        <div id="dropdown-menu-parcelas" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                                            <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                                <div onclick="selectSingleOption('', 'Parcelas...', 'quantidade_parcelas', 'label-parcelas', 'dropdown-menu-parcelas', 'chevron-parcelas', false)"
                                                     class="option-parcelas flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                                    <span class="option-title font-medium text-[#95aba5]">Selecione...</span>
                                                </div>
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
                            </div>div>
                            
                            
  
                            
                            <!--FECHANDO A SEGUNDA LINHA-->                        
                        </div>
                        <!--TERCEIRA LINHA REFERENTE AOS CAMPOS (NOME D OCARTORIO NUMERO LIVRO REISTRO)-->
                        <div class="row">
                            
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="obs_do_acordo" >Detalhes sobre o acordo:</label>
                                    <textarea  class="form-control ajuste" placeholder="Todas as informações sobre o acordo devem ser descritos neste campo." rows="10" type="text" name="obs_do_acordo" maxlength="30000"></textarea>

                                </div>
                            </div>
                            
                            
                        </div>
  
      
                  <!--Quarta Linha)-->
                  <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <br>
                                    <button type="submit" class="btn btn-success"> GERAR ACORDO</button>
                                </div>
                            </div>  
                                          <!--FECHANDO A quarta LINHA-->
                        </div> 
                    
                                    <!--fim botão que gerar carnêr Linha-->  
                        <!--*****************************************************************************
                        *********************************************************************************
                        FIM FORMULARIO DA GUIA NOVO CARNÊ
                        *********************************************************************************
                        *********************************************************************************
                        -->
</div>
                            <!--FECHANDO A QUINTA LINHA-->
                    
                        <!--*****************************************************************************
                        *********************************************************************************
                        FIM FORMULARIO DA GUIA DADOS DOS PAIS
                        *********************************************************************************
                        *********************************************************************************
                        -->
                  {!! csrf_field() !!}
            </form> <!--Fim do formulario-->
  
</div> <!--Fim do caminho-din-->
@endsection