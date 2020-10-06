<?php

$dado = $_GET['dados'];
$idSistema= $_GET['idSistema'];
    if($dado == 0)
    {
        insereDados($idSistema);
    }else{
        atualizaDados($idSistema);
    }

function insereDados($idSistema)
{
    require_once('conexao.php');
    $bd = new Conexao;

    $doacaoAvulsaLink = $_POST['avulso'];
    $doacaoMensalLink = $_POST['link_extra'];
    $doacaoMensalValor = $_POST['valor_extra'];

    $bd->query("CALL registra_cartao_avulso('$doacaoAvulsaLink', '$idSistema')");
    $bd->query("INSERT INTO doacao_cartao_mensal(link, valor, id_sistema)VALUES('$doacaoMensalLink', '$doacaoMensalValor', '$idSistema')");

    header("Location: configuracao_doacao.php");

}    


function atualizaDados($idSistema)
{
    require_once('conexao.php');
    $bd = new Conexao;

    $linkDoacaoAvulsa = $_POST['avulso'];
    $arrayValoresMensal = $_POST['valores'];
    //print_r($arrayValoresMensal);
    $arrayLinkMensal = $_POST['link_doacao'];
    //print_r($arrayLinkMensal);
    $arrayIdMensal = $_POST['id'];
    //print_r($arrayIdMensal);
    
    for($i=0; $i<count($arrayValoresMensal); $i++)
    {
        $bd->query("UPDATE doacao_cartao_mensal SET valor = '$arrayValoresMensal[$i]', link = '$arrayLinkMensal[$i]' WHERE id = '$arrayIdMensal[$i]' AND id_sistema = '$idSistema'");
    }

    $bd->query("UPDATE doacao_cartao_avulso SET url = '$linkDoacaoAvulsa' WHERE id_sistema = '$idSistema'");

    echo $doacaoMensalLink = $_POST['link_extra'];
    echo $doacaoMensalValor = $_POST['valor_extra'];
        if(!empty($doacaoMensalLink) && !empty($doacaoMensalValor))
        {
            $bd->query("INSERT INTO doacao_cartao_mensal(link, valor, id_sistema)VALUES('$doacaoMensalLink', '$doacaoMensalValor', '$idSistema')");
        }
    
       header("Location: configuracao_doacao.php");
}  
?>