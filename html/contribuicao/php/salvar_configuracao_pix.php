<?php
require_once('conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idSistema = 4;

    try {
        $conexao = new Conexao();
        $sql = "SELECT api, token_api FROM doacao_boleto_info WHERE id_sistema = :id_sistema";
        $stmt = $conexao->pdo->prepare($sql);
        $stmt->bindParam(':id_sistema', $idSistema, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            $api = $resultado['api'];
            $token_api = $resultado['token_api'];
            echo "API: " . $api . "<br>";
            echo "Token API: " . $token_api . "<br>";
        } else {
            echo "Nenhum dado encontrado para o ID do sistema especificado.";
        }
    } catch (PDOException $e) {
        echo "Erro ao selecionar dados: " . $e->getMessage();
    }
}
?>
