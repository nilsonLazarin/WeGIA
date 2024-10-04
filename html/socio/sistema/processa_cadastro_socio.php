<?php
//Escolher qual ação executar
$acao = trim(filter_input(INPUT_POST, 'acao'));

if(!$acao || empty($acao)){
    http_response_code(400);
    echo json_encode(['erro' => 'Ação não definida']);
    exit();
}

switch($acao){
    case 'cadastrar': cadastrar();break;
    case 'atualizar': atualizar();break;
    default: echo json_encode(['erro' => 'Ação não válida']); exit();
}


/**
 * Realiza os procedimentos necessários para inserir um novo sócio no banco de dados da aplicação
 */
function cadastrar(){
    http_response_code(200);
    echo json_encode(['retorno' => 'Sócio cadastrado']);
}
//Atualizar dados de sócio existente
function atualizar(){

}