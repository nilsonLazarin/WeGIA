<?php
	$usuario = "wegia";
  	$senha = "wegia";
  	$servidor = "localhost";
  	$bddnome = "wegia";
  	$conexao = mysqli_connect($servidor,$usuario,$senha,$bddnome);
  	$tamanho=$_POST['tamanho'];
  	mysqli_query ($conexao,"INSERT INTO calca (tamanhos) values ('$tamanho')");
  	session_start();
  	$_SESSION['msg']="Tamanho de calça adicionado com sucesso";
    $_SESSION['proxima']="Cadastrar outro tamanho";
    $_SESSION['link']="../html/adicionar_calca.php";
  	header("Location: sucesso.php");
?>