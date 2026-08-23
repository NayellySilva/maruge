@extends('layouts.app')  
@section('content')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{ $titulo ?? 'Lançamento de Notas Fundamental II - 1º Bimestre' }}</h1>
</div>  
<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
    <div class="formularios">    
        @if((isset($errors) ? count($errors) : 0)>0)
        @foreach($errors->all() as $error)
        {{$error}}
        @endforeach
        @endif
        <form class="form form-search form-Nu formularios" action="/coordenacao/salva_nota_1bim_fun2" method="POST" send="/coordenacao/salva_nota_1bim_fun2">
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
                                <th><center>MENSAL</center></th>
                        <th><center>1º BIMESTRE</center></th>
                        <th>MÉDIA</th>
                        <th><center>EDITAR</center></th>
                        </tr>
                        </thead>   
                        <!-- Recebendo valores na vareavel disciplinas e passando para disciplina -->
                        @foreach($disciplinas as $key => $disciplina )
                        <input type="hidden" name="tb_disciplinas_idDisciplinas[{{$key}}]" value="{{$disciplina->tb_disciplinas_idDisciplinas}}">
                        <input type="hidden" name="tb_usuario_idUsuario[{{$key}}]" value="{{data_get(auth()->guard('guardLogin')->user(), 'idUsuario', 1)}}">
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
                                @if (isset ($nota->AM1)) <!-- Verifica no banco de dados se existe uma linha expecifica referente a busca a cima. AM1 APENAS UMA REFERENCIA QUALQUER PODERIA SER QUALQUER UM -->
                                @if (($nota->AM1) == 0 && ($nota->AB1) == 0 )
                                <td>
                            <center>
                                <div class="col-md-4 col-md-offset-4" >                                  
                                    <input type="text" name="AM1[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                                </div>  
                            </center> 
                            </td>
                            <td>
                            <center>
                                <div class="col-md-4 col-md-offset-4" >                                  
                                    <input type="text" name="AB1[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                                </div>  
                            </center> 
                            </td>
                            <td>
                                <div class="col-md-4 " > - </div> 
                            </td>
                            <td>
                            <center> 
                                <img src="{{url('imgs/icones/inativo.png')}}" alt="editar">
                            </center>
                            </td>
                            </tr> 
                            @elseif (($nota->AM1) != 0 && ($nota->AB1) == 0 )
                            @if (($nota->AM1) < 7)
                            <td>
                            <center> 
                                <div class="col-md-4 col-md-offset-4 notaVermelha">{{number_format($nota->AM1 ,1)}}
                                    <input type="hidden" name="AM1[{{$key}}]" value="{{$nota->AM1}}" >
                                </div>
                            </center>
                            </td>
                            <td>
                            <center>
                                <div class="col-md-4 col-md-offset-4" >                                  
                                    <input type="text" name="AB1[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                                </div>  
                            </center> 
                            </td>


                            <!-- fim da condição do vermelho -->
                            @else
                            <td>
                            <center> 
                                <div class="col-md-4 col-md-offset-4 notaAzul">{{number_format($nota->AM1 ,1)}}
                                    <input type="hidden" name="AM1[{{$key}}]" value="{{$nota->AM1}}" >
                                </div>
                            </center>
                            </td>
                            <td>
                            <center>
                                <div class="col-md-4 col-md-offset-4" >                                  
                                    <input type="text" name="AB1[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                                </div>  
                            </center> 
                            </td>
                            <!-- fim da condição do azul -->
                            @endif
                            @php
                            $media = ($nota->AM1)/2;
                            @endphp

                            <td>
                                <div class="col-md-4  notaVermelha">{{number_format($media ,1)}}</div>
                            </td>
                            <td>
                            <center> 
                                <a href="#">
                                    <img src="{{url('imgs/icones/editar.png')}}" data-toggle="modal" data-target="#edita_nota_1mensal_fun2" 
                                         data-whatever_tb_aluno_idaluno="{{$aluno->idAluno}}"
                                         data-whatever_idnotas="{{$nota->idNotas}}"
                                         data-whatever_nome_aluno="{{$aluno->NomeAluno}}"
                                         data-whatever_am1="{{number_format($nota->AM1 ,1)}}"
                                         data-whatever_disciplina="{{$disciplina->NomeDisciplina}}"
                                         data-whatever_idusuario="{{data_get(auth()->guard('guardLogin')->user(), 'idUsuario', 1)}}"
                                         >
                                </a>
                            </center>
                            </td>
                            </tr>




 @elseif (($nota->AM1) == 0 && ($nota->AB1) != 0 )
 @if (($nota->AB1) < 7)
<td>
                            <center>
                                <div class="col-md-4 col-md-offset-4" >                                  
                                    <input type="text" name="AM1[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                                </div>  
                            </center> 
                            </td>
                            <td>
                            <center> 
                                <div class="col-md-4 col-md-offset-4 notaVermelha">{{number_format($nota->AB1 ,1)}}
                                    <input type="hidden" name="AB1[{{$key}}]" value="{{$nota->AB1}}" >
                                </div>
                            </center>
                            </td>
                            <!-- fim da condição do vermelho -->
                            @else
                            <td>
                            <center>
                                <div class="col-md-4 col-md-offset-4" >                                  
                                    <input type="text" name="AM1[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                                </div>  
                            </center> 
                            </td>
                            <td>
                            <center> 
                                <div class="col-md-4 col-md-offset-4 notaAzul">{{number_format($nota->AB1 ,1)}}
                                    <input type="hidden" name="AB1[{{$key}}]" value="{{$nota->AB1}}" >
                                </div>
                            </center>
                            </td>
                            <!-- fim da condição do azul -->
                            @endif
                             @php
                            $media = ($nota->AB1)/2;
                            @endphp

                            <td>
                                <div class="col-md-4  notaVermelha">{{number_format($media ,1)}}</div>
                            </td>
                            <td>
                            <center> 
                                <a href="#">
                                    <img src="{{url('imgs/icones/editar.png')}}" data-toggle="modal" data-target="#edita_nota_1bim_fun2" 
                                         data-whatever_tb_aluno_idaluno="{{$aluno->idAluno}}"
                                         data-whatever_idnotas="{{$nota->idNotas}}"
                                         data-whatever_nome_aluno="{{$aluno->NomeAluno}}"
                                         data-whatever_ab1="{{number_format($nota->AB1 ,1)}}"
                                         data-whatever_disciplina="{{$disciplina->NomeDisciplina}}"
                                         data-whatever_idusuario="{{data_get(auth()->guard('guardLogin')->user(), 'idUsuario', 1)}}"
                                         >
                                </a>
                            </center>
                            </td>
                            </tr> 

                            @elseif (($nota->AM1) != 0 && ($nota->AB1) != 0 )

                            <!-- VERIFICANDO A COR DA NOTA DENTRO DA CONDIÇÃO QUE EXISTE A DUAS NOTAS -->
                            @if (($nota->AM1) < 7)
                            <td>
                            <center> 
                                <div class="col-md-4 col-md-offset-4 notaVermelha">{{number_format($nota->AM1 ,1)}}
                                    <input type="hidden" name="AM1[{{$key}}]" value="{{$nota->AM1}}" >
                                </div>
                            </center>
                            </td>
                            @else
                            <td>
                            <center> 
                                <div class="col-md-4 col-md-offset-4 notaAzul">{{number_format($nota->AM1 ,1)}}
                                    <input type="hidden" name="AM1[{{$key}}]" value="{{$nota->AM1}}" >
                                </div>
                            </center>
                            </td>
                            @endif
                            <!-- VERIFICANDO A COR DA NOTA DENTRO DA CONDI~]AO QUE EXISTE AS 2 NOTAS -->
                            @if (($nota->AB1) < 7)
                            <td>
                            <center> 
                                <div class="col-md-4 col-md-offset-4 notaVermelha">{{number_format($nota->AB1 ,1)}}
                                    <input type="hidden" name="AB1[{{$key}}]" value="{{$nota->AB1}}" >
                                </div>
                            </center>
                            </td>
                            @else
                            <td>
                            <center> 
                                <div class="col-md-4 col-md-offset-4 notaAzul">{{number_format($nota->AB1 ,1)}}
                                    <input type="hidden" name="AB1[{{$key}}]" value="{{$nota->AB1}}" >
                                </div>
                            </center>
                            </td>
                            @endif

                            @php
                            $media = ($nota->AM1 + $nota->AB1)/2;
                            @endphp

                            <!-- VERIFICANDO A COR DA MÉDIA -->
                            @if (($media) < 7)
                            <td>
                                <div class="col-md-4  notaVermelha">{{number_format($media ,1)}}</div>
                            </td>
                            @else
                            <td>
                                <div class="col-md-4 notaAzul">{{number_format($media ,1)}}</div>
                            </td>
                            @endif
                            <td>
                            <center> 
                                <a href="#">
                                    <img src="{{url('imgs/icones/editar.png')}}" data-toggle="modal" data-target="#edita_nota_1mensal_1bim_fun2" 
                                         data-whatever_tb_aluno_idaluno="{{$aluno->idAluno}}"
                                         data-whatever_idnotas="{{$nota->idNotas}}"
                                         data-whatever_nome_aluno="{{$aluno->NomeAluno}}"
                                         data-whatever_am1="{{number_format($nota->AM1 ,1)}}"
                                         data-whatever_ab1="{{number_format($nota->AB1 ,1)}}"
                                         data-whatever_disciplina="{{$disciplina->NomeDisciplina}}"
                                         data-whatever_idusuario="{{data_get(auth()->guard('guardLogin')->user(), 'idUsuario', 1)}}"
                                         >
                                </a>
                            </center>
                            </td>
                            </tr> 










                            @endif <!-- Fecha o if verifica as condições das notas que existem -->





                            @endif<!-- Fecha o if que verifica se existe nota -->
                            @empty <!-- Quando o for for vazio -->
                            <td><center><div class="col-md-4 col-md-offset-4" >                                  
                                    <input type="text" name="AM1[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                                </div>  </center> </td>
                            <td><center><div class="col-md-4 col-md-offset-4" >                                  
                                    <input type="text" name="AB1[{{$key}}]"placeholder="0.00"  class="form-control nota" min="0" max="10" >
                                </div>  </center> </td>
                            <td>
                                <div class="col-md-4 " > - </div> 
                            </td>
                            <td><center> <img src="{{url('imgs/icones/inativo.png')}}" alt="editar"</center></td>
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
<!-- Modal Alteração Nota 1º MENSAL SO -->
<div class="modal fade" id="edita_nota_1mensal_fun2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alteraNota-titulo">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="NomeAluno"></h4>
            </div>
            <div class="modal-body">
                <form class="alteraNota form formularios" action="/coordenacao/editar_nota" method="POST" send="/coordenacao/editar_nota">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}
                    <input type="hidden" name="idNotas" id="idNotas" >
                    <input type="hidden" name="tb_usuario_idUsuario" id="tb_usuario_idUsuario">
                    <input type="hidden" name="tb_aluno_idAluno" id="tb_aluno_idAluno">
                    <div class="row ">
                        <div class="col-md-12 ">
                            <label for="1mensal" id="Disciplina"></label>   
                        </div>  
                        <div class="col-md-2 col-md-offset-5">
                            <input type="text" name="AM1" class="form-control nota" min="0" max="10" id="notaAtual" >
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
<!-- Modal Alteração Nota 1º BIMESTRE SÓ -->
<div class="modal fade" id="edita_nota_1bim_fun2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alteraNota-titulo">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="NomeAluno"></h4>
            </div>
            <div class="modal-body">
                <form class="alteraNota form formularios" action="/coordenacao/editar_nota" method="POST" send="/coordenacao/editar_nota">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}
                    <input type="hidden" name="idNotas" id="idNotas" >
                    <input type="hidden" name="tb_usuario_idUsuario" id="tb_usuario_idUsuario">
                    <input type="hidden" name="tb_aluno_idAluno" id="tb_aluno_idAluno">
                    <div class="row ">
                        <div class="col-md-12 ">
                            <label for="1bim" id="Disciplina"></label>   
                        </div>  
                        <div class="col-md-2 col-md-offset-5">
                            <input type="text" name="AB1" class="form-control nota" min="0" max="10" id="notaAtual" >
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
<!-- Modal Alteração Nota 1º BIMESTRE DA DUAS NOTAS -->
<div class="modal fade" id="edita_nota_1mensal_1bim_fun2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header alteraNota-titulo">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="NomeAluno"></h4>
            </div>
            <div class="modal-body">
                <form class="alteraNota form formularios" action="/coordenacao/editar_nota" method="POST" send="/coordenacao/editar_nota">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}
                    <input type="hidden" name="idNotas" id="idNotas" >
                    <input type="hidden" name="tb_usuario_idUsuario" id="tb_usuario_idUsuario">
                    <input type="hidden" name="tb_aluno_idAluno" id="tb_aluno_idAluno">
                    <div class="col-md-12 ">
                        <label for="1bim" id="Disciplina"></label>   
                    </div> 
                    <div class="row ">


                        <div class="col-md-2 col-md-offset-4" >
                            <div class="form-group">
                                <label for="1MENSAL">MENSAL:</label>
                                <center>
                                    <input type="text" name="AM1" class="form-control nota" min="0" max="10" id="notaAtualMensal" >    
                                </center>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="1BIM">BIMENTRAL:</label>
                                <center>
                                    <input type="text" name="AB1" class="form-control nota" min="0" max="10" id="notaAtualBimestral" >    
                                </center>   
                            </div>
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