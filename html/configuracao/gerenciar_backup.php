<pre>
<?php

session_start();
if(!isset($_SESSION['usuario'])){
    header ("Location: ../../index.php");
}

define("DEBUG", false);

function autosaveBD(){
    // Executando Backup do Banco de Dados
    
    // Define nome do arquivo (sem o path)
    define("DUMP_NAME", date("YmdHis")."-autosave");
    define("AUTOSAVE_ERROR_FATAL", true);

    // Define o comando para exportar o banco de dados para a pasta de backup com o nome definido acima
    $dbDump = "cd ".BKP_DIR." && mysqldump -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." --add-drop-table > ".BKP_DIR.DUMP_NAME.".bd.sql";

    // Compacta o dump gerado em um .dump.tar.gz
    $dbComp = "tar -czf ".DUMP_NAME.".dump.tar.gz ".DUMP_NAME.".bd.sql";

    // Remove o arquivo não compactado
    $dbRemv = "rm ".BKP_DIR.DUMP_NAME.".bd.sql";

    // Faz os 3 comandos acima serem executados na mesma linha
    $cmdStream = $dbDump . " && " . $dbComp . " && " . $dbRemv;

    // var_dump(
    //     DUMP_NAME, 
    //     $dbDump,
    //     $dbComp,
    //     $dbRemv,
    //     $cmdStream
    // );
    // die();
    
    // Executa os comandos
    return shell_exec($cmdStream);
}


if (PHP_OS != 'Linux'){
    header("Location: ./listar_backup.php?msg=error&err=Função de backup compatível apenas com Linux. Seu Sistema Operacional: ".PHP_OS."");
}else{
    // Verifica Permissão do Usuário
    require_once '../permissao/permissao.php';
    permissao($_SESSION['id_pessoa'], 9);

    require_once "../../config.php";

    extract($_REQUEST);

    if (DEBUG){
        $ls = shell_exec("cd ".BKP_DIR." && ls $file");
        var_dump("cd ".BKP_DIR." && ls $file", $file, $ls, $ls == $file."\n");
    }
    if (shell_exec("cd ".BKP_DIR." && ls $file") == $file."\n"){
        // echo "File exists\n";
        if ($action == "remove"){
            $rmDump = "cd ".BKP_DIR." && rm $file";
            if (DEBUG){
                var_dump($rmDump);
                die();
            }
            $log = shell_exec($rmDump);
            if ($log){
                header("Location: ./listar_backup.php?msg=error&err=Houve um erro ao remover o arquivo!&log=".base64_encode($log));
            }else{
                header("Location: ./listar_backup.php?msg=success&sccs=Backup removido com sucesso!");
            }
        } else if ($action == "restore"){
            $logAS = autosaveBD();
            if ($log && AUTOSAVE_ERROR_FATAL){
                header("Location: ./listar_backup.php?msg=error&err=A ação não pode ser realizada devido a um erro no backup automático!&log=".base64_encode($log));
            }
            $extract = "cd ".BKP_DIR." && tar -xf ".$file;
            $import = "mysql  -u ".DB_USER."  ".DB_NAME." -p".DB_PASSWORD." < ".explode('.', $file)[0].".bd.sql";
            $rmDump = "rm ".explode('.', $file)[0].".bd.sql";
            if (DEBUG){
                var_dump($extract, $import, $rmDump, $extract . " && " . $import . " && " . $rmDump);
                die();
            }
            $log = shell_exec($extract . " && " . $import . " && " . $rmDump);
            if ($log){
                header("Location: ./listar_backup.php?msg=error&err=Houve um erro ao restaurar a Base de Dados!&log=".base64_encode($log));
            }else{
                if ($logAS){
                    header("Location: ./listar_backup.php?msg=warning&warn=AVISO:&log=".base64_encode("O backup foi restaurado com sucesso, mas houve um erro ao gerar um Backup automático de segurança. Log:\n\n".$logAS));
                }else{
                    header("Location: ./listar_backup.php?msg=success&sccs=Backup restaurado com sucesso!");
                }
            }
        } else {
            header("Location: ./listar_backup.php?msg=warning&warn=Nenhuma ação válida foi selecionada!");
        }
    }
}
?>
</pre>