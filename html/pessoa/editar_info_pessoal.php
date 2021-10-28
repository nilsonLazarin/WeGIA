<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}


// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 1, 3);

require_once "../../dao/Conexao.php";
$pdo = Conexao::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

extract($_POST);

if ($action == "mudarInfoPessoal"){
    $id_pessoa = $_POST['id_pessoa'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $telefone = $_POST['telefone'];
    $sexo = $_POST['sexo'];
    $data_nascimento = $_POST['data_nascimento'];
    $nome_pai = $_POST['nome_pai'];
    $nome_mae = $_POST['nome_mae'];
    $sql = "UPDATE pessoa SET nome=$nome, sobrenome=$sobrenome, telefone=$telefone, sexo=$sexo, nome_pai=$nome_pai, nome_mae=$nome_mae, data_nascimento=$data_nascimento  WHERE id_pessoa=$id_pessoa;";
    try {
        $pdo->query($sql);
        echo json_encode($pdo->query($response_query)->fetchAll(PDO::FETCH_ASSOC));
    } catch (PDOException $th) {
        echo json_encode($th);
    }
}



// $nome = ($nome ? "'$nome'" : "NULL");
// $sobrenome = ($sobrenome ? "'$sobrenome'" : "NULL");
// $telefone = ($telefone ? "'$telefone'" : "NULL");
// $nome_pai = ($nome_pai ? "'$nome_pai'" : "NULL");
// $nome_mae = ($nome_mae ? "'$nome_mae'" : "NULL");
// $gender = ($gender ? "'$gender'" : "NULL");
// $sangue = ($sangue ? "'$sangue'" : "NULL");
// $nascimento = ($nascimento ? "'$nascimento'" : "NULL");

// $sql = "UPDATE pessoa SET nome=$nome, sobrenome=$sobrenome, telefone=$telefone, sexo=$sexo, nome_pai=$nome_pai, nome_mae=$nome_mae, data_nascimento=$data_nascimento  WHERE id_pessoa=$id_pessoa;";


// $sql = "UPDATE pessoa SET nome=:nome, sobrenome=:sobrenome, telefone=:telefone, sexo=:sexo, nome_pai=:nome_pai, nome_mae=:nome_mae, data_nascimento=:data_nascimento WHERE id_pessoa=:id_pessoa";

// $stmt->bindParam('id_pessoa',$id_pessoa);
// $stmt->bindParam('nome',$nome);
// $stmt->bindParam('sobrenome',$sobrenome);
// $stmt->bindParam(':cpf',$cpf);
// $stmt->bindParam(':sexo',$sexo);
// $stmt->bindParam(':telefone',$telefone);
// $stmt->bindParam(':data_nascimento',$data_nascimento);
// $stmt->bindParam(':nome_pai',$nome_pai);
// $stmt->bindParam(':nome_mae',$nome_mae);

// $stmt->execute();

// $pdo->query($sql);


$_GET['sql'] = $sql;
echo(json_encode($_GET));