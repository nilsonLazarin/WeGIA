<?php
    require("../conexao.php");

    if (!isset($_POST) or empty($_POST)) {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        $_POST = $data;
    } else if (is_string($_POST)) {
        $_POST = json_decode($_POST, true);
    }

    $required_fields = ['codigo', 'descricao', 'data_emissao', 'data_vencimento', 'data_pagamento', 'valor', 'valor_pago', 'status', 'link_cobranca', 'link_boleto', 'linha_digitavel', 'id_socio'];
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            die("Campo $field não está definido.");
        }
    }
    
    $codigo = (int)$_POST['codigo'];
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $data_emissao = mysqli_real_escape_string($conexao, $_POST['data_emissao']);
    $data_pagamento = mysqli_real_escape_string($conexao, $_POST['data_pagamento']);
    $data_vencimento = mysqli_real_escape_string($conexao, $_POST['data_vencimento']);
    $valor = (float)$_POST['valor'];
    $valor_pago = (float)$_POST['valor_pago'];
    $status = mysqli_real_escape_string($conexao, $_POST['status']);
    $link_cobranca = mysqli_real_escape_string($conexao, $_POST['link_cobranca']);
    $link_boleto = mysqli_real_escape_string($conexao, $_POST['link_boleto']);
    $linha_digitavel = mysqli_real_escape_string($conexao, $_POST['linha_digitavel']);
    $id_socio = (int)$_POST['id_socio'];
    
    $stmt = mysqli_prepare($conexao, "INSERT INTO cobrancas (`codigo`, `descricao`, `data_emissao`, `data_vencimento`, `data_pagamento`, `valor`, `valor_pago`, `status`, `link_cobranca`, `link_boleto`, `linha_digitavel`, `id_socio`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Erro ao preparar a consulta: " . htmlspecialchars(mysqli_error($conexao)));
    }

    mysqli_stmt_bind_param($stmt, "issssddssssi", $codigo, $descricao, $data_emissao, $data_vencimento, $data_pagamento, $valor, $valor_pago, $status, $link_cobranca, $link_boleto, $linha_digitavel, $id_socio);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
?>