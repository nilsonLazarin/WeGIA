<?php
include("conexao.php");
$id_memorando=$_GET["desp"];
$arquivado=$_GET["arq"];
echo "<table border='1'>";
$comando="select pessoa.nome, despacho.texto, despacho.id_remetente, despacho.data from despacho join pessoa where id_memorando=".$id_memorando." and despacho.id_remetente=pessoa.id_pessoa order by despacho.data desc";
$query=mysqli_query($conexao, $comando);
$linhas=mysqli_num_rows($query);
for($i=0; $i<$linhas; $i++)
{
    echo "<tr>";
    $consulta=mysqli_fetch_row($query);
    $reme=$consulta[0];
    $mensagem=$consulta[1];
    $data=$consulta[3];
    echo "<td>".$reme."</td>";
    echo "<td>".$mensagem."</td>";
    echo "<td>".$data."</td>";
    echo "</tr>";
}
echo "</table>";
if($arquivado!=1)
{
echo "<form action=inseredespacho.php?id=".$id_memorando." method=post>";
echo "<label for=destinatario id=etiqueta_destinatario>Para </label>";
echo "<select id=destinatario name=destinatario id=destinatario required>";
$comando="select pessoa.nome, funcionario.id_funcionario from funcionario join pessoa where funcionario.id_funcionario=pessoa.id_pessoa";
$query=mysqli_query($conexao, $comando);
$linhas=mysqli_num_rows($query);
for($i=0; $i<$linhas; $i++)
{
$consulta = mysqli_fetch_row($query);
$nome=$consulta[0];
$id=$consulta[1];
echo "<option id='$id' value='$id' name='$id'>$nome</option>";
}
echo "</select>";
echo "<tr><td><input type='text' id='despacho' name='despacho' required placeholder='Mensagem'></td>";
echo "<td><input type='submit' value='Novo despacho' name='enviar' id='enviar'></td></tr>";
echo "<span id='mostra_assunto'></span>";
echo "</form>";
}
?>