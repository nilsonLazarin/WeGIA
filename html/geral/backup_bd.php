<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("Locatiion ../../index.php");
    }
    require_once("../../config.php");
    echo "iniciando backup banco de dados";

    exec("mysqldump -u root  wegia -p".DB_PASSWORD." > ".BKP_DIR.date("Ymd").".bd.sql", $output[0]);

    echo("<pre>");
    var_dump($output);
    echo("Iniciando Backup");
    header("Location: backup_wegia.php");
?>
