<?php
	require_once('../conexao.php');
	$tag = $_POST["tag"];
	$tag = addslashes($tag);
	$tags = trim($tag);
	$sql = "INSERT into socio_tag(tag) values('$tag')";
	$stmt = mysqli_prepare($conexao, $sql);
	mysqli_stmt_execute($stmt);
?>