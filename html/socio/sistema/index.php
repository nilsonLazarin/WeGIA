<?php
    require("../conexao.php");
    
    session_start();
    if(!isset($_SESSION['cod_usuario'])) header("Location: ../erros/login_erro/");
    if(isset($_SESSION['adm_configurado'])){
      if($_SESSION['adm_configurado'] == false) header("Location: ../configuracao/");
    }
    $nome = $_SESSION['nome'];
    $id = $_SESSION['cod_usuario'];
    $comando = "select * from usuario where id=$id";
    $resultado = mysqli_query($conexao, $comando);
    $registro = mysqli_fetch_array($resultado);
    $foto = $registro['foto'];
    $dados_config = mysqli_fetch_array(mysqli_query($conexao, "SELECT `id`, `nome`, `foto_login`, `mensagem_login` FROM `configuracao` WHERE 1"));
    $nome_empresa = $dados_config['nome'];
?>
    <?php require_once("./controller/import_head.php"); ?>
    <?php require_once("./controller/import_header.php"); ?>
    <?php require_once("./controller/import_sidebar.php"); ?>
    <?php require_once("./controller/import_conteudo_index.php"); ?>
    <?php require_once("./controller/import_modais.php"); ?>
    <?php require_once("./controller/import_scripts.php"); ?>
</body>
</html>
