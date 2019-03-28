<html>
<head>
	 <link rel="stylesheet" type="text/css" href="css/theme.css">
</head>
<body>
	<?php
		$nomeDB = $_POST["nomebd"]; // nome da base de dados
		$localsql ='../' .$nomeDB .'.sql';  //local arquivo .sql
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
		
		//verificar se base de dados foi criada
		if(mysqli_select_db ($conn, $nomeDB))
		{
			
			echo '<p style="color:green;">Base de dados ' .$nomeDB .' importada!</p>';
		}
		else
		{
			echo '<p style="color:red;">Falha na criaçao do banco de dados! Verifique se o arquivo .sql está na pasta raiz do projeto e se o nome do banco de dados é igual ao nome do arquivo.sql</p>';
		}
		
		$conn->close();
	?>

</body>
</html>