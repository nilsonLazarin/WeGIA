<?php
require_once "./controleSaudePet.php";

$post = json_decode(file_get_contents("php://input"));

foreach( $post as $valor){
    $dado = $valor;
}

$c = new controleSaudePet();
$dado = $c->getPet($dado);

echo json_encode($dado);