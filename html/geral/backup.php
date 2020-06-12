<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
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
  /*  
  exec("mysqldump -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." --no-create-info > ".BKP_DIR.date("YmdHi").".bd.sql", $output[0]);

    /*Executando Backup do Diretório do site*/
    /*
    exec("tar -cvzf ".BKP_DIR.date("YmdHi").".site.tar.gz ".ROOT);
    
    header("Location: ../atualizacao_sistema.php?msg=success");
    */
    echo (ROOT);
?>
