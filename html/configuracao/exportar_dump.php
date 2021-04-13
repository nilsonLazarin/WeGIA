<?php

session_start();
if (!isset($_SESSION["usuario"])){
    header("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 9);

require_once "../../config.php";



$fullname = BKP_DIR . $_POST['file'];

function _Download($f_location, $f_name){
    ob_clean();
    header('Content-Description: File Transfer');
    header('Content-Type: application/x-gzip');
    header('Content-Length: ' . filesize($f_location));
    header('Content-Disposition: attachment; filename=' . basename($f_name));
    readfile($f_location);
}


_Download($fullname, $_POST['file']);