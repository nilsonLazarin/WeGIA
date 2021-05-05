
<?php

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 11, 7);

require_once "../../dao/Conexao.php";
$pdo = Conexao::connect();
$docfuncional = $pdo->query("SELECT * FROM funcionario_docfuncional ORDER BY nome_docfuncional ASC;");
$docfuncional = $docfuncional->fetchAll(PDO::FETCH_ASSOC);
$docfuncional = json_encode($docfuncional);
echo $docfuncional;

die();

?>