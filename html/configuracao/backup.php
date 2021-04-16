<pre>
<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Locatiion ../../index.php");
    }

    // Verifica Permissão do Usuário
	require_once '../permissao/permissao.php';
    permissao($_SESSION['id_pessoa'], 9);

    require_once "./config_funcoes.php";
    
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


    // require_once("../../config.php");

    // Define os redirecionamentos padrão para cada tipo de backup.
    define('REDIRECT_URLS', [
        "./configuracao_geral.php",
        "./listar_backup.php",
        "./debug_info.php"
    ]);

    if (PHP_OS != 'Linux'){
        header("Location: ./configuracao_geral.php?msg=error&err=Função de backup compatível apenas com Linux. Seu Sistema Operacional: ".PHP_OS."");
    }else{
        $dblog = "";
        $filelog = "";

        /*
        Identifica o tipo de ação:
            false: Backup do banco de dados e do site
            bd: backup do banco de dados apenas
            site: backup do site apenas
            default: Backup do banco de dados e do site
        */
        $action = $_GET['action'] ?? false;
        if(!$action){
            $redirect = REDIRECT_URLS[0];
        
            // Executa os comandos
            $dblog = backupBD();
    
            // Executando Backup do Diretório do site
            $filelog = backupSite();

        }else{
            if ($action == "bd"){
                $redirect = REDIRECT_URLS[1];
        
                // Executa os comandos
                $dblog = backupBD();

            }else if ($action == "site"){
                $redirect = REDIRECT_URLS[0];
    
                // Executando Backup do Diretório do site
                $filelog = backupSite();

            }
            else {
                $redirect = REDIRECT_URLS[0];
        
                // Executa os comandos
                $dblog = backupBD();
    
                // Executando Backup do Diretório do site
                $filelog = backupSite();

            }
        }

        // Caso exista um redirect definido, ele terá prioridade sobre o padrão
        $redirect = $_GET['redirect'] ?? $redirect;
    
        $log = "";
        
        if ($dblog || $filelog){
            if ($dblog){
                $log .= "Houve um erro ao realizar o Backup do Banco de Dados:\n" . $dblog;
                // foreach ($dblog as $value){
                //     $log .= $value . "\n";
                // }
            }
            if ($filelog){
                $log .= "Houve um erro ao realizar o Backup do Sistema:\n" . $filelog;
                // foreach ($filelog as $value){
                //     $log .= $value . "\n";
                // }
            }
            header("Location: $redirect?msg=error&err=Houve um erro no processo de execução dos Backups&log=".base64_encode($log));
        }

        header("Location: $redirect?msg=success&sccs=Backup realizado com sucesso!");
    }
?>