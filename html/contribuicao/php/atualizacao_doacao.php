<?php
    include ("conexao.php");

    $cod_sistema = $_POST['cod_sistema'];
    $cod_cartao = $_POST['cod_cartao'];
    $MinValUnic = $_POST['minval'];
    $MensalDiasV =$_POST['mensaldiasv'];
    $juros = $_POST['juros'];
    $multa =$_POST['multa'];
    $MaiValParc = $_POST['maivalparc'];
    $MinValParc = $_POST['minvalparc'];
    $agradecimento = $_POST['agradecimento'];
    $UnicDiasV =$_POST['unicdiasv'];
    $opVenc0 = $_POST['op1'];
    $opVenc1 = $_POST['op2'];
    $opVenc2= $_POST['op3'];
    $opVenc3 = $_POST['op4'];
    $opVenc4 = $_POST['op5'];
    $opVenc5 = $_POST['op6'];
    $API = $_POST['api'];
    $token = $_POST['token_api'];
    $sandbox = $_POST['sandbox'];
    $token_sandbox = $_POST['token_sandbox'];

   
    $atualiza_regras = mysqli_query($conexao,  "UPDATE doacao_boleto_regras SET min_boleto_uni = '$MinValUnic', max_dias_venc = '$MensalDiasV', juros = '$juros', multa = '$multa', max_parcela = '$MaiValParc', min_parcela = '$MinValParc', agradecimento = '$agradecimento', dias_boleto_a_vista = '$UnicDiasV', dias_venc_carne_op1 = '$opVenc0', dias_venc_carne_op2 = '$opVenc1', dias_venc_carne_op3 = '$opVenc2', dias_venc_carne_op4 = '$opVenc3', dias_venc_carne_op5 = '$opVenc4', dias_venc_carne_op6 = '$opVenc5' WHERE id = '$cod_sistema'");

   
    $link_avulso = $_POST['avulso_link'];

    $atualiza_avulso = mysqli_query($conexao, "UPDATE doacao_cartao_avulso SET url = '$link_avulso' WHERE id_sistema = $cod_cartao");

    $valor1 = $_POST['valor0'];
    $valor2 = $_POST['valor1'];
    $valor3 = $_POST['valor2'];
    $valor4 = $_POST['valor3'];

    $link1 = $_POST['link0'];
    $link2 = $_POST['link1'];
    $link3 = $_POST['link2'];
    $link4 = $_POST['link3'];

    $valor = $_POST['valor'];
    $link = $_POST['link'];
    
    $insere = mysqli_query($conexao, "INSERT INTO doacao_cartao_mensal (valor, link, id_sistema) VALUES('$valor', '$link', '$cod_cartao')");

       
    $atualiza_val1 = mysqli_query($conexao, "UPDATE doacao_cartao_mensal SET  valor = '$valor1', link = '$link1' WHERE id = 0 and id_sistema = $cod_cartao");

    $atualiza_val2 = mysqli_query($conexao, "UPDATE doacao_cartao_mensal SET  valor = '$valor2', link = '$link2' WHERE id = 1 and id_sistema = $cod_cartao");

;
    $atualiza_val3 = mysqli_query($conexao, "UPDATE doacao_cartao_mensal SET  valor = '$valor3', link = '$link3' WHERE id = 2 and id_sistema = $cod_cartao");

    $atualiza_val4 = mysqli_query($conexao, "UPDATE doacao_cartao_mensal SET  valor = '$valor4', link = '$link4' WHERE id = 3 and id_sistema = $cod_cartao");


    header("Location: configuracao_doacao.php");
?>


    


        
  