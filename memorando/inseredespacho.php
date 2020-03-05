<?php
    include("conexao.php");
    $remetente=$_POST["remetente"];
    $destinatario=$_POST["destinatario"];
    $despacho=$_POST["despacho"];
    $id_memorando=$_GET["id"];

    $comando="insert into despacho(id_memorando, id_remetente, id_destinatario, texto) values('$id_memorando', '$remetente', '$destinatario', '$despacho')";
    $query=mysqli_query($conexao, $comando);
    $linhas=mysqli_affected_rows($conexao);
    if($linhas==1)
    {
        echo "Despacho enviado";
    }
?>
