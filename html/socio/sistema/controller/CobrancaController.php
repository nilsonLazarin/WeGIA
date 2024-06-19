<?php

require_once('../model/Cobranca.php');
require_once('../dao/CobrancaDAO.php');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo == 'POST') {
    cadastrarCobranca();
}

/**Extrai os dados do formulário, instancia os objetos necessários e chama o método de inserirCobranca() do CobrancaDAO */
function cadastrarCobranca()
{
    extract($_REQUEST);
    //print_r($_REQUEST);
    //adicionar uma forma de gerar um código
    $cobranca = new Cobranca();
    $cobranca->setIdSocio($socio_id);
    $cobranca->setLocalRecepcao($local_recepcao);
    $cobranca->setValorPagamento($valor_cobranca);
    $cobranca->setFormaPagamento($forma_doacao);
    $cobranca->setDataPagamento($data_doacao);
    $cobranca->setReceptor($receptor);

    $cobrancaDAO = new CobrancaDAO();
    try{
        $cobrancaDAO->inserirCobranca($cobranca);
        header('Location: ../cobrancas.php');
    }catch(PDOException $e){
        $e->getMessage();
    }  
}
