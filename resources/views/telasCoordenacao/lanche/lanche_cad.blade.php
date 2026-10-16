@extends('layouts.app')  
@section('content')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{ $titulo ?? 'Novo Lanche' }}</h1>

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
        @if(isset($lanche))
        <form class="form form-search form-Nu formularios" action="/coordenacao/lanche_editar/{{$lanche->idlanche}}" method="POST">
        @else
            <form class="form form-search form-Nu formularios" action="/coordenacao/lanche_cad" method="POST" send="/coordenacao/lanche_cad">
            @endif 
                {!! csrf_field() !!}
                <!--PRIMEIRA LINHA REFERENTE A TODOS OS CAMPOS REFERENTE AO LANCHE-->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="NomedoLanche">Nome do Lanche (Produto):</label>
                            <input type="texto" name="NomeLanche" placeholder="Nome do Lanche"  class="form-control" value="{{ $lanche->NomeLanche ?? old('NomeLanche') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ValorLanche">Valor:</label>
                            <input type="texto" name="ValorLanche" placeholder="R$ 0,00" id="Mensalidade" class="form-control" value="{{ $lanche->ValorLanche ?? old('ValorLanche') }}">
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