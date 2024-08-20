<?php

require_once('conexao.php');
$query = new Conexao();
$pdo = $query->pdo;

$nome = $_POST['nome'];
$tel = $_POST['telefone'];
$email = $_POST['email'];
$doc = $_POST['doc'];
$dataN = trim($_POST['datanascimento']);

if(!$dataN || empty($dataN)){
   $dataN = null;
}

$cep = $_POST['cep'];
$rua = $_POST['log'];
$numero = $_POST['numero'];
$compl = $_POST['comp'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$uf = $_POST['uf'];

$tipoPessoa = $_POST['tipoPessoa'];

try{//Try catch para validar se um funcionário está logado para conseguir alterar suas informações
   $sqlPesquisaFuncionario = 'SELECT p.id_pessoa FROM pessoa p JOIN funcionario f ON(p.id_pessoa=f.id_pessoa) WHERE p.cpf=:doc';
   $stmt = $pdo->prepare($sqlPesquisaFuncionario);
   $stmt->bindParam(':doc', $doc);
   $stmt->execute();
   $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

   if($resultado && !empty($resultado)){
      $idPessoa = $resultado['id_pessoa'];
      if($idPessoa && $idPessoa > 0){
         session_start();
         $idPessoaLogada = $_SESSION['id_pessoa'];
         if($idPessoaLogada != $idPessoa){
            echo json_encode(['Erro' => 'Você não possuí as permissões necessárias']);
            exit();
         }
      }
   }

}catch(PDOException $e){
   echo 'Erro ao consultar banco de dados: '.$e->getMessage();
}


try {//Try catch para editar sócio

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

   $sqlAlterarPessoa = "UPDATE pessoa as p JOIN socio as s ON(p.id_pessoa = s.id_pessoa) SET nome = :nome, telefone=:tel, data_nascimento =:dataN, cep =:cep, logradouro =:rua, numero_endereco =:numero, complemento =:compl, bairro =:bairro, cidade =:cidade, estado=:uf, email =:email WHERE cpf =:doc";

   $stmt4 = $pdo->prepare($sqlAlterarPessoa);
   $stmt4->bindParam(':nome', $nome);
   $stmt4->bindParam(':tel', $tel);
   $stmt4->bindParam(':nome', $nome);
   $stmt4->bindParam(':dataN', $dataN);
   $stmt4->bindParam(':cep', $cep);
   $stmt4->bindParam(':rua', $rua);
   $stmt4->bindParam(':numero', $numero);
   $stmt4->bindParam(':compl', $compl);
   $stmt4->bindParam(':bairro', $bairro);
   $stmt4->bindParam(':cidade', $cidade);
   $stmt4->bindParam(':uf', $uf);
   $stmt4->bindParam(':email', $email);
   $stmt4->bindParam(':doc', $doc);

   if($stmt4->execute()){
      echo json_encode(['Sucesso' => 'Alteração concluída com sucesso']);
   }else{
      echo json_encode(['Erro' => 'Falha na Alteração do sócio']);
   }
   
} catch (PDOException $e) {
   echo json_encode(['ErroBD' => 'Falha na Alteração do sócio: '.$e->getMessage()]);
}
