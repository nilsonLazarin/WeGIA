<?php
 session_start();
 if(!isset($_SESSION['usuario'])){
    header ("Location: ../index.php");
 }
 include ("conexao.php");
echo "<table border='1'>";
echo "<tr>";
echo "<td colspan=2>Memorandos despachados</td>";
echo "</tr>";
$cpf_remetente=$_SESSION['usuario'];
            $comando5="select id_pessoa from pessoa where cpf='$cpf_remetente'";
            $query5=mysqli_query($conexao, $comando5);
            $linhas5=mysqli_num_rows($query5);
            for($i=0; $i<$linhas5; $i++)
            {
                $consulta5=mysqli_fetch_row($query5);
                $remetente=$consulta5[0];
            }
$comando="SELECT distinct memorando.id_memorando, memorando.titulo from memorando join despacho on(despacho.id_memorando=memorando.id_memorando) where despacho.id_destinatario=$remetente";
$query=mysqli_query($conexao, $comando);
$linhas=mysqli_num_rows($query);
            for($i=0; $i<$linhas; $i++)
            {
                $consulta=mysqli_fetch_row($query);
                $id_mem=$consulta[0];
                $titulo_des=$consulta[1];
                echo "<tr>";
                echo "<td value=".$id_mem."><a href=listaM.php?desp=".$id_mem."&arq=1>".$titulo_des."</a></td>";
                echo "</tr>";
            }
            echo "</table>";
?>