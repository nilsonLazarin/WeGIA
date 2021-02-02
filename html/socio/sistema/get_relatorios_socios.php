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
    switch($suposicao){
        case "s": $sql = "SELECT *, max(c.data_vencimento) as ultimo_vencimento, ((SELECT c.data_vencimento FROM cobrancas c Where c.id_socio=s.id_socio ORDER BY c.data_vencimento DESC LIMIT 1,1)) penultimo_vencimento FROM socio s JOIN pessoa p on p.id_pessoa = s.id_pessoa JOIN socio_tipo st on st.id_sociotipo = s.id_sociotipo JOIN cobrancas c on c.id_socio = s.id_socio JOIN (SELECT *, valor as m_valor FROM cobrancas GROUP BY valor ORDER BY COUNT(*) DESC) cv on cv.id_socio = s.id_socio WHERE s.id_sociotipo in ($td) and c.valor $op $valor $p GROUP BY s.id_socio"; break;
        case "n": $sql = "SELECT * FROM socio s JOIN pessoa p on p.id_pessoa = s.id_pessoa JOIN socio_tipo st on st.id_sociotipo = s.id_sociotipo  WHERE s.id_sociotipo in ($td) $p and s.valor_periodo $op $valor"; break;
    }

    // query para implementar
    // SELECT *, max(c.data_vencimento) as ultimo_vencimento FROM socio s JOIN pessoa p on p.id_pessoa = s.id_pessoa JOIN socio_tipo st on st.id_sociotipo = s.id_sociotipo JOIN cobrancas c on c.id_socio = s.id_socio JOIN (SELECT *, valor as m_valor FROM cobrancas GROUP BY valor ORDER BY COUNT(*) DESC LIMIT 1) cv on cv.id_socio = s.id_socio WHERE s.id_sociotipo in (0,1,2,3,4,5,6,7,8,9,10,11) GROUP BY s.id_socio
    $dados = [];
    $query = mysqli_query($conexao, $sql);
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