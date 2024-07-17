<?php
//Recuperar Info BD

require_once("../../php/conexao.php");

$cpf = $_POST['dcpf'];
$cpfSemMascara = preg_replace('/\D/', '', $cpf);

$banco = new Conexao;
$stmt = $banco->pdo;

try {

    $req = $stmt->prepare("SELECT pessoa.id_pessoa, pessoa.nome, pessoa.telefone, pessoa.cep, pessoa.estado, pessoa.cidade, pessoa.bairro, pessoa.complemento, pessoa.numero_endereco, socio.id_pessoa, socio.email FROM pessoa, socio WHERE pessoa.id_pessoa = socio.id_pessoa AND pessoa.cpf=:cpf;");
    $req->bindParam(":cpf", $cpf);
    $req->execute();
    $arrayBd = $req->fetch(PDO::FETCH_ASSOC);
    //Adicionar verificação para validar se o banco de dados retornou algo ou se a resposta está vazia.
    if (!empty($arrayBd)) {
        $nome = $arrayBd['nome'];
        $telefone = $arrayBd['telefone'];
        $email = $arrayBd['email'];
        $estado = $arrayBd['estado'];
        $cidade = $arrayBd['cidade'];
        $bairro = $arrayBd['bairro'];
        $complemento = $arrayBd['complemento'];
        $cep = $arrayBd['cep'];
        $n_ender = $arrayBd['numero_endereco'];
    } else {
        http_response_code(400);
        exit('Não foi possível encontrar um sócio cadastrado com o CPF/CNPJ informado, por favor tente novamente.');
    }
} catch (PDOException $e) {
    die("Erro: Não foi possível buscar o sócio no BD" . $e->getMessage() . ".");
}

$idBoleto = rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9);
$idBoleto = intval($idBoleto);

$type = "DM";

//Requisição Boleto

$value = intval($_POST["valor"]);
//parcelar
$qtd_p = 1;

$ano = date('Y');
$mes = date('m');
$dia = date('d') + 7;

$aux = 0;

$datas_de_vencimento = array(); // Inicializa o array de datas de vencimento

for ($i = 0; $i <= $qtd_p; $i++) {
    if ($mes == 12) {
        // Se o mês for 12, ajusta o ano e o mês
        $datas_de_vencimento[$i] = ($ano + 1) . "/" . (01) . "/" . ($dia); // Janeiro do próximo ano
    } else {
        // Incrementa o mês e ajusta para não ultrapassar 12 meses no ano
        $mes_atual = $mes + $i;
        $ano_atual = $ano + floor(($mes_atual - 1) / 12); // Ajusta o ano conforme o número de meses
        $mes_atual = ($mes_atual % 12 == 0) ? 12 : ($mes_atual % 12); // Ajusta o mês dentro do limite de 1 a 12

        $datas_de_vencimento[$i] = $ano_atual . "/" . str_pad($mes_atual, 2, '0', STR_PAD_LEFT) . "/" . $dia;
    }
}

// Definição inicial da primeira data
$datas_de_vencimento[0] = $ano . "/" . $mes . "/" . $dia;

try {
    $req = $stmt->prepare("SELECT doacao_boleto_info.api, doacao_boleto_info.token_api FROM doacao_boleto_info WHERE 1;");
    $req->execute();
    $arrayBd = $req->fetchAll(PDO::FETCH_ASSOC)[0];
    $apikey = $arrayBd['token_api'];
    $url = $arrayBd['api'];
} catch (PDOException $e) {
    die("Erro: Não foi possível buscar a venda no BD" . $e->getMessage() . ".");
}

$headers = [
    'Authorization: Basic ' . base64_encode($apikey . ':'),
    'Content-Type: application/json;charset=utf-8',
];

try {
    $req = $stmt->prepare("SELECT * FROM `doacao_boleto_regras` WHERE 1;");
    $req->execute();
    $arrayBd = $req->fetchAll(PDO::FETCH_ASSOC)[0];
    $msg = $arrayBd['agradecimento'];
} catch (PDOException $e) {
    die("Erro: Não foi possível buscar a venda no BD" . $e->getMessage() . ".");
}

//Boleto
$boleto = [
    "items" => [
        [
            "amount" => $value * 100,
            "description" => "Donation",
            "quantity" => 1
        ]
    ],
    "customer" => [
        "name" => $nome,
        "email" => $email,
        "document_type" => "CPF",
        "document" => $cpfSemMascara,
        "type" => "Individual",
        "address" => [
            "line_1" => $n_ender . "," . $bairro . "," . $cidade,
            "line_2" => $complemento,
            "zip_code" => $cep,
            "city" => $cidade,
            "state" => $estado,
            "country" => "BR"
        ],
    ],
    "payments" => [
        [
            "payment_method" => "boleto",
            "boleto" => [
                "instructions" => $msg,
                "document_number" => $idBoleto,
                "due_at" => $ano . "/" . $mes . "/" . $dia,
                "type" => $type
            ]
        ]
    ]
];

$pdf_links = [];
$arquivos = [];

//Transforma o boleto em um objeto JSON
for ($i = 0; $i < $qtd_p; $i++) {
    // Atualizar a data de vencimento para cada boleto
    $boleto['payments'][0]['boleto']['due_at'] = $datas_de_vencimento[$i];

    // Transformar o boleto em JSON
    $boleto_json = json_encode($boleto);

    // Iniciar a requisição cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
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
        exit;
    }

    // Obtém o código de status HTTP
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Fecha a conexão cURL
    curl_close($ch);


    // Verifica o código de status HTTP
    if ($httpCode === 200 || $httpCode === 201) {
        $responseData = json_decode($response, true);
        $pdf_links[] = $responseData['charges'][0]['last_transaction']['pdf'];
        $arquivos[] = $responseData['charges'][0]['last_transaction']['pdf'];
    } else {
        echo json_encode('Erro: A API retornou o código de status HTTP ' . $httpCode . '<br>');
        // Verifica se há mensagens de erro na resposta JSON
        $responseData = json_decode($response, true);
        if (isset($responseData['errors'])) {
            //echo 'Detalhes do erro:';
            foreach ($responseData['errors'] as $error) {
                //echo '<br> ' . htmlspecialchars($error['message']);
            }
        }
    }
}

foreach ($pdf_links as $pdf_link) {
    echo json_encode(['boletoLink' => $pdf_link]);
}
