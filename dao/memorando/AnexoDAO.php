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
require_once ROOT."/dao/Conexao.php";
require_once ROOT."/Functions/funcoes.php";

class AnexoDAO
{
	public function listarTodos($id_despacho)
	{
		try{
		$Anexos = array();
		$pdo = Conexao::connect();
		$consulta = $pdo->query("SELECT anexo, extensao, nome FROM anexo WHERE id_despacho=$id_despacho");
		$x = 0;

			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
			{
				$link = "data:image/".$linha['extensao'].";base64,".$linha['anexo'];
				$Anexos[$x] = array('anexo'=>$link, 'extensao'=>$linha['extensao'], 'nome'=>$linha['nome']);
				$x++;
			}
		}
		catch(PDOException $e)
		{
			echo 'Error:' . $e->getMessage;
		}

		return json_encode($Anexos);
	}

	public function incluir($anexo)
	{
		try
		{
			$sql = "call insanexo(:id_despacho, :anexo, :extensao, :nome)";
			$sql = str_replace("'", "\'", $sql);
			$pdo = Conexao::connect();
			$id_despacho = $anexo->getId_despacho();
			$arquivo = $anexo->getAnexo();
			$extensao = $anexo->getExtensao();
			$nome = $anexo->getNome();
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':id_despacho', $id_despacho);
			$stmt->bindParam(':anexo', $arquivo);
			$stmt->bindParam(':extensao', $extensao);
			$stmt->bindParam(':nome', $nome);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			echo 'Error:' . $e->getMessage();
		}
	}
}
?>