
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('conexao.php');

function resgataImagem()
{
    $banco = new Conexao();

    $query = "SELECT imagem.imagem, imagem.tipo 
    FROM imagem, campo_imagem, tabela_imagem_campo 
    WHERE campo_imagem.id_campo = tabela_imagem_campo.id_campo 
    AND imagem.id_imagem = tabela_imagem_campo.id_imagem 
    AND campo_imagem.nome_campo = 'Logo'";

    $banco->querydados($query);
    $result = $banco->result();

    if ($result) {
        $imagem = $result['imagem'];
        $tipo = $result['tipo'];

        if (substr($imagem, 0, 2) === "\x1f\x8b") {
            $imagem = gzuncompress($imagem);
            if ($imagem === false) {
                echo "Erro ao descomprimir a imagem.";
                return;
            }
        }

        $imagem_base64 = base64_encode($imagem);

        if ($imagem_base64 === false) {
            echo "Erro ao codificar a imagem para base64.";
            return;
        }

        echo "<img id='logo_img' width='100px' src='data:image/".$tipo.";base64,".$imagem_base64."' alt='Logo'>";

    } else {
        echo "Imagem não encontrada ou erro ao recuperar do banco de dados.";
    }
}

function resgataParagrafo()
{
    $banco = new Conexao();

    $banco->querydados("SELECT paragrafo FROM selecao_paragrafo WHERE nome_campo = 'ContribuiçãoMSG'");
    $result = $banco->result();

    echo $result['paragrafo'];
}
?>
