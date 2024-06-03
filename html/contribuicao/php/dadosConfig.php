<?php
require_once('conexao.php');
$banco = new Conexao;
$sistemas = [];

$banco->querydados("SELECT id FROM sistema_pagamento WHERE nome_sistema= 'BOLETOFACIL'");
$dados = $banco->result();
$sistemas[0] = $dados['id'];

$banco->querydados("SELECT id FROM sistema_pagamento WHERE nome_sistema= 'PAGSEGURO'");
$dados = $banco->result();
$sistemas[1] = $dados['id'];

$banco->querydados("SELECT id FROM sistema_pagamento WHERE nome_sistema= 'PAYPAL'");
$dados = $banco->result();
$sistemas[2] = $dados['id'];

//dados do boleto...

$banco->querydados("SELECT * FROM doacao_boleto_regras as regras JOIN doacao_boleto_info as info ON (info.id_regras = regras.id) WHERE info.id_sistema = '$sistemas[0]'");
$linhasboleto = $banco->rows();
$dadosBoleto = $banco->result();
if ($linhasboleto != 0) {
    $valMinUni = $dadosBoleto['min_boleto_uni'];
    $valMinParc = $dadosBoleto['min_parcela'];
    $valMaxParc = $dadosBoleto['max_parcela'];
    $carenciaUni = $dadosBoleto['dias_boleto_a_vista'];
    $carenciaMen = $dadosBoleto['max_dias_venc'];
    $juros = $dadosBoleto['juros'];
    $multa = $dadosBoleto['multa'];
    $agradecimento = $dadosBoleto['agradecimento'];
    $op1 =  $dadosBoleto['dias_venc_carne_op1'];
    $op2 = $dadosBoleto['dias_venc_carne_op2'];
    $op3 = $dadosBoleto['dias_venc_carne_op3'];
    $op4 =  $dadosBoleto['dias_venc_carne_op4'];
    $op5 = $dadosBoleto['dias_venc_carne_op5'];
    $op6 = $dadosBoleto['dias_venc_carne_op6'];
    $api =  $dadosBoleto['api'];
    $token = $dadosBoleto['token_api'];
}

// dados do cartao paypal... 
$banco->querydados("SELECT * FROM doacao_cartao_mensal WHERE id_sistema = '$sistemas[2]'");
$dadosiniciais = $banco->result();
$dadospaypal = $banco->arraydados();
$linhaspaypal = $banco->rows();

$banco->querydados("SELECT url FROM doacao_cartao_avulso WHERE id_sistema = '$sistemas[2]'");
$linkAvulso = $banco->result();
$linkAvulsoPay = $linkAvulso['url'];

// dados do cartao pagseguro...  
$banco->querydados("SELECT * FROM doacao_cartao_mensal WHERE id_sistema = '$sistemas[1]'");
$dadoinicial = $banco->result();
$dadospagseguro = $banco->arraydados();
$linhaspagseguro = $banco->rows();

$banco->querydados("SELECT url FROM doacao_cartao_avulso WHERE id_sistema = '$sistemas[1]'");
$linkAvulsoResult = $banco->result();
$linkAvulsoPag = $linkAvulsoResult['url'];
