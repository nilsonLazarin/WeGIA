
<?php

require_once "../classes/Memorando.php";
require_once "../dao/MemorandoDAO.php";

class MemorandoControle

{

	public function listarTodos()

	{

		extract($_REQUEST);
		$memorandoDAO = new MemorandoDAO();
		$memorandos = $memorandoDAO->listarTodos();
		session_start();
		$_SESSION['memorando']=$memorandos;

	}

}


?>