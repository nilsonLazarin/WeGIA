<?php
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
    $resultado = mysqli_query($conexao, "SELECT `id_recurso` FROM `modulos_visiveis` WHERE `visivel` = 1");
    $modulos = array();
    $i = 0;
    while($modulo = $resultado->fetch_array(MYSQLI_NUM))
    {
        $modulos[$i] = $modulo[0];
        $i++;
    }
    echo json_encode($modulos);
?>