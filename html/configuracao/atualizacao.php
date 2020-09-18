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

    // Controla o modo debug
    define("DEBUG_MODE", false);

    define("DAY_TIME", date("YmdHi")); // Data e hora em formato AAAAMMDDHHII (I = minuto)
    define("BD_BKP", BKP_DIR.date("YmdHi").".bd.sql"); //Caminho para arquivo de backup temporário do Banco de dados
    define("PAGE_BKP", BKP_DIR.date("YmdHi").".site.tar.gz"); //Caminho para arquivo de backup temporário da página

    function createBdBackup() {
        exec("mysqldump -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." --no-create-info > ".BD_BKP);
    }

    function createPageBackup() {
        exec("tar -cvzf ".PAGE_BKP." ".ROOT);
    }

    function tempBackup() {
        if (PHP_OS != 'Linux'){
            return false;
        }
        createBdBackup();
        createPageBackup();
        return true;
    }

    function gitPull() {
        //$x = exec("cd ".ROOT." && git fetch --all && git reset --hard origin/master && git pull https://github.com/nilsonmori/WeGIA.git master", $y);
        $output = array();
        exec("git -C ".ROOT." pull 2>&1", $output);
        return $output;
    }

    
    $output = gitPull();
    if (DEBUG_MODE) {
        var_dump("git -C ".ROOT." pull 2>&1", $output);
        die();
    }
    if ($output) {
        if (sizeof($output) == 1){
            if ($output[0] == 'Already up to date.'){
                header("Location: ./configuracao_geral.php?msg=success&sccs=O sistema já está atualizado!");
            }else{
                header("Location: ./configuracao_geral.php?msg=error&err=Houve um erro ao executar o comando git -C ".ROOT." pull");
            }
        }elseif (sizeof($output) != 0) {
            $log = "Status da atualização: \n";
            foreach ($output as $value){
                $log = $log . $value . "\n";
            }
            $_SESSION['log'] = $log;
            if (tempBackup()){
                // header("Location: ./configuracao_geral.php?msg=success&sccs=Backup realizado e Atualização concluída!&log=".base64_encode($log));
                header("Location: ./configuracao_geral.php?tipo=success&mensagem=Backup realizado e Atualização concluída!");
            }else{
                // header("Location: ./configuracao_geral.php?msg=warning&warn=Atualização concluída, mas houve um erro ao realizar o backup (Sistema compatível: Linux, Seu Sistema: ".PHP_OS.")!&log=".base64_encode($log));
                header("Location: ./configuracao_geral.php?tipo=warning&mensagem=Atualização concluída, mas houve um erro ao realizar o backup (Sistema compatível: Linux, Seu Sistema: ".PHP_OS.")!");
            }
        }
    } else {
        // header("Location: ./configuracao_geral.php?msg=error&err=Houve um erro ao executar o comando git -C ".ROOT." pull");
        header("Location: ./configuracao_geral.php?tipo=error&mensagem=Houve um erro ao executar o comando git -C ".ROOT." pull");
    }

?>