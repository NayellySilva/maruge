@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo or 'Lançamento de Notas Educação Infantil - 2º Bimestre'}}</h1>
</div>  
<div class="caminho-din">
        <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
    <div class="formularios">    
        @if(count($errors)>0)
        @foreach($errors->all()as $error)
        {{$error}}
        @endforeach
        @endif
        <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/salva_nota_2bim_inf" method="POST" send="/maruge/public/coordenacao/salva_nota_2bim_inf">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="NomeTurma">Aluno: {{$aluno->NomeAluno}}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="NomeTurma">RA: {{$matricula->RA}}</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="NomeTurma">Turma: {{$turma->NomeTurma}}</label>
                    </div>
                </div>
                <div class="caminho-din">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>CÓD. DISC. </th>
                                <th>DISCIPLINAS</th>
                                <th><center>2º BIMESTRE</center></th>
                        <th><center>EDITAR</center></th>
                        </tr>
                        </thead>   
                        <!-- Recebendo valores na vareavel disciplinas e passando para disciplina -->
                        @foreach($disciplinas as $key => $disciplina )
                        <input type="hidden" name="tb_disciplinas_idDisciplinas[{{$key}}]" value="{{$disciplina->tb_disciplinas_idDisciplinas}}">
                        <input type="hidden" name="tb_usuario_idUsuario[{{$key}}]" value="{{auth()->guard('guardLogin')->user()->idUsuario}}">
                        <input type="hidden" name="tb_turmas_idTurmas[{{$key}}]" value="{{$turma->idTurmas}}">
                        <input type="hidden" name="tb_aluno_idAluno[{{$key}}]" value="{{$aluno->idAluno}}">
                        <input type="hidden" name="RA[{{$key}}]" value="{{$matricula->RA}}">
                        <center>
                            <tr>
                                <td> {{$disciplina->tb_disciplinas_idDisciplinas}} </td>
                                <td>{{$disciplina->NomeDisciplina}}</td>
                                @php
                                $notasDoAluno = \App\Models\modelCoordenacao\tb_notas::busca_notas_do_aluno($aluno->idAluno, $disciplina->tb_disciplinas_idDisciplinas);
                                @endphp
                                <!-- INICIO DO FOREACH DA NOTA DA DISCILPLINA QUE TA LISTANDO-->
                                @forelse($notasDoAluno as $nota)
                                @if (isset ($nota->AB2))
                                @if (($nota->AB2) == 0)
                                <td><center><div class="col-md-4 col-md-offset-4" >                                  
                                    <input type="text" name="AB2[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                                </div>  
                            </center>
                        </td> <td>
                    <center> <img src="{{url('imgs/icones/inativo.png')}}" alt="editar"</center></td>
                    </tr> 
                    </td>
                    @elseif (($nota->AB2) < 7)
                    <td><center><div class="col-md-4 col-md-offset-4 notaVermelha" >                  
                            {{number_format($nota->AB2 ,1)}}  
                            <input type="hidden" name="AB2[{{$key}}]" value="{{$nota->AB2}}" >
                        </div>  
                    </center>
                    </td> 
                    <td> 
                    <center><a href="#">
                            <img src="{{url('imgs/icones/editar.png')}}" data-toggle="modal" data-target="#edita_nota_2bim_inf" 
                                 data-whatever_tb_aluno_idaluno="{{$aluno->idAluno}}"
                                 data-whatever_idnotas="{{$nota->idNotas}}"
                                 data-whatever_nome_aluno="{{$aluno->NomeAluno}}"
                                 data-whatever_AB2="{{number_format($nota->AB2 ,1)}}"
                                 data-whatever_disciplina="{{$disciplina->NomeDisciplina}}"
                                 data-whatever_idusuario="{{auth()->guard('guardLogin')->user()->idUsuario}}"
                                 >
                        </a></center>
                    </td>
                    </tr> 
                    @else
                    <td><center><div class="col-md-4 col-md-offset-4 notaAzul" >                  
                            {{number_format($nota->AB2 ,1)}} 
                            <input type="hidden" name="AB2[{{$key}}]" value="{{$nota->AB2}}" >
                        </div>  
                    </center> </td>
                    </td> 
                    <td> 
                    <center><a href="#">
                            <img src="{{url('imgs/icones/editar.png')}}" data-toggle="modal" data-target="#edita_nota_2bim_inf" 
                                 data-whatever_tb_aluno_idaluno="{{$aluno->idAluno}}"
                                 data-whatever_idnotas="{{$nota->idNotas}}"
                                 data-whatever_nome_aluno="{{$aluno->NomeAluno}}"
                                 data-whatever_AB2="{{number_format($nota->AB2 ,1)}}"
                                 data-whatever_disciplina="{{$disciplina->NomeDisciplina}}"
                                 data-whatever_idusuario="{{auth()->guard('guardLogin')->user()->idUsuario}}"
                                 >
                        </a></center>                  
                    </td>
                    </tr> 
                    @endif
                    @endif
                    @empty
                    <td><center><div class="col-md-4 col-md-offset-4" >                                  
                            <input type="text" name="AB2[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                        </div>  
                    </center>
                </td> <td><center> <img src="{{url('imgs/icones/inativo.png')}}" alt="editar"</center></td>
            </tr> 
            @endforelse 
            <!-- FIM DO FOREACHO QUE LISTA A DISCIPLINA-->
            @endforeach
    </table> 
</div>
</div> <!--Fim do caminho-din-->
<!--SEGUNDA LINHA REFERENTE AOS CAMPOS ( SALVA E LIMPA )-->
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <button type="submit" class="btn btn-success">SALVAR</button>
            <button type="reset" class="btn btn-default">LIMPAR</button>
        </div>
    </div>   
</div>       
</form> <!--Fim do formulario-->
</div>
</div> <!--Fim do caminho-din-->

<!-- Modal Alteração Nota Educação Infantil -->
<div class="modal fade" id="edita_nota_2bim_inf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alteraNota-titulo">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="NomeAluno"></h4>
            </div>
            <div class="modal-body">
                <form class="alteraNota form formularios" action="/maruge/public/coordenacao/editar_nota" method="POST" send="/maruge/public/coordenacao/editar_nota">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}
                    <input type="hidden" name="idNotas" id="idNotas" >
                    <input type="hidden" name="tb_usuario_idUsuario" id="tb_usuario_idUsuario">
                    <input type="hidden" name="tb_aluno_idAluno" id="tb_aluno_idAluno">
                    <div class="row ">
                        <div class="col-md-12 ">
                            <label for="2bim" id="Disciplina"></label>   
                        </div>  
                        <div class="col-md-2 col-md-offset-5">
                            <input type="text" name="AB2" class="form-control nota" min="0" max="10" id="notaAtual" >
                        </div>  
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success"   >Alterar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection