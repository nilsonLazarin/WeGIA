<?php

require_once '../model/RegraPagamento.php';
require_once '../dao/RegraPagamentoDAO.php';

class RegraPagamentoController
{
    /**
     * Retorna as regras de contribuição presentes no sistema
     */
    public function buscaRegrasContribuicao()
    {
        $regraPagamentoDao = new RegraPagamentoDAO();
        $regrasContribuicao = $regraPagamentoDao->buscaRegrasContribuicao();
        return $regrasContribuicao;
    }

    /**
     * Retorna o conjunto de regras de pagamento presentes no sistema
     */
    public function buscaConjuntoRegrasPagamento()
    {
        $regraPagamentoDao = new RegraPagamentoDAO();
        $conjuntoRegrasPagamento = $regraPagamentoDao->buscaConjuntoRegrasPagamento();
        return $conjuntoRegrasPagamento;
    }

    /**
     * Retorna o conjunto de regras de pagamento pertencentes a um meio de pagamento.
     */
    public function buscaConjuntoRegrasPagamentoPorNomeMeioPagamento()
    {

        $nomeMeioPagamento = trim(filter_input(INPUT_GET, 'nome-meio-pagamento', FILTER_SANITIZE_STRING));

        try {
            $regraPagamentoDao = new RegraPagamentoDAO();
            $conjuntoRegrasPagamento = $regraPagamentoDao->buscaConjuntoRegrasPagamentoPorNomeMeioPagamento($nomeMeioPagamento);

            http_response_code(200);
            echo json_encode(['regras' => $conjuntoRegrasPagamento]);
            exit();
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'erro ao buscar conjunto de regras de pagamento no servidor.']);
            exit();
        }
    }

    /**
     * Extraí os dados do formulário e realiza os procedimentos necessários para inserir um novo
     * conjunto de regras no sistema.
     */
    public function cadastrar()
    {
        //Implementar restante da lógica do código...
        $meioPagamentoId = $_POST['meio-pagamento-plataforma'];
        $regraContribuicaoId = $_POST['regra-pagamento'];
        $valor = $_POST['valor'];
        try {
            $regraPagamento = new RegraPagamento();
            $regraPagamento
                ->setMeioPagamentoId($meioPagamentoId)
                ->setRegraContribuicaoId($regraContribuicaoId)
                ->setValor($valor)
                ->setStatus(0)
                ->cadastrar();
            header("Location: ../view/regra_pagamento.php?msg=cadastrar-sucesso");
        } catch (Exception $e) {
            header("Location: ../view/regra_pagamento.php?msg=cadastrar-falha");
        }
    }

    /**
     * Realiza os procedimentos necessários para remover uma regra de pagamento do sistema.
     */
    public function excluirPorId()
    {
        $regraPagamentoId = trim($_POST['regra-pagamento-id']);

        if (!$regraPagamentoId || empty($regraPagamentoId) || $regraPagamentoId < 1) {
            //parar operação
            header("Location: ../view/regra_pagamento.php?msg=excluir-falha#mensagem-tabela");
            exit();
        }

        try {
            $regraPagamentoDao = new RegraPagamentoDAO();
            $regraPagamentoDao->excluirPorId($regraPagamentoId);
            header("Location: ../view/regra_pagamento.php?msg=excluir-sucesso#mensagem-tabela");
        } catch (Exception $e) {
            header("Location: ../view/regra_pagamento.php?msg=excluir-falha#mensagem-tabela");
        }
    }

    /**
     * Realiza os procedimentos necessários para alterar as informações de uma regra de pagamento do sistema
     */
    public function editarPorId()
    {
        $valor = $_POST['valor'];
        $regraPagamentoId = $_POST['id'];

        try {
            $regraPagamento = new RegraPagamento();
            $regraPagamento
                ->setId($regraPagamentoId)
                ->setValor($valor)
                ->editar();
            header("Location: ../view/regra_pagamento.php?msg=editar-sucesso#mensagem-tabela");
        } catch (Exception $e) {
            header("Location: ../view/regra_pagamento.php?msg=editar-falha#mensagem-tabela");
        }
    }

    /**
     * Realiza os procedimentos necessários para ativar/desativar uma regra de pagamento no sistema
     */
    public function alterarStatus()
    {
        $regraPagamentoId = $_POST['id'];
        $status = trim($_POST['status']);

        if (!$regraPagamentoId || empty($regraPagamentoId)) {
            http_response_code(400);
            echo json_encode(['Erro' => 'O id deve ser maior ou igual a 1.']);
            exit;
        }

        if (!$status || empty($status)) {
            http_response_code(400);
            echo json_encode(['Erro' => 'O status informado não é válido.']);
            exit;
        }

        if ($status === 'true') {
            $status = 1;
        } elseif ($status === 'false') {
            $status = 0;
        }

        try {
            $regraPagamentoDao = new RegraPagamentoDAO();
            $regraPagamentoDao->alterarStatusPorId($status, $regraPagamentoId, $status);
            echo json_encode(['Sucesso']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['Erro' => 'Ocorreu um problema no servidor.']);
            exit;
        }
    }
}
