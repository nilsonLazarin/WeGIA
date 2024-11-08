<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'contribuicao/php/conexao.php';

if (isset($_GET['almoxarifado_id'])) {
    $almoxarifadoId = $_GET['almoxarifado_id'];

    try {
        $conexao = new Conexao();
        $sql = "
            SELECT p.id_produto, p.descricao
            FROM produto p
            JOIN estoque e ON p.id_produto = e.id_produto
            WHERE e.id_almoxarifado = :almoxarifado_id
            ORDER BY p.descricao
        ";
        $stmt = $conexao->pdo->prepare($sql);
        $stmt->bindParam(':almoxarifado_id', $almoxarifadoId, PDO::PARAM_INT);
        $stmt->execute();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($produtos);
    } catch (PDOException $e) {
        echo json_encode(["error" => "Erro ao consultar o banco de dados: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "almoxarifado_id não foi fornecido."]);
}
?>
