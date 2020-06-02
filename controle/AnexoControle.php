<?php

include_once "../classes/Anexo.php";
include_once "../dao/AnexoDAO.php";

class AnexoControle
{
	public function listarTodos()
	{
		extract($_REQUEST);
		$AnexoDAO = new AnexoDAO();
		$anexos = $AnexoDAO->listarTodos($id_despacho);
		$_SESSION['anexo'] = $anexos;
		//header("Location: ../html/listar_despachos.php?id_memorando=".$_GET['id_memorando']);
	}

	public function incluir($anexo, $lastId)
	{
		extract($_REQUEST);
		$total = count($anexo['name']);
		for($i=0; $i<$total; $i++)
		{
			$arquivo = file_get_contents($anexo['tmp_name'][$i]);
			$arquivo1 = $anexo['name'][$i];
			$arquivo64 = base64_encode($arquivo);
			$tamanho = strlen($arquivo1);
			$pos = strpos($arquivo1, ".")+1;
			$extensao = substr($arquivo1, $pos, strlen($arquivo1)+1);
			$nome = substr($arquivo1, 0, $pos-1);
			$anexo = new Anexo();
			$anexo->setId_despacho($lastId);
    		$anexo->setAnexo($arquivo64);
    		$anexo->setNome($nome);
    		$anexo->setExtensao($extensao);	
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

	/*public function verificarAnexo()
	{
        $arquivo=file_get_contents($this['tmp_name'][$i]);
        $arquivo1=$this['name'][$i];
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
	}*/
}
$anexo = new AnexoControle();
$anexo->listarTodos();

?>