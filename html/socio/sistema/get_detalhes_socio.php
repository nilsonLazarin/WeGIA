<?php
require("../conexao.php");
if (!isset($_POST) or empty($_POST)) {
    $data = file_get_contents("php://input");
    $data = json_decode($data, true);
    $_POST = $data;
} else if (is_string($_POST)) {
    $_POST = json_decode($_POST, true);
}
$conexao->set_charset("utf8");
extract($_REQUEST);

// Primeiro statement
$sql1 = "SELECT *, sp.nome_sistema as sistema_pagamento, 
        DATE_FORMAT(lc.data, '%d/%m/%Y') as data_geracao, 
        DATE_FORMAT(lc.data_venc_boleto, '%d/%m/%Y') as data_vencimento, 
        s.id_socio as socioid 
        FROM socio AS s 
        LEFT JOIN pessoa AS p ON s.id_pessoa = p.id_pessoa 
        LEFT JOIN socio_tipo AS st ON s.id_sociotipo = st.id_sociotipo 
        LEFT JOIN log_contribuicao AS lc ON lc.id_socio = s.id_socio 
        LEFT JOIN sistema_pagamento as sp ON sp.id = lc.id_sistema 
        LEFT JOIN socio_tag stag ON stag.id_sociotag = s.id_sociotag 
        WHERE s.id_socio = ?";

$stmt1 = mysqli_prepare($conexao, $sql1);

mysqli_stmt_bind_param($stmt1, 'i', $id_socio);

mysqli_stmt_execute($stmt1);

// Obter o resultado do statement
$result1 = mysqli_stmt_get_result($stmt1);

$dados['log_contribuicao'] = [];
while ($resultado = mysqli_fetch_assoc($result1)) {
    $dados['log_contribuicao'][] = $resultado;
}

// Fechar o primeiro statement
mysqli_stmt_close($stmt1);

// Segundo statement
$sql2 = "SELECT *, 
        DATE_FORMAT(data_emissao, '%d/%m/%Y') as data_emissao, 
        DATE_FORMAT(data_vencimento, '%d/%m/%Y') as data_vencimento, 
        DATE_FORMAT(data_pagamento, '%d/%m/%Y') as data_pagamento 
        FROM cobrancas c 
        JOIN socio s ON s.id_socio = c.id_socio 
        JOIN pessoa p ON s.id_pessoa = p.id_pessoa 
        WHERE s.id_socio = ?";

$stmt2 = mysqli_prepare($conexao, $sql2);

mysqli_stmt_bind_param($stmt2, 'i', $id_socio);

mysqli_stmt_execute($stmt2);

// Obter o resultado do statement
$result2 = mysqli_stmt_get_result($stmt2);

$dados['log_cobranca'] = [];
while ($resultado = mysqli_fetch_assoc($result2)) {
    $dados['log_cobranca'][] = $resultado;
}

// Fechar o segundo statement
mysqli_stmt_close($stmt2);

// Fechar a conexão
mysqli_close($conexao);

echo json_encode($dados);
