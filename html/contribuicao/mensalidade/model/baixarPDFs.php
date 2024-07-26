<?php
$pdf_links = [
    'https://api.pagar.me/core/v5/transactions/tran_lwnDra6SESv1Km8B/pdf',
    'https://api.pagar.me/core/v5/transactions/tran_64DWQBkS2SPmgwye/pdf',
    'https://api.pagar.me/core/v5/transactions/tran_WXo30GVH9khBjnbG/pdf'
];

// Diretório onde os arquivos serão armazenados
$saveDir = './pdfs_temp/';

// Verifica se o diretório existe, se não, cria o diretório
if (!is_dir($saveDir)) {
    mkdir($saveDir, 0755, true);
}

foreach ($pdf_links as $indice => $url) {
    // Extrai o nome do arquivo a partir da URL
    $pathParts = explode('/', $url);
    $fileName = $indice . '_'.$pathParts[count($pathParts) - 2] . '.pdf';
    
    // Caminho completo para salvar o arquivo
    $savePath = $saveDir . $fileName;

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
        echo 'Erro ao baixar o arquivo: ' . curl_error($ch) . PHP_EOL;
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
                echo "Arquivo salvo em: $savePath" . PHP_EOL;//trocar para colocar o caminho em um array
            } else {
                echo "Erro: O conteúdo da URL não é um PDF." . PHP_EOL;
            }
        } else {
            echo "Erro ao baixar o arquivo: HTTP $httpCode" . PHP_EOL;
        }
    }

    // Fecha a sessão cURL
    curl_close($ch);
}