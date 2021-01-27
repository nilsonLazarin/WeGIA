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
    switch($tipo_socio){
        case "x": $td = "2,3,4,6,7,8,9,10,11"; break; //Todos
        case "b": $td = "6,7"; break; //Bimestrais
        case "t": $td = "8,9"; break; //Trimestrais
        case "s": $td = "10,11"; break; //Semestrais
        case "m": $td = "2,3"; break; //Mensais
    }
    switch($tipo_pessoa){
        case "x": $p = ""; break; //Todos
        case "f": $p = "and LENGTH(p.cpf) = 14"; break;
        case "j": $p = "and LENGTH(p.cpf) = 18"; break;
    }
    switch($operador){
        case "maior_q": $op = ">"; break;
        case "maior_ia": $op = ">="; break;
        case "igual_a": $op = "="; break;
        case "menor_ia": $op = "<="; break;
        case "menor_q": $op = "<"; break;
    }
    $dados = [];
    $query = mysqli_query($conexao, "SELECT * FROM socio s JOIN pessoa p on p.id_pessoa = s.id_pessoa JOIN socio_tipo st on st.id_sociotipo = s.id_sociotipo  WHERE s.id_sociotipo in ($td) $p and s.valor_periodo $op $valor");
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