<?php

function listarArquivos($diretorio) {
    // Verifica se o diretório existe
    if (!is_dir($diretorio)) {
        return false;
    }

    // Abre o diretório
    $arquivos = scandir($diretorio);

    // Remove os diretórios '.' e '..' da lista de arquivos
    $arquivos = array_diff($arquivos, array('.', '..'));

    return $arquivos;
}

// Extrair dados da requisição
$doc = trim($_GET['documento']);
$docLimpo = preg_replace('/\D/', '', $doc);

// Caminho para o diretório de PDFs
$path = '../../pdfs/';

// Listar arquivos no diretório
$arrayBoletos = listarArquivos($path);

if(!$arrayBoletos){
    $mensagemErro = json_encode(['erro' => 'O diretório de armazenamento de PDFs não existe']);
    exit($mensagemErro); 
}

$boletosEncontrados = [];

foreach ($arrayBoletos as $boleto) {
    // Extrair o documento do nome do arquivo
    $documentoArquivo = explode('_', $boleto)[1];
    if ($documentoArquivo == $docLimpo) {
        $boletosEncontrados[] = $boleto;
    }
}

// Retornar JSON com os boletos encontrados
echo json_encode($boletosEncontrados);
?>
