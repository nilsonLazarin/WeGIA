<pre>
<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

session_start();
extract($_REQUEST);
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

if ($_POST){
    require_once "../../dao/Conexao.php";

    // $idatendido, $id_docfuncional e $arquivo
    var_dump($_POST);
    extract($_POST);

    $arquivo = $_FILES["arquivo"];
    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        die("Houve um erro no upload do arquivo. Código de erro: " . $arquivo['error']);
    }
    $arquivo_nome = $arquivo["name"];
    $extensao_nome = strtolower(pathinfo($arquivo["name"], PATHINFO_EXTENSION));
    $arquivo_b64 = base64_encode(file_get_contents($arquivo['tmp_name']));	
    
    $tipos_permitidos = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'];

    if (in_array($extensao_nome, $tipos_permitidos)) {
        try {
            $pdo = Conexao::connect();
            $prep = $pdo->prepare("INSERT INTO atendido_documentacao( atendido_idatendido, atendido_docs_atendidos_idatendido_docs_atendidos, data, arquivo_nome, arquivo_extensao, arquivo) 	
            VALUES ( :atendido_idatendido , :atendido_docs_atendidos_idatendido_docs_atendidos , :data, :arquivo_nome , :arquivo_extensao, :arquivo )");

            //$prep->bindValue(":ida", $idatendido);
            //$prep->bindValue(":idd", $atentido_ocorrencia_idatentido_ocorrencias);
            $prep->bindValue(":atendido_idatendido", $idatendido);
            $prep->bindValue(":atendido_docs_atendidos_idatendido_docs_atendidos", $id_docfuncional);
            $prep->bindValue(":arquivo_nome", $arquivo_nome);
            $prep->bindValue(":arquivo_extensao", $extensao_nome);
            $prep->bindValue(":arquivo", gzcompress($arquivo_b64));

            $dataDocumento = date('Y/m/d');
            $prep->bindValue(":data", $dataDocumento);

            $prep->execute();
            
            header("Location: Profile_Atendido.php?idatendido=$idatendido");
        } catch (PDOException $e) {
            error_log("Erro de PDO: " . $e->getMessage());
            echo("Houve um erro ao realizar o upload do documento:<br><br>$e");
        }
    } else {
        echo "Tipo de arquivo não permitido. Apenas arquivos PDF, JPG, JPEG, PNG, DOC e DOCX são aceitos.";
    }
}else {
    header("Location: Informacao_Atendido.php");
}