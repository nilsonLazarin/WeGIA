<?php

$config_path = "config.php";
$loopLimit = 2000;
if(file_exists($config_path)){
    require_once($config_path);
}else{
    while(true){
        $loopLimit--;
        $config_path = "../" . $config_path;
        if(file_exists($config_path)) break;
        if($loopLimit < 0) { 
            // Caso config.php não seja encontrado
            header("Location: instalador/index.php");
            break;
        }
    }
    require_once($config_path);
}
if (isset($_COOKIE['PHPSESSID'])){
    header("Set-Cookie: PHPSESSID=".$_COOKIE["PHPSESSID"]."; expires=".(time() + 3600 * 0).";path=/; domain=".DB_HOST.";SameSite=Strict;HttpOnly=On;Secure");
}