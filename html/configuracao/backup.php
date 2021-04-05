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


    /*require_once("../../config.php");*/

    if (PHP_OS != 'Linux'){
        header("Location: ./configuracao_geral.php?msg=error&err=Função de backup compatível apenas com Linux. Seu Sistema Operacional: ".PHP_OS."");
    }else{
        /*Executando Backup do Banco de Dados*/
        
        // Define nome do arquivo (sem o path)
        define("DUMP_NAME", date("YmdHi"));

        // Define o comando para exportar o banco de dados para a pasta de backup com o nome definido acima
        $dbDump = "mysqldump -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." --no-create-info > ".BKP_DIR.DUMP_NAME.".bd.sql";

        // Compacta o dump gerado em um .dump.tar.gz
        $dbComp = "tar -czf ".BKP_DIR.DUMP_NAME.".dump.tar.gz ".BKP_DIR.DUMP_NAME.".bd.sql";

        // Remove o arquivo não compactado
        $dbRemv = "rm ".BKP_DIR.DUMP_NAME.".bd.sql";

        // Faz os 3 comandos acima serem executados na mesma linha
        $cmdStream = $dbDump . " && " . $dbComp . " && " . $dbRemv;

        
        // Executa os comandos
        $dblog = shell_exec($cmdStream);

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
    
        /*Executando Backup do Diretório do site*/
        
        $filelog = shell_exec("tar -czf ".BKP_DIR.date("YmdHi").".site.tar.gz ".ROOT);
    
        
    
        $log = "";
        
        if ($dblog || $filelog){
            if ($dblog){
                $log .= "Houve um erro ao realizar o Backup do Banco de Dados:\n";
                foreach ($dblog as $value){
                    $log .= $value . "\n";
                }
            }
            if ($filelog){
                $log .= "Houve um erro ao realizar o Backup do Sistema:\n";
                foreach ($filelog as $value){
                    $log .= $value . "\n";
                }
            }
            header("Location: ./configuracao_geral.php?msg=error&err=Houve um erro no processo de execução dos Backups&log=".base64_encode($log));
        }

        header("Location: ./configuracao_geral.php?msg=success&sccs=Backup realizado com sucesso!");
    }
?>
