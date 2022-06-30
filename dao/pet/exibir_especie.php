<?php	
    require_once'../Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from pet_especie';
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('id_especie'=>$row['id_pet_especie'],'especie'=>$row['descricao']);
	}
	echo json_encode($resultado);

?>