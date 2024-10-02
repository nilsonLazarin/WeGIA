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

        //Iniciar requisição

        // Iniciar a requisição cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $gatewayPagamento['endPoint']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $boleto_json);

        // Executar a requisição cURL
        $response = curl_exec($ch);

        // Lidar com a resposta da API (mesmo código de tratamento que você já possui)

        // Verifica por erros no cURL
        if (curl_errno($ch)) {
            echo 'Erro na requisição: ' . curl_error($ch);
            curl_close($ch);
            return false;
        }

        // Obtém o código de status HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Fecha a conexão cURL
        curl_close($ch);

        // Verifica o código de status HTTP
        if ($httpCode === 200 || $httpCode === 201) {
            $responseData = json_decode($response, true);
            $pdf_link = $responseData['charges'][0]['last_transaction']['pdf'];

            //envia resposta para o front-end
            echo json_encode(['link' => $pdf_link]);
        } else {
            echo json_encode(['Erro' => 'A API retornou o código de status HTTP ' . $httpCode]);
            return false;
            // Verifica se há mensagens de erro na resposta JSON
            $responseData = json_decode($response, true);
            if (isset($responseData['errors'])) {
                //echo 'Detalhes do erro:';
                foreach ($responseData['errors'] as $error) {
                    //echo '<br> ' . htmlspecialchars($error['message']);
                }
            }
        }

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
