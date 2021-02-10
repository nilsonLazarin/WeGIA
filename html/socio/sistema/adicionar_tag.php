<?php
	require_once('../conexao.php');
	$tag = $_POST["tag"];

	$sql = "INSERT into socio_tag(tag) values('" .$tag ."')";
	mysqli_query($conexao, $sql);
?>