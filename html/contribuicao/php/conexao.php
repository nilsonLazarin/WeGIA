<?php
$servidor = "localhost";
$usuario = "root";
$senha='root';
$banco ="wegia"; 


$conexao = new MySQLi($servidor, $usuario, $senha, $banco);
if($conexao->connect_error){
   echo "Desconectado! Erro: " . $conexao->connect_error;
}


?>
