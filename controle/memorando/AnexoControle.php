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

			//NAO APAGAR OS COMENTARIOS!!!!!!!!!!!!
			//NAO APAGAR OS COMENTARIOS!!!!!!!!!!!!
			//NAO APAGAR OS COMENTARIOS!!!!!!!!!!!!

			//$arquivo64 = base64_encode($arquivo);

			//$zip = new ZipArchive();
			/*if($zip->open('anexo_zip.zip', ZIPARCHIVE::CREATE) == TRUE)
			{
				$zip->addFile($arq['tmp_name'][$i], $nome.".".$extensao);
			}
			var_dump($zip);
			$caminho=$zip->filename;
			$zip->close();
			$arquivo_zip = file_get_contents($caminho);
			$arquivo64 = base64_encode($arquivo_zip);
			unlink('anexo_zip.zip');*/
			$arquivo_zip = gzencode($arquivo, 9);
			$arquivo64 = base64_encode($arquivo_zip);

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
?>