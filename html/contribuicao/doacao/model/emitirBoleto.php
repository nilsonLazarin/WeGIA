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
        $telefone = $arrayBd['telefone'];
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

$idBoleto = rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9);
$idBoleto = intval($idBoleto);

$type = "DM";

//Requisição Boleto

//Validação do valor de um boleto
$value = intval($_POST["valor"]);

$regras = $stmt->query("SELECT dbr.min_boleto_uni FROM doacao_boleto_regras AS dbr JOIN doacao_boleto_info AS dbi ON (dbr.id = dbi.id_regras)");
$regras = $regras->fetch(PDO::FETCH_ASSOC);

if ($value < $regras['min_boleto_uni']) {
    echo json_encode('O valor para uma doação está abaixo do mínimo requerido.');
    exit();
}

//parcelar
$qtd_p = 1;

//Permite a escolha do dia do boleto caso seja gerado por um funcionário
if (isset($_POST['dia']) && !empty($_POST['dia'])) {
    require_once '../../../permissao/permissao.php';
    
    session_start();
    permissao($_SESSION['id_pessoa'], 4);

    $dataVencimento = $_POST['dia'];
} else {
    $dataAtual = new DateTime();
    $dataVencimento = $dataAtual->modify('+7 days');
    $dataVencimento = $dataVencimento->format('Y-m-d');
}

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

$code = gerarCodigoAleatorio();

//Boleto
$boleto = [
    "items" => [
        [
            "amount" => $value * 100,
            "description" => "Donation",
            "quantity" => 1,
            "code" => $code
        ]
    ],
    "customer" => [
        "name" => $nome,
        "email" => $email,
        "document_type" => "CPF",
        "document" => $cpfSemMascara,
        "type" => "Individual",
        "address" => [
            "line_1" => $logradouro . ", n°" . $n_ender . ", " . $bairro,
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
                "due_at" => $dataVencimento,
                "type" => $type
            ]
        ]
    ]
];

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
    $pdf_link = $responseData['charges'][0]['last_transaction']['pdf'];

    //salva uma cópia do boleto para emissão de 2° via.

    // Diretório onde os arquivos serão armazenados
    $saveDir = '../../pdfs/';

    // Verifica se o diretório existe, se não, cria o diretório
    if (!is_dir($saveDir)) {
        mkdir($saveDir, 0755, true);
    }

    $numeroAleatorio = gerarCodigoAleatorio();
    $ultimaDataVencimento = $dataVencimento;
    $ultimaDataVencimento = str_replace('-', '', $ultimaDataVencimento);
    $nomeArquivo = $saveDir . $numeroAleatorio . '_' . $cpfSemMascara . '_' . $ultimaDataVencimento . '_' . $value . '.pdf';

    // Inicia uma sessão cURL
    $ch = curl_init($pdf_link);

    // Configurações da sessão cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, true);

    // Executa a sessão cURL e obtém a resposta com cabeçalhos
    $response = curl_exec($ch);

    // Verifica se ocorreu algum erro durante a execução do cURL
    if (curl_errno($ch)) {
        echo json_encode('Erro ao baixar o arquivo.'); //. curl_error($ch) . PHP_EOL;
        exit();
    } else {
        // Verifica o código de resposta HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200) {
            // Separa os cabeçalhos do corpo da resposta
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($response, 0, $headerSize);
            $fileContent = substr($response, $headerSize);

            // Verifica o tipo de conteúdo
            if (strpos($headers, 'Content-Type: application/pdf') !== false) {
                // Salva o conteúdo do arquivo no diretório especificado
                file_put_contents($nomeArquivo, $fileContent);
                //$arquivos []= $savePath;
            } else {
                //echo "Erro: O conteúdo da URL não é um PDF." . PHP_EOL;
            }
        } else {
            echo json_encode("Erro ao baixar o arquivo: HTTP $httpCode");
            exit();
        }
    }

    // Fecha a sessão cURL
    curl_close($ch);

    //envia resposta para o front-end
    echo json_encode(['link' => $pdf_link]);
} else {
    echo json_encode(['Erro' => 'A API retornou o código de status HTTP ' . $httpCode]);
    // Verifica se há mensagens de erro na resposta JSON
    $responseData = json_decode($response, true);
    if (isset($responseData['errors'])) {
        //echo 'Detalhes do erro:';
        foreach ($responseData['errors'] as $error) {
            //echo '<br> ' . htmlspecialchars($error['message']);
        }
    }
}
