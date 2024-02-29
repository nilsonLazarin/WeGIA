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
    
    // A tabela atendido_ocorrencia_docs requer idatendido_ocorrencia_doc 	atentido_ocorrencia_idatentido_ocorrencias 	data 	arquivo_nome 	arquivo_extensao 	arquivo
    $arquivo = $_FILES["arquivo"];
    $arquivo_nome = $arquivo["name"];
    $extensao_nome = explode(".", $arquivo["name"])[1];
    $arquivo_b64 = base64_encode(file_get_contents($arquivo['tmp_name']));	 	

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
        echo("Houve um erro ao realizar o upload do documento:<br><br>$e");
    }


}else {
    header("Location: Informacao_Atendido.php");
}


