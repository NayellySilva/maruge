<html>
    <header>   
        <title>{{$titulo}}</title>
    </header>
    <body>
                <style media="print">
            .botao {
                display: none;
            }
        </style>
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">   
       
        <button type="button"  value="Imprimir" onClick="window.print()" class="botao btn-imprimir"> Imprimir</button>

        <table class="timbre-horizontal">
            <tr>
                <td>
                    <img src="{{asset('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                </td>
                <td>
                    @forelse($escolas as $escola)
                    {{$escola->Rua}} , {{$escola->Numero}}<br>
                    {{$escola->Bairro}} - CEP:{{$escola->CEP}}<br>
                    {{$escola->Cidade}} - {{$escola->Estado}}<br>
                    Tel: {{$escola->Fone1}} / {{$escola->Fone2}}<br>
                    E-mail:{{$escola->EmailColegio}}<br>
                    CNPJ: {{$escola->CNPJ}}<br>
                    INEP:{{$escola->NumeroInep}}
                </td>
            </tr>         
        </table>
        @empty
        @endforelse
        <div class="mapa-titulo"> FREQUÊNCIA MÊS: {{$mes}}   -    TURMA - {{$turma->NomeTurma}}</div>   
            
        <hr class="linha">   
        
       <table class="table-striped table-bordered mapa" >    
            <thead  >
                <tr>        
                    <th width="80"><center>Nº</center></th>
                    <th width="80"><center>RA</center></th>
                    <th >ALUNO</th>
                    <th width="21">01</th>  
                    <th width="21">02</th>  
                    <th width="21">03</th>  
                    <th width="21">04</th>  
                    <th width="21">05</th>  
                    <th width="21">06</th>  
                    <th width="21">07</th>  
                    <th width="21">08</th>  
                    <th width="21">09</th>  
                    <th width="21">10</th>  
                    <th width="21">11</th>  
                    <th width="21">12</th>  
                    <th width="21">13</th>  
                    <th width="21">14</th>  
                    <th width="21">15</th>  
                    <th width="21">16</th>  
                    <th width="21">17</th>  
                    <th width="21">18</th>  
                    <th width="21">19</th>  
                    <th width="21">20</th>  
                    <th width="21">21</th>  
                    <th width="21">22</th>  
                    <th width="21">23</th>  
                    <th width="21">24</th>  
                    <th width="21">25</th>  
                    <th width="21">26</th>  
                    <th width="21">27</th>  
                    <th width="21">28</th>  
                    <th width="21">29</th>  
                    <th width="21">30</th>  
                    <th width="21">31</th>  
                </tr>
            </thead> 
            
            
                @php
                $contando = 0;
                @endphp
            
            
            
            @forelse($Alunos as $Aluno)      
            <tr >
                
                 @if (isset ($Aluno))
                    @php
                    $contando == ($contando++)
                    @endphp
                <td><center>{{$contando }}</center></td>
                
                <td><center>{{$Aluno->RA}}</center></td>
                <td>{{$Aluno->NomeAluno}}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endif
            @empty
            @endforelse
        </table>
    </body>
</html>