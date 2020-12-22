
<?php

    function resgataImagem()
    {
        require_once('conexao.php');
        $banco = new Conexao();

        $banco->querydados("SELECT imagem.imagem, imagem.tipo FROM imagem, campo_imagem, tabela_imagem_campo WHERE campo_imagem.id_campo=tabela_imagem_campo.id_campo AND imagem.id_imagem=tabela_imagem_campo.id_imagem AND campo_imagem.nome_campo='Logo'");
        $result = $banco->result();

        $imagem = $result['imagem'];
        $tipo = $result['tipo'];

        echo "<img id='logo_img' width='100px' src=data:image/".$tipo.";base64,".$imagem.">";

    } 

    function resgataParagrafo()
    {
        require_once('conexao.php');
        $banco = new Conexao();

        $banco->querydados("SELECT paragrafo FROM selecao_paragrafo WHERE nome_campo = 'ContribuiçãoMSG'");
        $result= $banco->result();

        echo $result['paragrafo'];

    }
    
?>
