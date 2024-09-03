<?php
require_once '../model/GatewayPagamento.php';

class GatewayPagamentoController{
    /**Realiza os procedimentos necessários para inserir um Gateway de pagamento na aplicação */
    public function cadastrar(){
        $nome = $_POST['nome'];
        $endpoint = $_POST['endpoint'];
        $token = $_POST['token'];

        try{
            $gatewayPagamento = new GatewayPagamento($nome, $endpoint, $token);
            $gatewayPagamento->cadastrar();
            header("Location: ../../gateway_pagamento.php?msg=sucesso");
            //echo json_encode('Cadastrado com sucesso');
        }catch(Exception $e){
            header("Location: ../../gateway_pagamento.php?msg=falha");
            //echo json_encode('Erro ao cadastrar: '.$e->getMessage());
        }
        
    }
}