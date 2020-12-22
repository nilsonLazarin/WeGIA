<?php
    require("../../conexao.php");
    $resultado = false;
    if(isset($_REQUEST['chave'])){
        $chave = $_REQUEST['chave'];
        if($chave === "h)8^#w4T<HaN-GSc&BM3[<?mvG[R?b"){
            $tabelas = array("endereco","pessoafisica","pessoajuridica","socio");
            $i = 0;
            mysqli_query($conexao,"SET FOREIGN_KEY_CHECKS=0");
            foreach ($tabelas as $n => $tabela) {
                $r_query = mysqli_query($conexao, "TRUNCATE TABLE $tabela");
                if(mysqli_affected_rows($conexao)) $i++;
            }
            $resultado = true;
            mysqli_query($conexao,"SET FOREIGN_KEY_CHECKS=1");
        }
    }
    
    echo json_encode($resultado);
?>