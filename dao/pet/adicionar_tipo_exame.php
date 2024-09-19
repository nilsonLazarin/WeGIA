<?php
require_once "../Conexao.php";

$pdo = Conexao::connect();
$tipo_exame = $_POST["tipo_exame"];

// Utilizando prepared statements para evitar injeções SQL
$sql = "INSERT INTO pet_tipo_exame(descricao_exame) VALUES (:tipo_exame)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':tipo_exame', $tipo_exame, PDO::PARAM_STR);

if ($stmt->execute()) {
    // Recupera todos os registros da tabela
    $pd = $pdo->query("SELECT * FROM pet_tipo_exame");
    $p = $pd->fetchAll(PDO::FETCH_ASSOC);
    
    $array = array();
    foreach ($p as $valor) {
        $array[] = array('id_tipo_exame' => $valor['id_tipo_exame'], 'tipo_exame' => $valor['descricao_exame']);
    }
    
    echo json_encode($array);
} else {
    echo json_encode(['error' => 'Erro ao inserir tipo de exame']);
}
?>
