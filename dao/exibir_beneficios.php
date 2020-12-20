<?php
  require_once'Conexao.php';
  $pdo = Conexao::connect();

  $sql = 'select * from beneficios';
  $stmt = $pdo->query($sql);
  $resultado = array();
  while ($row = $stmt->fetch()) {
    $resultado[] = array('id_beneficios'=>$row['id_beneficios'],'descricao_beneficios'=>$row['descricao_beneficios']);
  }
  echo json_encode($resultado);
?>