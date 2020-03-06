<?php
include("conexao.php");
$id_memorando=$_GET["desp"];
echo "<table border='1'>";
$comando="select pessoa.nome, despacho.texto, despacho.id_remetente, despacho.data from despacho join pessoa where id_memorando=".$id_memorando." and despacho.id_remetente=pessoa.id_pessoa";
$query=mysqli_query($conexao, $comando);
$linhas=mysqli_num_rows($query);
for($i=0; $i<$linhas; $i++)
{
    echo "<tr>";
    $consulta=mysqli_fetch_row($query);
    $mensagem=$consulta[0];
    $reme=$consulta[1];
    $data=$consulta[2];
    echo "<td>".$reme."</td>";
    echo "<td>".$mensagem."</td>";
    echo "<td>".$data."</td>";
    echo "</tr>";
}
echo "</table>";
?>