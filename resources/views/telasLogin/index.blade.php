<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
        <title>Login | Maruge</title>
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
        <!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <!--CSS EscolaOnline-->
        <link rel="stylesheet" type="text/css" href="{{asset('css/login.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/responsivo.css')}}">
        <!-- Jquery Local-->
        <script src="{{asset('css/jquery-3.0.0.js')}}" ></script>
    </head>
    <body class="bg-padrao-login">
        <header><h1 class="oculta">Login | Maruge</h1></header>
        <section class="login">

            <img src="{{ \App\Support\LogoColegio::src() }}" alt="" height="130" width="140" class="bg-efeito-bordas">

            <div class="conteudo-login">

                @yield('form')

            </div>
        </section>
        <div class="login" > Desenvolvido por: 
            <a href="http://maruge.com.br"> Maruge - Sistema de Gestão Escolar</a></div>

        <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('jquery/jquery.mask.min.js')}}" ></script>
        @yield('script-messagem')
        <script>
$(function () {
    /*Mascaras do para o CPF do Login*/
    jQuery('#CPF').mask('000.000.000-00');
    jQuery('#SENHA').mask('########');
    jQuery('#RA').mask('########');

});
        </script>

    </body>
</html>