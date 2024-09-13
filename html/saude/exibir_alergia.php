<?php
	require_once'../../dao/Conexao.php';
	$pdo = Conexao::connect();

	try{
		$sql = "select * from saude_tabelacid WHERE CID LIKE 'T78.4.%'";
		$stmt = $pdo->query($sql);
		$resultado = array();
		while ($row = $stmt->fetch()) {
			$resultado[] = array('id_CID'=>$row['id_CID'],'CID'=>$row['CID'],'descricao'=>$row['descricao']);
		}
		echo json_encode($resultado);
	}catch (PDOException $e) {
        echo("Houve um erro ao realizar a exibição da alergia:<br><br>$e");
    }


?>