<?php
declare(strict_types=1);

// Função para formatar CPF
function formatCPF($cpf) {
    return substr_replace(substr_replace(substr_replace($cpf, '.', 3, 0), '.', 7, 0), '-', 11, 0);
}

// Verifica se a solicitação é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dos dados do formulário
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $document = filter_input(INPUT_POST, 'document', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);

    // Validações adicionais
    if (!$email || !$document || !$phone || !$amount || $amount <= 0) {
        echo 'Dados inválidos fornecidos.';
        exit;
    }

    // Remove caracteres indesejados de document e phone
    $document = preg_replace('/\D/', '', $document);
    $phone = preg_replace('/\D/', '', $phone);

    // Configuração dos dados para a API
    $description = 'Doação';
    $expires_in = 3600;
    $apiKey = 'pegar_do_banco_de_dados';
    $url = 'pegar_do_banco_de_dados';

    $headers = [
        'Authorization: Basic ' . base64_encode($apiKey . ':'),
        `uri: $url`,
        'Content-Type: application/json;charset=UTF-8'
    ];

    //Configura os dados a serem enviados
    $data = [
        'items' => [
            [
                'amount' => intval($amount * 100),
                'description' => $description,
                'quantity' => 1
            ]
        ],
        'customer' => [
            'name' => $name,
            'email' => $email,
            'type' => 'individual',
            'document' => $document,
            'phones' => [
                'mobile_phone' => [
                    'country_code' => '55',
                    'area_code' => substr($phone, 0, 2),
                    'number' => substr($phone, 2)
                ]
            ],
        ],
        'payments' => [
            [
                'payment_method' => 'pix',
                'pix' => [
                    'expires_in' => $expires_in,
                    'additional_information' => [
                        [
                            'name' => 'Teste',
                            'value' => '1'
                        ]
                    ]
                ]
            ]
        ]
    ];

    // Converte os dados para JSON
    $jsonData = json_encode($data);

    // Inicia a requisição cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($ch);

    // Verifica por erros no cURL
    if (curl_errno($ch)) {
        echo 'Erro na requisição: ' . curl_error($ch);
        curl_close($ch);
        exit;
    }

    // Obtém o código de status HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Fecha a conexão cURL
    curl_close($ch);

    // Verifica o código de status HTTP
    if ($httpCode === 200 || $httpCode === 201) {
        $responseData = json_decode($response, true);

    } else {
        echo 'Erro: A API retornou o código de status HTTP ' . $httpCode . '<br>';
        // Verifica se há mensagens de erro na resposta JSON
        $responseData = json_decode($response, true);
        if (isset($responseData['errors'])) {
            echo 'Detalhes do erro:';
            foreach ($responseData['errors'] as $error) {
                echo '<br>- ' . htmlspecialchars($error['message']);
            }
        }
    } 

        // Exibe informações do cliente

/*         echo '<pre>';
        print_r($responseData);
        echo '</pre>'; */
        
    /*  echo 'Informações do cliente:<br>';
        echo 'Nome: ' . htmlspecialchars($responseData['customer']['name']) . '<br>';
        echo 'E-mail: ' . htmlspecialchars($responseData['customer']['email']) . '<br>';
        echo 'CPF/CNPJ: ' . formatCPF($responseData['customer']['document']) . '<br>';
        echo 'Telefone: ' . htmlspecialchars($responseData['customer']['phones']['mobile_phone']['country_code']) . ' (' . htmlspecialchars($responseData['customer']['phones']['mobile_phone']['area_code']) . ') ' . htmlspecialchars($responseData['customer']['phones']['mobile_phone']['number']) . '<br>';
        echo 'Valor da transferência: R$ ' . number_format($amount, 2, ',', '.') . '<br>';    */

    //Verifica se o status é 'pending'
    if ($responseData['status'] === 'pending') {
        // Gera um qr_code
        $qr_code_url = $responseData['charges'][0]['last_transaction']['qr_code_url'];
        //echo 'URL: ' . $qr_code_url;
        $qr_code = file_get_contents($qr_code_url);
    
        // Exibe a imagem do QR code
        echo '<img class="imagem" src="data:image/jpeg;base64,' . base64_encode($qr_code) . '" />';
    } else {
        echo "Houve um erro ao gerar o QR CODE de pagamento. Verifique se as informações fornecidas são válidas.";
    }
    
    // Caso a transação for realizada, envia uma mensagem de sucesso.
    if($responseData['status'] === 'paid'){
        echo "Transação realizada com sucesso.";
    }
}
?>