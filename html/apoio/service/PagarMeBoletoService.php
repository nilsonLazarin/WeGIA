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
            $gatewayPagamento = $gatewayPagamentoDao->buscarPorId(8); //Pegar valor do id dinamicamente

            //print_r($gatewayPagamento);
        } catch (PDOException $e) {
            //Implementar tratamento de erro
            echo 'Erro: ' . $e->getMessage();
        }

        //Buscar mensagem de agradecimento no BD
        $msg = 'Agradecimento';
        //Configurar cabeçalho da requisição
        $headers = [
            'Authorization: Basic ' . base64_encode($gatewayPagamento['token'] . ':'),
            'Content-Type: application/json;charset=utf-8',
        ];

        //Montar array de Boleto

        $cpfSemMascara = preg_replace('/\D/', '', $contribuicaoLog->getSocio()->getDocumento());

        $boleto = [
            "items" => [
                [
                    "amount" => $contribuicaoLog->getValor() * 100,
                    "description" => "Donation",
                    "quantity" => 1,
                    "code" => $contribuicaoLog->getCodigo()
                ]
            ],
            "customer" => [
                "name" => $contribuicaoLog->getSocio()->getNome(),
                "email" => $contribuicaoLog->getSocio()->getEmail(),
                "document_type" => "CPF",
                "document" => $cpfSemMascara,
                "type" => "Individual",
                "address" => [
                    "line_1" => $contribuicaoLog->getSocio()->getLogradouro() . ", n°" . $contribuicaoLog->getSocio()->getNumeroEndereco() . ", " . $contribuicaoLog->getSocio()->getBairro(),
                    "line_2" => $contribuicaoLog->getSocio()->getComplemento(),
                    "zip_code" => $contribuicaoLog->getSocio()->getCep(),
                    "city" => $contribuicaoLog->getSocio()->getCidade(),
                    "state" => $contribuicaoLog->getSocio()->getEstado(),
                    "country" => "BR"
                ],
            ],
            "payments" => [
                [
                    "payment_method" => "boleto",
                    "boleto" => [
                        "instructions" => $msg,
                        "document_number" => $numeroDocumento,
                        "due_at" => $contribuicaoLog->getDataVencimento(),
                        "type" => $type
                    ]
                ]
            ]
        ];

        // Transformar o boleto em JSON
        $boleto_json = json_encode($boleto);
        echo $boleto_json;
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
