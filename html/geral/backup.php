<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("Locatiion ../../index.php");
    }
    require_once("../../config.php");
    
    /*Executando Backup do Banco de Dados*/
    exec("mysqldump -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." > ".BKP_DIR.date("YmdHi").".bd.sql", $output[0]);
    /*Executando Backup do Diretório do site*/
    exec("tar -cvzf ".BKP_DIR.date("YmdHi").".site.tar.gz ".caminho);
    
    /*
    echo("<pre>");
    var_dump($output);
    echo("Iniciando Backup");
    header("Location: backup_wegia.php");
    */
    echo "Backup realizado com sucesso";
?>
