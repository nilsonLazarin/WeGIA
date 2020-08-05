<?php
session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../index.php");
}
require_once "../dao/Conexao.php";
$pdo = Conexao::connect();

$msg='';
$success = true;

if (isset($_POST["imagem_0"])){
    for ($i = 0; isset($_POST["imagem_$i"]); $i++){
        $id_img = $_POST["imagem_$i"];
        echo("delete from imagem where id_imagem=$id_img;<br>");

        $res = $pdo->prepare("select i.nome from tabela_imagem_campo ic inner join imagem i on ic.id_imagem = i.id_imagem where ic.id_imagem=:id;");
        $res->bindValue(":id",$id_img);
        $res->execute();
        $campo = $res->fetchAll(PDO::FETCH_ASSOC);

        var_dump($campo);
        var_dump(sizeof($campo));

        if (sizeof($campo) == 0){
            $cmd = $pdo->prepare("delete from imagem where id_imagem=:id;");
            $cmd->bindValue(":id",$id_img);
            $cmd->execute();
        }else{
            $nome_img = $campo[0]["nome"];
            $msg .= "Aviso: A imagem '$nome_img' está vinculada a um campo e não pode ser excluida<br>";
            $success = false;
        }
    }
    if ($success){
        $header = "Location: personalizacao_imagem.php?msg=success";
    }else{
        $header = "Location: personalizacao_imagem.php?msg=warn&err=$msg";
    }
}

header ($header);

?>