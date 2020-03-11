<!DOCTYPE html>
<html>

    <head>
        <title>Memorando</title>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    </head>

    <body>
        <?php
            session_start();
            if(!isset($_SESSION['usuario'])){
            header ("Location: ../index.php");
            }
            include ("conexao.php");
            $cpf_remetente=$_SESSION['usuario'];
            $comando5="select id_pessoa from pessoa where cpf='$cpf_remetente'";
            $query5=mysqli_query($conexao, $comando5);
            $linhas5=mysqli_num_rows($query5);
            for($i=0; $i<$linhas5; $i++)
            {
                $consulta5=mysqli_fetch_row($query5);
                $remetente=$consulta5[0];
            }
        ?>
        <form action="#" method="post">
        <?php
            $comando1="select * from despacho where id_destinatario='$remetente'";
            $query1=mysqli_query($conexao, $comando1);
            $linhas1=mysqli_num_rows($query1);
            for($i=0; $i<$linhas1; $i++)
            {
                $consulta1=mysqli_fetch_row($query1);
                
            }
            echo "<table border='1'>";
            echo "<tr><td><input type='text' id='assunto' name='assunto' required placeholder='Assunto'></td>";
            echo "<td><input type='submit' value='Criar memorando' name='enviar' id='enviar'></td></tr>";
            echo "<span id='mostra_assunto'></span>";
            echo "</form>";
            $comando5="select id_memorando, id_destinatario from despacho where (despacho.id_despacho in (select max(id_despacho) from despacho group by id_memorando))";
            $query5=mysqli_query($conexao, $comando5);
            $linhas5=mysqli_num_rows($query5);
            for($i=0; $i<$linhas5; $i++)
            {
                $consulta5=mysqli_fetch_row($query5);
                $id_mem=$consulta5[0];
                
            }
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
                echo "<td value=".$id_des."><a href=listaM.php?desp=".$id_des.">".$titulo_des."</a></td>";
                echo "<td>$data_des</td>";
                echo "</tr>";
            }
            echo "</table>";
                if(isset($_POST["enviar"]))
                {
                    $assunto=$_POST["assunto"];
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
                        for($i=0; $i<$linhas3; $i++)
                        {
                            $consulta3=mysqli_fetch_row($query3);
                            $id=$consulta3[0];
                        } 
                        ?>
                        <form action="inseredespacho.php?id=<?php echo ($id);?>" method="post">
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