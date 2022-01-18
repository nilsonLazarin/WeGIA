<pre>
<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

session_start();
extract($_REQUEST);
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

if ($_POST){
    require_once "../../dao/Conexao.php";	 
    
    try {
        $pdo = Conexao::connect();
        $prep = $pdo->prepare("INSERT INTO saude_atendimento(id_fichamedica, id_funcionario, data_atendimento, descricao) VALUES (:id_fichamedica, :id_funcionario, :data_atendimento, :descricao)");

        $prep->bindValue(":id_fichamedica", $id_fichamedica);
        $prep->bindValue(":id_funcionario", $id_funcionario);
        $prep->bindValue(":data_atendimento", $data_atendimento);
        $prep->bindValue(":descricao", $texto);

        $prep->execute();
        
        header("Location: profile_paciente.php?id_fichamedica=$id_fichamedica");
    } catch (PDOException $e) {
        echo("Houve um erro ao realizar o cadastro da enfermidade:<br><br>$e");
    }


}else {
    header("Location: profile_paciente.php");
}


