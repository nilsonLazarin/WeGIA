<?php
    session_start();
    if(!isset($_SESSION['usuario'])){
    header ("Location: ../index.php");
    }
    include("conexao.php");
    $cpf_remetente=$_SESSION['usuario'];
    $comando5="select id_pessoa from pessoa where cpf='$cpf_remetente'";
    $query5=mysqli_query($conexao, $comando5);
    $linhas5=mysqli_num_rows($query5);
    for($i=0; $i<$linhas5; $i++)
    {
        $consulta5=mysqli_fetch_row($query5);
        $remetente=$consulta5[0];
    }
    $destinatario=$_POST["destinatario"];
    $despacho=$_POST["despacho"];
    $id_memorando=$_GET["id"];
    $image = file_get_contents ($_FILES['arquivo']['tmp_name']);
    $image64 = base64_encode($image);
    date_default_timezone_set('America/Sao_Paulo');
    $data_criacao3=date('Y-m-d H:i:s');
    $comando="insert into despacho(id_memorando, id_remetente, id_destinatario, texto, data, id_status_despacho, arquivo) values('$id_memorando', '$remetente', '$destinatario', '$despacho', '$data_criacao3', '0', '$image64')";
    $query=mysqli_query($conexao, $comando);
    $linhas=mysqli_affected_rows($conexao);
    if($linhas==1)
    {
        header("Location: ../html/listar_memorandos_ativos.php");
    }
?>
