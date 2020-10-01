<?php

/*$config_path = "config.php";
if(file_exists($config_path))
{
   require_once($config_path);
}else{
   while(true){
      $config_path = "../".$config_path;
      if(file_exists($config_path)) break;
   }
   require_once($config_path);
}

   try {
      $Conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $Conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }*/


$config_path = "config.php";
if(file_exists($config_path))
{
   require_once($config_path);
}else{
   while(true){
      $config_path = "../".$config_path;
      if(file_exists($config_path)) break;
   }
   require_once($config_path);
}

$conexao = new MySQLi(DB_HOST,DB_USER, DB_PASSWORD,DB_NAME); 
if($conexao->connect_error){
   echo "Desconectado! Erro: " . $conexao->connect_error;
}
      
   




