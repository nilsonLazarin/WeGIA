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
	public function listarTodos($id_memorando)
	{
		try{
		$Anexos = array();
		$pdo = Conexao::connect();
		$consulta = $pdo->query("SELECT a.anexo, a.extensao, a.nome, d.id_despacho FROM anexo a JOIN despacho d ON(a.id_despacho=d.id_despacho) JOIN memorando m ON(d.id_memorando=m.id_memorando) WHERE m.id_memorando=$id_memorando");
		$x = 0;

			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
			{
				$AnexoDAO = new AnexoDAO;
				$base64_encode = $AnexoDAO->descomprimir($linha['anexo']);
				$link = "data:image/".$linha['extensao'].";base64,".$base64_encode;
				$Anexos[$x] = array('anexo'=>$link, 'extensao'=>$linha['extensao'], 'nome'=>$linha['nome'], 'id_despacho'=>$linha['id_despacho']);
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

	public function descomprimir($arquivoParaDescomprimir)
	{
		$base64 = base64_decode($arquivoParaDescomprimir);
		$gz = gzdecode($base64);
		$base64_encode = base64_encode($gz);
		return $base64_encode;
	}
}
?>