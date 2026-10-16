@extends('layouts.app')  
@section('content')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{ $titulo ?? 'Nova Aula' }}</h1>

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

        @if(isset($aula))
        <form class="form form-search form-Nu formularios" action="/coordenacao/aula_editar/{{$aula->idAula}}" method="POST">
            @else
            <form class="form form-search form-Nu formularios" action="/coordenacao/aula_cad" method="POST" send="/coordenacao/aula_cad">
                @endif 
                {!! csrf_field() !!}
                <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (nome funcionário - cpf - rg - função )-->
                
                
                
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="Link da Aula">Aula:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-video-camera" aria-hidden="true"></i>
                                </div>
                                <!--
                                <input type="text" name="aula" id="aula" class="form-control" placeholder="Link da Aula" value="{{old('aula')}}">
                          -->
                          <textarea  class="form-control ajuste" rows="1" type="text" name="aula">{{ $aula->aula ?? old('') }}</textarea>
                                </div>
                        </div>

                        
                        
                        
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="data da Aula">Data:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                              
                                <input type="date" name="data_aula" class="form-control"  value="{{ $aula->data_aula ?? old('') }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="idTurma">Turma:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-users" aria-hidden="true"></i>
                                </div>
                                <div class="relative">
                                    <select class="w-full h-11 appearance-none bg-white border border-[#e3e8e6] rounded-xl px-4 pr-10 text-sm text-[#0a241e] focus:outline-none focus:border-[#008a4b] focus:ring-2 focus:ring-[#008a4b]/10 cursor-pointer transition-all" name="tb_turmas_idTurmas">
                                        @if(isset($aula))
                                            <option value="" disabled selected>Selecione a Turma</option>
                                            @forelse($turmas as $turma) 
                                                <option value="{{$turma->idTurmas}}">{{ $turma->NomeTurma ?? old('') }}</option>
                                            @empty
                                            @endforelse 
                                        @else 
                                            <option value="" disabled selected>Selecione a Turma</option>
                                            @forelse($turmas as $turma)  
                                                <option value="{{$turma->idTurmas}}">{{$turma->NomeTurma}}</option>
                                            @empty
                                            @endforelse 
                                        @endif
                                    </select>
                                    <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-[#95aba5] pointer-events-none"></i>
                                </div>
                                
                                
                                
                                
                       
                                
                                
                                
                                
                                
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Linha de Comentário -->
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="ObsAula" >Comentário da Aula</label>
                            <textarea  class="form-control ajuste" rows="8" type="text" name="ObsAula" maxlength="1000">{{ $aula->ObsAula ?? old('') }}</textarea>

                        </div>
                    </div>
                    <!-- LINHA REFERENTE AOS CAMPOS ( SALVA E LIMPA )-->

                    <div class="col-md-12">
                        <div class="form-group">
                            <br>
                            <button type="reset" class="btn btn-default"> LIMPAR</button> 
                            <button type="submit" class="btn btn-success"> SALVAR</button>

                        </div>
                    </div>   
                </div>


            </form> <!--Fim do formulario-->
    </div>
</div> <!--Fim do caminho-din-->
@endsection