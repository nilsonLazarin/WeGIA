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
    $resultado = mysqli_query($conexao, "DELETE FROM `permissao` WHERE id_cargo=$c and id_acao = $a and id_recurso = $r");
    if(mysqli_affected_rows($conexao)){
        $_SESSION['msg'] = "Permissão deletada com sucesso.";
        $_SESSION['link'] = "./geral/listar_permissoes.php";
        $_SESSION['proxima'] = "Listar permissões";
        header("Location: ../sucesso.php");
    }else{
        header("Location: ./listar_permissoes.php?msg_e=Erro ao deletar permissão.");
    }
?>