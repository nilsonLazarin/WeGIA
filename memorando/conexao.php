<?php

$servidor="localhost";
$usuario="root";
$senha='';
$banco="wegia";

$conexao = mysqli_connect($servidor, $usuario, $senha);
	if(!$conexao)
        die("Não foi possivel conectar".mysql_error());
        
mysqli_select_db($conexao, $banco) or die ("Erro ao selecionar banco de dados".mysql_error());

?>