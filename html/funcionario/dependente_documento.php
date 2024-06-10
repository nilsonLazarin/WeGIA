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
$id_dependente = $_POST["id_dependente"];

$sql = "SELECT doc.nome_docdependente AS descricao, ddoc.data, ddoc.id_doc FROM funcionario_dependentes_docs ddoc LEFT JOIN funcionario_docdependentes doc ON doc.id_docdependentes = ddoc.id_docdependentes WHERE ddoc.id_dependente=$id_dependente;";

$dependente = $pdo->query($sql);
$dependente = $dependente->fetchAll(PDO::FETCH_ASSOC);

foreach ($dependente as $key => $value) {
    //formatar data
    $data = new DateTime($value['data']);
    $dependente[$key]['data'] = $data->format('d/m/Y h:m:s');
  }

$dependente = json_encode($dependente);

echo $dependente;

die();