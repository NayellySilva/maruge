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
        <div class="mapa-titulo"> ################### MAPAS DE NOTAS - 4º BIMESTRE - {{$turma->AnoLetivo}}</div>
        <div class="mapa-titulo-turma"> TURMA - {{$turma->NomeTurma}}</div>
        <hr class="linha">   
        <table class="table-striped table-bordered mapa" >    
            <thead  >
                <tr>        
                    <th width="80"><center>RA</center></th>
        <th >ALUNO</th>                 
        <!-- DISCIPLINAS -->
        @foreach($disciplinas as $key => $disciplina )
        <th >  {{substr ($disciplina->NomeDisciplina ,0,4 )}}</th>
        @endforeach
    </tr>
</thead> 
<!-- Listando todos os alunos da turma -->
@forelse($Alunos as $Aluno)      
    <tr>
    <td><center>{{$Aluno->RA}}</center></td>
    <td width=330>{{$Aluno->NomeAluno}}</td>
    <!-- pecorrendo a lista da disciplinas existente da turma e para consulta se existe nota-->
        @foreach($disciplinas as $key => $disciplina )
        <!-- Buscando a nota referente a disciplina -->
                    @php
                    $notasDoAluno = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($Aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
                    @endphp
        <!-- Declarando as notas e criando um laço pra elas -->            
        @forelse($notasDoAluno as $nota)
                    <!-- Verifiva se existe noda de AB4 da X disciplina -->
                    @if (isset ($nota->AB4))
            <!-- Fazendo media bimestral -->
            @php 
            $nota->AB4 = ($nota->AB4+$nota->AM4)/2; 
            @endphp
            <!-- / Fazendo media bimestral -->
                                <!-- imprimindo a nota -->
                                @if (($nota->AB4) == 0)
                                    <td class="Mapa_valorX"><center>X</center></td>
                                @elseif (($nota->AB4) < 7)
                                <td><center><div class="Mapa_notaVermelha">{{number_format($nota->AB4 ,1)}}</div></center></td> 
                                @else
                                <td><center><div class="Mapa_notaAzul">{{number_format($nota->AB4 ,1)}}</div></center></td> 
                                <!-- / imprimindo a nota -->
                                @endif    
                    <!-- / Verifiva se existe noda de AB4 da X disciplina -->
                    @endif
                    <!-- / Declarando as notas e criando um laço pra elas (quando não existir nota)-->    
                    @empty
                    <td class="Mapa_valorX"><center>X</center></td>
                    @endforelse
    <!-- / pecorrendo a lista da disciplinas existente da turma e para consulta se existe nota-->
        @endforeach
    </tr>
<!-- / Listando todos os alunos da turma -->
@empty
@endforelse
</table>
</body>
</html>