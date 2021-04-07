<pre>
<?php

session_start();
if(!isset($_SESSION['usuario'])){
    header ("Location: ../../index.php");
}

// Verifica Permissão do Usuário
require_once '../permissao/permissao.php';
permissao($_SESSION['id_pessoa'], 9);

require_once "../../config.php";

extract($_REQUEST);

$ls = shell_exec("cd ".BKP_DIR." && ls $file");
// var_dump("cd ".BKP_DIR." && ls $file", $file, $ls, $ls == $file."\n");
if (shell_exec("cd ".BKP_DIR." && ls $file") == $file."\n"){
    // echo "File exists\n";
    if ($action == "remove"){
        $log = shell_exec("cd ".BKP_DIR." && rm $file");
        if ($log){
            header("Location: ./listar_backup.php?msg=error&err=Houve um erro ao remover o arquivo!&log=".base64_encode($log));
        }else{
            header("Location: ./listar_backup.php?msg=success&sccs=Backup removido com sucesso!");
        }
    } else if ($action == "restore"){
        
    } else {
        header("Location: ./listar_backup.php?msg=warning&warn=Nenhuma ação válida foi selecionada!");
    }
}
?>
</pre>