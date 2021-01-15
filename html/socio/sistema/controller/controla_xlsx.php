<?php
    $r = array(
        "resultado"=> false,
        "url"=> null
    );
    if(!is_dir("../tabelas/")){
        if(mkdir("../tabelas")){
            mkdir("../tabelas/cobrancas/");
        }
    }
    if(!empty($_FILES['arquivo']['name'])){
        if(move_uploaded_file($_FILES['arquivo']['tmp_name'], "../tabelas/".$_FILES['arquivo']['name'])){
            $r['resultado'] = true;
            $r['url'] = "./tabelas/".$_FILES['arquivo']['name'];
        }
    }

    echo(json_encode($r))
?>