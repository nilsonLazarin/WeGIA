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
	public function listarTodos($id_memorando)
	{
		$id_despacho=0;
		extract($_REQUEST);
		$AnexoDAO = new AnexoDAO();
		$anexos = $AnexoDAO->listarTodos($id_memorando);
		if (session_status() !== PHP_SESSION_ACTIVE)
 		{
    		session_start();
		}
		$_SESSION['arquivos'] = $anexos;
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
			$tamanho = strlen($arquivo1);
			$pos = strpos($arquivo1, ".")+1;
			$extensao = substr($arquivo1, $pos, strlen($arquivo1)+1);
			$nome = substr($arquivo1, 0, $pos-1);

			$arquivo64 = comprimir($arquivo);

			$anexo = new Anexo();
			$anexo->setId_despacho($lastId);
    		$anexo->setAnexo($arquivo64);
    		$anexo->setNome($nome);
    		$anexo->setExtensao($extensao);	
    		$anexoDAO = new AnexoDAO();
			try
			{
				$anexoDAO->incluir($anexo);
			}
			catch(PDOException $e)
			{
				$msg= "Não foi possível criar o despacho"."<br>".$e->getMessage();
            	echo $msg;
			}
	}
	}

	public function comprimir($anexoParaCompressao)
	{
		$arquivo_zip = gzencode($anexoParaCompressao, 9);
		$arquivo64 = base64_encode($arquivo_zip);
		return $arquivo64;
	}
}
?>