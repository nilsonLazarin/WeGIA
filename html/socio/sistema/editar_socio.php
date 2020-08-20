<?php
    require("../conexao.php");
    // Adiciona a Função display_campo($nome_campo, $tipo_campo)
	  require_once ROOT."/html/personalizacao_display.php";
    session_start();
    if(!isset($_SESSION['usuario'])) header("Location: ../erros/login_erro/");
    $id = $_SESSION['usuario'];
    $id_pessoa = $_SESSION['id_pessoa'];
	$resultado = mysqli_query($conexao, "SELECT `imagem`, `nome` FROM `pessoa` WHERE id_pessoa=$id_pessoa");
    $pessoa = mysqli_fetch_array($resultado);
    $nome = $pessoa['nome'];
?>
    <?php require_once("./controller/import_head.php"); ?>
    <?php require_once("./controller/import_header.php"); ?>
    <?php require_once("./controller/import_sidebar.php"); ?>
    <?php require_once("./controller/import_conteudo_editarsocios.php"); ?>
    <?php require_once("./controller/import_scripts.php"); ?>
    
</body>
</html>
