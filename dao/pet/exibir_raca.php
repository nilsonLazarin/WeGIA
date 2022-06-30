<?php	
    require_once'../Conexao.php';
	$pdo = Conexao::connect();

	$sql = 'select * from pet_raca';
	$stmt = $pdo->query($sql);
	$resultado = array();
	while ($row = $stmt->fetch()) {
    	$resultado[] = array('id_raca'=>$row['id_pet_raca'],'raca'=>$row['descricao']);
	}
	echo json_encode($resultado);

?>