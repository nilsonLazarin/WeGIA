<?php
	$usuario = "wegia";
  	$senha = "wegia";
  	$servidor = "localhost";
  	$bddnome = "wegia";
  	$conexao = mysqli_connect($servidor,$usuario,$senha,$bddnome);
  	$tamanho=$_POST['tamanho'];
  	mysqli_query ($conexao,"INSERT INTO camisa (tamanhos) values ('$tamanho')");
  	session_start();
  	$_SESSION['msg']="Tamanho da camisa adicionado com sucesso";
    $_SESSION['proxima']="Cadastrar outro tamanho";
    $_SESSION['link']="../html/adicionar_camisa.php";
    header("Location: sucesso.php");
?>