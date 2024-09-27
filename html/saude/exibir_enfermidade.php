<?php
	require_once'../../dao/Conexao.php';
	$pdo = Conexao::connect();

	try{
		$sql = 'select * from saude_tabelacid';
		$stmt = $pdo->prepare($sql);
		$stmt = $pdo->execute();
		
		$resultado = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$resultado[] = array('id_CID'=>$row['id_CID'],'CID'=>$row['CID'],'descricao'=>$row['descricao']);
		}
		
		echo json_encode($resultado);
	} catch (PDOException $e) {
		// Em caso de erro, você pode registrar ou lidar com a exceção de forma apropriada
		error_log('Database error: ' . $e->getMessage());
		echo json_encode(array('error' => 'Unable to fetch data'));
	}
?>
