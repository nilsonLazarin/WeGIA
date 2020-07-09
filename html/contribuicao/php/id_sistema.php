<?php

include("conexao.php");

$nome_sistema = $_POST['nome_sistema'];

$SELECT = mysqli_query($conexao, "SELECT id FROM sistema_pagamento WHERE nome_sistema = '$nome_sistema'");
$FETCH = mysqli_fetch_row($SELECT);
$id = $FETCH[0];

echo $id;

?>