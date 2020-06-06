<?php
    session_start();
    if (!isset($_SESSION["usuario"])) {
        header("Locatiion ../../index.php");
    }

    /*Buscando arquivo de configuração.. */
    $config_path = "config.php";
    if(file_exists($config_path)){
        require_once($config_path);
    }
    else{
        while(true){
            $config_path = "../" . $config_path;
            if(file_exists($config_path)) break;
        }
    require_once($config_path);
    }


    /*require_once("../../config.php");*/
    
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
