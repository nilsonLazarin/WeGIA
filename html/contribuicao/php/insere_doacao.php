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
          if($MinValUnic == '' && $MensalDiasV == '' && $juros == '' && $multa == '' && $MaiValParc == '' && $MinValParc == '' && $agradecimento == '' && $UnicDiasV == '' && $opVenc1 == '' && $opVenc2 == '' && $opVenc3 == '' && $opVenc4 == '' && $opVenc5 == '' && $opVenc6 == '' && $API == '' && $token == '' && $sandbox == '' && $token_sandbox == '')
          {
               header("Location: configuracao_doacao.php");
          }
          else
          {
               $query = mysqli_query($conexao, "CALL insregras ('$MinValUnic', '$MensalDiasV','$juros','$multa','$MaiValParc','$MinValParc','$agradecimento','$UnicDiasV', '$opVenc1', '$opVenc2', '$opVenc3', '$opVenc4', '$opVenc5', '$opVenc6')");
    
               $cod_regras = mysqli_query($conexao, "SELECT id FROM doacao_boleto_regras ORDER BY id DESC LIMIT 1");
               $registro = mysqli_fetch_row($cod_regras);
               $id_regras = $registro [0];

               mysqli_query($conexao, "INSERT INTO doacao_boleto_info (api, token_api, sandbox, token_sandbox, id_sistema, id_regras) VALUES ('$API', '$token', '$sandbox', '$token_sandbox', '$id_sistema', '$id_regras')"); 
                  
          }

     $cod_cartao = $_POST['cod_cartao'];
     $link_avulso = $_POST['avulso_link'];
     $possivel_link = $_POST['link_avulso'];
          if($link_avulso == '')
          {
               $atualiza_avulso = mysqli_query($conexao, "UPDATE doacao_cartao_avulso SET url = '$possivel_link' WHERE id_sistema = '$cod_cartao'");
          }else{
               mysqli_query($conexao,"INSERT INTO doacao_cartao_avulso (url, id_sistema) values ('$link_avulso', '$cod_cartao')") ;
          }
    


     $valor = $_POST['valor'];
     $link_1 = $_POST['link'];
     $link_2 = $_POST['link_doacao'];
          if($valor == '')
          {

          }else{
               if($link_2 == '')
                    {
                         mysqli_query($conexao,"INSERT INTO doacao_cartao_mensal (link, valor, id_sistema) values ('$link_1', '$valor', '$cod_cartao')" );
                    }
                    else{
                         mysqli_query($conexao,"INSERT INTO doacao_cartao_mensal (link, valor, id_sistema) values ('$link_2', '$valor', '$cod_cartao')" );
                    }
          }
     $valor_extra = $_POST['valor_extra'];
     $link_extra = $_POST['link_extra'];
          if(!empty($valor_extra) && !empty($link_extra))
          {
               mysqli_query($conexao,"INSERT INTO doacao_cartao_mensal (link, valor, id_sistema) values ('$link_extra', '$valor_extra', '$cod_cartao')" );     
          }
               
     header("Location: configuracao_doacao.php");
    
?>


    


        
  