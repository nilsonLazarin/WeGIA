<?php

    include_once"conexao.php";
   
    //$SISTEMA = $_POST['id_sistema'];
    $SISTEMA=3;
    $sql = $Conn->query("SELECT * FROM doacao_boleto_regras as regras JOIN doacao_boleto_info as info ON (info.id_regras = regras.id) WHERE info.id_sistema = '$SISTEMA'");
    $stmt = $Conn->prepare("SELECT * FROM doacao_boleto_regras as regras JOIN doacao_boleto_info as info ON (info.id_regras = regras.id) WHERE info.id_sistema=$SISTEMA");
        $stmt->execute();
        $stmt->bindValue(":id_sistema",$SISTEMA);
         while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
            print_r($linha);
         }
        //var_dump($stmt);
        
?>