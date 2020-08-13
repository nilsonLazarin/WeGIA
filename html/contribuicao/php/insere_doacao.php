<?php
    include ("conexao.php");

    
    $id_sistema = $_POST['id_sistema'];
    $MinValUnic = $_POST['minval'];
    $MensalDiasV =$_POST['mensaldiasv'];
    $juros = $_POST['juros'];
    $multa =$_POST['multa'];
    $MaiValParc = $_POST['maivalparc'];
    $MinValParc = $_POST['minvalparc'];
    $agradecimento = $_POST['agradecimento'];
    $UnicDiasV =$_POST['unicdiasv'];
    $opVenc1 = $_POST['op01'];
    $opVenc2 = $_POST['op02'];
    $opVenc3 = $_POST['op03'];
    $opVenc4 = $_POST['op04'];
    $opVenc5 = $_POST['op05'];
    $opVenc6 = $_POST['op06'];
    $API = $_POST['api'];
    $token = $_POST['token_api'];
    $sandbox = $_POST['sandbox'];
    $token_sandbox = $_POST['token_sandbox'];

    mysqli_query($conexao, "CALL  ('$MinValUnic', '$MensalDiasV','$juros','$multa','$MaiValParc','$MinValParc','$agradecimento','$UnicDiasV', '$opVenc1', '$opVenc2', '$opVenc3', '$opVenc4', '$opVenc5', '$opVenc6')");
    

    $cod_cartao = $_POST['cod_cartao'];
    $link_avulso = $_POST['avulso_link'];
    $atualiza_avulso = mysqli_query($conexao, "CALL ('$link_avulso', '$cod_cartao')");

    $valor = $_POST['valor'];
    $link = $_POST['link'];

    for($i =0; $i<count($valor); $i++)
    {
        
         mysqli_query($conexao, "CALL ('$valor[$i]', '$link[$i]', '$cod_cartao')");
    }

   // header("Location: configuracao_doacao.php");*/
?>


    


        
  