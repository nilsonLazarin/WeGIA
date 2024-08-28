<?php

function montaConsultaStatus(&$consulta, $status, &$where)
{
    if ($status != 'x' && $where === false) {
        $consulta .= " WHERE s.id_sociostatus=$status";
        $where = true;
    } elseif ($status != 'x') {
        $consulta .= " AND s.id_sociostatus=$status";
    }
}

function montaConsultaTAG(&$consulta, $tag, &$where)
{
    if ($tag != 'x' && $where === false) {
        $consulta .= " WHERE s.id_sociotag=$tag";
        $where = true;
    } elseif ($tag != 'x') {
        $consulta .= " AND s.id_sociotag=$tag";
    }
}

function montaConsultaValor(&$consulta, $valor, $operador, &$where)
{
    $op = '';
    switch ($operador) {
        case "maior_q":
            $op = ">";
            break;
        case "maior_ia":
            $op = ">=";
            break;
        case "igual_a":
            $op = "=";
            break;
        case "menor_ia":
            $op = "<=";
            break;
        case "menor_q":
            $op = "<";
            break;
    }

    if (!isset($valor) || empty(trim($valor))) {
        $valor = '0';
    }

    if ($where === false) {
        $consulta .= " WHERE s.valor_periodo $op $valor";
        $where = true;
    } else {
        $consulta .= " AND s.valor_periodo $op $valor";
    }
}

function montaConsultaTipoPessoa(&$consulta, $tipoPessoa, &$where){
    $qtdCaracteres = 0;
    switch ($tipoPessoa) {
        case "f":
            $qtdCaracteres = 14;
            break;
        case "j":
            $qtdCaracteres = 18;
            break;
    }

    if($qtdCaracteres === 0){
        return;
    }

    if ($where === false) {
        $consulta .= " WHERE LENGTH(p.cpf)=$qtdCaracteres";
        $where = true;
    } else {
        $consulta .= " AND LENGTH(p.cpf)=$qtdCaracteres";
    }
}

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

//print_r($_REQUEST);
$where = false;
$consultaBasica = "SELECT p.nome, p.telefone, p.cpf, s.valor_periodo, s.email, st.tipo, ss.status, stag.tag FROM pessoa p JOIN socio s ON (p.id_pessoa=s.id_pessoa) JOIN socio_tipo st ON (s.id_sociotipo = st.id_sociotipo) JOIN socio_status ss ON (ss.id_sociostatus = s.id_sociostatus) JOIN socio_tag stag on (stag.id_sociotag = s.id_sociotag)";
montaConsultaStatus($consultaBasica, $status, $where);
montaConsultaTAG($consultaBasica, $tag, $where);
montaConsultaValor($consultaBasica, $valor, $operador, $where);
montaConsultaTipoPessoa($consultaBasica, $tipo_pessoa, $where);
$consultaBasica .= " ORDER BY p.nome";

//echo $consultaBasica;

$query = mysqli_query($conexao, $consultaBasica);
while ($resultado = mysqli_fetch_assoc($query)) {
    $dados[] = $resultado;
}

if(!isset($dados)){
    echo json_encode(null);
}else{
    echo json_encode($dados);
}


/*switch($tipo_socio){
        case "x": $td = "2,3,4,6,7,8,9,10,11"; $periodo = "BETWEEN -720 AND 720"; break; //Todos
        case "b": $td = "6,7"; $periodo = "BETWEEN 49 AND 70"; break; //Bimestrais
        case "t": $td = "8,9"; $periodo = "BETWEEN 71 AND 100"; break; //Trimestrais
        case "s": $td = "10,11"; $periodo = "BETWEEN 100 AND 200"; break; //Semestrais
        case "m": $td = "2,3"; $periodo = "BETWEEN 28 AND 49"; break; //Mensais
    }
    switch($tipo_pessoa){
        case "x": $p = ""; break; //Todos
        case "f": $p = "and LENGTH(p.cpf) = 14"; break;
        case "j": $p = "and LENGTH(p.cpf) = 18"; break;
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
    if($status == "x"){
        $status = "0,1,2,3,4";
    }
    if($tag != "x"){
        $tag_search = "AND stag.id_sociotag = $tag";
    }else $tag_search = "";
    // switch($suposicao){
    //     case "s": $sql = "SELECT *, max(c.data_vencimento) as ultimo_vencimento, ((SELECT c.data_vencimento FROM cobrancas c Where c.id_socio=s.id_socio ORDER BY c.data_vencimento DESC LIMIT 1,1)) penultimo_vencimento FROM socio s JOIN pessoa p on p.id_pessoa = s.id_pessoa JOIN socio_tipo st on st.id_sociotipo = s.id_sociotipo JOIN cobrancas c on c.id_socio = s.id_socio JOIN (SELECT *, valor as m_valor FROM cobrancas GROUP BY valor ORDER BY COUNT(*) DESC) cv on cv.id_socio = s.id_socio WHERE s.id_sociotipo in ($td) and c.valor $op $valor $p GROUP BY s.id_socio"; break;
    //     case "n": $sql = "SELECT * FROM socio s JOIN pessoa p on p.id_pessoa = s.id_pessoa JOIN socio_tipo st on st.id_sociotipo = s.id_sociotipo  WHERE s.id_sociotipo in ($td) $p and s.valor_periodo $op $valor"; break;
    // }

    if($suposicao == "s"){
        $sql = "
            SELECT 
            p.nome, p.telefone, p.cpf, s.valor_periodo, st.tipo, s.id_socio, c.valor, max(c.data_vencimento) as ultimo_vencimento,
            DATE_FORMAT(c.data_vencimento, '%d/%m/%Y') as data_formatada,
            (SELECT DISTINCT c.data_vencimento FROM cobrancas c Where c.id_socio = s.id_socio ORDER BY c.data_vencimento DESC LIMIT 1,1) penultimo_vencimento,
            c.status as ultimo_status_cobranca,
            DATEDIFF(c.data_vencimento, (SELECT DISTINCT c.data_vencimento FROM cobrancas c Where c.id_socio = s.id_socio ORDER BY c.data_vencimento DESC LIMIT 1,1)) provavel_periodicidade
            FROM pessoa p
            JOIN socio s on (s.id_pessoa = p.id_pessoa)
            JOIN socio_tipo st on (s.id_sociotipo = st.id_sociotipo)
            LEFT JOIN cobrancas c on (c.id_socio = s.id_socio)
            LEFT JOIN socio_tag stag on (stag.id_sociotag = s.id_sociotag)
            WHERE DATEDIFF(c.data_vencimento, (SELECT DISTINCT c.data_vencimento FROM cobrancas c Where c.id_socio = s.id_socio ORDER BY c.data_vencimento DESC LIMIT 1,1)) 
                $periodo
            $p
            AND c.valor $op $valor
            $tag_search
            GROUP BY s.id_socio
            ORDER BY c.data_vencimento DESC
        ";

        $query = mysqli_query($conexao, $sql);
        while($resultado = mysqli_fetch_assoc($query)){
            $dados[] = $resultado;
        }

    }else{
        $sql = "
        SELECT p.nome, p.cpf, p.telefone, s.valor_periodo, st.tipo, ss.status FROM pessoa p
        JOIN socio s ON (s.id_pessoa = p.id_pessoa)
        JOIN socio_tipo st ON (s.id_sociotipo = st.id_sociotipo)
        JOIN socio_status ss ON (ss.id_sociostatus = s.id_sociostatus)
        LEFT JOIN socio_tag stag on (stag.id_sociotag = s.id_sociotag)
        WHERE s.id_sociotipo IN ($td) AND s.valor_periodo $op $valor $p AND ss.id_sociostatus IN ($status)
        $tag_search 
        ORDER BY p.nome
        ";

        $query = mysqli_query($conexao, $sql);
        while($resultado = mysqli_fetch_assoc($query)){
            $dados[] = $resultado;
        }

    }

    // query para implementar
    // SELECT *, max(c.data_vencimento) as ultimo_vencimento FROM socio s JOIN pessoa p on p.id_pessoa = s.id_pessoa JOIN socio_tipo st on st.id_sociotipo = s.id_sociotipo JOIN cobrancas c on c.id_socio = s.id_socio JOIN (SELECT *, valor as m_valor FROM cobrancas GROUP BY valor ORDER BY COUNT(*) DESC LIMIT 1) cv on cv.id_socio = s.id_socio WHERE s.id_sociotipo in (0,1,2,3,4,5,6,7,8,9,10,11) GROUP BY s.id_socio
    // $dados = [];
    // $query = mysqli_query($conexao, $sql);
    // while($resultado = mysqli_fetch_assoc($query)){
    //     $dados[] = $resultado;
    // }

    // array_walk_recursive($dados, function (&$val) {
    //     if (is_string($val)) {
    //         $val = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
    //     }
    // });
    if(!isset($dados)){
        echo json_encode(null);
    }else{
        echo json_encode($dados);
    }*/
