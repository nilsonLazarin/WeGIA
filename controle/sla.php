<?php 

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
extract($_REQUEST);
session_start();

   	
   	if(!isset($_SESSION['usuario'])){
   		header ("Location: ../../index.php");
   	}
      $config_path = "config.php";
      if(file_exists($config_path)){
         require_once($config_path);
      }else{
         while(true){
            $config_path = "../" . $config_path;
            if(file_exists($config_path)) break;
         }
         require_once($config_path);
      }
      $conexao = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $id_pessoa = $_SESSION['id_pessoa'];
      $resultado = mysqli_query($conexao, "SELECT * FROM funcionario WHERE id_pessoa=$id_pessoa");
      if(!is_null($resultado)){
         $id_cargo = mysqli_fetch_array($resultado);
         if(!is_null($id_cargo)){
            $id_cargo = $id_cargo['id_cargo'];
         }
         $resultado = mysqli_query($conexao, "SELECT * FROM permissao WHERE id_cargo=$id_cargo and id_recurso=12");
         if(!is_bool($resultado) and mysqli_num_rows($resultado)){
            $permissao = mysqli_fetch_array($resultado);
            if($permissao['id_acao'] < 7){
           $msg = "Você não tem as permissões necessárias para essa página.";
           header("Location: ../../home.php?msg_c=$msg");
            }
            $permissao = $permissao['id_acao'];
         }else{
              $permissao = 1;
             $msg = "Você não tem as permissões necessárias para essa página.";
             header("Location: ../../home.php?msg_c=$msg");
         }	
      }else{
         $permissao = 1;
       $msg = "Você não tem as permissões necessárias para essa página.";
       header("Location: ./home.php?msg_c=$msg");
      }	
   

   include_once '../../classes/Cache.php';    
	// Adiciona a Função display_campo($nome_campo, $tipo_campo)
  require_once "../personalizacao_display.php";
  
  require_once ROOT."/controle/FuncionarioControle.php";
  $cpf = new FuncionarioControle;
  $cpf->listarCPF();

  require_once ROOT."/controle/AtendidoControle.php";
  $cpf1 = new AtendidoControle;
  $cpf1->listarCPF();

  require_once ROOT."/controle/EnderecoControle.php";
  $endereco = new EnderecoControle;
  $endereco->listarInstituicao();
   
   $id=$_GET['id'];
   $cache = new Cache();
   $teste = $cache->read($id);
   
   if (!isset($teste)) {
   		
   		header('Location: ../controle/control.php?metodo=listarUm&nomeClasse=AtendidoControle&nextPage=../html/atendido/Profile_Atendido.php?idatendido='.$id.'&id='.$id);
      }
   
?>