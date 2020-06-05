<?php
	require("conexao.php");
	if(!$conexao) header("./erros/bd_erro/");

	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];
	echo($login."<br>".$senha);

	$comando = "select * from usuario where usuario='$usuario' and senha=AES_ENCRYPT('$senha','token')";
	$resultado = mysqli_query($conexao,$comando);

	$linhas = mysqli_affected_rows($conexao);

	if($linhas){
		session_start();
		// echo("teste");
		$registro = mysqli_fetch_array($resultado);
		$_SESSION['cod_usuario'] =  $registro['id'];
		$_SESSION['nome'] =  $registro['nome'];
		if($registro['nivel'] == 0 || $registro['nivel'] == 1){
			header("Location: ./sistema/");
		}else if($registro['adm_configurado'] == 0){header("Location: ./configuracao/"); $_SESSION['adm_configurado'] = false;}
			else{header("Location: ./sistema/"); $_SESSION['adm_configurado'] = true;};
	}else header("Location: ./erros/login_erro/");


?>