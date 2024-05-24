<?php
$r = array(
    "resultado"=> false,
    "url"=> null
);

if (!is_dir("../tabelas/")) {
    if (mkdir("../tabelas")) {
        mkdir("../tabelas/cobrancas/");
    }
}

if (!empty($_FILES['arquivo']['name'])) {
    $bloqueados = array('php', 'exe', 'sh', 'bat', 'js', 'html', 'htm');
    $extensao = strtolower(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));

    if (!in_array($extensao, $bloqueados)) {
        $file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['arquivo']['name']));

        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], "../tabelas/cobrancas/".$file_name)) {
            $r['resultado'] = true;
            $r['url'] = "./tabelas/cobrancas/".$file_name;
        } else {
            $r['url'] = "Erro ao mover o arquivo.";
        }
    } else {
        $r['url'] = "Tipo de arquivo não permitido.";
    }
}

echo json_encode($r);
?>
