<?php
    require("../conexao.php");

    // Processando o input POST
    if (!isset($_POST) or empty($_POST)) {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        $_POST = $data;
    } else if (is_string($_POST)) {
        $_POST = json_decode($_POST, true);
    }
    
    // Verificando se todas as variáveis necessárias estão definidas
    $required_fields = ['codigo', 'descricao', 'data_emissao', 'data_vencimento', 'data_pagamento', 'valor', 'valor_pago', 'status', 'link_cobranca', 'link_boleto', 'linha_digitavel', 'id_socio'];
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            die("Campo $field não está definido.");
        }
    }
    
    // Sanitizando e escapando os valores das variáveis
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
    
    // Utilizando prepared statements para evitar SQL Injection
    $stmt = $conexao->prepare("INSERT INTO cobrancas (`codigo`, `descricao`, `data_emissao`, `data_vencimento`, `data_pagamento`, `valor`, `valor_pago`, `status`, `link_cobranca`, `link_boleto`, `linha_digitavel`, `id_socio`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssddssssi", $codigo, $descricao, $data_emissao, $data_vencimento, $data_pagamento, $valor, $valor_pago, $status, $link_cobranca, $link_boleto, $linha_digitavel, $id_socio);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    
    $stmt->close();
    $conexao->close();
?>