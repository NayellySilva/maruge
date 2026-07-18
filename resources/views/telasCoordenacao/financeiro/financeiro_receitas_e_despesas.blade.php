@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-endereco">
    <a href="#">
        Financeiro / Receitas e Despesas  
    </a>
</div>


<div class="caminho-din">

    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <strong>Cadastrar</strong>  
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <center> 
                        <a href="#modalDespesa" data-toggle="modal" data-target="#modal_receita" role="button" type="button" class="btn btn-success hidden-sm hidden-xs"><i class="fa fa-plus"></i>  RECEITA</a>
                        <a href="#modalDespesa" data-toggle="modal" data-target="#modal_categoria" role="button" type="button" class="btn btn-warning hidden-sm hidden-xs"><i class="fa fa-plus"></i>  CATEGORIA</a>
                        <a href="#modalDespesa" data-toggle="modal" role="button" class="btn btn-danger hidden-sm hidden-xs"><i class="fa fa-plus"></i>  DESPESA</a>
                    </center>
                    <!-- / Armazenando os nomes do professores correspondentes a sua disciplina -->
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>    
        <!-- /.panel -->
    </div>
    <div class="col-lg-9">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <strong>Relatórios</strong>  
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <center> 
                        <div class="btn-toolbar">
                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas a receber</a>
                            <a href="#btn-report" class="btn btn-default hidden-sm hidden-xs" id="btn-report"><i class="fa fa-print"></i> Relatório contas a pagar</a>
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


    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <strong>Parâmetros da Consulta</strong>  
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">

                    <div class="btn-toolbar">
                        <form class="form-search pesquisar" method="POST" action="/maruge/public/coordenacao/financeiro_contas_pagar_pesq">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="SituacaoAluno ">Descrição:</label>
                                    {!! csrf_field() !!}
                                    <input type="texto" name="codbarras" placeholder="Localizar Título"  class="form-control"> </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="EstadoCartorio">Exibir:</label>
                                    <select class="form-control" name="EstadoCartorio" >
                                        <option ></option>
                                        <option> Todas </option>
                                        <option> Receitas</option>
                                        <option> Despesas</option>
                                        <option> Previsto</option>
                                        <option> Realizado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="EstadoCartorio">Categoria:</label>
                                    <select class="form-control" name="EstadoCartorio" >
                                        <option ></option>
                                        <option> Todas </option>
                                        <option> Receitas</option>
                                        <option> Despesas</option>
                                        <option> Previsto</option>
                                        <option> Realizado</option>
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

                    </div>

                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>    
        <!-- /.panel -->
    </div>



    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading ">
                <strong>Resultado da Consulta</strong>  
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <center> 

                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td colspan="2">Larry the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>



                    </center>

                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>    
        <!-- /.panel -->
    </div>
</div> <!--Fim do caminho-din-->


<!-- Modal de Receita -->
<div class="modal fade" id="modal_receita" tabindex="-2" role="dialog" aria-labelledby="exampleModalScrollableTitle">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content ">
            <div class="modal-header modal_Receita">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal_Receita"><i class="fa fa-plus">  NOVA RECEITA </i></h4>
            </div>
            <div class="modal-body"> 
                <form action="/maruge/public/coordenacao/financeiro_criando_receita" method="POST" send="/maruge/public/coordenacao/financeiro_criando_receita">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}

                    <!--  
                    <input type="hidden" name="NomeAluno"id="nomealuno">
                    <input type="hidden" name="NomeTurma" id="nometurma">
                    <input type="hidden" name="Meses" id="meses">
                    <input type="hidden" name="codbarras" id="codbarras" >
                    <input type="hidden" name="parcelas" id="parcelas">
                    <input type="hidden" name="Ano_Letivo" id="ano_letivo">
                    <input type="hidden" name="Mensalidade" id="mensalidade">
                    <input type="hidden" name="Carteira" id="carteira">
                    <input type="hidden" name="Acordo" id="acordo">
                    <input type="hidden" name="Data_venc" id="data_venc">
                    <input type="hidden" name="data_pagamento" id="data_pagamento">
                    <input type="hidden" name="idcarne" id="idcarne">
                    -->
                    <!-- Linha do campo Descrição-->
                    <div class="row ">
                        <dt class="frequencia-gabarito"></dt><br>
                        <div class="col-md-2">
                            <label>DESCRIÇÃO*:</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="NomeReceita"  id="NomeReceita" class="form-control" >
                        </div>
                    </div>

                    <!-- Linha do campo CATEGORIA-->
                    <div class="row ">
                        <dt class="frequencia-gabarito"></dt><br>
                        <div class="col-md-2">
                            <label>CATEGORIA*:</label>
                        </div>
                        <div class="col-md-10">
                            <select class="form-control" name="tb_categoria_idCategoria">
                                        @if(isset($categorias))
                                        <option ></option>   
                                        @forelse($categorias as $categoria) 
                                        <option value="{{$categoria->idCategoria}}">{{$categoria->NomeCategoria or old('')}}</option>
                                        @empty
                                        @endforelse 
                                        <!--Fim do laço da turma para editar-->
                                        @else 
                                        <option></option>
                                        <!-- condição para cadastrar-->
                                        @forelse($categorias as $categoria)  
                                        <option value="{{$categoria->idCategoria}}">{{$categoria->NomeCategoria}}</option>
                                        @empty
                                        @endforelse 
                                        @endif
                                    </select>
                        </div>
                    </div>

                    
                    <!-- Linha do campo Data da Recebimento-->
                    <div class="row ">
                        <dt class="frequencia-gabarito"></dt><br>
                        <div class="col-md-5">
                            <label>DATA DE RECEBIMENTO*:</label>
                        </div>
                        <div class="col-md-7">
                            <input type="date" name="DataReceita"  id="DataReceita" class="form-control" >
                        </div>
                    </div>

                    <!-- Linha do campo valor da receita-->
                    <div class="row ">
                        <dt class="frequencia-gabarito"></dt><br>
                        <div class="col-md-2">
                            <label>VALOR*:</label>
                        </div>
                        <div class="col-md-10 ">
                            <input type="text" name="ReceitaValor" placeholder="R$ 0,00" id="ReceitaValor" class="form-control" >
                        </div>
                    </div>
                    <br>
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#maisopcoes" role="button" aria-expanded="false" aria-controls="collapseExample">
                            (+) Exibir mais opções
                        </a>
                    </p>
                    <!-- Linha do dados de pagamento-->
                    <div class="collapse" id="maisopcoes">
                        <div class="card card-body">
                            <div class="row ">
                                <dt class="frequencia-gabarito"></dt><br>
                                <div class="col-md-3">
                                    <label> PAGAMENTO:</label>
                                </div>
                                <div class="col-md-9">
                                    <label >
                                        <input type="radio" name="StatusReceita" value="realizado"> Pagamento realizado</label> &nbsp; &nbsp;&nbsp;
                                    <label>
                                        <input type="radio" name="StatusReceita" checked="" value="previsto"> Ainda não foi realizado</label>
                                </div>
                            </div>
                            <div class="row ">
                                <dt class="frequencia-gabarito"></dt>
                                <div class="col-md-12">
                                    <label for="message-text" class="col-form-label">OBSERVAÇÕES:</label>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control" rows="4" type="text" name="ObsReceita" maxlength="2000" ></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="row ">
                                <dt class="frequencia-gabarito"></dt>
                                <div class="col-md-12">
                                    <label for="message-text" class="col-form-label">ANEXO:</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="imgReceita" class="form-control"
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-success"   >SALVAR</button>
            </div>
            </form>
        </div>
    </div>
</div>          
</div>



<!-- Modal de Categoria -->
<div class="modal fade" id="modal_categoria" tabindex="-2" role="dialog" aria-labelledby="exampleModalScrollableTitle">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content ">
            <div class="modal-header modal_Categoria">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal_Categoria"><i class="fa fa-plus"> NOVA CATEGORIA </i></h4>
            </div>
            <div class="modal-body"> 
                <form class="alteraNota form formularios" action="/maruge/public/coordenacao/financeiro_criando_categoria" method="POST" send="/maruge/public/coordenacao/financeiro_criando_categoria">
                    <div class="preloader" style="display: none"> Enviando os dados...</div>  
                    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
                    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 
                    {!! csrf_field() !!}
                    <!--  
                    <input type="hidden" name="NomeAluno"id="NomeCategoria">
                    -->
                    <!-- Linha do campo Descrição-->
                    <div class="row ">
                        <dt class="frequencia-gabarito"></dt><br>
                        <div class="col-md-2">
                            <label>CATEGORIA*:</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="NomeCategoria"  id="NomeCategoria" class="form-control" >
                        </div>
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">CANCELAR</button>
                <button type="submit" class="btn btn-success"   >SALVAR</button>
            </div>
            </form>
        </div>
    </div>
</div>          
</div>


@endsection