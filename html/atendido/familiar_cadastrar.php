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
permissao($_SESSION['id_pessoa'], 11, 7);
require_once '../../dao/Conexao.php';
$pdo = Conexao::connect();

// Pessoa

$cpf = $_POST['cpf'];
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$sexo = $_POST['sexo'];
$telefone = $_POST['telefone'];
$data_nascimento = $_POST['nascimento'];
$registro_geral = $_POST['rg'];
$orgao_emissor = $_POST['orgao_emissor'];
$data_expedicao = $_POST['data_expedicao'];

define("NOVA_PESSOA", "INSERT IGNORE INTO pessoa (cpf, nome, sobrenome, sexo, telefone, data_nascimento, registro_geral, orgao_emissor, data_expedicao) VALUES 
                            (:cpf, :nome, :sobrenome, :sexo, :telefone, :data_nascimento, :registro_geral, :orgao_emissor, :data_expedicao)");
try {
    $pessoa = $pdo->prepare(NOVA_PESSOA);
    $pessoa->bindValue(":cpf", $cpf);
    $pessoa->bindValue(":nome", $nome);
    $pessoa->bindValue(":sobrenome", $sobrenome);
    $pessoa->bindValue(":sexo", $sexo);
    $pessoa->bindValue(":telefone", $telefone);
    $pessoa->bindValue(":data_nascimento", $data_nascimento);
    $pessoa->bindValue(":registro_geral", $registro_geral);
    $pessoa->bindValue(":orgao_emissor", $orgao_emissor);
    $pessoa->bindValue(":data_expedicao", $data_expedicao);
    $pessoa->execute();
} catch (PDOException $th) {
    echo "Houve um erro ao inserir a pessoa no banco de dados: $th";
    die();
}


// Familiar

$id_parentesco = $_POST['id_parentesco'];
$idatendido = $_POST['idatendido'];
try {
    $id_pessoa = $pdo->query("SELECT id_pessoa FROM pessoa WHERE cpf = '$cpf';")->fetch(PDO::FETCH_ASSOC)["id_pessoa"];
} catch (PDOException $th) {
    echo "Houve um erro ao obter o id da pessoa do banco de dados: $th";
    die();
}

define("NOVO_FAMILIAR", "INSERT IGNORE INTO atendido_familiares (atendido_idatendido, pessoa_id_pessoa, atendido_parentesco_idatendido_parentesco ) VALUES 
                                ( $idatendido , $id_pessoa , $id_parentesco );");
echo NOVO_FAMILIAR."<br><br>";
try {
    $pdo->query(NOVO_FAMILIAR);
} catch (PDOException $th) {
    echo "Houve um erro ao adicionar o dependente ao banco de dados: $th";
    die();
}

header("Location: Profile_Atendido.php?idatendido=$idatendido");