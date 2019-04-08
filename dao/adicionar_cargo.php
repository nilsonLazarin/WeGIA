<?php
	$nomeDB = 'wegia'; // nome da base de dados
	$local = 'localhost';//local servidor mysql
	$user = 'root';
	$senha = 'root';
	$cargo = $_POST["cargo"];
	$conn = mysqli_connect($local, $user, $senha, $nomeDB);
	
	if(!$conn){
		echo 'problema conexao';
	}

	$sql = "INSERT into cargo(cargo) values('" .$cargo ."')";
	echo $sql;
	if(mysqli_query($conn, $sql)){
		echo 'sucesso';
	}
	else
	{
		echo mysqli_error($conn);
	}
?>