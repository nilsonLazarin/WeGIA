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
    $opVenc0 = $_POST['op0'];
    $opVenc1 = $_POST['op1'];
    $opVenc2= $_POST['op2'];
    $opVenc3 = $_POST['opvenc3'];
    echo$opVenc4 = $_POST['opvenc4'];
    echo$opVenc5 = $_POST['opvenc5'];
    $API = $_POST['api'];
    $token = $_POST['token_api'];
    $sandbox = $_POST['sandbox'];
    $token_sandbox = $_POST['token_sandbox'];

    $insere_regras = mysqli_query($conexao, "INSERT INTO 'doacao_boleto_regras' ('id', 'min_boleto_uni', 'max_dias_venc', 'juros', 'multa', 'max_parcela', 'min_parcela', 'agradecimento', 'dias_boleto_a_vista', 'dias_venc_carne_op1', 'dias_venc_carne_op2', 'dias_venc_carne_op3', 'dias_venc_carne_op4', 'dias_venc_carne_op5', 'dias_venc_carne_op6') VALUES ('null', '$MinValUnic', '$MensalDiasV','$juros','$multa','$MaiValParc','$MinValParc','$agradecimento','$UnicDiasV', '$opVenc0', '$opVenc1', '$opVenc2','$opVenc3','$opVenc4', '$opVenc5'");
    
    /*$cod_cartao = $_POST['cod_cartao'];
    $link_avulso = $_POST['avulso_link'];
    $atualiza_avulso = mysqli_query($conexao, "INSERT INTO doacao_cartao_avulso ('url', 'id_sistema') VALUES ('$link_avulso', '$cod_cartao'");

    $valor = $_POST['valor'];
    $link = $_POST['link'];
   
    for($i =0; $i<count($valor); $i++)
    {
        
         mysqli_query($conexao, "INSERT INTO doacao_cartao_mensal (valor, link, id_sistema) VALUES ('$valor[$i]', '$link[$i]', '$cod_cartao'");
    }

   // header("Location: configuracao_doacao.php");*/
?>


    


        
  