<?php
	$usuario = "root";
  	$senha = "root";
  	$servidor = "localhost";
  	$bddnome = "wegia";
  	$conexao = mysqli_connect($servidor,$usuario,$senha,$bddnome);
    extract($_REQUEST);
  	mysqli_query ($conexao,"INSERT INTO situacao(situacoes) values ('$situacao')");
  	session_start();
  	$_SESSION['msg']="Situação do Funcionário adicionado com sucesso";
    $_SESSION['proxima']="Cadastrar outra situação";
    $_SESSION['link']="../html/adicionar_situacao.php";
    header("Location: sucesso.php");
?>