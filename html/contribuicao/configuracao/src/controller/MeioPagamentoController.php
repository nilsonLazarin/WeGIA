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

require_once ROOT . '/html/contribuicao/configuracao/src/model/MeioPagamento.php';
require_once ROOT . '/html/contribuicao/configuracao/src/dao/MeioPagamentoDAO.php';

class MeioPagamentoController{
    public function cadastrar(){
        //Implementar restante da lógica do código...
        $descricao = $_POST['nome'];
        $gatewayId = $_POST['meio-pagamento-plataforma'];
        try{
            $meioPagamento = new MeioPagamento($descricao, $gatewayId);
            $meioPagamento->cadastrar();
            header("Location: ../../meio_pagamento.php?msg=cadastrar-sucesso");
        }catch(Exception $e){
            header("Location: ../../meio_pagamento.php?msg=cadastrar-falha");
        }
    }

    /**
     * Busca os meios de pagamentos registrados no banco de dados da aplicação
     */
    public function buscaTodos(){
        try{
            $meioPagamentoDao = new MeioPagamentoDAO();
            $meiosPagamento = $meioPagamentoDao->buscaTodos();
            return $meiosPagamento;
        }catch(PDOException $e){
            echo 'Erro na busca de meios de pagamento: '.$e->getMessage();
        }
    }

    /**
     * Realiza os procedimentos necessários para remover um meio de pagamento do sistema.
     */
    public function excluirPorId(){
        $meioPagamentoId = trim($_POST['meio-pagamento-id']);

        if (!$meioPagamentoId || empty($meioPagamentoId) || $meioPagamentoId < 1) {
            //parar operação
            header("Location: ../../meio_pagamento.php?msg=excluir-falha#mensagem-tabela");
            exit();
        }

        try{
            $meioPagamentoDao = new MeioPagamentoDAO();
            $meioPagamentoDao->excluirPorId($meioPagamentoId);
            header("Location: ../../meio_pagamento.php?msg=excluir-sucesso#mensagem-tabela");
        }catch(Exception $e){
            header("Location: ../../meio_pagamento.php?msg=excluir-falha#mensagem-tabela");
        }
    }

    /**
     * Realiza os procedimentos necessários para alterar as informações de um meio de pagamento do sistema
     */
    public function editarPorId(){
        $descricao = $_POST['nome'];
        $gatewayId = $_POST['plataforma'];
        $meioPagamentoId = $_POST['id'];

        try{
            $meioPagamento = new MeioPagamento($descricao, $gatewayId);
            $meioPagamento->setId($meioPagamentoId);
            $meioPagamento->editar();
            header("Location: ../../meio_pagamento.php?msg=editar-sucesso#mensagem-tabela");
        }catch(Exception $e){
            header("Location: ../../meio_pagamento.php?msg=editar-falha#mensagem-tabela");
        }
    }

     /**
     * Realiza os procedimentos necessários para ativar/desativar um meio de pagamento no sistema
     */
    public function alterarStatus()
    {
        $meioPagamentoId = $_POST['id'];
        $status = trim($_POST['status']);

        if (!$meioPagamentoId || empty($meioPagamentoId)) {
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
            $meioPagamentoDao = new MeioPagamentoDAO();
            $meioPagamentoDao->alterarStatusPorId($status, $meioPagamentoId);
            echo json_encode(['Sucesso']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['Erro'=>'Ocorreu um problema no servidor.']);exit;
        }
    }
}