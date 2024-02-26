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

    var_dump($_POST);
    extract($_POST);
    $arquivo = $_FILES["arquivo"];
    $arquivo_nome = $arquivo["name"];
    $extensao_nome = explode(".", $arquivo["name"])[1];
    $arquivo_b64 = base64_encode(file_get_contents($arquivo['tmp_name']));	 
    
    try {
        $pdo = Conexao::connect();
        $prep = $pdo->prepare("INSERT INTO saude_exames(id_fichamedica, id_exame_tipos, data, arquivo_nome, arquivo_extensao,arquivo) VALUES ( :id_fichamedica, :id_exame_tipos, :data, :arquivo_nome , :arquivo_extensao, :arquivo )");

        $prep->bindValue(":id_fichamedica", $id_fichamedica);
        $prep->bindValue(":id_exame_tipos", $id_docfuncional);
        $prep->bindValue(":arquivo_nome", $arquivo_nome);
        $prep->bindValue(":arquivo_extensao", $extensao_nome);
        $prep->bindValue(":arquivo", gzcompress($arquivo_b64));

        $dataExame = date('Y/m/d');
        $prep->bindValue(":data", $dataExame);

        $prep->execute();
        
        header("Location: profile_paciente.php?id_fichamedica=$id_fichamedica");
    } catch (PDOException $e) {
        echo("Houve um erro ao realizar o upload do exame:<br><br>$e");
    }


}else {
    header("Location: profile_paciente.php");
}


