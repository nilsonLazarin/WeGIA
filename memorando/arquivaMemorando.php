<?php
    include("conexao.php");
    $desp=$_GET["desp"];
    $comando="update memorando set id_status_memorando='8' where id_memorando=$desp";
    $query=mysqli_query($conexao, $comando);
    $linhas=mysqli_affected_rows($conexao);
    if($linhas==1)
    {
        header("Location: envio.php");
    }
    else
    {
        echo "Não foi possível arquivar o despacho";
    }
?>