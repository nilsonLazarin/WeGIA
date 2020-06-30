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

    if (PHP_OS != 'Linux'){
        header("Location: ../atualizacao_sistema.php?msg=error&err=Função de backup compatível apenas com Linux. Seu Sistema Operacional: ".PHP_OS."");
    }else{
        /*Executando Backup do Banco de Dados*/
        
        exec("mysqldump -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." --no-create-info > ".BKP_DIR.date("YmdHi").".bd.sql", $output[0]);
    
        /*Executando Backup do Diretório do site*/
        
        exec("tar -cvzf ".BKP_DIR.date("YmdHi").".site.tar.gz ".ROOT, $output[1]);
    
    
    
        if (sizeof($output[0]) && sizeof($output[1])) {
            $log = "Status do backup do Banco de dados: \n";
            foreach ($output[0] as $value){
                $log .= $value . "\n";
            }
            $log .= "\n\nStatus do backup do Sistema: \n";
            foreach ($output[1] as $value){
                $log .= $value . "\n";
            }
            header("Location: ../atualizacao_sistema.php?msg=success&sccs=Backup realizado com sucesso!&log=".base64_encode($log));
        } else {
            header("Location: ../atualizacao_sistema.php?msg=error&err=Houve um erro no processo de execução dos Backups");
        }
        var_dump($output);
    }
?>
