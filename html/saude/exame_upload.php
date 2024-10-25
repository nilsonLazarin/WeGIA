<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../../index.php");
    exit();
}

if ($_POST) {
    require_once "../../dao/Conexao.php";

    extract($_POST);
    $arquivo = $_FILES["arquivo"];
    
    // Verificação de erro no upload
    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        switch ($arquivo['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $mensagem = "O arquivo é muito grande. O tamanho máximo permitido é de " . ini_get("upload_max_filesize") . ".";
                break;
            case UPLOAD_ERR_PARTIAL:
                $mensagem = "O arquivo foi carregado parcialmente. Tente novamente.";
                break;
            case UPLOAD_ERR_NO_FILE:
                $mensagem = "Nenhum arquivo foi enviado. Por favor, selecione um arquivo.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $mensagem = "Erro no servidor: Diretório temporário ausente.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $mensagem = "Erro no servidor: Falha ao gravar o arquivo no disco.";
                break;
            case UPLOAD_ERR_EXTENSION:
                $mensagem = "Erro: Uma extensão do PHP bloqueou o upload do arquivo.";
                break;
            default:
                $mensagem = "Erro desconhecido ao fazer o upload do arquivo.";
                break;
        }
        echo htmlspecialchars($mensagem);
        exit();
    }

    // Verificação da extensão do arquivo
    $arquivo_nome = htmlspecialchars($arquivo["name"]);
    $extensao_nome = strtolower(pathinfo($arquivo_nome, PATHINFO_EXTENSION));
    $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'pdf'];

    if (!in_array($extensao_nome, $extensoes_permitidas)) {
        echo "Formato de arquivo inválido. Apenas " . implode(", ", $extensoes_permitidas) . " são permitidos.";
        exit();
    }

    $arquivo_b64 = base64_encode(file_get_contents($arquivo['tmp_name']));

    try {
        $pdo = Conexao::connect();
        $prep = $pdo->prepare("INSERT INTO saude_exames(id_fichamedica, id_exame_tipos, data, arquivo_nome, arquivo_extensao, arquivo) VALUES (:id_fichamedica, :id_exame_tipos, :data, :arquivo_nome, :arquivo_extensao, :arquivo)");

        // Sanitização dos dados
        $id_fichamedica = htmlspecialchars($id_fichamedica);
        $id_docfuncional = htmlspecialchars($id_docfuncional);
        $dataExame = date('Y/m/d');

        $prep->bindValue(":id_fichamedica", $id_fichamedica);
        $prep->bindValue(":id_exame_tipos", $id_docfuncional);
        $prep->bindValue(":arquivo_nome", $arquivo_nome);
        $prep->bindValue(":arquivo_extensao", $extensao_nome);
        $prep->bindValue(":arquivo", gzcompress($arquivo_b64));
        $prep->bindValue(":data", $dataExame);

        $prep->execute();

        header("Location: profile_paciente.php?id_fichamedica=$id_fichamedica");
        exit();
    } catch (PDOException $e) {
        echo "Houve um erro ao realizar o upload do exame:<br><br>" . htmlspecialchars($e->getMessage());
    }
} else {
    header("Location: profile_paciente.php");
    exit();
}
