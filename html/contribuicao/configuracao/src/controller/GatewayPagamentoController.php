<?php

$config_path = "config.php";
if (file_exists($config_path)) {
    require_once($config_path);
} else {
    while (true) {
        $config_path = "../" . $config_path;
        if (file_exists($config_path)) break;
    }
    require_once($config_path);
}

require_once ROOT . '/html/contribuicao/configuracao/src/model/GatewayPagamento.php';
require_once ROOT . '/html/contribuicao/configuracao/src/dao/GatewayPagamentoDAO.php';

class GatewayPagamentoController
{
    /**Realiza os procedimentos necessários para inserir um Gateway de pagamento na aplicação */
    public function cadastrar()
    {
        $nome = $_POST['nome'];
        $endpoint = $_POST['endpoint'];
        $token = $_POST['token'];

        try {
            $gatewayPagamento = new GatewayPagamento($nome, $endpoint, $token);
            $gatewayPagamento->cadastrar();
            header("Location: ../../gateway_pagamento.php?msg=cadastrar-sucesso");
        } catch (Exception $e) {
            header("Location: ../../gateway_pagamento.php?msg=cadastrar-falha");
        }
    }

    /**
     * Realiza os procedimentos necessários para buscar os gateways de pagamento da aplicação
     */
    public function buscaTodos()
    {
        try {
            $gatewayPagamentoDao = new GatewayPagamentoDAO();
            $gateways = $gatewayPagamentoDao->buscaTodos();
            return $gateways;
        } catch (PDOException $e) {
            echo 'Erro na busca de gateways de pagamento: ' . $e->getMessage();
        }
    }

    public function excluirPorId()
    {
        $gatewayId = trim($_POST['gateway-id']);

        if (!$gatewayId || empty($gatewayId)) {
            //parar operação
            header("Location: ../../gateway_pagamento.php?msg=excluir-falha#mensagem-tabela");
            exit();
        }

        try {
            $gatewayPagamentoDao = new GatewayPagamentoDAO();
            $gatewayPagamentoDao->excluirPorId($gatewayId);
            header("Location: ../../gateway_pagamento.php?msg=excluir-sucesso#mensagem-tabela");
        } catch (Exception $e) {
            header("Location: ../../gateway_pagamento.php?msg=excluir-falha#mensagem-tabela");
        }
        //echo 'O id do gateway que será excluído é: '.$gatewayId;
    }
}
