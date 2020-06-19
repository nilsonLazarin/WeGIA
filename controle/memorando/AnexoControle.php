<?php

$config_path = "config.php";
if(file_exists($config_path)){
    require_once($config_path);
}else{
    while(true){
        $config_path = "../" . $config_path;
        if(file_exists($config_path)) break;
    }
    require_once($config_path);
}

require_once ROOT."/classes/memorando/Anexo.php";
require_once ROOT."/dao/memorando/AnexoDAO.php";

class AnexoControle
{
	public function listarTodos()
	{
		$id_despacho=0;
		extract($_REQUEST);
		$AnexoDAO = new AnexoDAO();
		$anexos = $AnexoDAO->listarTodos($id_despacho);
		session_start();
		$_SESSION['arquivos'] = $anexos;
		header("Location: ".WWW."html/memorando/listar_despachos.php?id_memorando=".$_GET['id_memorando']);
	}

	public function incluir($anexo, $lastId)
	{
		extract($_REQUEST);
		$total = count($anexo['name']);
		$arq = $_FILES['anexo'];

		for($i=0; $i<$total; $i++)
		{
			$anexo_tmpName=$arq['tmp_name'];
			$arquivo = file_get_contents($anexo_tmpName[$i]);
			$arquivo1 = $arq['name'][$i];
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
			//header("Location: ../html/memorando/listar_despachos.php?id_memorando=".$_GET['id_memorando']);
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