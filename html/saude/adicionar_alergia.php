<?php
	require_once '../../dao/Conexao.php';
	
	$pdo = Conexao::connect();
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$ultima_alergia = $mysqli->query("SELECT * FROM saude_tabelacid WHERE CID LIKE 'T78.4.%' ORDER BY CAST(SUBSTRING_INDEX(CID, '.', -1) AS UNSIGNED) DESC LIMIT 1");
	$s2 = $_POST["nome"];
	if($ultima_alergia->num_rows > 0){
		$row = $ultima_alergia->fetch_assoc();
		$divided_row = explode(".", $row["CID"]);
		$row_number = end($divided_row); 
		$row_number+=1;
	   $alergia_CID = "T78.4.".$row_number;
	  }
	else $alergia_CID = "T78.4.0";
	$sql = "INSERT into saude_tabelacid(CID, descricao) values('$alergia_CID', '$s2')";
	$pdo->query($sql);
?>