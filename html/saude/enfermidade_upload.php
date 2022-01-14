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

    // $id_CID = $_POST["id_CID"];
    // var_dump($_POST);
    // extract($_POST);
    // $arquivo = $_FILES["arquivo"];
    // $arquivo_nome = $arquivo["name"];
    // $extensao_nome = explode(".", $arquivo["name"])[1];
    // $arquivo_b64 = base64_encode(file_get_contents($arquivo['tmp_name']));	 
    
    try {
        $pdo = Conexao::connect();
        $prep = $pdo->prepare("INSERT INTO saude_enfermidades(id_fichamedica, id_CID, data_diagnostico, status) VALUES (:id_fichamedica, :id_CID, :data_diagnostico, :status)");

        $prep->bindValue(":id_fichamedica", $id_fichamedica);
        $prep->bindValue(":id_CID", $id_CID);
        $prep->bindValue(":data_diagnostico", $data_diagnostico);
        $prep->bindValue(":status", $intStatus);

        $prep->execute();
        
        header("Location: profile_paciente.php?id_fichamedica=$id_fichamedica");
    } catch (PDOException $e) {
        echo("Houve um erro ao realizar o cadastro da enfermidade:<br><br>$e");
    }


}else {
    header("Location: profile_paciente.php");
}


