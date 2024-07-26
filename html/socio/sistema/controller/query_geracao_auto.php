<?php
    require("../../conexao.php");

    function cleanInput($data) {
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }

    if (!isset($_POST) or empty($_POST)) {
        $data = file_get_contents("php://input");
        $data = json_decode($data, true);
        if (is_array($data)) {
            $_POST = $data;
        }
    } else if (is_string($_POST)) {
        $_POST = json_decode($_POST, true);
    }

    $conexao->set_charset("utf8");

    extract($_REQUEST);

    if (isset($_POST['query']) && !empty($_POST['query'])) {
        $query = cleanInput($_POST['query']);
        $query = mysqli_query($conexao, $query);
        while($resultado = mysqli_fetch_assoc($query)){
            $dados[] = $resultado;
        }

        // array_walk_recursive($dados, function (&$val) {
        //     if (is_string($val)) {
        //         $val = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
        //     }
        // });
        if(isset($dados)){
            echo json_encode($dados);
        }else echo json_encode(false);
    } else {
        echo json_encode(['error' => 'Query nao fornecida ou esta vazia.']);
    }
?>