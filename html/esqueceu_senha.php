<html>
<?php 
	date_default_timezone_set("America/Sao_Paulo");
	require_once '../dao/Conexao.php';
	require_once '../Functions/funcoes.php';

?>
	<head>
		<title>Recuperar Senha</title>
	</head>
	<body>
		<?php
			if(isset($_POST['acao']) && $_POST['acao'] == "recuperar"){
				$cpf = $_POST["cpf"];
				echo $cpf;

				$pdo = Conexao::connect();
				$consulta = $pdo->query("SELECT cpf,senha FROM pessoa WHERE cpf = '$cpf'");

				if(mysql_num_rows($consulta) == 1){
					
					$codigo = base64_encode("cpf");
					echo "Entrar";
					$data_expirar = date('Y-m-h H:i:s', strtotime('+1day'));
					$mensagem = '<p>Clique no link abaixo para alterar a senha:<br> <a href="./html/recuperar.php?codigo='.$codigo.'">Recuperar Senha</a></p>';
					$inserir = mysql_query("INSERT INTO 'codigos' SET codigo = '$codigo', data = '$data_expirar'");
					echo "Entrou";
					if($inserir){
						echo $mensagem;
					}
					
				}

			}
		
		?>
		<form action="" method="post" enctype="multipart/form-data">
			<input type="text" name="cpf">
			<input type="hidden" name="acao" value="recuperar">
			<input type="submit" name="Recuperar Senha">
			<a href="../index.php">Logar</a>
		</form>
	</body>
</html>