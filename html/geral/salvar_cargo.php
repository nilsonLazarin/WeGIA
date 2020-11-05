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
    $resultado = mysqli_query($conexao, "UPDATE `cargo` SET `cargo`='$value' WHERE id_cargo=$id_cargo");
    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "Cargo salvo com sucesso.";
        $_SESSION['link'] = "./geral/cargos.php";
        $_SESSION['proxima'] = "Listar cargos";
        header("Location: ../sucesso.php");
    }else{
        header("Location: ./cargos.php?msg_e=Erro ao modificar cargo.");
    }
?>