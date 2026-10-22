<!DOCTYPE html>
<html lang="pt-br" class="index-geral">
    <head>
        <title>	{{$titulo or 'Maruge Docente'}}</title>
    </head>
    <body class="index-geral" >
        <!-- CSS compilada e minificada on-line do bootstrap-->
        <link href="{{url('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
        <!--CSS Personalizado para o Painel-->
        <link rel="stylesheet" href="{{asset('css/painel.css')}}">
        <!-- CSS - Para fazer Reset nos Paineis-->
        <link rel="stylesheet" href="{{asset('css/reset.css')}}">       
        <!-- favicon-->
        <link rel="stylesheet" href="{{asset('imgs/favicon.png')}}">     
        <!-- Jquery Local-->
        <script src="{{asset('css/jquery-3.0.0.js')}}" ></script>

        <div class="logo" >
            <img src="{{asset('imgs/logo-Painel.png')}}" alt="Maruge Sistema de GestÃ£o Escolar" class="logo-painel">
            <div class="perfil">
                <div class="dropdown usuario-drop">
                    <div class=" dropdown-toggle ajustedrop"  id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <p class="nomeUsuario">
                    @php
                    $dadosUsuario = \App\Models\modelCoordenacao\tb_usuario::infUsuario(auth()->guard('guardLogin')->user()->CPFUsuario);
                    @endphp  
                        @foreach($dadosUsuario as $usuario )
                        Olá, {{ $usuario->NomeFuncionario}}                                          
                        @endforeach
    <span class="caret"></span>
                    </div>
                    <ul class="dropdown-menu drop" aria-labelledby="dropdownMenu1">
                        <li>
                            <a href="{{url("/docente/funcionario_perfil/$usuario->idFuncionarios")}}" >Perfil</a></li>
                        <li><a href="/maruge/public/logout">Sair</a></li>
                    </ul>
                </div>
            </div> <!--Fim perfil-->
        </div> <!--Fim logo-->
        <section class="menu">
            <div class="descricao-menu">Painel Docente</div>
            <div class="lista-menu">
                <ul class="menu-lista">
                    <li>
                        <a href="/maruge/public/docente">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            HOME
                        </a>
                    </li>
                  
                    <li>
                        <a href="/maruge/public/docente/secretaria">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            SECRETARIA
                        </a>
                    </li>
                    <li>
                        <a href="/maruge/public/docente/relatorios">
                            <i class="fa fa-list" aria-hidden="true"></i>
                            RELATÓRIOS
                        </a>
                    </li>
                    <li>
                        <a href="/maruge/public/docente/ajuda">
                            <i class="fa fa-question-circle" aria-hidden="true"></i>
                            AJUDA
                        </a>
                    </li>
                </ul>
            </div>
        </section> <!-- FIM DO MENU -->

        <section class="conteudo">

            <div class="infPagina">

         
               @yield('conteudo')
            </div> <!-- fim infPagina-->
        </section> <!-- FIM conteudo -->
        <!-- jQuery (obrigatÃ³rio para plugins JavaScript do Bootstrap) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessÃ¡rio -->
       
         
         <script src="{{asset('js/bootstrap.min.js')}}" ></script>
        <script src="{{asset('jquery/jquery.mask.min.js')}}" ></script>
        <script src="{{asset('jquery/jquery.PrintArea.js')}}" ></script>
         
         
         
        <script>
            
            
/*Ajax para salva os dados dos fomularios*/
$(function () {
    jQuery("form.formularios").submit(function () {
        jQuery("msg-erro").hide();
        jQuery("msg-exito").hide();
        var dadosForm = jQuery(this).serialize();
        jQuery.ajax({
            url: jQuery(this).attr("send"),
            data: dadosForm,
            type: "POST",
            beforeSend: preloader()
        }).done(function (data) {
            Fimpreloader();
// Quando os cadastros de qualquer formularios for realizado com sucesso deverá retorna 1
            if (data == "1") {
                jQuery(".msg-exito").html("Cadastro realizado com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.reload()", 2500);
                /*Codição se ja existir uma escola cadastrada*/
            } else if (data == "escolaExistente") {
                jQuery(".msg-erro").html("Desculpa já existe uma escola cadastrada !");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2500);
                /*Codição quando atualização da escola for realizada*/
            } else if (data == "EscolaAtualizada") {
                jQuery(".msg-exito").html("Escola atualizada com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/maruge/public/coordenacao/escola_inf';", 2500);
            }
            /*Codição quando atualização do aluno for realizada*/
            else if (data == "AlunoAtualizado") {
                jQuery(".msg-exito").html("Aluno atualizado com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/maruge/public/coordenacao/aluno_inf';", 2500);
            }
            /*Codição quando atualização do aluno for realizada*/
            else if (data == "AlunoTransferido") {
                jQuery(".msg-exito").html("Aluno transferido com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/maruge/public/coordenacao/aluno_inf';", 2500);
            }
            /*Codição se não informar o nome da disciplina*/
            else if (data == "DesciplinaNaoinformada") {
                jQuery(".msg-erro").html("Nenhuma disciplina informada!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.href ='/maruge/public/coordenacao/disciplina_cad';", 2000);
                /*Codição se não informar o nome da disciplina para update*/
            }
            /*Aluno Já existente*/
            else if (data == "alunojacadastrado") {
                jQuery(".msg-erro").html("Desculpe, Aluno já cadastrado");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.href ='/maruge/public/coordenacao/aluno_cad';", 2000);

            } else if (data == "novaDesciplinaNaoinformada") {
                jQuery(".msg-erro").html("Nenhuma disciplina informada!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2000);
                /*Codição se o update da disciplina for realizada com sucesso*/
            } else if (data == "disciplinaatualizada") {
                jQuery(".msg-exito").html("Disciplina atualizada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/maruge/public/coordenacao/disciplina_inf';", 2000);
                /*Codição se não informar 2 campos ao mesmo tempo*/
            } else if (data == "2campos") {
                jQuery(".msg-erro").html("Não é possivel digitar e selecionar disciplinas, por favor digite ou selecioner a disciplina!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2500);
                // Turma atualizada com sucesso
            } else if (data == "turmaatualizada") {
                jQuery(".msg-exito").html("Turma atualizada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/maruge/public/coordenacao/turma_inf';", 2000);

            }// lançamento de nota com sucesso
            else if (data == "notalancada") {
                $(this).attr('href');
                jQuery(".msg-exito").html("Nota cadastrada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.reload($(this).attr('href'))", 3000);
            } else if (data == "notaNaoInformada") {
                jQuery(".msg-erro").html("Desculpa mas nenhuma nota foi informada !");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2500);

            }
            /*Codição funcionario atualizado com sucesso*/
            else if (data == "FuncionarioAtualizado") {
                jQuery(".msg-exito").html("Funcionário atualizado com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/maruge/public/coordenacao/funcionario_inf';", 2000);
            }
            /*Codição para atualiza nota com sucesso*/
            else if (data == "notaAtualizada") {
                jQuery(".msg-exito").html("A nota foi atualizada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.reload($(this).attr('href'))", 3000);
            }
   /*Codição funcionario atualizado com sucesso*/
            else if (data == "UsuarioAtualizado") {
                jQuery(".msg-exito").html("Usuário atualizado com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/maruge/public/coordenacao/usuario_inf';", 2000);
            }

            /*Codição que da um retorno de algum erro espercifico ex: campos invalidos */
            else {
                jQuery(".msg-erro").html(data);
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 79000);
            }
            /*Metodo quando alguma operação for barrada por algum motivo da aplicação ex: não achar o banco de dados*/
        }).fail(function () {
            Fimpreloader();
            alert("Falha ao cadastrar os dados !");
            setTimeout("location.reload();", 1000);
        });
        return false;
    });
});
/*Preloader que comunica que os dados estão sendo enviados*/
function preloader() {
    jQuery(".preloader").show();
}
function Fimpreloader() {
    jQuery("preloader").hide();
}
/*Conjuto de mascaras para todos os formularios basta add o que for necessarios*/
$(function () {
    /*Mascaras do formulario cadastras escola*/
    jQuery("#CEP").mask("00000-000");
    jQuery('#Fone1').mask('(00) 0000-0000');
    jQuery('#Fone2').mask('(00) 0.0000-0000');
    jQuery('#CNPJ').mask('00.000.000/0000-00', {reverse: true});
    /*Mascaras do formulario cadastrar turma*/
    jQuery('#Mensalidade').mask("#.##0,00", {reverse: true});
    /*Mascaras do formulario cadastrar novo aluno guia Dados Alunos*/
    jQuery('#ValorPGTO').mask("#.##0,00", {reverse: true});
    jQuery('#DataNascimento').mask("##/##/####", {reverse: true});
    jQuery('#DataMatricula').mask("##/##/####", {reverse: true});
    jQuery('#DataEmissao').mask("##/##/####", {reverse: true});
    jQuery('#NumeroRGNovo').mask("######.##.##.####.#.#####.###.#######.##", {reverse: true});
    /*Mascaras do formulario cadastrar novo aluno guia Dados Pais*/
    jQuery('#FonePai1').mask('(00) 0.0000-0000');
    jQuery('#FonePai2').mask('(00) 0.0000-0000');
    jQuery('#CPFPai').mask('000.000.000-00');
    jQuery('#CPFMae').mask('000.000.000-00');
    jQuery('#CPFResponsavel').mask('000.000.000-00');
    jQuery('#FoneMae1').mask('(00) 0.0000-0000');
    jQuery('#FoneMae2').mask('(00) 0.0000-0000');
    /*Mascaras do formulario cadastrar novo aluno guia Dados Endereço*/
    jQuery('#CEP').mask("00000-000");
    jQuery('#tel-fixo').mask('(00) 0000-0000');
    /*Mascaras do formulario cadastrar novo funcionario*/
    jQuery('#CPFFuncionario').mask('000.000.000-00');
    jQuery('#Salario').mask("#.##0,00", {reverse: true});
    /*Mascaras para o forme de transferir */
    jQuery('#DataSaida').mask("##/##/####", {reverse: true});
    /*Mascara de notas*/
    jQuery('#nota').mask("#.##", {reverse: true});
});
/*Script para deixa todos os campos do tipo input em maisculos*/
$(document).ready(function () {
    $("input").keyup(function () {
        $(this).val($(this).val().toUpperCase());
    })
})

/*Script para selecionar todos od campos checkbox da pagina disciplina*/
function selecionando(master, group) {
    var cbarray = document.getElementsByClassName(group);
    for (var i = 0; i < cbarray.length; i++) {
        var cb = document.getElementById(cbarray[i].id);
        cb.checked = master.checked;
    }
}
/* Script para mascarar os campo de nota de 0 a 10 */
var notas = document.getElementsByClassName("nota");
var onNotaInput = function (event) {
    var regexp = new RegExp("[^0-9]", "g");
    var value = event.target.value.replace(regexp, "");
    value = parseInt(value) / 10;
    if (value >= event.target.min && value <= event.target.max) {
        event.target.dataset.value = value;
    } else {
        value = parseFloat(event.target.dataset.value);
    }
    if (isNaN(value)) {
        value = 0;
    }
    event.target.value = value.toFixed(1);
};
[].forEach.call(notas, function (nota) {
    nota.addEventListener("input", onNotaInput);
});

/* Script para edita nota modal_1bim_inf */
$('#edita_nota_1bim_inf').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB1 = button.data('whatever_ab1');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('1º BIM: ' + Disciplina);
    modal.find('#notaAtual').val(AB1);
    });
/* Script para edita nota modal_2bim_inf */
$('#edita_nota_2bim_inf').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB2 = button.data('whatever_ab2');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('2º BIM: ' + Disciplina);
    modal.find('#notaAtual').val(AB2);
    });
/* Script para edita nota modal_3bim_inf */
$('#edita_nota_3bim_inf').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB3 = button.data('whatever_ab3');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('3º BIM: ' + Disciplina);
    modal.find('#notaAtual').val(AB3);
    });
/* Script para edita nota modal_4bim_inf */
$('#edita_nota_4bim_inf').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB4 = button.data('whatever_ab4');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('4º BIM: ' + Disciplina);
    modal.find('#notaAtual').val(AB4);
    });
/* Script para edita nota modal_1bim_fun1 */
$('#edita_nota_1bim_fun1').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB1 = button.data('whatever_ab1');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('1º BIM: ' + Disciplina);
    modal.find('#notaAtual').val(AB1);
    });
/* Script para edita nota modal_2bim_fun1 */
$('#edita_nota_2bim_fun1').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB2 = button.data('whatever_ab2');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('2º BIM: ' + Disciplina);
    modal.find('#notaAtual').val(AB2);
    });
/* Script para edita nota modal_3bim_fun1 */
$('#edita_nota_3bim_fun1').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB3 = button.data('whatever_ab3');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('3º BIM: ' + Disciplina);
    modal.find('#notaAtual').val(AB3);
    });
/* Script para edita nota modal_4bim_fun1 */
$('#edita_nota_4bim_fun1').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB4 = button.data('whatever_ab4');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('4º BIM: ' + Disciplina);
    modal.find('#notaAtual').val(AB4);
    });
/* Script para edita nota modal_mensal_fun2 1 bim */
$('#edita_nota_1mensal_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AM1 = button.data('whatever_am1');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('1º MENSAL: ' + Disciplina);
    modal.find('#notaAtual').val(AM1);
    });
/* Script para edita nota modal_bimestral_fun2  1 bim*/
$('#edita_nota_1bim_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB1 = button.data('whatever_ab1');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('1º BIM.: ' + Disciplina);
    modal.find('#notaAtual').val(AB1);
    });
/* Script para edita nota modal as duas notas 1bim */
$('#edita_nota_1mensal_1bim_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AM1 = button.data('whatever_am1');
    var AB1 = button.data('whatever_ab1');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('1º MENSAL E BIMESTRAL: ' + Disciplina);
    modal.find('#notaAtualMensal').val(AM1);
    modal.find('#notaAtualBimestral').val(AB1);
    });
    
/* Script para edita nota modal_mensal_fun2 2 bim */
$('#edita_nota_2mensal_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AM2 = button.data('whatever_am2');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('2º MENSAL: ' + Disciplina);
    modal.find('#notaAtual').val(AM2);
    });
/* Script para edita nota modal_bimestral_fun2  2 bim*/
$('#edita_nota_2bim_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB2 = button.data('whatever_ab2');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('2º BIM.: ' + Disciplina);
    modal.find('#notaAtual').val(AB2);
    });
/* Script para edita nota modal as duas notas 2bim */
$('#edita_nota_2mensal_2bim_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AM2 = button.data('whatever_am2');
    var AB2 = button.data('whatever_ab2');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('2º MENSAL E BIMESTRAL: ' + Disciplina);
    modal.find('#notaAtualMensal').val(AM2);
    modal.find('#notaAtualBimestral').val(AB2);
    });
    
/* Script para edita nota modal_mensal_fun2 3 bim */
$('#edita_nota_3mensal_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AM3 = button.data('whatever_am3');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('3º MENSAL: ' + Disciplina);
    modal.find('#notaAtual').val(AM3);
    });
/* Script para edita nota modal_bimestral_fun2  3 bim*/
$('#edita_nota_3bim_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB3 = button.data('whatever_ab3');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('3º BIM.: ' + Disciplina);
    modal.find('#notaAtual').val(AB3);
    });
/* Script para edita nota modal as duas notas 3bim */
$('#edita_nota_3mensal_3bim_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AM3 = button.data('whatever_am3');
    var AB3 = button.data('whatever_ab3');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('3º MENSAL E BIMESTRAL: ' + Disciplina);
    modal.find('#notaAtualMensal').val(AM3);
    modal.find('#notaAtualBimestral').val(AB3);
    });
    
/* Script para edita nota modal_mensal_fun2 4 bim */
$('#edita_nota_4mensal_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AM4 = button.data('whatever_am4');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('4º MENSAL: ' + Disciplina);
    modal.find('#notaAtual').val(AM4);
    });
/* Script para edita nota modal_bimestral_fun2  4 bim*/
$('#edita_nota_4bim_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AB4 = button.data('whatever_ab4');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('4º BIM.: ' + Disciplina);
    modal.find('#notaAtual').val(AB4);
    });
/* Script para edita nota modal as duas notas 4bim */
$('#edita_nota_4mensal_4bim_fun2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var AM4 = button.data('whatever_am4');
    var AB4 = button.data('whatever_ab4');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('4º MENSAL E BIMESTRAL: ' + Disciplina);
    modal.find('#notaAtualMensal').val(AM4);
    modal.find('#notaAtualBimestral').val(AB4);
    });
/* Script para edita nota modal_parciel */
$('#edita_nota_RP').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var RP = button.data('whatever_rp');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('RECUPERAÇÃO PARCIAL: ' + Disciplina);
    modal.find('#notaAtual').val(RP);
    });
/* Script para edita nota modal_final */
$('#edita_nota_RF').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var RF = button.data('whatever_rf');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('RECUPERAÇÃO FINAL: ' + Disciplina);
    modal.find('#notaAtual').val(RF);
    });
/* Script para edita nota modal as duas REUPERAÇÕES */
$('#edita_nota_RP_RF').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var idNotas = button.data('whatever_idnotas');
    var tb_aluno_idAluno = button.data('whatever_tb_aluno_idaluno');
    var tb_usuario_idUsuario = button.data('whatever_idusuario');
    var NomeAluno = button.data('whatever_nome_aluno');
    var Disciplina = button.data('whatever_disciplina');
    var RP = button.data('whatever_rp');
    var RF = button.data('whatever_rf');
    var modal = $(this);
    modal.find('#idNotas').val(idNotas);
    modal.find('#tb_aluno_idAluno').val(tb_aluno_idAluno);
    modal.find('#tb_usuario_idUsuario').val(tb_usuario_idUsuario);
    modal.find('#NomeAluno').text('Alterar nota de : ' + NomeAluno);
    modal.find('#Disciplina').text('RECUPERAÇÃO PARCIAL E FINAL: ' + Disciplina);
    modal.find('#notaAtualRP').val(RP);
    modal.find('#notaAtualRF').val(RF);
    });
    
 // Script para imprimir um conteudo especifico
  $(document).ready(function(){
    $("#imprimir_conteudo").click(function(){
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("div.imprimir_conteudo").printArea( options );
    });
});
        </script>
        
        
        
        
       
    </body>
</html>