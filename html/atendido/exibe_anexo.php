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

session_start();

if(!isset($_SESSION['usuario'])){
	header ("Location: ".WWW."index.php");
}

require_once ROOT."/controle/Atendido_ocorrenciaControle.php";

$id_anexo = $_GET['id_anexo'];
$extensao = $_GET['extensao'];
$nome = $_GET['nome'];

$AnexoControle = new Atendido_ocorrenciaControle;
$AnexoControle->listarAnexo($id_anexo);

header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename="' . $nome . '.' . $extensao . '"');

/*Header('Content-Disposition: attachment; filename="'.$nome.'.'.$extensao);*/
echo $_SESSION['arq'][0]['anexo'];
?>