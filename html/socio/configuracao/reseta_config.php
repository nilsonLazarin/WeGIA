<?php
    require("../conexao.php");
    $linhas = 0;
    $admin = mysqli_real_escape_string($conexao, 'admin');
    $token = mysqli_real_escape_string($conexao, 'token');
    $resultado = mysqli_query($conexao, "UPDATE `usuario` SET nome='admin_saga', adm_configurado=0, senha=AES_ENCRYPT('$admin', '$token'), foto='./fotos/padrao.png'  WHERE usuario='admin'");
    if(mysqli_affected_rows($conexao)==1) $linhas++;
    $resultado2 = mysqli_query($conexao, "UPDATE `configuracao` SET `nome`='SaGA',`foto_login`='./configuracao/dados/imagem_padrao.jpg',`mensagem_login`='Seja bem-vindo ao sistema SaGA, entre com as credenciais padrão para configurar o sistema. <br><br> usuário: admin<br>senha: admin' WHERE 1");
    if(mysqli_affected_rows($conexao)==1) $linhas++;


    session_start();
    session_destroy();
    header("Location: ../index.php");
   
?>