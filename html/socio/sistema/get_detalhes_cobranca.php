<?php
    require("../conexao.php");

    if (!$conexao) {
        die(json_encode(["error" => "Falha na conexão com o banco de dados."]));
    }

    if (!isset($_POST) or empty($_POST)) {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        $_POST = $data;
    } else if (is_string($_POST)) {
        $_POST = json_decode($_POST, true);
    }

    $conexao->set_charset("utf8");
    extract($_REQUEST);

    // Inicializa a variável $dados como um array vazio
    $dados = [];

    if (isset($codigo)) {
        $query = mysqli_query($conexao, "SELECT * FROM `cobrancas` c JOIN socio s ON c.id_socio = s.id_socio JOIN pessoa p ON s.id_pessoa = p.id_pessoa WHERE codigo = '$codigo'");
        
        if ($query) {
            while($resultado = mysqli_fetch_assoc($query)) {
                $dados[] = $resultado;
            }

            if (empty($dados)) {
                $dados = ["message" => "Nenhum resultado encontrado para o código fornecido."];
            }
        } else {
            $dados = ["error" => "Erro na consulta SQL: " . mysqli_error($conexao)];
        }
    } else {
        $dados = ["error" => "Código não fornecido."];
    }

    echo json_encode($dados);
?>
