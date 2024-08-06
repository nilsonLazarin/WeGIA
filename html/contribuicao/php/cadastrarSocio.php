<?php
//Refazer arquivo
require_once('conexao.php');
$conexao = new Conexao;
$pdo = $conexao->pdo;

$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$email = $_POST['contato'];
$tipo = $_POST['tipo'];
$doc = $_POST['doc'];
$dataNascimento = $_POST['datanascimento'];

$cep = $_POST['cep'];
$rua = $_POST['log'];
$numero = $_POST['numero'];
$complemento = $_POST['comp'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$uf = $_POST['uf'];

$status = $_POST['status'];
$idTipo = $_POST['id_sociotipo']; //Por enquanto são cadastrados apenas sócios com doações casuais

try {
    $sql1 = "INSERT INTO pessoa(nome,cpf,telefone,data_nascimento,cep,estado,cidade, bairro, logradouro, numero_endereco,complemento) VALUES (:nome, :doc, :telefone, :dataNascimento, :cep, :uf, :cidade, :bairro, :rua, :numero, :complemento)";

    $sql2 = "INSERT INTO socio(id_pessoa, id_sociostatus, id_sociotipo, email)values (:idPessoa, :status, :idTipo, :email)";

    $sql3 = "SELECT id_pessoa FROM pessoa WHERE cpf =:cpf";

    $pdo->beginTransaction();

    $stmt3 = $pdo->prepare($sql3);
    $stmt3->bindParam(':cpf', $doc);
    $stmt3->execute();
    $resultado = $stmt3->fetch(PDO::FETCH_ASSOC);

    if (!empty($resultado)) {//verifica se existe alguem com o cpf informado no banco de dados de pessoas que não está cadastrado como sócio (um funcionário por exemplo)
        $idPessoa = $resultado['id_pessoa'];
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->bindParam(':idPessoa', $idPessoa);
        $stmt2->bindParam(':status', $status);
        $stmt2->bindParam(':idTipo', $idTipo);
        $stmt2->bindParam(':email', $email);

        if ($stmt2->execute()) {
            $pdo->commit();
        } else {
            $pdo->rollBack();
        }
    } else {

        $stmt1 = $pdo->prepare($sql1);
        $stmt1->bindParam(':nome', $nome);
        $stmt1->bindParam(':doc', $doc);
        $stmt1->bindParam(':telefone', $telefone);
        $stmt1->bindParam(':dataNascimento', $dataNascimento);
        $stmt1->bindParam(':cep', $cep);
        $stmt1->bindParam(':uf', $uf);
        $stmt1->bindParam(':cidade', $cidade);
        $stmt1->bindParam(':bairro', $bairro);
        $stmt1->bindParam(':rua', $rua);
        $stmt1->bindParam(':numero', $numero);
        $stmt1->bindParam(':complemento', $complemento);

        if ($stmt1->execute()) {

            $idPessoa = $pdo->lastInsertId();

            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(':idPessoa', $idPessoa);
            $stmt2->bindParam(':status', $status);
            $stmt2->bindParam(':idTipo', $idTipo);
            $stmt2->bindParam(':email', $email);

            if ($stmt2->execute()) {
                $pdo->commit();
            } else {
                $pdo->rollBack();
            }
        } else {
            $pdo->rollBack();
        }
    }
} catch (PDOException $e) {
    http_response_code(500);
    exit('Ocorreu um erro ao tentar inserir um sócio no banco de dados: ' . $e->getMessage());
}
