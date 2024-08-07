<?php
//Posteriormente mudar o paradigma para orientação a objetos.
//Recuperar Info BD

/**
 * Função para gerar um código aleatório
 */
function gerarCodigoAleatorio($tamanho = 16)
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $caracteresTamanho = strlen($caracteres);
    $codigoString = '';
    for ($i = 0; $i < $tamanho; $i++) {
        $codigoString .= $caracteres[rand(0, $caracteresTamanho - 1)];
    }
    return $codigoString;
}

require_once("../../php/conexao.php");

$cpf = $_POST['dcpf'];
$cpfSemMascara = preg_replace('/\D/', '', $cpf);

$banco = new Conexao;
$stmt = $banco->pdo;

try {

    $req = $stmt->prepare("SELECT pessoa.id_pessoa, pessoa.nome, pessoa.telefone, pessoa.cep, pessoa.estado, pessoa.cidade, pessoa.bairro, pessoa.complemento, pessoa.numero_endereco, pessoa.logradouro, socio.id_pessoa, socio.email FROM pessoa, socio WHERE pessoa.id_pessoa = socio.id_pessoa AND pessoa.cpf=:cpf;");
    $req->bindParam(":cpf", $cpf);
    $req->execute();
    $arrayBd = $req->fetch(PDO::FETCH_ASSOC);
    //Verificação para validar se o banco de dados retornou algo ou se a resposta está vazia.
    if (!empty($arrayBd)) {
        $nome = $arrayBd['nome'];
        $telefone = preg_replace('/\D/', '', $arrayBd['telefone']);
        $email = $arrayBd['email'];
        $estado = $arrayBd['estado'];
        $cidade = $arrayBd['cidade'];
        $bairro = $arrayBd['bairro'];
        $complemento = $arrayBd['complemento'];
        $cep = $arrayBd['cep'];
        $n_ender = $arrayBd['numero_endereco'];
        $logradouro = $arrayBd['logradouro'];
    } else {
        http_response_code(400);
        exit('Não foi possível encontrar um sócio cadastrado com o CPF/CNPJ informado, por favor tente novamente.');
    }
} catch (PDOException $e) {
    die("Erro: Não foi possível buscar o sócio no BD" . $e->getMessage() . ".");
}

$value = intval($_POST["valor"]);

$regras = $stmt->query("SELECT dbr.min_boleto_uni FROM doacao_boleto_regras AS dbr JOIN doacao_boleto_info AS dbi ON (dbr.id = dbi.id_regras)");
$regras = $regras->fetch(PDO::FETCH_ASSOC);

if ($value < $regras['min_boleto_uni']) {
    echo json_encode(['erro' => 'O valor para uma doação está abaixo do mínimo requerido.']);
    exit();
}

try {
    $req = $stmt->prepare("SELECT doacao_boleto_info.api, doacao_boleto_info.token_api FROM doacao_boleto_info WHERE 1;");
    $req->execute();
    $arrayBd = $req->fetchAll(PDO::FETCH_ASSOC)[0];
    $apiKey = $arrayBd['token_api'];
    $url = $arrayBd['api'];
} catch (PDOException $e) {
    die("Erro: Não foi possível buscar a venda no BD" . $e->getMessage() . ".");
}

// Configuração dos dados para a API
$description = 'Doação';
$expires_in = 3600;

$headers = [
    'Authorization: Basic ' . base64_encode($apiKey . ':'),
    `uri: $url`,
    'Content-Type: application/json;charset=UTF-8'
];

//Configura os dados a serem enviados

//gerar um número aleatório para o parâmetro code
$code = gerarCodigoAleatorio();
$data = [
    'items' => [
        [
            'amount' => intval($value * 100),
            'description' => $description,
            'quantity' => 1,
            "code" => $code
        ]
    ],
    'customer' => [
        'name' => $nome,
        'email' => $email,
        'type' => 'individual',
        'document' => $cpfSemMascara,
        'phones' => [
            'mobile_phone' => [
                'country_code' => '55',
                'area_code' => substr($telefone, 0, 2),
                'number' => substr($telefone, 2)
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
    echo json_encode(['erro' => curl_error($ch)]);
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
    echo json_encode(['erro' => 'A API retornou o código de status HTTP ' . $httpCode]);
    exit();
    // Verifica se há mensagens de erro na resposta JSON
    $responseData = json_decode($response, true);
    if (isset($responseData['errors'])) {
        //echo 'Detalhes do erro:';
        foreach ($responseData['errors'] as $error) {
            //echo '<br>- ' . htmlspecialchars($error['message']);
        }
    }
}

//Verifica se o status é 'pending'
if ($responseData['status'] === 'pending') {
    // Gera um qr_code
    $qr_code_url = $responseData['charges'][0]['last_transaction']['qr_code_url'];
    $qr_code = file_get_contents($qr_code_url);
    //envia o link da url
    echo json_encode(['qrcode' => base64_encode($qr_code)]);//enviar posteriormente a cópia do QR para área de transferência junto
} else {
    echo json_encode(["erro" => "Houve um erro ao gerar o QR CODE de pagamento. Verifique se as informações fornecidas são válidas."]);
}
