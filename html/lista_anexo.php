<?php

include "../memorando/conexao.php";

$despacho=$_GET["despacho"];
$memorando=$_GET["memorando"];

$comando="select anexo, extensao, nome from anexo where id_despacho='".$despacho."'";
$query=mysqli_query($conexao, $comando);
$linhas=mysqli_num_rows($query);

$anexos=array();

for($i=0; $i<$linhas; $i++)
{
	$consulta=mysqli_fetch_row($query);
	$imgBase64="data:image/".$consulta[1].";base64,".$consulta[0];
	$num=$i+1;
	$anexos[$i]=array('link'=>$imgBase64, 'nome'=>$consulta[2], 'extensao'=>$consulta[1]);
}

$anexo=json_encode($anexos);
session_start();
$_SESSION["anexos"]=$anexo;

if(isset($_GET["arq"]))
{
	header("Location: ../html/listar_despachos.php?desp=".$memorando."&arq=1");
}
else
{
header("Location: ../html/teste.php?desp=".$memorando);
}
?>