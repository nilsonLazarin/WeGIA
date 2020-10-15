<?php

    $dados = $_GET['dados'];
    $idSistema = $_GET['idSistema'];
    $idRegras = $_GET['idRegras'];
   
        if($dados == 0)
        {
            insereDados($idSistema);
        }else{
            atualizaDados($idSistema, $idRegras);
        }

    function insereDados($idSistema)
    {
        require_once('conexao.php');
        $banco = new Conexao;

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
                   
                    $banco->query("CALL insregras ('$MinValUnic', '$MensalDiasV','$juros','$multa','$MaiValParc','$MinValParc','$agradecimento','$UnicDiasV', '$opVenc1', '$opVenc2', '$opVenc3', '$opVenc4', '$opVenc5', '$opVenc6')");
                        
                    $banco->querydados("SELECT id FROM doacao_boleto_regras ORDER BY id DESC LIMIT 1");
                    $dados = $banco->result();
                    $cod = $dados['id'];
                        
                        
                    $banco->query("INSERT INTO doacao_boleto_info (api, token_api, sandbox, token_sandbox, id_sistema, id_regras) VALUES ('$API', '$token', '$sandbox', '$token_sandbox', '$idSistema', '$cod')");

    }

    function atualizaDados($idSistema, $idRegras)
    {
        require_once('conexao.php');
        $banco = new Conexao;

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
            if($opVenc1 == '' && $opVenc2 == '' && $opVenc3 == '' && $opVenc4 == '' && $opVenc5 == '' && $opVenc6 == '')
            {
                $opVenc1 = 0;
                $opVenc2 = 0;
                $opVenc3 = 0;
                $opVenc4 = 0;
                $opVenc5 = 0;
                $opVenc6 = 0;
            }

        $API = $_POST['api'];
        $token = $_POST['token_api'];
        $sandbox = $_POST['sandbox'];
        $token_sandbox = $_POST['token_sandbox'];

        $banco->query("UPDATE  doacao_boleto_regras as regras JOIN doacao_boleto_info as info ON (info.id_regras = regras.id) SET min_boleto_uni = '$MinValUnic', max_dias_venc = '$MensalDiasV', juros = '$juros', multa = '$multa', max_parcela = '$MaiValParc', min_parcela = '$MinValParc', agradecimento = '$agradecimento', dias_boleto_a_vista = '$UnicDiasV', dias_venc_carne_op1 = '$opVenc1', dias_venc_carne_op2 = '$opVenc2', dias_venc_carne_op3 = '$opVenc3', dias_venc_carne_op4 = '$opVenc4', dias_venc_carne_op5 = '$opVenc5', dias_venc_carne_op6 = '$opVenc6', api = '$API', token_api = '$token', sandbox = '$sandbox', token_sandbox = '$token_sandbox' WHERE id_regras = '$idRegras' AND id_sistema = '$idSistema'");

    }
    
    header("Location: configuracao_doacao.php");

    

?>