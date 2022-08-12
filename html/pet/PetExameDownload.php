<?php

/*
session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../../index.php");
}

// Verifica Permissão do Usuário
require_once '../../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);*/

require_once "../../dao/Conexao.php";
//require_once "./Documento.php";

//$prep->bindValue(":a", gzcompress($arquivo_b64));
define("TYPEOF_EXTENSION", [
    'jpg' => 'image/jpg',
    'png' => 'image/png',
    'jpeg' => 'image/jpeg',
    'pdf' => 'application/pdf',
    'docx' => 'application/docx',
    'doc' => 'application/doc',
    'odp' => 'application/odp',
]);

$pdo = Conexao::connect();
$query = $pdo->query("SELECT * FROM pet_exame WHERE id_exame = " .$_GET['id_exame']);
$query = $query->fetch(PDO::FETCH_ASSOC);
var_dump($query);

//header("Content-type: ".TYPEOF_EXTENSION[$query["arquivo_extensao"]]);
header("Content-Disposition: attachment; filename=".$query["arquivo_nome"].".".$query["arquivo_extensao"]);
ob_clean();
flush();
    
//echo base64_decode($query["arquivo_exame"]);
echo base64_decode(gzuncompress($query["arquivo_exame"]));
//echo base64_decode(gzuncompress($query["arquivo_exame"]));

//die();
