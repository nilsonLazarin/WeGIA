<?php
	require_once '../dao/Conexao.php';
	require_once '../Functions/funcoes.php';

	if(isset($_GET['codigo'])){
		$codigo = $_GET['codigo'];
		$cpf_codigo = base64_decode($codigo);
		$pdo = Conexao::connect();
		$consulta = $pdo->query('SELECT cpf from pessoa WHERE codigo = cpf AND data> NOW()');

		if (mysql_num_rows($consulta) >= 1) {
		if(isset($_POST['acao']) && $_POST['acao'] == 'mudar'){
			$nova_senha = $_POST['novasenha'];
			$pdo = Conexao::connect();
			$atualizar = $pdo->query('UPDATE usuarios SET senha = $nova_senha WHERE cpf = $cpf_codigo');
			if($atualizar){
				echo 'A senha foi modificada';
			}
		}

	?>

	<h1>Digite a senha nova</h1>
	<form action="" method="post" enctype="multipart/form-data">
	<input type="password" name="novasenha" value="">

	<input type="hidden" name="acao" value="mudar">

	<?php
	}else{
		echo '<h1>Desculpe mais este link já expirou!</h1>';
	}
		}

}
?>

	<input type="submit" name="Mudar Senha">
</form>