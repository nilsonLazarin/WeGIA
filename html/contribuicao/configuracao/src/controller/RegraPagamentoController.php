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

require_once ROOT . '/html/contribuicao/configuracao/src/model/RegraPagamento.php';
require_once ROOT . '/html/contribuicao/configuracao/src/dao/RegraPagamentoDAO.php';

class RegraPagamentoController{
    /**
     * Retorna as regras de contribuição presentes no sistema
     */
    public function buscaRegrasContribuicao(){
        $regraPagamentoDao = new RegraPagamentoDAO();
        $regrasContribuicao = $regraPagamentoDao->buscaRegrasContribuicao();
        return $regrasContribuicao;
    }

    /**
     * Retorna o conjunto de regras de pagamento presentes no sistema
     */
    public function buscaConjuntoRegrasPagamento(){
        $regraPagamentoDao = new RegraPagamentoDAO();
        $conjuntoRegrasPagamento = $regraPagamentoDao->buscaConjuntoRegrasPagamento();
        return $conjuntoRegrasPagamento;
    }

    /**
     * Extraí os dados do formulário e realiza os procedimentos necessários para inserir um novo
     * conjunto de regras no sistema.
     */
    public function cadastrar(){
        //Implementar restante da lógica do código...
        $meioPagamentoId = $_POST['meio-pagamento-plataforma'];
        $regraContribuicaoId = $_POST['regra-pagamento'];
        $valor = $_POST['valor'];
        try{
            $regraPagamento = new RegraPagamento();
            $regraPagamento
                ->setMeioPagamentoId($meioPagamentoId)
                ->setRegraContribuicaoId($regraContribuicaoId)
                ->setValor($valor)
                ->cadastrar();
            header("Location: ../../regra_pagamento.php?msg=cadastrar-sucesso");
        }catch(Exception $e){
            header("Location: ../../regra_pagamento.php?msg=cadastrar-falha");
        }
    }
}