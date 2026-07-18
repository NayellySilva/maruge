@extends('telasCoordenacao.painel')  
@section('conteudo')
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
                                        <form  method="POST" action="/maruge/public/coordenacao/financeiro_pesq_relatorio">
                                            {!! csrf_field() !!}                      
                                          
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="turma">Turma:</label>
                                                    <select class="form-control" name="idTurmas">
                                                        <option ></option>                                        
                                                       
                                                        
                                        @forelse($turmas as $turma)  
                                        <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                        @empty
                                        @endforelse 
                                                        
  
                                                        
                                               </select>
                                                </div>
                                            </div>
                                            
                                                   
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Mês">Mês:</label>
                                                    <select class="form-control" name="Meses" required="required" >
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
                                                </div>
                                            </div>
                                            
                                                                              
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Situação">Situação:</label>
                                                    <select class="form-control" name="status_pagamento" required="required" >
                                                        <option ></option>
                                                        <option> PAGO</option>
                                                        <option> PARCIAL</option>
                                                        <option> ABERTO</option>
                                                    </select>
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
                                        <form  method="POST" action="/maruge/public/coordenacao/financeiro_pesq_relatorio_turma">
                                            {!! csrf_field() !!}                      
                                          
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="turma">Turma:</label>
                                                    <select class="form-control" name="idTurmas">
                                                        <option ></option>                                        
                                                       
                                                        
                                        @forelse($turmas as $turma)  
                                        <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                        @empty
                                        @endforelse 
                                                        
  
                                                        
                                               </select>
                                                </div>
                                            </div>
                                            
                                                   
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Mês">Mês:</label>
                                                    <select class="form-control" name="Meses" required="required" >
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
    
    
    <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="false">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingThree2">
                <h4 class="panel-title">
                        <a 
                            <i class="fa fa-search" aria-hidden="true"></i> 
                            <button type="button" data-toggle="collapse" href="#filtro3" class="btn btn-success"data-parent="#accordion2" role="button"   aria-controls="collapseOne">
                             ANO
                            </button> 
                        </a>
                    </a>
                </h4>
            </div>
            
             <!-- Filtros por turma / mes / situação -->
            
            <div id="filtro3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="filtro3">
                <div class="panel-body">
                    <div class="col-lg-7">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <strong> GRÁFICOS DE BALANÇOS ANUAIS  </strong>  
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <center> 
                                        <form  method="POST" action="/maruge/public/coordenacao/financeiro_pesq_relatorio_balanco">
                                            {!! csrf_field() !!}                      
                                          
                                            
                                            <!--
                                            
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="turma">Turma:</label>
                                                    <select class="form-control" name="idTurmas">
                                                        <option ></option>                                        
                                                       
                                                        
                                        @forelse($turmas as $turma)  
                                        <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                        @empty
                                        @endforelse 
       
                                                          
                                               </select>
                                                </div>
                                            </div>
                                                                                      -->
              
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="Ano">Ano:</label>
                                                    <select class="form-control" name="Ano" required="required" >
                                                        <option ></option>                                        
                                                        <option>2020 </option>
                                                        <option>2021 </option>
                                                    </select>
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
                                                  
                                                    <th class="bg-primary"> <center> <i class="fa fa-calendar"></i>    Total de Boletos (Geral)</center> </th>
                                                    <th class="danger" ><center> <i class="fa fa-search" aria-hidden="true"></i>  Abertos</center>  </th>
                                                    <th class="danger" ><center> <i class="fa fa-search" aria-hidden="true"></i> Pagos </center> </th>
                                                    <th class="danger" > <center><i class="fa fa-search" aria-hidden="true"></i> Parcial </center>  </th>
                                                    <th class="warning" ><center> <i class="fa fa-money" aria-hidden="true"></i> Total a Receber </center> </th>
                                                    <th class="success" > <center><i class="fa fa-money" aria-hidden="true" ></i>  Total  Recebido </center>  </th>
                                                    <th class="warning" > <center><i class="fa fa-money" aria-hidden="true" ></i>  Falta Receber </center>  </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                   
                                                    <td > <center>{{$QuantidadeDeBoletos}}</center> </td>
                                                    <td ><center> {{ $Abertos}}</center> </td>
                                                    <td ><center> {{ $Pagos}}</center> </td>
                                                    <td ><center> {{ $Parcial}}</center> </td>
                                                <td > <center> <b> R$: </b> {{ number_format($receber,2,",",".")}} </center> </td>
                                                <td > <center> <b>R$: </b> {{ number_format($recebido,2,",",".")}} </center> </td>
                                             
                                             @php 
                                             $restante = ($receber-$recebido); 
                                             @endphp
                                             
                                             
                                             
                                                <td > <center> <b>R$: </b> {{ number_format($restante,2,",",".")}} </center> </td>
                                                    </tr> 
                                                </table>
                                           
                                              
                                           
  <table  class="table financeiro_tabela_receber"  >
                                                <thead>
                                                <tr  class="panel-heading ">
                                                <th class="bg-primary" > <center> <i class="fa fa-calendar" aria-hidden="true" ></i>  FATURAMENTO ANUAL E INADIMPLÊNCIA </center>  </th>
                            
                                                </tr>
                                                </thead> 
                                                <tbody>
                                                    <tr>
                                                <td > <center>              
                                                
                                                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
           ['PAGOS',     {{ $Pagos}}],
          ['ABERTOS',     {{ $Abertos}}],
          ['PAGOS PARCIALMENTE',     {{ $Parcial}}],

        ]);

        var options = {
          title: 'GRÁFICO ESTÁTISTICO DE FATURAMENTO ' 
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 1000px; height: 800px;"></div>
  </body>
                                                
                                                
                                                </center> </td>
    
                                                </tr> 
                                            </table>            
                    
                                            <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.panel-body -->
                                </div>    
                                <!-- /.panel -->
                            </div>
                            

                            
                    </div><!--Fim do caminho-din-->
                            
                            
                           
                    @endsection

