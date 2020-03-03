<!DOCTYPE html>
<html>
    <head>
        <title>Memorando</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <form action="inserememorando.php" method="post">
        <label for="assunto">Assunto </label>
        <input type="text" id="assunto" name="assunto" required placeholder="Assunto">
        <label for="remetente">De </label>
        <select id="remetente" required>
            <?php
            include ("conexao.php");
            $comando="select pessoa.nome, funcionario.id_funcionario from funcionario join pessoa where funcionario.id_funcionario=pessoa.id_pessoa";
            $query=mysqli_query($conexao, $comando);
            $linhas=mysqli_num_rows($query);
            for($i=0; $i<$linhas; $i++)
            {
                $consulta = mysqli_fetch_row($query);
                $nome=$consulta[0];
                $id=$consulta[1];
                echo "<option id='$id' name='$id'>$nome</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Criar memorando"><br>
    </form>












    
        <label for="destinatario">Para </label>
        <select id="destinatario" required>
            <?php
            include ("conexao.php");
            $comando="select pessoa.nome, funcionario.id_funcionario from funcionario join pessoa where funcionario.id_funcionario=pessoa.id_pessoa";
            $query=mysqli_query($conexao, $comando);
            $linhas=mysqli_num_rows($query);
            for($i=0; $i<$linhas; $i++)
            {
                $consulta = mysqli_fetch_row($query);
                $nome=$consulta[0];
                $id=$consulta[1];
                echo "<option id='$id' name='$id'>$nome</option>";
            }
            ?>
        </select><br>
        <label for="mensagem">Mensagem </label>
        <input type="text" id="mensagem" name="mensagem" required placeholder="Mensagem"><br>
        <input type="submit"> 
        </form>
    </body>
</html>