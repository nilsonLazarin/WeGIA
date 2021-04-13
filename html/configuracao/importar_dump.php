<pre>
<?php

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 9);

require_once "../../dao/Conexao.php";

require_once "../../config.php";

define("REDIRECT", $_REQUEST["redirect"] ?? "./configuracao_geral.php");

$newFileName = date("YmdHis") . "-import";

try {

    $newImport = fopen(BKP_DIR . $newFileName . ".bd.sql", "w");
    fwrite($newImport, file_get_contents($_FILES["import"]["tmp_name"]));

} catch (Exception $e){

    header("Location: ".REDIRECT."?msg=error&err=Houve um erro na criação do arquivo .sql!&log=".base64_encode($e));

}

// Compacta o dump gerado em um .dump.tar.gz
$dbComp = "tar -czf ".$newFileName.".dump.tar.gz ".$newFileName.".bd.sql";

// Remove o arquivo não compactado
$dbRemv = "rm ".BKP_DIR.$newFileName.".bd.sql";

$log = shell_exec("cd ".BKP_DIR." && ". $dbComp . " && " . $dbRemv);

if ($log){
    header("Location: ./configuracao_geral.php?msg=error&err=Houve um erro na compactação do arquivo!&log=".base64_encode($log));
}

header("Location: ./configuracao_geral.php?msg=success&sccs=Importação realizada com sucesso!");