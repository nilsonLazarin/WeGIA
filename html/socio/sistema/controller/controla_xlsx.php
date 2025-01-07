<?php
//verificar privilégios do solicitante
session_start();
require_once(dirname(__DIR__, 3) . '/permissao/permissao.php');

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

    // Cria os diretórios necessários, se não existirem
    if (!is_dir($diretorio)) {
        if (!mkdir($diretorio, 0755, true)) {
            $r['mensagem'] = "Erro ao criar diretório de upload.";
            echo json_encode($r);
            exit;
        }
    }

    if (!empty($_FILES['arquivo']['name'])) {
        // Lista de extensões e tipos MIME permitidos
        $extensoesPermitidas = array('jpg', 'jpeg', 'png', 'gif');
        $tiposMimePermitidos = array('image/jpeg', 'image/png', 'image/gif');

        // Obtém o nome e extensão do arquivo
        $file_name_original = basename($_FILES['arquivo']['name']);
        $extensao = strtolower(pathinfo($file_name_original, PATHINFO_EXTENSION));

        if (in_array($extensao, $permitidos)) {
            $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['arquivo']['name']));

            if (move_uploaded_file($_FILES['arquivo']['tmp_name'], "../tabelas/" . $file_name)) {
                $r['resultado'] = true;
                $r['url'] = "./tabelas/" . htmlspecialchars($file_name, ENT_QUOTES, 'UTF-8');
            } else {
                $r['url'] = "Erro ao mover o arquivo.";
            }
        } else {
            $r['url'] = "Tipo de arquivo não permitido.";
        }
    }
    // Verifica se a extensão é permitida
    if (!in_array($extensao, $extensoesPermitidas)) {
        $r['mensagem'] = "Extensão de arquivo não permitida.";
        echo json_encode($r);
        exit;
    }

    // Obtém o tipo MIME do arquivo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $tipoMime = finfo_file($finfo, $_FILES['arquivo']['tmp_name']);
    finfo_close($finfo);

    // Verifica se o tipo MIME é permitido
    if (!in_array($tipoMime, $tiposMimePermitidos)) {
        $r['mensagem'] = "Tipo de arquivo inválido.";
        echo json_encode($r);
        exit;
    }

    // Sanitiza e gera um nome de arquivo único
    $file_name_sanitized = preg_replace("/[^a-zA-Z0-9\._-]/", "_", pathinfo($file_name_original, PATHINFO_FILENAME));
    $file_name = uniqid() . "_" . $file_name_sanitized . '.' . $extensao;

    // Verifica se o arquivo já existe (mesmo com nomes únicos, esta é uma garantia extra)
    $destino = $diretorio . $file_name;
    if (file_exists($destino)) {
        $r['mensagem'] = "Um arquivo com o mesmo nome já existe.";
        echo json_encode($r);
        exit;
    }

    // Verifica se o arquivo é realmente uma imagem válida
    if (!getimagesize($_FILES['arquivo']['tmp_name'])) {
        $r['mensagem'] = "O arquivo enviado não é uma imagem válida.";
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

echo (json_encode($r));
