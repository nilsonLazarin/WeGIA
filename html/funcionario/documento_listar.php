
<?php

require_once "../../dao/Conexao.php";
$pdo = Conexao::connect();
$docfuncional = $pdo->query("SELECT * FROM funcionario_docfuncional;");
$docfuncional = $docfuncional->fetchAll(PDO::FETCH_ASSOC);
$docfuncional = json_encode($docfuncional);
echo $docfuncional;

?>