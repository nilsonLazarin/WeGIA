<?php

function permissao($id_pessoa, $id_recurso, $id_acao = 1){
	define("DEBUG", true);
    $wegia_path = '';
    $config_path = "config.php";
	if(file_exists($wegia_path.$config_path)){
		require_once($wegia_path.$config_path);
	}else{
        $cont = 0;
		while($cont++ < 100){
            $wegia_path .= "../";
			if(file_exists($wegia_path.$config_path)) break;
		}
		require_once($wegia_path.$config_path);
	}
	$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
	if(!is_null($resultado)){
		$id_cargo = mysqli_fetch_array($resultado);
		if(!is_null($id_cargo)){
			$id_cargo = $id_cargo['id_cargo'];
		}
		$resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=$id_recurso");
		if(!is_bool($resultado) and mysqli_num_rows($resultado)){
			$permissao = mysqli_fetch_array($resultado);
			if($permissao['id_acao'] <= $id_acao){
				$msg = "Você não tem as permissões necessárias para essa página.".(DEBUG ? " Sem acesso!" : "" );
				header("Location: ".$wegia_path."/html/home.php?msg_c=$msg");
			}
			$permissao = $permissao['id_acao'];
		}else{
			$permissao = $id_acao;
			$msg = "Você não tem as permissões necessárias para essa página.".(DEBUG ? " Não há permissão!" : "" );
			header("Location: ".$wegia_path."/html/home.php?msg_c=$msg");
		}	
	}else{
		$permissao = $id_acao;
		$msg = "Você não tem as permissões necessárias para essa página.".(DEBUG ? " ID do funcionário não cadastrado!" : "" );
		header("Location: ".$wegia_path."/html/home.php?msg_c=$msg");
	}
}
?>