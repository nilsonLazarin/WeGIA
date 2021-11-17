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

require_once ROOT."/classes/Atendido_ocorrenciaDoc.php";
require_once ROOT."/dao/Conexao.php";
require_once ROOT."/Functions/funcoes.php";

class Atendido_ocorrenciaDocDAO
{
	// public function listarTodos($id_memorando)
	// {
	// 	try{
	// 	$Anexos = array();
	// 	$pdo = Conexao::connect();
	// 	$consulta = $pdo->query("SELECT a.extensao, a.nome, d.id_despacho, a.id_anexo FROM anexo a JOIN despacho d ON(a.id_despacho=d.id_despacho) JOIN memorando m ON(d.id_memorando=m.id_memorando) WHERE m.id_memorando=$id_memorando");
	// 	$x = 0;

	// 		while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
	// 		{
	// 			$AnexoDAO = new AnexoDAO;
	// 			$Anexos[$x] = array('extensao'=>$linha['extensao'], 'nome'=>$linha['nome'], 'id_despacho'=>$linha['id_despacho'], 'id_anexo'=>$linha['id_anexo']);
	// 			$x++;
	// 		}
	// 	}
	// 	catch(PDOException $e)
	// 	{
	// 		echo 'Error:' . $e->getMessage;
	// 	}
	// 	return json_encode($Anexos);
	// }

	// public function listarAnexo($id_anexo)
	// {
	// 	try
	// 	{	
	// 		$Anexo = array();
	// 		$pdo = Conexao::connect();
	// 		$consulta = $pdo->query("SELECT anexo FROM anexo WHERE id_anexo=$id_anexo");
	// 		$x = 0;

	// 		while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
	// 		{
	// 			$AnexoDAO = new AnexoDAO;
	// 			$decode = gzuncompress($linha['anexo']);
	// 			$Anexo[$x] = array('anexo'=>$decode);
	// 			$x++;
	// 		}
	// 	}
	// 	catch(PDOException $e)
	// 	{
	// 		echo 'Error:' . $e->getMessage;
	// 	}
	// 	return $Anexo;
	// }

	public function incluir($anexo)
	{
		try
		{
			$pdo = Conexao::connect();
			$consulta = $pdo->query("SELECT max(idatendido_ocorrencias) from atendido_ocorrencia;")->fetch(PDO::FETCH_ASSOC);
			
			$sql = "call insarquivo_ocorrencia(:atentido_ocorrencia_idatentido_ocorrencias, :arquivo_nome, :arquivo_extensao, :arquivo)";
			
			$id = $consulta['max(idatendido_ocorrencias)'];
			$arquivo = $anexo->getAnexo();
			$data = '2003-11-11';
			$extensao = $anexo->getExtensao();
			$nome = $anexo->getNome();
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':atentido_ocorrencia_idatentido_ocorrencias', $id);
			$stmt->bindParam(':arquivo', $arquivo);
			$stmt->bindParam(':arquivo_extensao', $extensao);
			$stmt->bindParam(':arquivo_nome', $nome);
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			echo 'Error:' . $e->getMessage();
		}
	}
}
?>