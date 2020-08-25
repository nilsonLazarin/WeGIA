<?php
        include("conexao.php");

        $SISTEMA = $_POST['id_sistema'];

        $QUERYR  = mysqli_query($conexao, "SELECT * FROM doacao_boleto_regras as regras JOIN doacao_boleto_info as info ON (info.id_regras = regras.id) WHERE info.id_sistema = '$SISTEMA'");
        $LINHAS = mysqli_num_rows($QUERYR);
        $REGRAS = mysqli_fetch_row($QUERYR);

        $MinValUnic = $REGRAS[1];
        $MensalDiasV = $REGRAS[2];
        $juros = $REGRAS[3];
        $multa = $REGRAS[4];
        $MaiValParc = $REGRAS[5];
        $MinValParc = $REGRAS[6];
        $agradecimento = $REGRAS[7];
        $UnicDiasV = $REGRAS[8];
        $opVenc0 = $REGRAS[9];
        $opVenc1 = $REGRAS[10];
        $opVenc2= $REGRAS[11];
        $opVenc3 = $REGRAS[12];
        $opVenc4 = $REGRAS[13];
        $opVenc5 = $REGRAS[14];
        $API = $REGRAS[16];
        $token = $REGRAS[17];
        $sandbox = $REGRAS[18];
        $token_sandbox = $REGRAS[19];
        $COD = $REGRAS[21];

        $vetor['cod_regras'] = $COD; 
        $vetor['MinValUnic'] = $MinValUnic;
        $vetor['MensalDiasV'] = $MensalDiasV;
        $vetor['juros'] = $juros;
        $vetor['multa'] = $multa;
        $vetor['MaiValParc'] = $MaiValParc;
        $vetor['MinValParc'] = $MinValParc;
        $vetor['agradecimento'] = $agradecimento;
        $vetor['UnicDiasV'] = $UnicDiasV;
        $vetor['opVenc0'] = $opVenc0; 
        $vetor['opVenc1'] = $opVenc1;
        $vetor['opVenc2'] = $opVenc2;
        $vetor['opVenc3'] = $opVenc3;
        $vetor['opVenc4'] = $opVenc4;
        $vetor['opVenc5'] = $opVenc5;
        $vetor['API'] = $API;
        $vetor['token'] = $token;
        $vetor['sandbox'] = $sandbox;
        $vetor['token_sandbox'] = $token_sandbox;

        if($LINHAS == 0)
        {
                echo$SISTEMA;
                echo"ERRNão há regras para esse sistema. Favor preencher no Banco de Dados";
        }else{
                $array = json_encode($vetor);
                echo$array;
        }
                
?>
                


    
