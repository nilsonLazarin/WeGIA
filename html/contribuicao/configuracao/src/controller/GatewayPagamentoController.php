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

    /**
     * Realiza os procedimentos necessários para remover um gateway de pagamento do sistema.
     */
    public function excluirPorId()
    {
        $gatewayId = trim($_POST['gateway-id']);

        if (!$gatewayId || empty($gatewayId) || $gatewayId < 1) {
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

    /**
     * Realiza os procedimentos necessários para alterar as informações de um gateway de pagamento do sistema
     */
    public function editarPorId()
    {
        $gatewayId = $_POST['id'];
        $gatewayNome = $_POST['nome'];
        $gatewayEndepoint = $_POST['endpoint'];
        $gatewayToken = $_POST['token'];

        try {
            $gatewayPagamento = new GatewayPagamento($gatewayNome, $gatewayEndepoint, $gatewayToken);
            $gatewayPagamento->setId($gatewayId);
            $gatewayPagamento->editar();
            header("Location: ../../gateway_pagamento.php?msg=editar-sucesso#mensagem-tabela");
        } catch (Exception $e) {
            header("Location: ../../gateway_pagamento.php?msg=editar-falha#mensagem-tabela");
        }
        //echo 'Editando gateway de id: '.$gatewayId;
    }

    public function alterarStatus()
    {
        $gatewayId = $_POST['id'];
        $status = trim($_POST['status']);

        if (!$gatewayId || empty($gatewayId)) {
            http_response_code(400);
            echo json_encode(['Erro' => 'O id deve ser maior ou igual a 1.']);exit;
        }

        if (!$status || empty($status)) {
            http_response_code(400);
            echo json_encode(['Erro' => 'O status informado não é válido.']);exit;
        }

        if ($status === 'true') {
            $status = 1;
        } elseif ($status === 'false') {
            $status = 0;
        }

        try {
            $gatewayPagamentoDao = new GatewayPagamentoDAO();
            $gatewayPagamentoDao->alterarStatusPorId($status, $gatewayId);
            echo json_encode(['Sucesso']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['Erro'=>'Ocorreu um problema no servidor.']);exit;
        }
    }
}
