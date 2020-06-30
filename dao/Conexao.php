<?php
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

class  Conexao
{
    public static function connect()
    {
        $pdo = new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME.'; charset=utf8',DB_USER,DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}

