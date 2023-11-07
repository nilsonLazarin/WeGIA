<?php
    require("../conexao.php");
    $config_path = "config.php";
    if(file_exists($config_path)){
        require_once($config_path);
    }else{
        while(true){
            $config_path = "../" . $config_path;
            if(file_exists($config_path)) break;
        }
        require_once($config_path);
    }
    if(isset($_GET['file'])){
        $file = $_GET['file'];
        if(substr(BKP_DIR, -1) == "/"){
            $filepath = BKP_DIR.$file;
        }
        else{
            $filepath = BKP_DIR."/".$file;
        }
        
        // Verifique se o arquivo existe
        if(file_exists($filepath)){
            // Configurar cabeçalhos para download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));

            // Lê e exibe o arquivo
            readfile($filepath);
            exit;
        } else {
            echo 'O arquivo não existe.';
        }
    }
?>