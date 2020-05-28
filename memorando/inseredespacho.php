<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
    
session_start();
if(!isset($_SESSION['usuario'])){
    header ("Location: ../index.php");
}

include("conexao.php");
    $cpf_remetente=$_SESSION['usuario'];
    $comando5="select id_pessoa, nome from pessoa where cpf='$cpf_remetente'";
    $query5=mysqli_query($conexao, $comando5);
    $linhas5=mysqli_num_rows($query5);
    for($i=0; $i<$linhas5; $i++)
    {
        $consulta5=mysqli_fetch_row($query5);
        $remetente=$consulta5[0];
        $nome=$consulta5[1];
    }
    $destinatario=$_POST["destinatario"];
    $despacho=$_POST["despacho"];
    $id_memorando=$_GET["id"];
    $ponto=".";
    date_default_timezone_set('America/Sao_Paulo');
    $data_criacao3=date('Y-m-d H:i:s');
    $comando="insert into despacho(id_memorando, id_remetente, id_destinatario, texto, data, id_status_despacho) values('$id_memorando', '$remetente', '$destinatario', '$despacho', '$data_criacao3', '0')";
    $query=mysqli_query($conexao, $comando);
    $linhas=mysqli_affected_rows($conexao);
    //echo $despacho;
    //$result1=mysqli_query($conexao, "CALL insdespacho('$id_memorando', '$remetente', '$destinatario', '0', '$despacho', '$data_criacao3');") or die("Erro na query da procedure: " . mysqli_error());
    //$linhas1=mysqli_affected_rows($conexao);

    $id_despacho=mysqli_insert_id ($conexao);
    $comando2="select id_status_memorando from memorando where id_memorando='$id_memorando'";
    $query2=mysqli_query($conexao, $comando2);
    $consulta2=mysqli_fetch_row($query2);

    if($destinatario==$remetente && $consulta2[0]==7)
    {
        $comando1="update memorando set id_status_memorando='6' where id_memorando='$id_memorando'";
        $query1=mysqli_query($conexao, $comando1);
    }
    if($destinatario!=$remetente)
    {
        $comando1="update memorando set id_status_memorando='7' where id_memorando='$id_memorando'";
        $query1=mysqli_query($conexao, $comando1);
    }

    if(isset($arquivos['name'][0]) && !empty($arquivos['name'][0]))
    {
        $arquivos = $_FILES['arquivo'];
        $total = count($arquivos['name']);
        for($i=0; $i<$total; $i++)
        {
        $arquivo=file_get_contents($arquivos['tmp_name'][$i]);
        $arquivo1=$arquivos['name'][$i];
        $arquivo64=base64_encode($arquivo);
        $tamanho=strlen($arquivo1);
        $pos = strpos ($arquivo1 , $ponto)+1;
        $ext=substr($arquivo1, $pos, strlen($arquivo1)+1);
        $nome=substr($arquivo1, 0, $pos-1);
        //$comando1="insert into anexo(id_despacho, anexo, extensao, nome) values('$id_despacho', '$arquivo64', '$ext', '$nome')";
        //$query1=mysqli_query($conexao, $comando1);
        $result = mysqli_query($conexao, "CALL insanexo('$id_despacho', '$arquivo64', '$ext', '$nome');") or die("Erro na query da procedure: " . mysqli_error());
        $linhas1=mysqli_affected_rows($conexao);
        }
    }
    if($linhas==1)
    {
        header("Location: ../html/listar_memorandos_ativos.php");
    }
?>