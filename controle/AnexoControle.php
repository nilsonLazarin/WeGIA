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
		if(isset($_FILES['anexo']) && !empty($_FILES))
		{
		$anexo = $this->verificarAnexo();
		$anexoDAO = new AnexoDAO();

		try
		{
			$anexoDAO->incluir($anexo);
			//header("Location: ../html/listar_despachos.php?id_memorando=".$_GET['id_memorando']);
		}
		catch(PDOException $e)
		{
			$msg= "Não foi possível criar o despacho"."<br>".$e->getMessage();
            echo $msg;
		}
		}
	}

	public function verificarAnexo()
	{
		$arquivos = $_FILES['anexo'];
        $total = count($arquivos['name']);
        for($i=0; $i<$total; $i++)
        {
        $arquivo=file_get_contents($arquivos['tmp_name'][$i]);
        $arquivo1=$arquivos['name'][$i];
        $arquivo64=base64_encode($arquivo);
        $tamanho=strlen($arquivo1);
        $pos = strpos ($arquivo1 , $ponto)+1;
        $extensao=substr($arquivo1, $pos, strlen($arquivo1)+1);
        $nome=substr($arquivo1, 0, $pos-1);
        $anexo = new Anexo();
    	$anexo->setId_despacho($id_despacho);
    	$anexo->setAnexo($arquivo64);
    	$anexo->setNome($nome);
    	$anexo->setExtensao($extensao);

    	return $anexo;
    	}
	}
}

//$despacho = new DespachoControle();
//$despacho->listarTodos();

?>