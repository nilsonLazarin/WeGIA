<?php
//Recuperar Info BD
//Refatorar arquivo posteriormente

require_once("../../php/conexao.php");
require 'vendor/autoload.php';

use setasign\Fpdi\Fpdi;

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

/**
 * Remove um diretório e todo o seu conteúdo.
 *
 * @param string $dir O caminho do diretório a ser removido.
 * @return bool Retorna true em caso de sucesso, false em caso de falha.
 */
function removeDirectory($dir) {
    // Verifica se o diretório existe
    if (!file_exists($dir)) {
        return false;
    }

    // Verifica se é um diretório
    if (!is_dir($dir)) {
        return false;
    }

    // Abre o diretório
    $dirHandle = opendir($dir);

    // Percorre todos os arquivos e diretórios dentro do diretório
    while (($file = readdir($dirHandle)) !== false) {
        if ($file != '.' && $file != '..') {
            $filePath = $dir . DIRECTORY_SEPARATOR . $file;

            // Se for um diretório, chama a função recursivamente
            if (is_dir($filePath)) {
                removeDirectory($filePath);
            } else {
                // Se for um arquivo, remove o arquivo
                unlink($filePath);
            }
        }
    }

    // Fecha o diretório
    closedir($dirHandle);

    // Remove o diretório
    return rmdir($dir);
}

$cpf = $_POST['dcpf'];
$cpfSemMascara = preg_replace('/\D/', '', $cpf);

$banco = new Conexao;
$stmt = $banco->pdo;

try {

    $req = $stmt->prepare("SELECT pessoa.id_pessoa, pessoa.nome, pessoa.telefone, pessoa.cep, pessoa.estado, pessoa.cidade, pessoa.bairro, pessoa.complemento, pessoa.numero_endereco, pessoa.logradouro, socio.id_pessoa, socio.email FROM pessoa, socio WHERE pessoa.id_pessoa = socio.id_pessoa AND pessoa.cpf=:cpf;");
    $req->bindParam(":cpf", $cpf);
    $req->execute();
    $arrayBd = $req->fetchAll(PDO::FETCH_ASSOC)[0];

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
} catch (PDOException $e) {
    die("Erro: Não foi possível buscar a venda no BD" . $e->getMessage() . ".");
}

$idBoleto = rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9);
$idBoleto = intval($idBoleto);

$type = "DM";

//Requisição Boleto

/*function verificaBanco($bank)
{
    if ($bank == "b_brasil") {
        $code = 001;
    } elseif ($bank == "pagar_me") {
        $code = 198;
    } elseif ($bank == "caixa_econ") {
        $code = 104;
    } elseif ($bank == "santander") {
        $code = 033;
    } elseif ($bank == "itau") {
        $code = 341;
    } elseif ($bank == "bradesco") {
        $code = 237;
    }
    return $code;
}*/

$value = intval($_POST["valor"]);

$regras = $stmt->query("SELECT dbr.min_boleto_uni FROM doacao_boleto_regras AS dbr JOIN doacao_boleto_info AS dbi ON (dbr.id = dbi.id_regras)");
$regras = $regras->fetch(PDO::FETCH_ASSOC);

if ($value < $regras['min_boleto_uni']) {
    echo json_encode('O valor para uma doação está abaixo do mínimo requerido.');
    exit();
}

//parcelar
$qtd_p = intval($_POST['parcela']);

if($qtd_p < 1){
    echo json_encode('A quantidade de parcelas não pode ser menor que 1.');
    exit();
}

if($qtd_p > 12){
    echo json_encode('A quantidade de parcelas não pode ser maior que 12.');
    exit();
}

$diaVencimento = intval($_POST['dia']);

if($diaVencimento < 1){
    echo json_encode('O dia de vencimento de uma parcela não pode ser menor que 1.');
    exit();
}

// Criar um array para armazenar as datas de vencimento
$datasVencimento = [];

// Pegar a data atual
$dataAtual = new DateTime();

// Verificar se o dia informado já passou neste mês
if ($diaVencimento <= $dataAtual->format('d')) {
    // Se o dia informado já passou, começar a partir do próximo mês
    $dataAtual->modify('first day of next month');
}

// Iterar sobre a quantidade de parcelas
for ($i = 0; $i < $qtd_p; $i++) {
    // Clonar a data atual para evitar modificar o objeto original
    $dataVencimento = clone $dataAtual;

    // Adicionar os meses de acordo com o índice da parcela
    $dataVencimento->modify("+{$i} month");

    // Definir o dia do vencimento para o dia informado
    $dataVencimento->setDate($dataVencimento->format('Y'), $dataVencimento->format('m'), $diaVencimento);

    // Ajustar a data caso o mês não tenha o dia informado (por exemplo, 30 de fevereiro)
    if ($dataVencimento->format('d') != $diaVencimento) {
        $dataVencimento->modify('last day of previous month');
    }

    // Adicionar a data formatada ao array
    $datasVencimento[] = $dataVencimento->format('Y-m-d');
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
                "due_at" => $datasVencimento[0],
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
    $boleto['payments'][0]['boleto']['due_at'] = $datasVencimento[$i];

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
        //$arquivos[] = $responseData['charges'][0]['last_transaction']['pdf'];
    } else {
        echo json_encode('Erro: A API retornou o código de status HTTP ' . $httpCode);
        exit();
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

// Diretório onde os arquivos serão armazenados
$saveDir = '../../pdfs/';
$saveDirTemp = $saveDir.'temp/';

// Verifica se o diretório existe, se não, cria o diretório
if (!is_dir($saveDir)) {
    mkdir($saveDir, 0755, true);
}

if (!is_dir($saveDirTemp)) {
    mkdir($saveDirTemp, 0755, true);
}

foreach ($pdf_links as $indice => $url) {
    // Extrai o nome do arquivo a partir da URL
    $pathParts = explode('/', $url);
    $fileName = $indice . '_' . $pathParts[count($pathParts) - 2] . '.pdf';

    // Caminho completo para salvar o arquivo
    $savePath = $saveDirTemp . $fileName;

    // Inicia uma sessão cURL
    $ch = curl_init($url);

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
                file_put_contents($savePath, $fileContent);
                $arquivos []= $savePath;
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
}

$pdf = new Fpdi();

// Itera sobre cada arquivo PDF
foreach ($arquivos as $file) {
    $pageCount = $pdf->setSourceFile($file);
    // Itera sobre cada página do PDF atual
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $templateId = $pdf->importPage($pageNo);
        $size = $pdf->getTemplateSize($templateId);

        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
        $pdf->useTemplate($templateId);
    }
}

$numeroAleatorio = gerarCodigoAleatorio();
$ultimaDataVencimento = $datasVencimento[$qtd_p - 1];
$ultimaDataVencimento = str_replace('-', '', $ultimaDataVencimento);

// Salva o arquivo PDF unido
$pdf->Output('F', '../../pdfs/'.$numeroAleatorio.'_'.$cpfSemMascara.'_'.$ultimaDataVencimento.'_'.$value.'.pdf');

removeDirectory('../../pdfs/temp');

$pdf_link = WWW.'html/contribuicao/pdfs/'.$numeroAleatorio.'_'.$cpfSemMascara.'_'.$ultimaDataVencimento.'_'.$value.'.pdf';

if($pdf_link){
    echo json_encode(['link' => $pdf_link]);
}else{
    echo json_encode('Não foi possível guardar o PDF gerado.');
}   