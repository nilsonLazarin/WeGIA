<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

require_once "../../dao/Conexao.php";
require_once "exame.php";

$conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$id_pessoa = isset($_SESSION['id_pessoa']) ? $_SESSION['id_pessoa'] : null;
try {
    $stmt = $conexao->prepare("SELECT * FROM funcionario WHERE id_pessoa=?");
    
    if (!$stmt) {
    throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }
    $stmt->bind_param("i", $id_pessoa);
    $stmt->execute();
  
    $resultado = $stmt->get_result();
    
    // Aqui você pode processar os resultados como necessário
    
    $stmt->close();
  } catch (PDOException $e) {
    echo "Ocorreu um erro: " . $e->getMessage();
  }

if(!is_null($resultado)){
    $id_cargo = mysqli_fetch_array($resultado);
    if(!is_null($id_cargo)){
    $id_cargo = $id_cargo['id_cargo'];
    }
    
    try {
        $stmt = $conexao->prepare("SELECT * FROM permissao WHERE id_cargo = ? and id_recurso=5");
        
        if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
        }
        $stmt->bind_param("i", $id_cargo);
        $stmt->execute();
      
        $resultado = $stmt->get_result();
        
        // Aqui você pode processar os resultados como necessário
        
        $stmt->close();
      } catch (PDOException $e) {
        echo "Ocorreu um erro: " . $e->getMessage();
      }
    
    if(!is_bool($resultado)){
        $permissao = mysqli_fetch_array($resultado);
        if($permissao['id_acao'] < 7){
            $msg = "Você não tem as permissões necessárias para essa página.";
            header("Location: ../home.php?msg_c=$msg");
        }
        $permissao = $permissao['id_acao'];
        }else{
            $permissao = 1;
            $msg = "Você não tem as permissões necessárias para essa página.";
            header("Location: ../home.php?msg_c=$msg");
        }	
    }else{
        $permissao = 1;
        $msg = "Você não tem as permissões necessárias para essa página.";
        header("Location: ../home.php?msg_c=$msg");
    }	



define("TYPEOF_EXTENSION", [
    'jpg' => 'image/jpg',
    'png' => 'image/png',
    'jpeg' => 'image/jpeg',
    'pdf' => 'application/pdf',
    'docx' => 'application/docx',
    'doc' => 'application/doc',
    'odp' => 'application/odp',
]);

$arquivo = new ExameSaude($_GET["id_doc"]);

if (!$arquivo->getException()){
    header("Content-type: ".TYPEOF_EXTENSION[$arquivo->getExtensao()]);
    header("Content-Disposition: attachment; filename=".$arquivo->getNome());
    ob_clean();
    flush();
    
    echo $arquivo->getDocumento();
}else{
    echo $arquivo->getException();
}

die();
