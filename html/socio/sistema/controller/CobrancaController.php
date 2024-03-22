<?php

require_once('../model/Cobranca.php');

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo == 'POST') {
    cadastrarCobranca();
}

/**Extrai os dados do formulário, instancia os objetos necessários e chama o método de inserirCobranca() do CobrancaDAO */
function cadastrarCobranca()
{
    extract($_REQUEST);
    print_r($_REQUEST);

    //continuar a partir daqui
}
