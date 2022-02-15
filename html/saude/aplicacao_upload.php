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

$id_medicacao = $_GET['id_medicacao'];
$pessoa_id_pessoa = $_GET['id_pessoa'];
$funcionario_id_funcionario = $_GET['id_funcionario'];

// echo file_put_contents('id_pessoa.txt',$pessoa_id_pessoa);
// echo file_put_contents('id_func.txt',$funcionario_id_funcionario);

require_once "../../dao/Conexao.php";	 
    
$aplicacao = date('Y-m-d H:i:s', time()); 

try {
    $pdo = Conexao::connect();
    $prep = $pdo->prepare("INSERT INTO saude_medicamento_administracao(aplicação, saude_medicacao_id_medicacao, pessoa_id_pessoa, funcionario_id_funcionario) VALUES (:aplicacao, :saude_medicacao_id_medicacao, :pessoa_id_pessoa, :funcionario_id_funcionario)");

    $prep->bindValue(":aplicacao", $aplicacao);
    $prep->bindValue(":saude_medicacao_id_medicacao", $id_medicacao);
    $prep->bindValue(":pessoa_id_pessoa", $pessoa_id_pessoa);
    $prep->bindValue(":funcionario_id_funcionario", $funcionario_id_funcionario);

    $prep->execute();
    
    header("Location: administrar_medicamento.php?id_fichamedica=$id_fichamedica");
} catch (PDOException $e) {
    echo("Houve um erro ao realizar o upload das aplicações:<br><br>$e");
}




