<?php
	$nomeDB = 'wegia'; // nome da base de dados
	$local = 'localhost';//local servidor mysql
	$user = 'root';
	$senha = 'root';
	$situacao = $_POST["situacao"];
	$conn = mysqli_connect($local, $user, $senha, $nomeDB);
	
	if(!$conn){
		echo 'problema conexao';
	}

	$sql = "INSERT into situacao(situacoes) values('" .$situacao ."')";
	echo $sql;
	if(mysqli_query($conn, $sql)){
		echo 'sucesso';
	}
	else
	{
		echo mysqli_error($conn);
	}
?>