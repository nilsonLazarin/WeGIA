<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("Locatiion ../../index.php");
    }
    require_once("../../config.php");
    
    exec("mysqldump -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." > ".BKP_DIR.date("Ymd").".bd.sql", $output[0]);
    
    exec("tar -cvzf ".BKP_DIR.date("Ymd").".site.tar.gz ".caminho);
    
    echo("<pre>");
    var_dump($output);
    echo("Iniciando Backup");
    header("Location: backup_wegia.php");
?>
