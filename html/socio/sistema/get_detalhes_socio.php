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
    $query = mysqli_query($conexao, "SELECT *, sp.nome_sistema as sistema_pagamento, DATE_FORMAT(lc.data, '%d/%m/%Y') as data_geracao, DATE_FORMAT(lc.data_venc_boleto, '%d/%m/%Y') as data_vencimento, s.id_socio as socioid FROM socio AS s LEFT JOIN pessoa AS p ON s.id_pessoa = p.id_pessoa LEFT JOIN socio_tipo AS st ON s.id_sociotipo = st.id_sociotipo LEFT JOIN log_contribuicao AS lc ON lc.id_socio = s.id_socio LEFT JOIN sistema_pagamento as sp ON sp.id = lc.id_sistema JOIN socio_tag stag ON stag.id_sociotag = s.id_sociotag WHERE s.id_socio = $id_socio");
    while($resultado = mysqli_fetch_assoc($query)){
        $dados['log_contribuicao'][] = $resultado;
    }

    $query = mysqli_query($conexao, "SELECT *, DATE_FORMAT(data_emissao, '%d/%m/%Y') as data_emissao, DATE_FORMAT(data_vencimento, '%d/%m/%Y') as data_vencimento, DATE_FORMAT(data_pagamento, '%d/%m/%Y') as data_pagamento FROM cobrancas c JOIN socio s ON s.id_socio = c.id_socio JOIN pessoa p ON s.id_pessoa = p.id_pessoa JOIN socio_tag stag ON stag.id_sociotag = s.id_sociotag WHERE s.id_socio = $id_socio");
    while($resultado = mysqli_fetch_assoc($query)){
        $dados['log_cobranca'][] = $resultado;
    }

    // array_walk_recursive($dados, function (&$val) {
    //     if (is_string($val)) {
    //         $val = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
    //     }
    // });

    echo json_encode($dados);
?>