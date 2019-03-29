<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/theme.css">
	<?php function exibirVoltar(){echo '<a href="JavaScript: window.history.back();">Voltar</a>';} ?>
</head>
<body>
	<?php
		$nomeDB = $_POST["nomebd"]; // nome da base de dados
		$localsql = '../wegia.sql';  //local arquivo .sql
		$local = $_POST["local"];//local servidor mysql
		$user = $_POST["usuario"];
		$senha = $_POST["senha"];
		$reinstalar = isset($_POST["reinstalar"]);

		/*conexao*/
		$conn = new mysqli($local, $user, $senha);
		if ($conn->connect_errno)//verificar conexao
		{
	    	echo '<p style="color:red;">Falha na conexao: ' .mysqli_connect_error() .'</p>';
			exibirVoltar();
			die();
		}
		
		/*verificar reinstalar*/	
		if(mysqli_select_db ($conn, $nomeDB))//verificar se db já existe
		{
			if($reinstalar)//verificar se opçao de reinstalar foi marcada
			{
				$conn->query('DROP DATABASE ' .$nomeDB .';');//excluir db
				echo '<p style="color:orange;">Base de dados exlcuída para reinstalação</p>';
			}
			else
			{
				$conn->close();
				echo '<p style="color:red;">Base de dados já existe! selecione a opção reinstalar para reinstalar a base de dados!</p>';
				exibirVoltar();
				die();
			}
		}

		/*importar base de dados*/
		$conn->query("CREATE DATABASE ".$nomeDB .";");//criar db
		$conn->query("USE ".$nomeDB .";");//usar db

		$lines = file($localsql);
		$op_data = '';
		foreach ($lines as $line)
		{
		    if (substr($line, 0, 2) == '--' || $line == '')//ignora linhas comentadas ou vazias
		    	continue;

		    if(strtoupper(ltrim(substr($line, 0, 15))) == 'CREATE DATABASE') //ignora create database
		    	continue;

		    if(strtoupper(ltrim(substr($line, 0, 3))) == 'USE')//ignora use database
		    	continue;

		    $op_data .= $line; //buffer
		    if (substr(trim($line), -1, 1) == ';')//Breack Line Upto ';' NEW QUERY
		    {
		        $conn->query($op_data);
		        $op_data = '';
		    }
		}
		
		/*verificar se base de dados foi criada*/
		if(mysqli_select_db ($conn, $nomeDB)) 
			echo '<p style="color:green;">Base de dados ' .$nomeDB .' importada!</p>';
		else
			echo '<p style="color:red;">Falha na criaçao do banco de dados!</p>';
		
		
		$conn->close();
		exibirVoltar();
	?>
	
</body>
</html>