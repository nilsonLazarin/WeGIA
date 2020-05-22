<?php

include_once "../classes/Despacho.php";
include_once "../dao/DespachoDAO.php";

class DespachoControle
{
	public function listarTodos()
	{
		extract($_REQUEST);
		$despachoDAO = new DespachoDAO();
		$despachos = $despachoDAO->listarTodos($id_memorando);
		$_SESSION['despacho']=$despachos;
	}

	public function incluir()
	{
		extract($_REQUEST);
		$despacho = $this->verificarDespacho();
		$despachoDAO = new DespachoDAO();

		try
		{
			$despachoDAO->incluir($despacho);
			header("Location: ../html/teste?".$_SESSION['despacho']."php");
		}
		catch(PDOException $e)
		{
			$msg= "Não foi possível criar o despacho"."<br>".$e->getMessage();
            echo $msg;
		}
	}

	public function verificarDespacho()
	{
		session_start();
		$cpf_usuario = $_SESSION["usuario"];
		extract($_REQUEST);
		if(!isset($texto) || (empty($texto)))
		{
			$msg = "Texto do despacho não informado. Por favor informe um texto";
		}
		$despacho = new DespachoDAO();
		$id_pessoa = 
	}
}

$despacho = new DespachoControle();
$despacho->listarTodos();
?>