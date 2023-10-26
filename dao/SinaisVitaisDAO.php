<?php

$config_path = "config.php";
if(file_exists($config_path)){
    require_once($config_path);
}else{
    while(true){
        $config_path = "../" . $config_path;
        if(file_exists($config_path)) break;
    }
    require_once($config_path);
}
require_once ROOT."/dao/Conexao.php";
require_once ROOT."/classes/SinaisVitais.php";
require_once ROOT."/Functions/funcoes.php";

class SinaisVitaisDAO
{
    public function incluir($sinaisvitais)
    {               
        try {
            $id_fichamedica = $sinaisvitais->getIdFichamedica();
            $id_funcionario = $sinaisvitais->getIdFuncionario();
            $data = $sinaisvitais->getData();
            $saturacao = $sinaisvitais->getSaturacao();
            $pres_art = $sinaisvitais->getPressaoArterial();
            $freq_card = $sinaisvitais->getFrequenciaCardiaca();
            $freq_resp = $sinaisvitais->getFrequenciaRespiratoria();
            $temperatura = $sinaisvitais->getTemperatura();
            $hgt = $sinaisvitais->getHgt();
            
            $sql = "INSERT INTO saude_sinais_vitais (id_fichamedica, id_funcionario, data, saturacao, pressao_arterial, frequencia_cardiaca, frequencia_respiratoria, temperatura, hgt) VALUES (:id_fichamedica, :id_funcionario, :data, :saturacao, :pressao_arterial, :frequencia_cardiaca, :frequencia_respiratoria, :temperatura, :hgt)";
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_fichamedica',$id_fichamedica);
            $stmt->bindParam(':id_funcionario',$id_funcionario);
            $stmt->bindParam(':data',$data);
            $stmt->bindParam(':saturacao',$saturacao);
            $stmt->bindParam(':pressao_arterial',$pres_art);
            $stmt->bindParam(':frequencia_cardiaca',$freq_card);
            $stmt->bindParam(':frequencia_respiratoria',$freq_resp);
            $stmt->bindParam(':temperatura',$temperatura);
            $stmt->bindParam(':hgt',$hgt);
            $stmt->execute();
           $pdo->commit();
           $pdo->close();
            
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
        
    }
    
}
