<!DOCTYPE html>
<html>

    <head>
        <title>Memorando</title>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>

    <body>
        <?php
            include ("conexao.php");
        ?>
        <form action="#" method="post">
            <label for="remetente" id="etiqueta_remetente">De </label>
            <select id="remetente" name="remetente" id="remetente" required>
            <?php
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
            ?>
        </select>
        <label for="assunto" id="etiqueta_assunto">Assunto </label>
        <input type="text" id="assunto" name="assunto" required placeholder="Assunto">
        <span id="mostra_assunto"></span>
        <input type="submit" value="Criar memorando" name="enviar" id="enviar"><br>
        </form>
        <?php
            echo "<table border='1'>";
            $comando4="select titulo, id_memorando, data from memorando";
            $query4=mysqli_query($conexao, $comando4);
            $linhas4=mysqli_num_rows($query4);
            for($i=0; $i<$linhas4; $i++)
            {
                $consulta4=mysqli_fetch_row($query4);
                $titulo_des=$consulta4[0];
                $id_des=$consulta4[1];
                $data_des=$consulta4[2];
                echo "<tr>";
                echo "<td>$data_des</td>";
                echo "<td value=".$id_des."><a href=listaM.php?desp=".$id_des.">".$titulo_des."</a></td>";
                echo "</tr>";
            }
            echo "</table>";
                if(isset($_POST["enviar"]))
                {
                    $assunto=$_POST["assunto"];
                    $remetente=$_POST["remetente"];
                    date_default_timezone_set('America/Sao_Paulo');
                    $data_criacao3=date('Y-m-d H:i:s');
                    $comando2="insert into memorando(id_pessoa, id_status_memorando, titulo, data) values('$remetente', '1', '$assunto', '$data_criacao3')";
                    $query2=mysqli_query($conexao, $comando2);
                    $linhas2=mysqli_affected_rows($conexao);
                    echo "<input type=hidden value='$assunto' id=titulo>";
                    if($linhas2==1)
                    {
            ?>
                        <script>
                            $("#remetente").hide();
                            $("#etiqueta_remetente").hide();
                            $("#etiqueta_assunto").hide();
                            $("#assunto").hide();
                            $("#enviar").hide();
                            var assunto_memorando=$("#titulo").val();
                            $("#mostra_assunto").html(assunto_memorando);
                            $("table").hide();
                        </script>
                        <?php 
                        $comando3="select id_memorando from memorando where titulo='$assunto'";
                        $query3=mysqli_query($conexao, $comando3);
                        $linhas3=mysqli_num_rows($query3);
                        for($i=0; $i<$linhas; $i++)
                        {
                            $consulta3=mysqli_fetch_row($query3);
                            $id=$consulta3[0];
                        } 
                        ?>
                        <form action="inseredespacho.php?id=<?php echo ($id);?>" method="post">
                        <label for="remetente" id="etiqueta_remetente">De </label>
                        <select id="remetente" name="remetente" id="remetente" required>
                        <?php
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
                        ?>  
                        </select>
                        <label for="destinatario" id="etiqueta_destinatario">Para </label>
                        <select id="destinatario" name="destinatario" id="destinatario" required>
                        <?php
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
                        ?>
                        </select>
                        <br><label for=despacho>Mensagem </label><input type=text id=despacho name="despacho" required placeholder=Mensagem>
                        <input type="submit" value="Criar despacho"> 
                        <?php                           
                    }
                }
                ?>
    </form>
    </body>
</html>