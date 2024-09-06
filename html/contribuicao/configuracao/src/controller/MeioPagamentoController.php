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
}