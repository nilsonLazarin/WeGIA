<?php
// Inicia a sessão
session_start();
require_once(dirname(__DIR__, 3) . '/permissao/permissao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['id_pessoa'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Acesso não autorizado, usuário não está logado.']);
    exit();
}

permissao($_SESSION['id_pessoa'], 4, 3);

// Inicializa a resposta padrão
$r = array(
    "resultado" => false,
    "mensagem" => "Ocorreu um erro ao processar o arquivo."
);

// Diretório seguro para armazenamento de arquivos
$diretorio = "../tabelas/";

// Cria o diretório, se não existir
if (!is_dir($diretorio)) {
    if (!mkdir($diretorio, 0755, true)) {
        $r['mensagem'] = "Erro ao criar diretório de upload.";
        echo json_encode($r);
        exit;
    }
}

if (!empty($_FILES['arquivo']['name'])) {
    // Tipos MIME permitidos para arquivos Excel (.xls e .xlsx)
    $tiposMimePermitidos = array(
        'application/vnd.ms-excel', // Para .xls
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' // Para .xlsx
    );

    // Obtém o tipo MIME do arquivo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $tipoMime = finfo_file($finfo, $_FILES['arquivo']['tmp_name']);
    finfo_close($finfo);

    // Verifica se o tipo MIME do arquivo é permitido
    if (!in_array($tipoMime, $tiposMimePermitidos)) {
        http_response_code(400);
        $r['mensagem'] = "Tipo de arquivo inválido. Apenas arquivos .xls e .xlsx são permitidos.";
        echo json_encode($r);
        exit;
    }

    // Obtém o nome e a extensão do arquivo
    $file_name_original = basename($_FILES['arquivo']['name']);
    $extensao = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));

    // Sanitiza o nome do arquivo para evitar problemas com caracteres especiais
    $file_name_sanitized = preg_replace("/[^a-zA-Z0-9\._-]/", "_", pathinfo($file_name_original, PATHINFO_FILENAME));
    $file_name = uniqid() . "_" . $file_name_sanitized . '.' . $extensao;

    // Verifica se o arquivo já existe (mesmo com nomes únicos, esta é uma garantia extra)
    $destino = $diretorio . $file_name;
    if (file_exists($destino)) {
        $r['mensagem'] = "Um arquivo com o mesmo nome já existe.";
        echo json_encode($r);
        exit;
    }

    // Move o arquivo para o diretório seguro
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $destino)) {
        $r['resultado'] = true;
        $r['mensagem'] = "Upload realizado com sucesso.";
        $r['url'] = "./tabelas/" . urlencode($file_name); // Codifica a URL para evitar problemas
    } else {
        $r['mensagem'] = "Erro ao mover o arquivo para o diretório de destino.";
    }
}

// Retorna a resposta em formato JSON
echo json_encode($r);
?>
