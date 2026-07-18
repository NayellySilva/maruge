<div class="titulo-pagina">
</div> 
<div class="caminho-din">
    <div class="formularios"> 
        <table width="550" border="5">
            <td>
            <center>
                <img src="{{url('imgs/logoempresa_transparente.png')}}" width="160" height="160" ><br>
                {{$endereco->Rua}} , {{$endereco->Numero}}<br>
                {{$endereco->Bairro}} - CEP:{{$endereco->CEP}}<br>
                {{$endereco->Cidade}} - {{$endereco->Estado}}<br>
                Tel: {{$endereco->Fone1}} / {{$endereco->Fone2}}<br>
                {{$escolas->EmailColegio}}<br>
                CNPJ: {{$escolas->CNPJ}}<br>
                INEP:{{$escolas->NumeroInep}}
            </center>
            </td>
            </tr>            
        </table>
    </div>
</div> 
<!-- FINAL DO TIMBRE>
<!--inicio dos relatórios-->
<h2 class="resultado">Alunos Cadastrados:{{$quantAlunosCadastrados}}</h2>
<h2 class="resultado">Alunos Ativos:{{$quantMatriculasAtivas}}</h2>
<h2 class="resultado">Alunos Inativos:{{$quantMatriculasInativas}}</h2>
<h2 class="resultado">Total de Turmas:{{$quantTurmasAtivas}}</h2>
<h2 class="resultado">Total de Disciplinas:{{$quantDisciplina}}</h2>
<h2 class="resultado">Total de Funcionários:{{$quantFuncionariosCadastrados}}</h2>
<h2 class="resultado">Total de Usuários:{{$quantUsuarioCadastrados}}</h2>

