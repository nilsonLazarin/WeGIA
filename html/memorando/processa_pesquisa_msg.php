<?php

require_once'Conexao.php';
  $pdo = Conexao::connect();

$nome=filter_input(INPUT_GET,'term', FILTER_SANITIZE_STRING);

//sql para selecionar os registros.
$result_msg_cont=" SELECT p.nome  FROM pessoa p JOIN funcionario f ON(f.id_funcionario=p.id_pessoa) WHERE p.nome LIKE '$nome%' ORDER BY $nome ASC limit 5 ; "


//selecionar os registros
$resultado_msg_conteudo=$pdo->prepare($result_msg_cont)
$resultado_msg_conteudo->execute();

while($row_msg_conteudo = $resultado_msg_conteudo )->fetch(PDO: : FETCH_ASSOC)){
$data[]=$row_msg_conteudo['nome']

}

echo json_encode($data)



?>