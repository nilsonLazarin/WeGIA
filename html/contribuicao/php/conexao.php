<?php

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
}echo"conectado";


?>
