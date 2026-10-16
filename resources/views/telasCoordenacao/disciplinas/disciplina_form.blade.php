@extends('layouts.app')  
@section('content')
<div class="titulo-pagina">
    <h1 class="titulo-pagina">{{ $titulo ?? 'Nova Disciplina' }}</h1>

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

        @if(isset($disciplina))
        <form class="form form-search form-Nu formularios" action="/coordenacao/editar_disciplina/{{$disciplina->idDisciplinas}}" method="POST">

            <!--LINHA QUE INFORMA A DISCIPLINA DIGITANTO, ESSA LINHA PERTENCE A CONDIÇÃO DE EDITAR-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="NomeDisciplina">Nome de disciplina:</label>
                        <input type="texto" name="NomeDisciplina" placeholder="Digite o nome da disciplina"  class="form-control" value="{{ $disciplina->NomeDisciplina ?? old('NomeDisciplina') }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <br>
                        <button type="submit" class="btn btn-success">ATUALIZAR</button>
                        <button type="reset" class="btn btn-default"> <a href="/coordenacao/disciplina_inf"> CANCELAR</button>
                    </div>
                </div>
            </div>

            @else
            <form class="form form-search form-Nu formularios" action="/coordenacao/caddisciplina" method="POST" send="/coordenacao/caddisciplina">
                <!--PRIMEIRA LINHA REFERENTE AOS CAMPOS (NOME DA DISCIPLINA INFORMADA DIGITANDO)-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="NomeDisciplina">Nome de disciplina:</label>
                            <input type="texto" name="NomeDisciplina" placeholder="Digite o nome da disciplina"  class="form-control" value="{{ $disciplina->NomeDisciplina ?? old('NomeDisciplina') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <br>
                            <button type="submit" class="btn btn-success">SALVA</button>
                            <button type="reset" class="btn btn-default">LIMPAR</button>
                        </div>
                    </div>
                </div>
                <!--SEGUNDA LINHA ESSE E REFERENTE AS OPÇÕES DO CHECKBOX)-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="disciplinas">Selecione todas as disciplinas:</label> 
                            <input type="checkbox" id="cbgroup1_master" onchange="selecionando(this, 'tudo')">
                        </div>
                    </div>
                </div>

                <div class="linha"></div>

                <!--Terceira linhas, iniciando a linha das disciplinas linha de portugues)-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox1" value="PORTUGUÊS"> PORTUGUÊS
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox2" value="MATEMÁTICA"> MATEMÁTICA
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox3" value="GEOGRAFIA"> GEOGRAFIA
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox4" value="CIÊNCIAS"> CIÊNCIAS
                        </div>
                    </div>
                </div>

                <!--Quarta linhas, segunda linhas de disciplinas)-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox5" value="INGLÊS"> INGLÊS
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox6" value="REDAÇÃO"> REDAÇÃO
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox7" value="ARTES"> ARTES
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox8" value="FÍSICA"> FÍSICA
                        </div>
                    </div>
                </div>
                <!--Quinta linha linhas, terceira linha de disciplinas)-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox9" value="HISTÓRIA"> HISTÓRIA
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox10" value="RELIGIÃO"> RELIGIÃO
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox11" value="LEITURA"> LEITURA
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox12" value="QUIMICA"> QUIMICA
                        </div>
                    </div>
                </div>

                <!--sexta linha , quarta linha de disciplinas)-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox13" value="CALIGRAFIA"> CALIGRAFIA
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox14" value="LITERATURA"> LITERATURA
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox15" value="ED.FÍSICA"> ED.FÍSICA
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox16" value="FILOSOFIA"> FILOSOFIA
                        </div>
                    </div>
                </div>

                <!--setima linha , quinta linha de disciplinas)-->
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox17" value="MATEMÁTICA II"> MATEMÁTICA II
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="checkbox" class="tudo" name="Disciplinas[]" id="checkbox18" value="LITERATURA"> COMPORTAMENTO
                        </div>
                    </div>

                </div>

                @endif 
                {!! csrf_field() !!} 



            </form> <!--Fim do formulario-->
    </div>
</div> <!--Fim do caminho-din-->



@endsection
