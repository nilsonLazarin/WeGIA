<?php

require_once('conexao.php');
$query = new Conexao();
$pdo = $query->pdo;

$nome = $_POST['nome'];
$tel = $_POST['telefone'];
$email = $_POST['email'];
$doc = $_POST['doc'];
$dataN = $_POST['datanascimento'];

$cep = $_POST['cep'];
$rua = $_POST['log'];
$numero = $_POST['numero'];
$compl = $_POST['comp'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$uf = $_POST['uf'];

$tipoPessoa = $_POST['tipoPessoa'];

try {

   $sqlPesquisaSocio = "SELECT * FROM socio s JOIN pessoa p ON (s.id_pessoa=p.id_pessoa) WHERE p.cpf =:doc";
   $stmt = $pdo->prepare($sqlPesquisaSocio);
   $stmt->bindParam(':doc', $doc);
   $stmt->execute();
   $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

   if (!$resultado || empty($resultado)) { //Verifica se de fato existe um sócio cadastrado antes de realizar a edição, do contrário cria o sócio
      $sqlSelecionaIdPessoa = "SELECT id_pessoa FROM pessoa WHERE cpf=:doc";

      $stmt2 = $pdo->prepare($sqlSelecionaIdPessoa);
      $stmt2->bindParam(':doc', $doc);
      $stmt2->execute();
      $resultado = $stmt2->fetch(PDO::FETCH_ASSOC);

      $idPessoa = $resultado['id_pessoa'];
      $idStatus = 0;

      $sqlCriarSocio = "INSERT INTO socio (id_pessoa, id_sociostatus, id_sociotipo, email) VALUES (:idPessoa, :idStatus, :idTipo, :email)";
      $stmt3 = $pdo->prepare($sqlCriarSocio);
      $stmt3->bindParam(':idPessoa', $idPessoa);
      $stmt3->bindParam(':idStatus', $idStatus);
      $stmt3->bindParam(':email', $email);

      if ($tipoPessoa == 'fisica') {
         $idTipo = '0';
         $stmt3->bindParam(':idTipo', $idTipo);
      } else if ($tipoPessoa == 'juridica') {
         $idTipo = '1';
         $stmt3->bindParam(':idTipo', $idTipo);
      }

      $stmt3->execute();
   }

   $query->query("UPDATE pessoa as p JOIN socio as s ON(p.id_pessoa = s.id_pessoa) SET nome = '$nome', telefone= '$tel', data_nascimento = '$dataN', cep = '$cep', logradouro = '$rua', numero_endereco = '$numero', complemento = '$compl', bairro = '$bairro', cidade = '$cidade', estado= '$uf', email = '$email' WHERE cpf = '$doc'");
} catch (PDOException $e) {
   echo 'Erro ao tentar alterar os dados de um sócio: ' . $e->getMessage();
}
