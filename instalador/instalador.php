<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/theme.css">
	<?php function exibirVoltar(){echo '<a href="JavaScript: window.history.back();">Voltar</a>';} ?>
</head>
<body>
	<?php

		function getExtensao($filename){
			$file = explode(".", $filename);
			if (sizeof($file) < 2){
				return false;
			}
			return (end($file) != '' ? end($file) : false);
		}

		function validSqlFiles($fileList){
			$files = $fileList;
			foreach ($files as $key => $file){
				$extensao = getExtensao($file);
				if (!$extensao){
					unset($files[$key]);
					continue;
				}
				if ($extensao != "sql"){
					unset($files[$key]);
					continue;
				}
				if (stristr($file, "test")){
					unset($files[$key]);
					continue;
				}
			}
			return array_values($files);
		}


		$nomeDB = str_replace(' ', '_', $_POST["nomebd"]); // nome da base de dados
		$dbDir = scandir("../BD/");
		//$localsql = '../BD/WeGIA-criacao.sql';  //local arquivo .sql
		$local = $_POST["local"];//local servidor mysql
		$user = $_POST["usuario"];
		$senha = $_POST["senha"];
		$backup = $_POST["backup"];
		$www = $_POST["www"];
		$reinstalar = isset($_POST["reinstalar"]);

		//Cria um diretório de Backup caso não haja um
		if (!is_dir($backup)) {
			$backup = "";
		}

		//Verifica se config.php já existe
		if (!file_exists("../config.php")){
			//Se não existir, cria um
			$file_name = realpath('../').'/config.php';
			$file = fopen($file_name, "w");


			fwrite($file, "<?php
/**
 *Configuração do WEGIA
*/
define( 'DB_NAME', '$nomeDB' );
define( 'DB_USER', '$user' );
define( 'DB_PASSWORD', '$senha' );
define( 'DB_HOST', '$local');
define( 'DB_CHARSET', 'utf8');
define( 'ROOT',dirname(__FILE__));
define( 'BKP_DIR', '$backup');
define( 'WWW', '$www');");


			echo('<p style="color:green;">config.php criado!</p>');
			if (!$backup){
				echo('<p style="color:orange;">Diretório para Backup não existe!</p>');
			}
		}



		/*conexao*/
		$conn = new mysqli($local, $user, $senha);
		verificarConexao($conn->connect_errno);//verificar se conexao foi estabelecida
		
		/*verificar reinstalar*/	
		if(mysqli_select_db ($conn, $nomeDB))//verificar se db já existe
		{
			if(!$reinstalar)//verificar se opçao de reinstalar foi marcada
			{
				$conn->close();
				echo '<p style="color:orange;">Base de dados já existe!</p>';
				exibirVoltar();
			}
		}else{
			$conn->query("CREATE DATABASE ".$nomeDB.";");//criar db
		}

		/*importar base de dados*/
		
		if (PHP_OS != "Linux"){
			echo("<p style='color:red;'>O software é compatível apenas com Linux. Seu Sistema Operacional é ".PHP_OS."</p>");
			die();
		}
		$sqlFiles = validSqlFiles($dbDir);
		foreach ($sqlFiles as $key => $file){
			$log = shell_exec("mysql -u $user -p$senha $nomeDB < ".realpath("../BD/$file")."");
			if (!$log){
				echo("<p style='color:orange;'>Houve uma falha ao importar o arquivo $file<p>");
			}else{
				echo("<p style='color:green;'>Log da importação do arquivo $file<pre>$log</pre></p>");
			}
		}

		/*
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
		*/
		
		/*verificar se base de dados foi criada*/
		if(mysqli_select_db ($conn, $nomeDB)) 
			echo '<p style="color:green;">Base de dados ' .$nomeDB .' importada!</p>';
		else
			die('<p style="color:red;">Falha na criaçao do banco de dados! Verifique se o nome do banco de dados foi inserido corretamente e se o usuario "' .$user .'" possui permissão para criar banco de dados.</p>');

		/*configurar arquivo conexao dao*/
		//configurarConexaoDao($local,$nomeDB, $user, $senha);


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
		/*
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
		}*/
		
	?>
	
</body>
</html>