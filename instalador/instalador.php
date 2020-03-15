<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/theme.css">
	<?php function exibirVoltar(){echo '<a href="JavaScript: window.history.back();">Voltar</a>';} ?>
</head>
<body>
	<?php
		$nomeDB = str_replace(' ', '_', $_POST["nomebd"]); // nome da base de dados
		$localsql = '../wegia.sql';  //local arquivo .sql
		$local = $_POST["local"];//local servidor mysql
		$user = $_POST["usuario"];
		$senha = $_POST["senha"];
		$reinstalar = isset($_POST["reinstalar"]);

		/*conexao*/
		$conn = new mysqli($local, $user, $senha);
		verificarConexao($conn->connect_errno);//verificar se conexao foi estabelecida
		
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
			die('<p style="color:red;">Falha na criaçao do banco de dados! Verifique se o nome do banco de dados foi inserido corretamente e se o usuario "' .$user .'" possui permissão para criar banco de dados.</p>');

		/*configurar arquivo conexao dao*/
		configurarConexaoDao($local,$nomeDB, $user, $senha);


		$conn->close();
		exibirVoltar();


		/*funcoes*/
		//Verificar e tratar erros de conexao 
		function verificarConexao($erro)
		{
			if($erro == 0) return;
			$msg = 'Erro '.$erro .': ';

			switch ($erro) {
				case 1045:
					$msg .='Nome de usuario e/ou senha incorreto(s).';
					break;
				case 2002:
					$msg .= 'Servidor MYSQL não encontrado.';
					break;
			}
			echo '<p style="color:red;">' .$msg .'</p>';
			exibirVoltar();
			die();
		}

		//Configurar arquivo 'Conexao' da pasta Dao
		function configurarConexaoDao($host, $dbname, $user, $senha){
			$localDao = '../dao/conexao.php';
			$lines = file($localDao);
			$saida = '';
			foreach ($lines as $line) {
				if(strpos($line, 'new PDO') != false)//achar linha a ser alterada
				{
					$comando = explode("=", $line);//separar nome da variavel original e instanciação
					$saida .= $comando[0] ."=";//guardar nome original da variavel
					$saida .= " new PDO('mysql:host=" .$host ."; dbname=" .$dbname ."','" .$user ."','" .$senha ."');\n"; //nova instanciação
					continue;
				}

				$saida .= $line;
			}

			file_put_contents($localDao, $saida);
			echo '<p style="color:green;">Arquivo conexao.php alterado com sucesso!</p>';
		}
		
	?>
	
</body>
</html>