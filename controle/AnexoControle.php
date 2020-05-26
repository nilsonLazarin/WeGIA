<?php

include_once "../classes/Anexo.php";
include_once "../dao/AnexoDAO.php";

class AnexoControle
{
	public function listarTodos()
	{
		extract($_REQUEST);
		$AnexoDAO = new AnexoDAO();
		$anexos = $anexoDAO->listarTodos($id_despacho);
		$_SESSION['anexo'] = $anexos;
	}

	public function incluir()
	{
		extract($_REQUEST);
		$anexo = $this->verificarAnexo();
		$anexoDAO = new AnexoDAO();

		try
		{
			$anexoDAO->incluir($anexo);
			header("Location: ../html/listar_despachos.php?id_memorando=".$_GET['id_memorando']);
		}
		catch(PDOException $e)
		{
			$msg= "Não foi possível criar o despacho"."<br>".$e->getMessage();
            echo $msg;
		}
	}

	public function verificarAnexo()
	{
		/*$arquivos = $_FILES['arquivo'];
        $total = count($arquivos['name']);
        for($i=0; $i<$total; $i++)
        {
        $arquivo=file_get_contents($arquivos['tmp_name'][$i]);
        $arquivo1=$arquivos['name'][$i];
        $arquivo64=base64_encode($arquivo);
        $tamanho=strlen($arquivo1);
        $pos = strpos ($arquivo1 , $ponto)+1;
        $ext=substr($arquivo1, $pos, strlen($arquivo1)+1);
        $nome=substr($arquivo1, 0, $pos-1);*/
		if(!isset($anexo) || empty($anexo))
		{
			$msg = "Anexo não informado. Por favor informe um anexo";
		}
		if(!isset($extensao) || empty($extensao))
		{
			$msg = "Extensao não informada. Por favor informe uma extensao";
		}
		if(!isset($nome) || empty($nome))
		{
			$msg = "Nome do arquivo não informado. Por favor informe um nome do arquivo";
		}

    	$anexo = new Anexo();
    	$anexo->setId_despacho($id_despacho);
    	$anexo->setAnexo($anexo);
    	$anexo->setNome($nome);
    	$anexo->setExtensao($extensao);

    	return $anexo;
	}
}

//$despacho = new DespachoControle();
//$despacho->listarTodos();

?>