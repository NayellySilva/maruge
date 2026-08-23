<!DOCTYPE html>
<html lang="pt-br" class="index-geral">
    <head>
        <title>	{{$titulo ?? 'Maruge Coordenação'}}</title>
        <!-- Estilos e Scripts (Vite) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        <script src="{{asset('SweetAlert2/sweetAlert.js')}}" ></script>


        <script src="{{asset('css2/jquery-3.0.0.js')}}" ></script>

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/all.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/v4-shims.css">  

        <link rel="stylesheet" href="{{asset('font-awesome2/css/fontawesome.min.css')}}">   
        
        
        
        
        
        
        

        <!--
        
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
          
          
        -->






        {{--
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
                            Olá, Coordenador
                            <span class="caret"></span>
                    </div>
                    <ul class="dropdown-menu drop" aria-labelledby="dropdownMenu1">
                        <li>
                            <a href="{{url("/coordenacao/funcionario_perfil/$usuario->idFuncionarios")}}" >Perfil</a>
                        </li>
                        <li><a href="/logout">Sair</a></li>
                    </ul>
                </div>
            </div> <!--Fim perfil-->
        </div> <!--Fim logo-->
        --}}

        <div class="dashboard-layout">
            <x-sidebar />

            <section class="conteudo main-content">
                <div class="infPagina">
                    <div class="caminho">
                        <a href="" class="cam"></a>
                        <a href="" class="cam"></a>
                    </div>
                    @yield('conteudo')
                </div> <!-- fim infPagina-->
            </section> 
        </div> 

        <!-- FIM conteudo -->
        <!-- jQuery (obrigatÃ³rio para plugins JavaScript do Bootstrap) -->      
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessÃ¡rio -->
        <script src="{{asset('js/bootstrap.min.js')}}" ></script>
        <script src="{{asset('jquery/jquery.mask.min.js')}}" ></script>
        <script src="{{asset('jquery/jquery.PrintArea.js')}}" ></script>


        
        
        
        
        
        
        

        <!--
TAVA BLOQUEANDO O LOGOUT, VERIFICA SE VAI SOFRE ALGUM IMPACTO
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        -->


        @yield('scripts')
        <script>
/*Ajax para salva os dados dos fomularios*/
$(function () {
    jQuery(document).on("submit", "form.formularios, form.form-Nu", function (e) {
        e.preventDefault();
        e.stopPropagation();
        jQuery(".msg-erro").hide();
        jQuery(".msg-exito").hide();
        var formObj = jQuery(this);
        var dadosForm = formObj.serialize();
        var targetUrl = formObj.attr("send") || formObj.attr("action");

        jQuery.ajax({
            url: targetUrl,
            data: dadosForm,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                if (typeof preloader === 'function') preloader();
            }
        }).done(function (data) {
            if (typeof Fimpreloader === 'function') Fimpreloader();
            var dataStr = String(data).trim();

            if (dataStr == "1" || dataStr == "11") {
                jQuery(".msg-exito").html("Cadastro realizado com sucesso!").show();
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else if (dataStr == "escolaExistente") {
                jQuery(".msg-erro").html("Desculpe, já existe uma escola cadastrada!").show();
            } else if (dataStr == "DesciplinaNaoinformada") {
                jQuery(".msg-erro").html("Nenhuma disciplina informada!").show();
            } else if (dataStr == "alunojacadastrado") {
                jQuery(".msg-erro").html("Desculpe, Aluno já cadastrado!").show();
            } else {
                jQuery(".msg-exito").html("Operação realizada com sucesso!").show();
                setTimeout(function() {
                    location.reload();
                }, 1500);
            }
        }).fail(function() {
            if (typeof Fimpreloader === 'function') Fimpreloader();
            jQuery(".msg-erro").html("Erro ao processar o formulário.").show();
        });

        return false;
    });
                /*Codição se ja existir uma escola cadastrada*/
            } else if (data == "escolaExistente") {
                jQuery(".msg-erro").html("Desculpa já existe uma escola cadastrada !");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2500);
                /*Codição quando atualização da escola for realizada*/
            } else if (data == "EscolaAtualizada") {
                jQuery(".msg-exito").html("Escola atualizada com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/escola_inf';", 2500);
            }
            /*Codição quando é criado um carnê novo com sucesso*/
            else if (data == "carnecadastrado") {
                jQuery(".msg-exito").html("Carnêr cadastrado com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/recibos';", 2500);

            }
            /*Codição quando é criado um ACOORDO novo com sucesso*/
            else if (data == "acordocadastrado") {
                jQuery(".msg-exito").html("Acordo cadastrado com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 4000);

            }
            /*Codição QUE MOSTRA QUE JÁ EXISTE UM CARNER*/
            else if (data == "carnerjaexistente") {
                jQuery(".msg-erro").html("Já existe um carnêr referente a este mês!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 4000);
            }
            /*Codição que avisa QUE JA TEM ACORDO FEITO*/
            else if (data == "acordojaexistente") {
                jQuery(".msg-erro").html("Já existe um acordo referente a este aluno!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 4000);
            }
           /*Codição quando atualização do aluno for realizada*/
            else if (data == "AlunoAtualizado") {
                jQuery(".msg-exito").html("Aluno atualizado com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/aluno_inf';", 2500);
            }
            /*Codição quando atualização do aluno for realizada*/
            else if (data == "AlunoTransferido") {
                jQuery(".msg-exito").html("Aluno transferido com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/aluno_inf';", 2500);
            }
            /*Codição se não informar o nome da disciplina*/
            else if (data == "DesciplinaNaoinformada") {
                jQuery(".msg-erro").html("Nenhuma disciplina informada!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.href ='/coordenacao/disciplina_cad';", 2000);
                /*Codição se não informar o nome da disciplina para update*/
            }
            /*Aluno Já existente*/
            else if (data == "alunojacadastrado") {
                jQuery(".msg-erro").html("Desculpe, Aluno já cadastrado");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.href ='/coordenacao/aluno_cad';", 2000);
            /*Aula Já Cadastrada*/
            } else if (data == "aulajacadastrada") {
                jQuery(".msg-erro").html("Desculpe, Aula já cadastrado !");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2000);
            } 
            /*Não foi informada uma nova disciplina*/
            else if (data == "novaDesciplinaNaoinformada") {
                jQuery(".msg-erro").html("Nenhuma disciplina informada!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2000);
                
                

            } else if (data == "LancheAtualizado") {
                jQuery(".msg-erro").html("Lanche Atualizado com Sucesso!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.href ='/coordenacao/lanche_inf';", 2000);

            } else if (data == "jaexistereserva") {
                jQuery(".msg-erro").html("Desculpe, já existe uma pré-matrícula pra esse aluno.");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.href ='/coordenacao/aluno_pre_matricula_lista';", 2000);

            } /*Codição se o update da disciplina for realizada com sucesso*/
            else if (data == "disciplinaatualizada") {
                jQuery(".msg-exito").html("Disciplina atualizada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/disciplina_inf';", 2000);
                /*Codição se não informar 2 campos ao mesmo tempo*/
            } else if (data == "2campos") {
                jQuery(".msg-erro").html("Não é possivel digitar e selecionar disciplinas, por favor digite ou selecione a disciplina!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2500);
                // Turma atualizada com sucesso
            } else if (data == "turmaatualizada") {
                jQuery(".msg-exito").html("Turma atualizada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/turma_inf';", 2000);
            
    
    
    } else if (data == "Aulaatualizada") {
                jQuery(".msg-exito").html("Aula atualizada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/aulas_inf';", 2000);






            }// lançamento de nota com sucesso
            else if (data == "notalancada") {
                $(this).attr('href');
                jQuery(".msg-exito").html("Nota cadastrada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.reload($(this).attr('href'))", 1000);
            } else if (data == "notaNaoInformada") {


            }// impresssão 2º via

            else if (data == "2via") {
                $(this).attr('href');
                jQuery(".msg-exito").html("2º Via impressa   com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.reload($(this).attr('href'))", 1000);


            } else if (data == "notaNaoInformada") {


            }// Boleto pago total ou parcial

            else if (data == "pagamento") {
                $(this).attr('href');
                jQuery(".msg-exito").html("Pagamento Recebido com Sucesso");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.reload($(this).attr('href'))", 1000);
              //  window.open("/coordenacao/recibo_mensalidade/}}","","height=400,width=400,left=40,top=40");
              } 
            
  


            /*codifo de barras ou RA não informado*/
            else if (data == "codNaoinformado") {
                jQuery(".msg-erro").html("Código de Barras ou RA não informado!");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.href ='/coordenacao/financeiro_receber';", 2000);
                /*Codição se não informar o nome da disciplina para update*/
            } 
            
            else if (data == "notaNaoInformada") {
                jQuery(".msg-erro").html("Desculpa mas nenhuma nota foi informada !");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2500);

            }
            // Nota não informada

            else if (data == "pagamentoErro") {
                jQuery(".msg-erro").html("Desculpa mas nenhuma nota foi informada !");
                jQuery(".msg-erro").show();
                setTimeout("jQuery('msg-erro').hide();location.reload();", 2500);

            }
            /*Codição funcionario atualizado com sucesso*/
            else if (data == "FuncionarioAtualizado") {
                jQuery(".msg-exito").html("Funcionário atualizado com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/funcionario_inf';", 2000);
            }
            /*Codição frequencia com sucesso*/
            else if (data == "FrequenciaRealizada") {
                $(this).attr('href');
                jQuery(".msg-exito").html("Frequência feita com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.reload($(this).attr('href'))", 1000);
            }
            /*Codição para atualiza nota com sucesso*/
            else if (data == "notaAtualizada") {
                jQuery(".msg-exito").html("A nota foi atualizada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.reload($(this).attr('href'))", 1000);
            }
            /*Codição funcionario atualizado com sucesso*/
            else if (data == "UsuarioAtualizado") {
                jQuery(".msg-exito").html("Usuário atualizado com sucesso!");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/usuario_inf';", 2000);
            }

            /*Codição quando uma reserva for realizada*/
            else if (data == "ReservaAluno") {
                jQuery(".msg-exito").html("Reseva foi realizada com sucesso !");
                jQuery(".msg-exito").show();
                setTimeout("jQuery('msg-exito').hide();location.href ='/coordenacao/aluno_pre_matricula_lista';", 2500);
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
    jQuery('#Mensalidade').mask("#.##0.00", {reverse: true});
    /*Mascaras do formulario cadastrar novo aluno guia Dados Alunos*/
    
    
    
    jQuery('#ValorPGTO').mask("#.##0.00", {reverse: true});
   // jQuery('#ValorPGTORecebimento').mask("#.###,## 0.000,00", {reverse: true});
   // jQuery('#ValorPGTORecebimentoAcordo').mask("#.##0.00", {reverse: true});
    jQuery('#ValorPGTO2').mask("#.##0.00", {reverse: true});
    jQuery('#ValorPGTO_acordo_total').mask("#.##0.00", {reverse: true});
    jQuery('#ValorPGTO_acordo').mask("#.##0.00", {reverse: true});
    
        
    
    jQuery('#DataNascimento').mask("##/##/####", {reverse: true});
    jQuery('#numeroMac').mask("#########################", {reverse: true});
    jQuery('#DataMatricula').mask("##/##/####", {reverse: true});
    jQuery('#DataEmissao').mask("##/##/####", {reverse: true});
    jQuery('#NumeroRGNovo').mask("######.##.##.####.#.#####.###.#######.##", {reverse: true});
    jQuery('#CPFAluno').mask('000.000.000-00');
    /*Mascaras do formulario cadastrar novo aluno guia Dados Pais*/
    jQuery('#FonePai1').mask('(00) 0.0000-0000');
    jQuery('#FonePai2').mask('(00) 0.0000-0000');
    jQuery('#CPFPai').mask('000.000.000-00');
    jQuery('#DataNascimentoPai').mask("##/##/####", {reverse: true});
    jQuery('#DataNascimentoMae').mask("##/##/####", {reverse: true});
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
/*DEIXANDO CAMPO EMAIL EM MINUSCULOS*/
$(window).load(function () {
    $("input[name=EmailColegio]").change(function () {
        var partes = this.value.split(' ');
        var email = partes[0];
        $("input[name=EmailColegio]").val(email.toLowerCase() + "");
    });
});












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
$(document).ready(function () {
    $("#imprimir_conteudo").click(function () {
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {mode: mode, popClose: close};
        $("div.imprimir_conteudo").printArea(options);
    });
});



/* Script para exibir as observação do pagamento*/
$('#obs_pagamento').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
    var obs_pagamento = button.data('whatever_obs_pagamento');
    var meses = button.data('whatever_meses');
    modal.find('#meses').text('Observações do mês: ' + meses);
    modal.find('#meses2').text('Observações do mês: ' + meses);
    modal.find('#obs_pagamento').text('Observações: ' + obs_pagamento);

});




/* Script salvar um pagamento carne */
$('#pagamento').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var nomealuno = button.data('whatever_nomealuno');
    var nometurma = button.data('whatever_nometurma');
    var meses = button.data('whatever_meses');
    var codbarras = button.data('whatever_codbarras');
    var parcelas = button.data('whatever_parcelas');
    var ano_letivo = button.data('whatever_ano_letivo');
    var valorpgto = button.data('whatever_valorpgto');
    var porconta = button.data('whatever_porconta');
    var mensalidade = button.data('whatever_mensalidade');
    var carteira = button.data('whatever_carteira');
    var acordo = button.data('whatever_acordo');
    var data_venc = button.data('whatever_data_venc');
    var data_pagamento = button.data('whatever_data_pagamento');
    var obs_pagamento = button.data('whatever_obs_pagamento');
    var status = button.data('whatever_status');
    var idcarne = button.data('whatever_idcarne');

    var modal = $(this);


/* SÃO TEXTO */
    modal.find('#nomealuno2').text(nomealuno);
    modal.find('#nometurma2').text(nometurma);
    modal.find('#meses2').text(meses);
    modal.find('#codbarras2').text(codbarras);
    modal.find('#parcelas2').text(parcelas);
    modal.find('#valorpgto2').text(valorpgto);
    modal.find('#ano_letivo2').text(ano_letivo);
    modal.find('#mensalidade2').text(mensalidade);
    modal.find('#carteira2').text(carteira);
    modal.find('#acordo2').text(acordo);
    modal.find('#data_venc2').text(data_venc);
    modal.find('#data_pagamento2').text(data_pagamento);
    modal.find('#status').text(status);
    modal.find('#porconta').text(porconta);
    
    /* SÃO VAREAVEIS */
    modal.find('#porconta').val(porconta);
    modal.find('#nomealuno').val(nomealuno);
    modal.find('#nometurma').val(nometurma);
    modal.find('#meses').val(meses);
    modal.find('#codbarras').val(codbarras);
    modal.find('#parcelas').val(parcelas);
    modal.find('#ano_letivo').val(ano_letivo);
    modal.find('#mensalidade').val(mensalidade);
    modal.find('#valorpgto').val(valorpgto);
    modal.find('#carteira').val(carteira);
    modal.find('#acordo').val(acordo);
    modal.find('#data_venc').val(data_venc);
    modal.find('#data_pagamento').val(data_pagamento);
    modal.find('#obs_pagamento').val(obs_pagamento);
    modal.find('#status').val(status);
    modal.find('#status2').val(status);
    modal.find('#idcarne').val(idcarne);
});
/* Script salvar um pagamento Acordo */
$('#pagamentoAcordo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var nomealuno = button.data('whatever_nomealuno');
    var nometurma = button.data('whatever_nometurma');
    var meses = button.data('whatever_meses');
    var codbarras = button.data('whatever_codbarras');
    var valorpgto = button.data('whatever_valorpgto');
    var porconta = button.data('whatever_porconta');
    var parcelas = button.data('whatever_parcelas');
    var ano_letivo = button.data('whatever_ano_letivo');
    var valor_prestacao = button.data('whatever_valor_prestacao');
    var carteira = button.data('whatever_carteira');
    var acordo = button.data('whatever_acordo');
    var data_venc = button.data('whatever_data_venc');
    var data_pagamento = button.data('whatever_data_pagamento');
    var obs_pagamento = button.data('whatever_obs_pagamento');
    var status = button.data('whatever_status');
    var idcarne = button.data('whatever_idcarne');

    var modal = $(this);

    modal.find('#nomealuno2').text(nomealuno);
    modal.find('#nometurma2').text(nometurma);
    modal.find('#meses2').text(meses);
    modal.find('#codbarras2').text(codbarras);
    modal.find('#parcelas2').text(parcelas);
    modal.find('#valorpgto2').text(valorpgto);
    modal.find('#ano_letivo2').text(ano_letivo);
    modal.find('#valor_prestacao2').text(valor_prestacao);
    modal.find('#carteira2').text(carteira);
    modal.find('#acordo2').text(acordo);
    modal.find('#data_venc2').text(data_venc);
    modal.find('#data_pagamento2').text(data_pagamento);
    modal.find('#status').text(status);
    modal.find('#porconta').text(porconta);

/* São Variaveis */
    modal.find('#porconta').val(porconta);
    modal.find('#nomealuno').val(nomealuno);
    modal.find('#nometurma').val(nometurma);
    modal.find('#meses').val(meses);
    modal.find('#codbarras').val(codbarras);
    modal.find('#parcelas').val(parcelas);
    modal.find('#ano_letivo').val(ano_letivo);
    modal.find('#valor_prestacao').val(valor_prestacao);
    modal.find('#carteira').val(carteira);
    modal.find('#acordo').val(acordo);
    modal.find('#data_venc').val(data_venc);
    modal.find('#valorpgto').val(valorpgto);
    modal.find('#data_pagamento').val(data_pagamento);
    modal.find('#obs_pagamento').val(obs_pagamento);
    modal.find('#status').val(status);
    modal.find('#status2').val(status);
    modal.find('#idcarne').val(idcarne);
});






/* Script imprimir 2º via carne*/
$('#2via').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var nomealuno = button.data('whatever_nomealuno');
    var nometurma = button.data('whatever_nometurma');
    var meses = button.data('whatever_meses');
    var codbarras = button.data('whatever_codbarras');
    var parcelas = button.data('whatever_parcelas');
    var ano_letivo = button.data('whatever_ano_letivo');
    var valorpgto = button.data('whatever_valorpgto');
    var mensalidade = button.data('whatever_mensalidade');
    var carteira = button.data('whatever_carteira');
    var acordo = button.data('whatever_acordo');
    var data_venc = button.data('whatever_data_venc');
    var data_pagamento = button.data('whatever_data_pagamento');
    var obs_pagamento = button.data('whatever_obs_pagamento');
    var status = button.data('whatever_status');

    var modal = $(this);

    modal.find('#nomealuno2').text(nomealuno);
    modal.find('#nometurma2').text(nometurma);
    modal.find('#meses2').text(meses);
    modal.find('#codbarras2').text(codbarras);
    modal.find('#parcelas2').text(parcelas);
    modal.find('#ano_letivo2').text(ano_letivo);
    modal.find('#valorpgto2').text(valorpgto);
    modal.find('#mensalidade2').text(mensalidade);
    modal.find('#carteira2').text(carteira);
    modal.find('#acordo2').text(acordo);
    modal.find('#data_venc2').text(data_venc);
    modal.find('#data_pagamento2').text(data_pagamento);
    modal.find('#obs_pagamento2').text(obs_pagamento);
    modal.find('#status').text(status);
    modal.find('#status2').text(status);

    modal.find('#nomealuno').val(nomealuno);
    modal.find('#nometurma').val(nometurma);
    modal.find('#meses').val(meses);
    modal.find('#codbarras').val(codbarras);
    modal.find('#parcelas').val(parcelas);
    modal.find('#ano_letivo').val(ano_letivo);
    modal.find('#valorpgto').val(valorpgto);
    modal.find('#mensalidade').val(mensalidade);
    modal.find('#carteira').val(carteira);
    modal.find('#acordo').val(acordo);
    modal.find('#data_venc').val(data_venc);
    modal.find('#data_pagamento').val(data_pagamento);
    modal.find('#obs_pagamento').val(obs_pagamento);
    modal.find('#status').val(status);
    modal.find('#status2').val(status);
});
/* Script imprimir 2º via Acordo*/
$('#2viaAcordo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var nomealuno = button.data('whatever_nomealuno');
    var nometurma = button.data('whatever_nometurma');
    var meses = button.data('whatever_meses');
    var codbarras = button.data('whatever_codbarras');
    var parcelas = button.data('whatever_parcelas');
    var ano_letivo = button.data('whatever_ano_letivo');
    var valorpgto = button.data('whatever_valorpgto');
    
    var valor_prestacao = button.data('whatever_valor_prestacao');
    
    
    var carteira = button.data('whatever_carteira');
    var acordo = button.data('whatever_acordo');
    var data_venc = button.data('whatever_data_venc');
    var data_pagamento = button.data('whatever_data_pagamento');
    var obs_pagamento = button.data('whatever_obs_pagamento');
    var status = button.data('whatever_status');

    var modal = $(this);

    modal.find('#nomealuno2').text(nomealuno);
    modal.find('#nometurma2').text(nometurma);
    modal.find('#meses2').text(meses);
    modal.find('#codbarras2').text(codbarras);
    modal.find('#parcelas2').text(parcelas);
    modal.find('#ano_letivo2').text(ano_letivo);
    modal.find('#valorpgto2').text(valorpgto);
    modal.find('#valor_prestacao2').text(valor_prestacao);
    modal.find('#carteira2').text(carteira);
    modal.find('#acordo2').text(acordo);
    modal.find('#data_venc2').text(data_venc);
    modal.find('#data_pagamento2').text(data_pagamento);
    modal.find('#obs_pagamento2').text(obs_pagamento);
    modal.find('#status').text(status);
    modal.find('#status2').text(status);

    modal.find('#nomealuno').val(nomealuno);
    modal.find('#nometurma').val(nometurma);
    modal.find('#meses').val(meses);
    modal.find('#codbarras').val(codbarras);
    modal.find('#parcelas').val(parcelas);
    modal.find('#ano_letivo').val(ano_letivo);
    modal.find('#valorpgto').val(valorpgto);
    modal.find('#valor_prestacao').val(valor_prestacao);
    modal.find('#carteira').val(carteira);
    modal.find('#acordo').val(acordo);
    modal.find('#data_venc').val(data_venc);
    modal.find('#data_pagamento').val(data_pagamento);
    modal.find('#obs_pagamento').val(obs_pagamento);
    modal.find('#status').val(status);
    modal.find('#status2').val(status);
});



/* Script para cadastrar ou editar receita*/
$('#modal_receita').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
    var obs_pagamento = button.data('whatever_obs_pagamento');
    var meses = button.data('whatever_meses');
    modal.find('#novareceita').text('Nova Receita: ' + meses);
    modal.find('#meses2').text('kkkkkkkkkkkkk: ' + meses);
    modal.find('#obs_pagamento').text('bbbbbbbbbbbbb: ' + obs_pagamento);

});




/* Script imprimir apenas o conteudo da 2º via */
document.getElementById('btn').onclick = function () {
    var conteudo = document.getElementById('2viaimprimir').innerHTML,
            tela_impressao = window.open('about:blank');

    tela_impressao.document.write(conteudo);
    tela_impressao.window.print();
    tela_impressao.window.close();
};


        </script>


        <!-- SCRIPT TABELA DE RECEBIMENTOS DE PAGAMENTOS SCROOL AUTO -->

















    </body>
</html>
