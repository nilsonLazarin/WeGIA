<?php
	extract($_REQUEST);
	include_once $nomeClasse.".php";
	$objeto = new $nomeClasse();
	$objeto->$metodo();
?>