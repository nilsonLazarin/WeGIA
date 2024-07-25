<?php
require_once('conexao.php');
use Versao\Conexao;

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
    $bd = new Conexao;

    $doacaoAvulsaLink = $_POST['avulso'];
    $doacaoMensalLink = $_POST['link_extra'];
    $doacaoMensalValor = $_POST['valor_extra'];
        if($doacaoMensalLink != '' && $doacaoMensalValor != '')
        {
           
            $bd->query("INSERT INTO doacao_cartao_mensal(link, valor, id_sistema)VALUES('$doacaoMensalLink', '$doacaoMensalValor', '$idSistema')");
        }

    $dadoCartao = verificaDadoCartao($idSistema);
        if($dadoCartao == 0)
        {
            $bd->query("INSERT INTO doacao_cartao_avulso(url, id_sistema) VALUES ('$doacaoAvulsaLink', '$idSistema')");
        }else{
            $bd->query("UPDATE doacao_cartao_avulso SET url = '$doacaoAvulsaLink' WHERE id_sistema = '$idSistema'");
        }
    
    
    header("Location: configuracao_doacao.php");

}    


function atualizaDados($idSistema)
{
    $bd = new Conexao;

    $linkDoacaoAvulsa = $_POST['avulso'];
    echo $linkDoacaoAvulsa;
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

    $dadoCartao = verificaDadoCartao($idSistema);
    if($dadoCartao == 0)
    {
         $bd->query("INSERT INTO doacao_cartao_avulso(url, id_sistema) VALUES ('$linkDoacaoAvulsa', '$idSistema')");
    }else{
        $bd->query("UPDATE doacao_cartao_avulso SET url = '$linkDoacaoAvulsa' WHERE id_sistema = '$idSistema'");
    }
   
    $doacaoMensalLink = $_POST['link_extra'];
    $doacaoMensalValor = $_POST['valor_extra'];
        if(!empty($doacaoMensalLink) && !empty($doacaoMensalValor))
        {

            $bd->query("INSERT INTO doacao_cartao_mensal(link, valor, id_sistema)VALUES('$doacaoMensalLink', '$doacaoMensalValor', '$idSistema')");
        }
    
    header("Location: configuracao_doacao.php");
}  

function verificaDadoCartao($idSistema)
{
    $bd = new Conexao;

    $bd->query("SELECT url FROM doacao_cartao_avulso WHERE id_sistema = '$idSistema'");
    $result = $bd->linhas();

    return $result;
}


?>