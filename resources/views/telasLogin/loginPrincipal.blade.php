@extends('telasLogin.index')                            
@section('form')  

<div class="alert-danger error error-danger" style="display: none;"></div>

<form class="form-login" method="POST" action="{{ url('/login') }}"  >
    {!!csrf_field()!!}

    
    
    
    <div class="login-form">
        <h1>Login</h1>

        <!-- Erro de login, Senha ou RA digitados errados -->
        <div>
            @if ($errors->has('ERRO-LOGIN'))<div class="alert-danger error error-danger"><strong>{{ $errors->first('ERRO-LOGIN') }}</strong> </div> @endif
        </div>
        <!-- Messagem de Inativo, quando o aluno estive inativo -->
        <div>
            @if ($errors->has('Inativo'))<div class="alert-danger error error-danger"><strong>{{ $errors->first('Inativo') }}</strong> </div> @endif
        </div>
        <div>
            @if ($errors->has('SEMPERMISSOES'))<div class="alert-danger error error-danger"><strong>{{ $errors->first('SEMPERMISSOES') }}</strong> </div> @endif
        </div>

        <!--Conjunto de Formulario do campo CPF -->
        <div class="form-group{{ $errors->has('CPF') ? ' has-error' : '' }}">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <input type="text" name="CPF" class="form-control" id="CPF" placeholder="CPF" value="{{old('CPF')}}">
                </div>
                @if ($errors->has('CPF'))<div class="alert-danger error error-danger"><strong>{{ $errors->first('CPF') }}</strong> </div> @endif
            </div>         
            <!--Conjunto de Formulario do campo Senha -->
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-expeditedssl" aria-hidden="true"></i>
                        </div>
                        <input type="password" name="password" class="form-control" id="SENHA" placeholder="SENHA">
                    </div>
                    @if ($errors->has('password'))<div class="alert-danger error error-danger"><strong>{{ $errors->first('password') }}</strong> </div> @endif
                </div>
                <!--Botão Entrar -->
                <input type="submit" name="btn-entrar" value="Entrar"  class="btn-padrao"> 
            </form>
@endsection  