<?php
	require("./conexao.php");
	if(!$conexao) header("Location: ./erros/bd_erro/");
	session_start();
	if(isset($_SESSION['cod_usuario'])) header("Location: ./sistema/");

	$comando = "select * from usuario where usuario='admin'";
	$resultado = mysqli_query($conexao,$comando);

	$linhas = mysqli_affected_rows($conexao);

	if($linhas){
		// echo("teste");
		$registro = mysqli_fetch_array($resultado);
		if($registro['adm_configurado'] == 0){
			header("Location: ./configuracao/"); 
			$_SESSION['adm_configurado'] = false;
		}
		else{$_SESSION['adm_configurado'] = true;};
	}

	$dados_config = mysqli_fetch_array(mysqli_query($conexao, "SELECT `id`, `nome`, `foto_login`, `mensagem_login` FROM `configuracao` WHERE 1"));
	$nome = $dados_config['nome'];
	$foto_login = $dados_config['foto_login'];
	$mensagem_login = $dados_config['mensagem_login'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Sistema SaGA - <?php echo($nome); ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="login/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
	<script src="https://kit.fontawesome.com/d7eb01c67c.js" crossorigin="anonymous"></script>
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="login.php" method="post">
					<span class="login100-form-title p-b-43">
						<?php echo($nome); ?>
					</span>
					
					
					<div class="wrap-input100 validate-input" data-validate = "Digite um usuário válido!">
						<input class="input100" type="text" name="usuario">
						<span class="focus-input100"></span>
						<span class="label-input100">Usuário</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate="Digite sua senha!">
						<input class="input100" type="password" name="senha">
						<span class="focus-input100"></span>
						<span class="label-input100">Senha</span>
					</div>
			

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					<div class="alert alert-dark mt-4" role="alert">
						<?php echo($mensagem_login); ?>
					</div>
				</form>


				<div class="login100-more" style="background-image: url('<?php echo($foto_login) ?>');">
				</div>
			</div>
		</div>
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/daterangepicker/moment.min.js"></script>
	<script src="login/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="login/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="login/js/main.js"></script>

</body>
</html>