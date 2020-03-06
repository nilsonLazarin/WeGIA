<?php
    include("conexao.php");
    $remetente=$_POST["remetente"];
    $destinatario=$_POST["destinatario"];
    $despacho=$_POST["despacho"];
    $id_memorando=$_GET["id"];
    date_default_timezone_set('America/Sao_Paulo');
    $data_criacao3=date('Y-m-d H:i:s');
    $comando="insert into despacho(id_memorando, id_remetente, id_destinatario, texto, data) values('$id_memorando', '$remetente', '$destinatario', '$despacho', '$data_criacao3')";
    $query=mysqli_query($conexao, $comando);
    $linhas=mysqli_affected_rows($conexao);
    if($linhas==1)
    {
        header("Location: envio.php");
    }
?>
