<?php
require_once '../../dao/Conexao.php';

if (!isset($_SESSION["usuario"])){
    header("Location: ../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 53, 7);

$alergiaNome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
if(!$alergiaNome){
	echo 'O nome de uma alergia não pode ser vazio!';
	exit(400);
}

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$ultima_alergia = $mysqli->query("SELECT * FROM saude_tabelacid WHERE CID LIKE 'T78.4.%' ORDER BY CAST(SUBSTRING_INDEX(CID, '.', -1) AS UNSIGNED) DESC LIMIT 1");

if ($ultima_alergia->num_rows > 0) {
	$row = $ultima_alergia->fetch_assoc();
	$divided_row = explode(".", $row["CID"]);
	$row_number = end($divided_row);
	$row_number += 1;
	$alergia_CID = "T78.4." . $row_number;
} else $alergia_CID = "T78.4.0";

try {
	$pdo = Conexao::connect();
	$sql = "INSERT into saude_tabelacid(CID, descricao) values(:alergiaCid, :alergiaNome)";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':alergiaCid', $alergia_CID);
	$stmt->bindParam(':alergiaNome', $alergiaNome);
	$stmt->execute();
} catch (PDOException $e) {
	echo 'Erro ao adicionar nova alergia: ' . $e->getMessage();
}
