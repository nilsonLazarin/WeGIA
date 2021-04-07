<pre>
<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header("Locatiion ../../index.php");
    }

    // Verifica Permissão do Usuário
	require_once '../permissao/permissao.php';
    permissao($_SESSION['id_pessoa'], 9);
    
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
        "./configuracao_geral.php"
    ]);

    function backupBD(){
        // Executando Backup do Banco de Dados
        
        // Define nome do arquivo (sem o path)
        define("DUMP_NAME", date("YmdHis"));

        // Define o comando para exportar o banco de dados para a pasta de backup com o nome definido acima
        $dbDump = "mysqldump -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." --no-create-info > ".BKP_DIR.DUMP_NAME.".bd.sql";

        // Compacta o dump gerado em um .dump.tar.gz
        $dbComp = "tar -czf ".BKP_DIR.DUMP_NAME.".dump.tar.gz ".BKP_DIR.DUMP_NAME.".bd.sql";

        // Remove o arquivo não compactado
        $dbRemv = "rm ".BKP_DIR.DUMP_NAME.".bd.sql";

        // Faz os 3 comandos acima serem executados na mesma linha
        $cmdStream = $dbDump . " && " . $dbComp . " && " . $dbRemv;

        /*
        var_dump(
            DUMP_NAME, 
            $dbDump,
            $dbComp,
            $dbRemv,
            $cmdStream,
            $dblog
        );
        die();
        */
        
        // Executa os comandos
        return shell_exec($cmdStream);
    }

    function backupSite(){
        // Executando Backup do Diretório do site
        
        return shell_exec("tar -czf ".BKP_DIR.date("YmdHis").".site.tar.gz ".ROOT);
    }

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
                $redirect = REDIRECT_URLS[2];
    
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