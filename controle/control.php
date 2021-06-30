<?php


ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
 


	if(isset($modulo))
	{
		include_once $modulo."/".$nomeClasse.".php";
		$objeto = new $nomeClasse();
		$objeto->$metodo();
	}
	else
	{
	include_once $nomeClasse.".php";
	$objeto = new $nomeClasse();
	$objeto->$metodo();
	}
<<<<<<< HEAD

=======
	die()
>>>>>>> 52e0f4c0a2e8318b4c137bf994afbe97d1c7d3a2
?>