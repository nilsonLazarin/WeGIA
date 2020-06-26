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

    define("DAY_TIME", time("YmdHi")); // Data e hora em formato AAAAMMDDHHII (I = minuto)
    define("BD_BKP", BKP_DIR.date("YmdHi").".bd.sql"); //Caminho para arquivo de backup temporário do Banco de dados
    define("PAGE_BKP", BKP_DIR.date("YmdHi").".site.tar.gz"); //Caminho para arquivo de backup temporário da página

    function createBdBackup() {
        exec("mysqldump -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." --no-create-info > ".BD_BKP);
    }

    function createPageBackup() {
        exec("tar -cvzf ".PAGE_BKP." ".ROOT);
    }

    function tempBackup() {
        createBdBackup();
        createPageBackup();
    }

    function gitPull() {
        //$x = exec("cd ".ROOT." && git fetch --all && git reset --hard origin/master && git pull https://github.com/nilsonmori/WeGIA.git master", $y);
        exec("git -C ".ROOT." pull", $output);
        return $output;
    }

    tempBackup();
    if (gitPull()) {
        header("Location: ../atualizacao_sistema.php?msg=success&sccs=Backup realizado e Atualização concluída!");
    } else {
        header("Location: ../atualizacao_sistema.php?msg=error&err=Houve um erro ao executar o comando git -C ".ROOT." pull");
    }

?>