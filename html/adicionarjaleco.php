<?php
	$usuario = "wegia";
  	$senha = "wegia";
  	$servidor = "localhost";
  	$bddnome = "wegia";
  	$conexao = mysqli_connect($servidor,$usuario,$senha,$bddnome);
  	$tamanho=$_POST['tamanho'];
  	mysqli_query ($conexao,"INSERT INTO jaleco (tamanhos) values ('$tamanho')");
  	session_start();
  	$_SESSION['msg']="Tamanho do jaleco adicionado com sucesso";
    $_SESSION['proxima']="Cadastrar outro tamanho";
    $_SESSION['link']="../html/adicionar_jaleco.php";
    header("Location: sucesso.php");
?>