<?php
    include("conexao.php");
    $assunto=$_POST["assunto"];
    $remetente=$_POST["remetente"];
    $data_atual=
    $comando="insert into memorando(id_memorando, id_pessoa, id_status_memorando, titulo, data) values ($remetente, 1, $assunto)"
?>
