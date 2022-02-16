<?php
    require("../conexao.php");
    if(!isset($_POST) or empty($_POST)){
        $data = file_get_contents( "php://input" );
        $data = json_decode( $data, true );
        $_POST = $data;
    }else if(is_string($_POST)){
        $_POST = json_decode($_POST, true);
    }

    extract($_REQUEST);

    echo file_put_contents("ar.txt",$codigo);
    // $descricao = "'$descricao'";
    // $data_emissao = "'$data_emissao'";
    // $data_pagamento = "'$data_pagamento'";
    // $data_vencimento = "'$data_vencimento'";
    // $link_cobranca= "'$link_cobranca'";
    // $link_boleto = "'$link_boleto'";
    // $linha_digitavel = "'$linha_digitavel'";
    // $status = "'$status'";
    $cadastrado = false;
    // mysqli_query($conexao, "INSERT INTO cobrancas (`codigo`, `descricao`, `data_emissao`, `data_vencimento`, `data_pagamento`, `valor`, `valor_pago`, `status`, `link_cobranca`, `link_boleto`, `linha_digitavel`, `id_socio`) VALUES ($codigo,$descricao,$data_emissao, $data_vencimento,$data_pagamento,$valor,$valor_pago,$status,$link_cobranca,$link_boleto,$linha_digitavel,$id_socio)");
    mysqli_query($conexao, "UPDATE cobrancas set status='BOLETO PAGO', data_pagamento='$data', valor_pago=$valor where codigo = $codigo");

    echo file_put_contents("ar.txt",$valor." ".$data." ".$codigo);

    if(mysqli_affected_rows($conexao)) $cadastrado = true;

    echo(json_encode($cadastrado));
?>