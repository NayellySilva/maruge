@extends('telasCoordenacao.painel')  
@section('conteudo')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{ $titulo ?? 'Nova Turma' }}</h1>

</div> 
<div class="caminho-din">
    <div class="preloader" style="display: none"> Enviando os dados...</div>  
    <div class="alert alert-success msg-exito" role="alert" style="display: none"></div>
    <div class="alert alert-warning msg-erro" role="alert" style="display: none"></div> 

    <div class="formularios">    
        @if(count($errors)>0)
        @foreach($errors->all() as $error)
        {{$error}}
        @endforeach
        @endif
        @if(isset($turma))
        <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/turma_editar/{{$turma->idTurmas}}" method="POST">


            @else
            <form class="form form-search form-Nu formularios" action="/maruge/public/coordenacao/turma_cad" method="POST" send="/maruge/public/coordenacao/turma_cad">
                @endif 


                {!! csrf_field() !!}
                <!--PRIMEIRA LINHA REFERENTE A TODOS OS CAMPOS REFERENTE A TURMA-->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="NomeEscola">Nome da Turma:</label>
                            <input type="texto" name="NomeTurma" placeholder="Nome da Turma"  class="form-control" value="{{$turma->NomeTurma or old('NomeTurma')}}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="Mensalidade">Valor da Mensalidade:</label>
                            <input type="texto" name="Mensalidade" placeholder="R$ 0,00" id="Mensalidade" class="form-control" value="{{$turma->Mensalidade or old('Mensalidade')}}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Situacao">Situação:</label>
                            <select class="form-control" name="SituacaoTurma" id="estado">
                                <option >{{$turma->SituacaoTurma or old('SituacaoTurma')}}</option>
                                <option> ATIVO </option>
                                <option> INATIVO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="AnoLetivo">Ano Letivo:</label>
                            <select class="form-control" name="AnoLetivo" id="estado">
                                <option >{{$turma->AnoLetivo or old('AnoLetivo')}}</option>
                                <option> 2017 </option>
                                <option> 2018 </option>
                                <option> 2019</option>
                                <option> 2020</option>
                                <option> 2021</option>
                                <option> 2022</option>
                                <option> 2023</option>
                                <option> 2024</option>
                                <option> 2025</option>
                                <option> 2026</option>
                            </select>
                        </div>
                    </div>
                </div>
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
@endsection