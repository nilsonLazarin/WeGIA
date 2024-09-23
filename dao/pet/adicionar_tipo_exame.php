<?php
require_once "../Conexao.php";
$pdo = Conexao::connect();

$tipo_exame = $_POST["tipo_exame"];

$sql = "INSERT INTO pet_tipo_exame(descricao_exame) values('" .$tipo_exame ."')";
$pdo->query($sql);
$pd = $pdo->query("SELECT * FROM pet_tipo_exame");
$p = $pd->fetchAll();
$array = array();
foreach ($p as $valor) {
    $array[] = array('id_tipo_exame'=>$valor['id_tipo_exame'], 'tipo_exame' => $valor['descricao_exame']);
}

echo json_encode($p);
?>
