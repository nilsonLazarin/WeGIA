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
require_once ROOT."/classes/pet/Pet.php";
require_once ROOT."/Functions/funcoes.php";

class saudePetDAO
{
    public function incluir($saudePet)
    {       
        try {
            $sql = "INSERT INTO pet_ficha_medica(id_pet, castrado, necessidades_especiais) VALUES(:id_pet,:castrado,:necessidades_especiais)";
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            $id_pet = $saudePet->getNome();
            $castrado = $saudePet->getCastrado();
            $necEsp = $saudePet->getTexto();
            $stmt->bindParam(':id_pet',$id_pet);
            $stmt->bindParam(':castrado',$castrado);
            $stmt->bindParam(':necessidades_especiais',$necEsp);
            $stmt->execute();
            header('Location: ../../html/pet/informacao_saude_pet.php');
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pet_ficha_medica = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }        
    }

    public function listarTodos(){
        try{
            $pets=array();
            $pdo = Conexao::connect();
            $pd = $pdo->query("SELECT fm.id_ficha_medica AS 'id_ficha_medica', p.id_pet AS 'id_pet', p.nome AS 'nome', pr.descricao AS 'raca',
            pc.descricao AS 'cor', fm.necessidades_especiais AS 'necessidades_especiais' FROM pet p INNER JOIN pet_ficha_medica fm ON fm.id_pet = p.id_pet JOIN pet_raca pr ON p.id_pet_raca = pr.id_pet_raca JOIN pet_cor pc ON p.id_pet_cor = pc.id_pet_cor");
            $pd->execute();
            $x=0;
            while($linha = $pd->fetch(PDO::FETCH_ASSOC)){
                $pets[$x]=array('id_ficha_medica'=>$linha['id_ficha_medica'],'id_pet'=>$linha['id_pet'],'nome'=>$linha['nome'],'raca'=>$linha['raca'],'cor'=>$linha['cor'],'necessidades_especiais'=>$linha['necessidades_especiais']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
        return json_encode($pets);
    }
}
