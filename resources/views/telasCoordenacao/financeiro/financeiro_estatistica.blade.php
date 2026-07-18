@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
        Financeiro / Receitas e Despesas  
    </a>
</div>


<div class="caminho-din">

    <div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading ">
            <strong> Contas a Receber</strong>  
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <center>

                    <div class="col-md-4 ">
                        <section class="panel panel-featured-left panel-featured-success">
                            <div class="panel-body sombra">
                                <div class="widget-summary widget-summary-md">
                                    <div class="widget-summary-col widget-summary-col-icon ">
                                        <div class="summary-icon bg-success ">
                                            <i class="fa fa-money contas-receber"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class=" contas-receber  ">
                                            <h4 >Falta receber</h4>
                                            <div class="info">
                                                <strong class="amount">R$ 0,00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>  
                    <div class="col-md-4 ">
                        <section class="panel panel-featured-left panel-featured-success">
                            <div class="panel-body sombra">
                                <div class="widget-summary widget-summary-md">
                                    <div class="widget-summary-col widget-summary-col-icon ">
                                        <div class="summary-icon bg-success ">
                                            <i class="fa fa-money contas-receber"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class=" contas-receber  ">
                                            <h4 >Total a receber</h4>
                                            <div class="info">
                                                <strong class="amount">R$ 0,00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>  
                    <div class="col-md-4 ">
                        <section class="panel panel-featured-left panel-featured-success">
                            <div class="panel-body sombra">
                                <div class="widget-summary widget-summary-md">
                                    <div class="widget-summary-col widget-summary-col-icon ">
                                        <div class="summary-icon bg-success ">
                                            <i class="fa fa-money contas-receber"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class=" contas-receber  ">
                                            <h4 >Total recebido</h4>
                                            <div class="info">
                                                <strong class="amount">R$ 0,00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>  
 </center>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>    
    <!-- /.panel -->
</div>


<div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading ">
            <strong> Contas a Pagar </strong>  
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <center>

                    <div class="col-md-4 ">
                        <section class="panel panel-featured-left panel-featured-success">
                            <div class="panel-body sombra">
                                <div class="widget-summary widget-summary-md">
                                    <div class="widget-summary-col widget-summary-col-icon ">
                                        <div class="summary-icon bg-success ">
                                            <i class="fa fa-money contas-pagar"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class=" contas-pagar  ">
                                            <h4 >Falta pagar</h4>
                                            <div class="info">
                                                <strong class="amount">R$ 0,00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>  
                    <div class="col-md-4 ">
                        <section class="panel panel-featured-left panel-featured-success">
                            <div class="panel-body sombra">
                                <div class="widget-summary widget-summary-md">
                                    <div class="widget-summary-col widget-summary-col-icon ">
                                        <div class="summary-icon bg-success ">
                                            <i class="fa fa-money contas-pagar"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class=" contas-pagar  ">
                                            <h4 >Total a pagar</h4>
                                            <div class="info">
                                                <strong class="amount">R$ 0,00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>  
                    <div class="col-md-4 ">
                        <section class="panel panel-featured-left panel-featured-success">
                            <div class="panel-body sombra">
                                <div class="widget-summary widget-summary-md">
                                    <div class="widget-summary-col widget-summary-col-icon ">
                                        <div class="summary-icon bg-success ">
                                            <i class="fa fa-money contas-pagar"></i>
                                        </div>
                                    </div>
                                    <div class="widget-summary-col">
                                        <div class=" contas-receber  ">
                                            <h4 >Total pago</h4>
                                            <div class="info">
                                                <strong class="amount">R$ 0,00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>  
 </center>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>    
    <!-- /.panel -->
</div>
    
    
    
    
    
        <div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading ">
            <strong> Movimentações de Receitas  </strong>  
        </div>

               
                    
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Falta Receber',     11],
          ['Total a Receber',      2],
          ['Total Recebido',  2],
         
        ]);

        var options = {
          
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
                   
                   <div id="piechart_3d" style="width: 750px; height:400px;"></div>
                 
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>    
    <!-- /.panel -->

    
    
    
        <div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading ">
            <strong> Despesas </strong>  
        </div>
        <!-- /.panel-heading -->
       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Falta Pagar',     60],
          ['Total a pagar',      30],
          ['Total pago',  20],
         
        ]);

        var options = {
          
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d2'));
        chart.draw(data, options);
      }
    </script>
                   
                   <div id="piechart_3d2" style="width: 750px; height:400px;"></div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>    
    <!-- /.panel -->
</div>  
    
    
    <div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading ">
            <strong> Gastos por Categoria </strong>  
        </div>

        
        
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
   
   function getValueAt(column, dataTable, row) {
        return dataTable.getFormattedValue(row, column);
        
      }
    
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density", { role: "style" } ],
        ["Água", 8.94, "#b87333"],
        ["Luz", 10.49, "silver"],
        ["Salário", 19.30, "gold"],
        ["Papel", 21.45, "color: #e5e4e2"]
        
      ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
       
        width: 750,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      
      
              
              
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }
  </script>
  
<div id="columnchart_values" style="width: 750px; height: 400px;"></div>
        
        
        
        
        <!-- /.panel-body -->
    </div>    
    <!-- /.panel -->
</div>
    
    
    
    <div class="col-lg-6">
    <div class="panel panel-default">
        <div class="panel-heading ">
            <strong> Receitas / Despesas </strong>  
        </div>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['MESES', 'Receitas', 'Despesas'],
          ['JAN', 1000, 400,],
          ['FEV', 1170, 250],
          ['MAR', 660, 30],
          ['ABR', 660, 1120],
          ['MAI', 680, 110],
          ['JUN', 660, 300],
          ['JUL', 670, 11],
          ['AGO', 500, 1130],
          ['SET', 800, 110],
          ['OUT', 300, 100],
          ['NOV', 580, 130],
          ['DEZ', 475, 118]
         
        ]);

        var options = {
          chart: {
            
            
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    
    
    
    
    <div id="columnchart_material" style="width: 750px; height: 400px;"></div>
        <!-- /.panel-body -->
    </div>    
    <!-- /.panel -->
</div>
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    

</div> <!--Fim do caminho-din-->






















@endsection