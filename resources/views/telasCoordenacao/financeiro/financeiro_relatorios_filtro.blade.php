@extends('layouts.app')
@section('content')
<div class="titulo-endereco">
    <a href="#"> Financeiro / Relatórios     </a>
</div>

<div class="caminho-din">
   <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                        <a 
                            <i class="fa fa-search" aria-hidden="true"></i> 
                            <button type="button" data-toggle="collapse" href="#filtro" class="btn btn-success"data-parent="#accordion" role="button"   aria-controls="collapseOne">
                            FILTRO POR TURMA / MÊS / SITUAÇÃO
                            </button> 
                        </a>
                    </a>
                </h4>
            </div>
            
             <!-- Filtros por turma / mes / situação -->
            
            <div id="filtro" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filtro">
                <div class="panel-body">
                    <div class="col-lg-7">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <strong>FILTRO POR TURMA / MÊS / SITUAÇÃO </strong>  
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <center> 
                                        <form  method="POST" action="/coordenacao/financeiro_pesq_relatorio">
                                            {!! csrf_field() !!}                      
                                          
                                                                                <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="turma" class="text-sm font-medium text-[#0a241e]">Turma:</label>
                                                    <div class="relative" id="dropdown-container-fin-turma">
                                                        <input type="hidden" id="idTurmas" name="idTurmas" value="{{ request()->input('idTurmas', '') }}">
                                                        @php
                                                            $selectedFinTurma = $turmas->firstWhere('idTurmas', request()->input('idTurmas'));
                                                        @endphp
                                                        <div onclick="toggleMultiDropdown('dropdown-menu-fin-turma', 'chevron-fin-turma')" 
                                                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                                                            <span id="label-fin-turma" class="text-sm font-medium truncate {{ $selectedFinTurma ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                                                {{ $selectedFinTurma ? $selectedFinTurma->NomeTurma : 'Selecione...' }}
                                                            </span>
                                                            <div id="chevron-fin-turma" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                                            </div>
                                                        </div>
                                                        <div id="dropdown-menu-fin-turma" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                                                            <div class="relative shrink-0">
                                                                <input type="text" onkeyup="filterDropdownOptions('search-fin-turma', 'option-fin-turma')" id="search-fin-turma" placeholder="Pesquisar..." class="w-full pl-3 pr-9 py-1.5 bg-[#f8faf9] border border-[#e3e8e6] rounded-lg text-xs focus:outline-none focus:border-[#008a4b]">
                                                                <i data-lucide="search" class="w-3.5 h-3.5 text-[#95aba5] absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                                            </div>
                                                            <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                                                <div onclick="selectSingleOption('', 'Selecione...', 'idTurmas', 'label-fin-turma', 'dropdown-menu-fin-turma', 'chevron-fin-turma', false)"
                                                                     class="option-fin-turma flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                                                    <span class="option-title font-medium text-[#95aba5]">Todas as Turmas</span>
                                                                </div>
                                                                @foreach($turmas as $turma)
                                                                    <div onclick="selectSingleOption('{{ $turma->idTurmas }}', '{{ $turma->NomeTurma }}', 'idTurmas', 'label-fin-turma', 'dropdown-menu-fin-turma', 'chevron-fin-turma', false)"
                                                                         class="option-fin-turma flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                                                        <span class="option-title font-medium">{{ $turma->NomeTurma }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                                   
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Mês" class="text-sm font-medium text-[#0a241e]">Mês:</label>
                                                    <div class="relative" id="dropdown-container-fin-mes">
                                                        <input type="hidden" id="Meses" name="Meses" value="{{ request()->input('Meses', '') }}">
                                                        @php
                                                            $valMes = request()->input('Meses', '');
                                                            $mesesArr = ['JANEIRO','FEVEREIRO','MARÇO','ABRIL','MAIO','JUNHO','JULHO','AGOSTO','SETEMBRO','OUTUBRO','NOVEMBRO','DEZEMBRO'];
                                                        @endphp
                                                        <div onclick="toggleMultiDropdown('dropdown-menu-fin-mes', 'chevron-fin-mes')" 
                                                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                                                            <span id="label-fin-mes" class="text-sm font-medium truncate {{ $valMes ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                                                {{ $valMes ?: 'Selecione o mês...' }}
                                                            </span>
                                                            <div id="chevron-fin-mes" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                                            </div>
                                                        </div>
                                                        <div id="dropdown-menu-fin-mes" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                                                            <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                                                <div onclick="selectSingleOption('', 'Selecione o mês...', 'Meses', 'label-fin-mes', 'dropdown-menu-fin-mes', 'chevron-fin-mes', false)"
                                                                     class="option-fin-mes flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                                                    <span class="option-title font-medium text-[#95aba5]">Selecione o mês...</span>
                                                                </div>
                                                                @foreach($mesesArr as $mItem)
                                                                    <div onclick="selectSingleOption('{{ $mItem }}', '{{ $mItem }}', 'Meses', 'label-fin-mes', 'dropdown-menu-fin-mes', 'chevron-fin-mes', false)"
                                                                         class="option-fin-mes flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                                                        <span class="option-title font-medium">{{ $mItem }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                                                              
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Situação" class="text-sm font-medium text-[#0a241e]">Situação:</label>
                                                    <div class="relative" id="dropdown-container-fin-sit">
                                                        <input type="hidden" id="status_pagamento" name="status_pagamento" value="{{ request()->input('status_pagamento', '') }}">
                                                        @php
                                                            $valSit = request()->input('status_pagamento', '');
                                                        @endphp
                                                        <div onclick="toggleMultiDropdown('dropdown-menu-fin-sit', 'chevron-fin-sit')" 
                                                             class="w-full flex items-center justify-between bg-[#f8faf9] border border-[#e3e8e6] hover:border-[#008a4b]/50 rounded-xl px-4 py-2.5 transition-all cursor-pointer shadow-2xs h-11">
                                                            <span id="label-fin-sit" class="text-sm font-medium truncate {{ $valSit ? 'text-[#0a241e]' : 'text-[#95aba5]' }}">
                                                                {{ $valSit ?: 'Selecione a situação...' }}
                                                            </span>
                                                            <div id="chevron-fin-sit" class="text-[#95aba5] transition-transform duration-200 shrink-0 ml-2">
                                                                <i data-lucide="chevron-down" class="w-4 h-4"></i>
                                                            </div>
                                                        </div>
                                                        <div id="dropdown-menu-fin-sit" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-[#e3e8e6] rounded-xl shadow-xl z-50 p-2 flex flex-col gap-2 overflow-hidden" style="max-height: 240px;">
                                                            <div class="custom-scroll flex flex-col gap-0.5 pr-1" style="max-height: 180px; overflow-y: auto;">
                                                                <div onclick="selectSingleOption('', 'Selecione a situação...', 'status_pagamento', 'label-fin-sit', 'dropdown-menu-fin-sit', 'chevron-fin-sit', false)"
                                                                     class="option-fin-sit flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                                                    <span class="option-title font-medium text-[#95aba5]">Selecione...</span>
                                                                </div>
                                                                @foreach(['PAGO', 'PARCIAL', 'ABERTO'] as $sItem)
                                                                    <div onclick="selectSingleOption('{{ $sItem }}', '{{ $sItem }}', 'status_pagamento', 'label-fin-sit', 'dropdown-menu-fin-sit', 'chevron-fin-sit', false)"
                                                                         class="option-fin-sit flex items-center p-2 hover:bg-[#ecfdf5] rounded-lg transition-colors cursor-pointer text-xs text-[#0a241e]">
                                                                        <span class="option-title font-medium">{{ $sItem }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>          </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <center> 
                                                        <div class="btn-toolbar">
                                                            <button type="submit" class="btn btn-success"> <i class="fa fa-search" aria-hidden="true"></i>  FILTRAR</button>
                                                            <button type="reset" class="btn btn-default">   LIMPAR</button> 
                                                        </div>
                                                    </center>
                                                    <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
                                                </div>
                                                <!-- /.table-responsive -->
                                            </div>
                                        </form>
                                    </center>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>    
                        <!-- /.panel -->
                    </div>
                    <div class="col-lg-5">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <strong>Relatórios PDF</strong>  
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <center> 
                                        <div class="btn-toolbar">
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas a receber</a>
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas a pagar</a>
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas pendentes</a>
                                            <br>  
                                            <br>  
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas pendentes</a>
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas pendentes</a>
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas pendentes</a>
                                        </div>
                                    </center>
                                    <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>    
                        <!-- /.panel -->
                    </div>
                </div>
            </div>
           
        </div>
    </div>
    
    
    
    
    <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="false">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree2">
                <h4 class="panel-title">
                        <a 
                            <i class="fa fa-search" aria-hidden="true"></i> 
                            <button type="button" data-toggle="collapse" href="#filtro2" class="btn btn-success"data-parent="#accordion2" role="button"   aria-controls="collapseOne">
                            FILTRO POR TURMA / MÊS
                            </button> 
                        </a>
                    </a>
                </h4>
            </div>
            
             <!-- Filtros por turma / mes / situação -->
            
            <div id="filtro2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filtro2">
                <div class="panel-body">
                    <div class="col-lg-7">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <strong>FILTRO POR TURMA / MÊS  </strong>  
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <center> 
                                        <form  method="POST" action="/coordenacao/financeiro_pesq_relatorio_turma">
                                            {!! csrf_field() !!}                      
                                          
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="turma">Turma:</label>
                                                    <div class="select-wrapper">
    <select class="form-control maruge-select" name="idTurmas">
                                                        <option ></option>                                        
                                                       
                                                        
                                        @forelse($turmas as $turma)  
                                        <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                        @empty
                                        @endforelse 
                                                        
  
                                                        
                                               </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
                                                </div>
                                            </div>
                                            
                                                   
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Mês">Mês:</label>
                                                    <div class="select-wrapper">
    <select class="form-control maruge-select" name="Meses" required="required" >
                                                        <option ></option>                                        
                                                        <option>JANEIRO </option>
                                                        <option>FEVEREIRO </option>
                                                        <option>MARÇO</option>
                                                        <option>ABRIL</option>
                                                        <option>MAIO</option>
                                                        <option>JUNHO</option>
                                                        <option>JULHO</option>
                                                        <option>AGOSTO</option>
                                                        <option>SETEMBRO</option>
                                                        <option>OUTUBRO</option>
                                                        <option>NOVEMBRO</option>
                                                        <option>DEZEMBRO</option>                                        
                                                    </select>
    <i data-lucide="chevron-down" class="select-icon"></i>
</div>
                                                </div>
                                            </div>
                                            
                                     
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <center> 
                                                        <div class="btn-toolbar">
                                                            <button type="submit" class="btn btn-success"> <i class="fa fa-search" aria-hidden="true"></i>  FILTRAR</button>
                                                            <button type="reset" class="btn btn-default">   LIMPAR</button> 
                                                        </div>
                                                    </center>
                                                    <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
                                                </div>
                                                <!-- /.table-responsive -->
                                            </div>
                                        </form>
                                    </center>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>    
                        <!-- /.panel -->
                    </div>
                    <div class="col-lg-5">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <strong>Relatórios PDF</strong>  
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <center> 
                                        <div class="btn-toolbar">
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas a receber</a>
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas a pagar</a>
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas pendentes</a>
                                            <br>  
                                            <br>  
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas pendentes</a>
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas pendentes</a>
                                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas pendentes</a>
                                        </div>
                                    </center>
                                    <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.panel-body -->
                        </div>    
                        <!-- /.panel -->
                    </div>
                </div>
            </div>
           
        </div>
    </div>
    
    
    
    
    
    
    <br>
    <div class="linha"></div>
    <br>
    <!--Terceira linhas, APENAS UM AVISO DE ALERTA -->
    <div class="row">
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4>   <strong>Por favor! </strong> Para obter o relatório é necessário realizar um filtro.<h4>
                    </div>
                    </div>
                    <br>
                    <div class="linha"></div>
                    <br>
                    <button type="button"  value="Imprimir" id="imprimir_conteudo"  class="botao btn-imprimir"> Imprimir</button> <br>
                    <div class="imprimir_conteudo"> 
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div id="box">
                                   <!-- /.panel-heading -->
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <center> 
                                               <table class="timbre">
                                                    <tr>
                                                        <td>
                                                            <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                                                            @forelse($escolas as $escola)
                                                            {{$escola->Rua}} , {{$escola->Numero}}<br>
                                                            {{$escola->Bairro}} - CEP:{{$escola->CEP}}<br>
                                                            {{$escola->Cidade}} - {{$escola->Estado}}<br>
                                                            Tel: {{$escola->Fone1}} / {{$escola->Fone2}}<br>
                                                            E-mail:{{$escola->EmailColegio}}<br>
                                                            CNPJ: {{$escola->CNPJ}}<br>
                                                            INEP:{{$escola->NumeroInep}}
                                                            @empty
                                                            @endforelse
                                                        </td>
                                                    </tr>         
                                                </table>
                                            </center>
                                           <br>
                                            <table  class="table financeiro_tabela_receber"  >
                                                <thead>
                                                <tr  class="panel-heading ">
                                                <th class="bg-primary" > <center> <i class="fa fa-calendar" aria-hidden="true" ></i>  Relatório Referênte </center>  </th>
                                             
                                            <th class="info"> <center> <i class="fa fa-search"></i>     Total de Boletos Localizados  </center>  </th>
                                               
                                                <th class="success" > <center>  <i class="fa fa-money" aria-hidden="true" ></i> Total  Recebido  </center></th>
                                                <th class="danger" > <center>  <i class="fa fa-money" aria-hidden="true" ></i> Total  em Aberto  </center></th>
                                                </tr>
                                                </thead> 
                                                <tbody>
                                                    <tr>
                                                        
                                                        <td > <center> Boletos do Mês: {{$Mes}} / {{$Situacao}}  </center> </td>
                                      
                                                                                  
                                            
                                            
                                                <td > <center>    {{$QuantidadeDeBoletos}} </center>  </td>
                                                
                                                <td > <center>  <b>R$: </b>   {{ number_format($recebido,2,",",".")}} </center> </td>
                                                <td > <center>  <b>R$: </b>   {{ number_format($atrasados,2,",",".")}} </center> </td>
                                                </tr> 
                                            </table>
                                            </center>
                                            <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>    
                                <!-- /.panel -->
                            </div>
                            <div id="box">
                                <table  class="table financeiro_tabela_receber"  >
                                    <thead>
                                        <tr>
                                          <!--  <th >Referência</th> -->
                                            <th >Turma</th>
                                            <th >RA</th>
                                            <th >ALUNO</th>
                                            
                                            <th >Parcela</th>
                                            <th >Ano</th>
                                            <th >Valor Bru.</th>
                                            <th >Des.%</th>
                                            <th >Valor Liq.</th>
                                            <!--
                                            
                                            <th >Mês</th>
                                            <th >Valor Pago</th>
                                            <th >Situação</th>                                            <th >Carteira</th>
                                            <th >Pago em</th>
                                            <th >Vencimento</th>
                                            -->
                                            
                                            
                                            
                                            <th >Responsavel</th>
                                            <th >CPFResponsavel</th>
                                            <th >RGResponsavel</th>
                                            <th >Tel: Mãe</th>
                                            <th >Tel: Pai</th>
                                        </tr>
                                    </thead> 
                                    <tbody>
                                        @forelse($Boletos as $Boleto)
                                        <tr>
                                              <!--   <td >{{$Boleto->idcarne}}</td> -->
                                            <td >{{$Boleto->NomeTurma}}</td>
                                            <td >{{$Boleto->RA}}</td>
                                            <td >{{$Boleto->NomeAluno}}</td>
                                            
                                            <td >{{$Boleto->parcelas}}</td>
                                            <td >{{$Boleto->Ano_Letivo}}</td>
                                            <td >R$:{{$Boleto->Mensalidade}}</td>
                                            
                                            
                                            <td >{{$Boleto->Bonus}}%</td>
                                            <td >R$:{{$Boleto->tb_turmas_Mensalidade}}</td>
                                           
                                            <!--
                                            <td >{{$Boleto->ValorPGTO}}</td>
                                            <td >{{$Boleto->Carteira}}</td>
                                            <td >{{$Boleto->data_pagamento}}</td>
                                            <td >{{$Boleto->Meses}}</td>
                                            <td >{{$Boleto->status_pagamento}}</td>
                                             <td >{{$Boleto->Data_venc}}</td>
                                            -->
                                           
                                            
                                            
                                            <td >{{$Boleto->Responsavel}}</td>
                                            <td >{{$Boleto->CPFResponsavel}}</td>
                                            <td >{{$Boleto->RGResponsavel}}</td>
                                            <td >{{$Boleto->FoneMae1}}</td>
                                            <td >{{$Boleto->FonePai1}}</td>
                                        </tr> @empty
                                        @endforelse
                                </table>
                            </div>
                        </div>     
                    </div><!--Fim do caminho-din-->
                    @endsection

