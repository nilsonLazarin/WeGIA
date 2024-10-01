<?php
require_once 'ApiBoletoServiceInterface.php';
require_once '../model/ContribuicaoLog.php';
require_once '../dao/GatewayPagamentoDAO.php';
class PagarMeBoletoService implements ApiBoletoServiceInterface
{
    public function gerarBoleto(ContribuicaoLog $contribuicaoLog)
    {
        //gerar um número para o documento
        $numeroDocumento = $this->gerarNumeroDocumento(16);

        //Tipo do boleto
        $type = 'DM';

        //Validar regras

        //Buscar Url da API e token no BD
        try {
            $gatewayPagamentoDao = new GatewayPagamentoDAO();
            $gatewayPagamento = $gatewayPagamentoDao->buscarPorId(8);//Pegar valor do id dinamicamente

            //print_r($gatewayPagamento);
        } catch (PDOException $e) {
            //Implementar tratamento de erro
            echo 'Erro: '.$e->getMessage();
        }

        //Buscar mensagem de agradecimento no BD

        //Configurar cabeçalho da requisição

        //Montar array de Boleto
        return true;
    }
    public function guardarSegundaVia() {}

    /**
     * Retorna um número com a quantidade de algarismos informada no parâmetro
     */
    public function gerarNumeroDocumento($tamanho)
    {
        $numeroDocumento = '';

        for ($i = 0; $i < $tamanho; $i++) {
            $numeroDocumento .= rand(0, 9);
        }

        return intval($numeroDocumento);
    }
}
