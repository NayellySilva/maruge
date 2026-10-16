<?php

//Pegando dados fornecidos no formulário
$nome = addslashes($_POST['nome']);
$telefone = addslashes($_POST['telefone']);
$email = addslashes($_POST['email']);
$verificacao = addslashes($_POST['verificacao']);
$verificacao2 = addslashes($_POST['verificacao2']);
$email = addslashes($_POST['email']);
$mensagem = addslashes($_POST['mensagem']);
$mensagem = "<b>NOME:</b> ".$nome."<br><b>TELEFONE:</b> ".$telefone."<br><br><b>MENSAGEM:</b> ".$mensagem."<br><br>Esta mensagem foi enviada por meio do formulario de conato do site http://maruge.com.br, respoda a mesma assim que possivel, uma copia da mesma foi envida para o email de Natan, David, Gerislanio e Viviane assim como o email de suporte.<br><br>(C)2016 - Marugue Sistema de Gestao Escolar";

$para = "to: suporte@maruge.com.br";
$para2 = "to: natan@maruge.com.br";
$para3 = "to: david@maruge.com.br";
$para4 = "to: gerislanio@maruge.com.br";
$para5 = "to: viviane@maruge.com.br";
$assunto = "CONTATO - Sugestões do Sistema";
$cabecalho = "MIME-Version: 1.0″ . “\r\n";
$cabecalho .= "Content-type: text/html; charset=ISO 8859-1″ . “\r\n";
$cabecalho .= "from: suporte@maruge.com.br" . "\r\n".
"Reply-to: suporte@maruge.com.br" . "\r\n";

if ($verificacao == $verificacao2){ //Verificando codigo de segurança
    
    //Verifica se o email foi enviado
if (mail($para, $assunto, $mensagem, $cabecalho) && mail($para2, $assunto, $mensagem, $cabecalho) && mail($para3, $assunto, $mensagem, $cabecalho) && mail($para4, $assunto, $mensagem, $cabecalho) && mail($para5, $assunto, $mensagem, $cabecalho)){
            echo "<script>
alert('Sua mensagem foi enviada, não se preocupe logo logo entraremos em contato com voce.');
location.href = 'coordenacao/ajuda';
</script>";
}else{
                  echo "<script>
alert('ERRO Nao foi possivel enviar o contato, tente novamente mais tarde!');
location.href = 'index.php';
</script>";  
}
}else {
                echo "<script>
alert('CÓDIGO DE SEGURANCA INVALIDO!');
location.href = 'index.php';
</script>";
}

?>