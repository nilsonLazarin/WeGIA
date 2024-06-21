<?php
declare(strict_types=1);

function formatCPF($cpf) {
    return substr_replace(substr_replace(substr_replace($cpf, '.', 3, 0), '.', 7, 0), '-', 11, 0);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta dos dados do formulário
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $document = filter_input(INPUT_POST, 'document', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);

    if (!$email || !$document || !$phone || !$amount || $amount <= 0) {
        echo 'Dados inválidos fornecidos.';
        exit;
    }

    $document = preg_replace('/\D/', '', $document);
    $phone = preg_replace('/\D/', '', $phone);

    $description = 'Doação';
    $expires_in = 3600;
    $apiKey = 'sk_test_e0825df65b1a4cceab318896abf1f71d';
    $url = 'https://api.pagar.me/core/v5/orders';

    $headers = [
        'Authorization: Basic ' . base64_encode($apiKey . ':'),
        `uri: $url`,
        'Content-Type: application/json;charset=UTF-8'
    ];

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

    $jsonData = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Erro na requisição: ' . curl_error($ch);
        curl_close($ch);
        exit;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode === 200 || $httpCode === 201) {
        $responseData = json_decode($response, true);

    } else {
        echo 'Erro: A API retornou o código de status HTTP ' . $httpCode . '<br>';
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

    if ($responseData['status'] === 'pending') {
        $qr_code_url = $responseData['charges'][0]['last_transaction']['qr_code_url'];
        $qr_code = file_get_contents($qr_code_url);
    
        echo '<div class = "div-pag">';
        echo '<p class = "qr-code-text">Escaneie o QR code para efetuar o pagamento.</p>';
        echo '<p class = "valorDaDoacao">Valor da doação: '.$amount.'R$'.'</p>';
        echo '<img class = "imagem" src="data:image/jpeg;base64,' . base64_encode($qr_code) . '" />';
        echo '</div>';
    } else {
        echo "Houve um erro ao gerar o QR CODE de pagamento. Verifique se as informações fornecidas são válidas.";
    }
    
    if($responseData['status'] === 'paid'){
        header("Location: ./sucessoPix.php");
    }
}
?>
<style>
*{
    background-color: gainsboro;
}

.div-pag {
    background-color: white;
    display: flex;
    flex-direction: column;
    justify-content: center; 
    align-items: center; 
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: 0 auto;
    margin-top: 150px;
}

.qr-code-text {
    background-color: white;
    font-family: Arial, Helvetica, sans-serif;
    font-size: larger;
    text-align: center;
}

.valorDaDoacao {
    background-color: white;
    font-family: Arial, Helvetica, sans-serif;
    font-size: medium;
    text-align: center;
}

.imagem {
    display: block;
    margin: 20px auto; 
    max-width: 200px;
}
</style>