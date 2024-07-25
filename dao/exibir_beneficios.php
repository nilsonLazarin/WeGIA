<?php
require_once 'Conexao.php';

try {
  $pdo = Conexao::connect();

  $sql = 'SELECT id_beneficios, descricao_beneficios FROM beneficios';
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if ($resultado) {
    $beneficios = $resultado;
  } else {
    $beneficios = [];
  }

  echo json_encode($beneficios);
} catch (PDOException $e) {
  echo 'Erro ao exibir benefícios: ' . $e->getMessage();
}
