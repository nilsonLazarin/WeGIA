<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

	extract($_REQUEST);
	var_dump($_REQUEST);
	include_once $nomeClasse.".php";
	$objeto = new $nomeClasse();
	$objeto->$metodo();
?>