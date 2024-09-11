<pre>
<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

session_start();
$id_CID_alergia = $_POST["id_CID_alergia"];
$id_fichamedica = $_POST["id_fichamedica"];
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

if ($_POST){
    require_once "../../dao/Conexao.php";	 
    
    try {
        $pdo = Conexao::connect();
        $prep = $pdo->prepare("INSERT INTO saude_enfermidades(id_fichamedica, id_CID, data_diagnostico, status) VALUES (:id_fichamedica, :id_CID_alergia, :data_diagnostico, :status)");

        $prep->bindValue(":id_fichamedica", $id_fichamedica);
        $prep->bindValue(":id_CID_alergia", $id_CID_alergia);
        $prep->bindValue(":data_diagnostico", "0001-01-01");
        $prep->bindValue(":status", "1");

        $prep->execute();
    } catch (PDOException $e) {
        echo("Houve um erro ao realizar o cadastro da enfermidade:<br><br>$e");
    }


}else {
    header("Location: profile_paciente.php");
}


