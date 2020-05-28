<?php

include_once "../classes/Despacho.php";
include_once "../dao/DespachoDAO.php";
include_once "../dao/MemorandoDAO.php";

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
			//header("Location: ../html/listar_despachos.php?id_memorando=".$_GET['id_memorando']);
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

		$pessoa = new MemorandoDAO();
    	$id_pessoa = $pessoa->obterUsuario($cpf_usuario);
    	$id_pessoa = $id_pessoa['0']['id_pessoa'];
    	$anexo = $anexo;
    	
    	$despacho = new Despacho($texto);
    	$despacho->setId_remetente($id_pessoa);
    	$despacho->setData();
    	$despacho->setId_destinatario($destinatario);
    	$despacho->setId_memorando($id_memorando);

    	return $despacho;
	}
}

$despacho = new DespachoControle();
$despacho->listarTodos();
?>