@extends('telasLogin.index')                               
@section('form')  
 <!-- tests -->
<div class="alert-danger error error-danger" style="display: none;"></div>
<form class="form-login" method="POST" action="{{ url('/loginaluno') }}"  >
    {!!csrf_field()!!}
    <div class="login-form">
        <h1>Login - Aluno</h1>
        <!-- Erro de login, Senha ou RA digitados errados -->
        <div>
            @if ($errors->has('ERRO-LOGIN'))<div class="alert-danger error error-danger"><strong>{{ $errors->first('ERRO-LOGIN') }}</strong> </div> @endif
        </div>
        <!-- Messagem de Inativo, quando o aluno estive inativo -->
        <div>
            @if ($errors->has('Inativo'))<div class="alert-danger error error-danger"><strong>{{ $errors->first('Inativo') }}</strong> </div> @endif
        </div>

        <!--Conjunto de Formulario do campo RA -->
        <div class="form-group{{ $errors->has('RA') ? ' has-error' : '' }}">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <input type="text" name="RA" class="form-control" id="RA" placeholder="RA" value="{{old('RA')}}">
                </div>
                @if ($errors->has('RA'))<div class="alert-danger error error-danger"><strong>{{ $errors->first('RA') }}</strong> </div> @endif
            </div>         

            <!--Conjunto de Formulario do campo RA -->
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
                <input type="submit" name="btn-entrar" value="Entrar" class="btn-padrao">
           
            </div>
            </form>
            @endsection  