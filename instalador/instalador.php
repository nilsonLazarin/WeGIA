<html>
<head>
	 <link rel="stylesheet" type="text/css" href="css/theme.css">
</head>
<body>
	<?php
		$nomeDB = "wegia"; // nome da base de dados
		$localsql ='../wegia.sql';  //local arquivo .sql
		$local = $_POST["local"];//local servidor mysql
		$user = $_POST["usuario"];
		$senha = $_POST["senha"];
		$reinstalar = isset($_POST["reinstalar"]);

		//criar conexao
		$conn = new mysqli($local, $user, $senha);
		
		//verificar conexao
		if ($conn->connect_errno) 
		{
	    	die('<p style="color:red;">Falha na conexao: ' .mysqli_connect_error() .'</p>');
		}
		
		//verificar reinstalacao	
		if(mysqli_select_db ($conn, $nomeDB))//verificar se db já existe
		{
			if($reinstalar == FALSE)
			{
				$conn->close();
				die('<p style="color:red;">Base de dados já existe! selecione a opção reinstalar para reinstalar a base de dados!</p>');
			}
			else
			{
				 $conn->query('DROP DATABASE ' .$nomeDB .';');//excluir db
				 
				 echo '<p style="color:orange;">Base de dados exlcuida para reinstalação</p>';
			}
		}

		//importar base de dados
		$lines = file($localsql);
		$op_data = '';
		foreach ($lines as $line)
		{
		    if (substr($line, 0, 2) == '--' || $line == '')//This IF Remove Comment Inside SQL FILE
		    {
		        continue;
		    }
		    $op_data .= $line;
		    if (substr(trim($line), -1, 1) == ';')//Breack Line Upto ';' NEW QUERY
		    {
		        $conn->query($op_data);
		        $op_data = '';
		    }
		}
		echo '<p style="color:green;">Base de dados ' .$nomeDB .' importada!</p>';
		$conn->close();
	?>

</body>
</html>