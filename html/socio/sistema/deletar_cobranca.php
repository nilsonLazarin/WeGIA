<?php
    session_start();
    if(!isset($_SESSION['usuario'])) die("Você não está logado(a).");
    $config_path = "config.php";
	if(file_exists($config_path)){
		require_once($config_path);
	}else{
		while(true){
			$config_path = "../" . $config_path;
			if(file_exists($config_path)) break;
		}
		require_once($config_path);
	}
    extract($_REQUEST);
    $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $cobranca = mysqli_real_escape_string($conexao, $cobranca);
    $resultado = mysqli_query($conexao, "DELETE FROM `cobrancas` WHERE codigo=$cobranca");
    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "Cobrança deletada com sucesso.";
        $_SESSION['link'] = "./socio/sistema/cobrancas.php";
        $_SESSION['proxima'] = "Listar Cobranças";
        header("Location: ../../sucesso.php");
    }else{
        header("Location: ./cobrancas.php?msg_e=Erro ao deletar cobrança.");
    }
?>