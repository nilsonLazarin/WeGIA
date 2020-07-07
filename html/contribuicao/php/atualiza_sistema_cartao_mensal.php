<?php

    include("conexao.php");

    $SISTEMA = $_POST['id_teste'];

    $QUERY_M = mysqli_query($conexao, "SELECT valor, link FROM doacao_cartao_mensal WHERE id_sistema = $SISTEMA");
    $QTD = mysqli_num_rows($QUERY_M);
    if($QTD > 0)
    {
        echo ("<input type='hidden' name='cod_cartao' value=".$SISTEMA.">");
        echo("<table border='1px'>
                <h3>DOAÇÃO MENSAL</h3>
                <tr>
                <th>VALOR</th>
                <th>LINK</th>
                </tr>");
            for($i = 0; $i < $QTD; $i++)
            {
                $RESULTADO = mysqli_fetch_row($QUERY_M);
                $valor = $RESULTADO[0];
                $url = $RESULTADO[1];
                echo"<tr>";
                echo("<td><input type='number' name='valor".$i."' value=".$valor."></td>");
                echo("<td><input type='text' name='link".$i."' value=".$url."></td>");
                echo"</tr> ";
               
            }
        echo"</table>";
    }/*else
    {
        echo ("<input type='hidden' name='cod_cartao' value=".$SISTEMA.">");
        echo("<table border='1px'>
                <h3>DOAÇÃO MENSAL</h3>
                <tr>
                <th>VALOR</th>
                <th>LINK</th>
                </tr>"); 
        echo"<tr>";
        echo("<td><input type='number' name='valor' value='0'></td>");
        echo("<td><input type='text' name='link' value='nenhum valor inserido'></td>");
        echo"</tr> ";
        echo"</table>";
    }*/
   
?>