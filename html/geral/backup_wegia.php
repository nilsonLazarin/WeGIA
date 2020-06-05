<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("Locatiion ../../index.php");
    }
    require_once("../../config.php");
    exec("tar -cvzf ".BKP_DIR.date("Ymd").".site.tar.gz ".caminho);
    echo("Backup Concluido");
?>