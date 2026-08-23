@extends('layouts.app')  
@section('content')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{$titulo}}</h1>
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
        @if(isset($usuario))
        <form class="form form-search form-Nu formularios" action="/coordenacao/usuario_editar/{{$usuario->idUsuario}}" method="POST">
      
            <div class="row"> 
                        <!--PRIMEIRA LINHA REPRESENTANDO TODOS OS CAMPOS NECESSARIOS PARA CADASTRAR UM NOVO USUARIO-->
                                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="NomeUsuario">Nome do Usuario:</label>
                            <input  type="hidden" class="form-control" name="Usuario" value="{{$funcionario->NomeFuncionario}}"> 
                            <input  class="form-control" name="Usuario" disabled="disabled" value="{{$funcionario->NomeFuncionario}}"> 
                            
                        </div>
                    </div>
            
            @else
            <form class="form form-search form-Nu formularios" action="/coordenacao/usuario_cad" method="POST" send="/coordenacao/usuario_cad">
                             <!--PRIMEIRA LINHA REPRESENTANDO TODOS OS CAMPOS NECESSARIOS PARA CADASTRAR UM NOVO USUARIO-->
                                 
                              <div class="row"> 
                             <div class="col-md-5">
                        <div class="form-group">
                            <label for="Usuario">Selecione o novo Usuário:</label>
                            <div class="relative">
                                <select name="Usuario" id="Usuario" class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all" required>
                                    <option value="" disabled selected>Selecione o Usuário</option>
                                    @foreach($funcionarios as $f)
                                        <option value="{{ $f->idFuncionarios }}">{{ $f->NomeFuncionario }}</option>
                                    @endforeach
                                </select>
                                <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                   @endif 
                {!! csrf_field() !!}

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="password">Senha de Usuário:</label>
                            <input type="password" placeholder="Senha só números" name="password" class="form-control" maxlength="8">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Situacao">Situação:</label>
                            <div class="relative">
                                <select name="Situacao" id="Situacao" class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all" required>
                                    <option value="" disabled selected>Selecione</option>
                                    <option value="ATIVO">ATIVO</option>
                                    <option value="INATIVO">INATIVO</option>
                                </select>
                                <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="Nivel">Nível:</label>
                            <div class="relative">
                                <select name="Nivel" id="Nivel" class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all" required>
                                    <option value="" disabled selected>Selecione o Nível</option>
                                    <option value="COORDENACÃO">COORDENACÃO</option>
                                    <option value="DOCENTE">DOCENTE</option>
                                </select>
                                <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"></i>
                            </div>
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