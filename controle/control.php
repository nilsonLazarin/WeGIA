<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

	extract($_REQUEST);
	require_once "/var/www/html/WeGIA/dao/Conexao.php";

	if(isset($modulo))
	{
	include_once $caminho."controle/".$modulo."/".$nomeClasse.".php";
	$objeto = new $nomeClasse();
	$objeto->$metodo();
	}
	else
	{
	include_once $nomeClasse.".php";
	$objeto = new $nomeClasse();
	$objeto->$metodo();
	}
?>