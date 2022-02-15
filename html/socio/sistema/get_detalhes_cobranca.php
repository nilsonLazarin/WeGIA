 <?php
    require("../conexao.php");
    if(!isset($_POST) or empty($_POST)){
        $data = file_get_contents( "php://input" );
        $data = json_decode( $data, true );
        $_POST = $data;
    }else if(is_string($_POST)){
        $_POST = json_decode($_POST, true);
    }
    $conexao->set_charset("utf8");
    extract($_REQUEST);
    $query = mysqli_query($conexao, "SELECT * FROM `cobrancas` c JOIN socio s ON c.id_socio = s.id_socio JOIN pessoa p ON s.id_pessoa = p.id_pessoa WHERE codigo = '$codigo'");
    while($resultado = mysqli_fetch_assoc($query)){
        $dados[] = $resultado;
    }

    // array_walk_recursive($dados, function (&$val) {
    //     if (is_string($val)) {
    //         $val = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
    //     }
    // });

    echo json_encode($dados);
?>