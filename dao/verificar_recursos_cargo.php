<?php
require_once '../config.php';
require_once './Conexao.php';

$cargo = trim(filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_NUMBER_INT));

if (!$cargo || $cargo < 1) {
    http_response_code(400);
    echo json_encode(['erro' => 'O id de um cargo deve ser um inteiro positivo maior ou igual a 1.']);
    exit();
}

try {
    $pdo = Conexao::connect();

    $sql = 'SELECT id_recurso FROM permissao WHERE id_cargo=:cargo';

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':cargo', $cargo);

    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $recursos = [];

    foreach($resultados as $resultado){
        $recursos []= $resultado['id_recurso'];
    }

    echo json_encode($recursos);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['erro' => 'Falha ao estabelecer conexão com o servidor.']);
}
