<?php

if(file_exists("../config.php")){
        require_once("../config.php");
    }else if(file_exists("config.php")){
        require_once("config.php");
    }

$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$conexao)
        die("Não foi possivel conectar".mysql_error());
        
mysqli_select_db($conexao, DB_NAME) or die ("Erro ao selecionar banco de dados".mysql_error());

?>