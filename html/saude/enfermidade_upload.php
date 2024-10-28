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
        $prep = $pdo->prepare("INSERT INTO saude_enfermidades(id_fichamedica, id_CID, data_diagnostico, status) VALUES (:id_fichamedica, :id_CID, :data_diagnostico, :status)");

        $prep->bindValue(":id_fichamedica", $id_fichamedica);
        $prep->bindValue(":id_CID", $id_CID);
        $prep->bindValue(":data_diagnostico", $data_diagnostico);
        $prep->bindValue(":status", $intStatus);

        $prep->execute();
        
        header("Location: profile_paciente.php?id_fichamedica=$id_fichamedica");
    } catch (PDOException $e) {
        // Exibe mensagem de erro de forma segura
        echo "Houve um erro ao realizar o cadastro da enfermidade:<br><br>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }


}else {
    header("Location: profile_paciente.php");
}


