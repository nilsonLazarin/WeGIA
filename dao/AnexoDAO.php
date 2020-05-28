<?php

require_once "../classes/Anexo.php";
require_once "Conexao.php";
require_once "../Functions/funcoes.php";

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
				$link = "data:image/".$linha['extesao'].";base64,".$linha['anexo'];
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