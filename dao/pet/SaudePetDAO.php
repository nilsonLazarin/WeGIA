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
    public function incluir($saudePet){
        try {
            $id_pet = $saudePet->getNome();
            $castrado = $saudePet->getCastrado();
            $necEsp = $saudePet->getTexto();
            $vacinado = $saudePet->getVacinado();
            $vermifugado = $saudePet->getVermifugado();

            $pdo = Conexao::connect();
                    
            $sql = "INSERT INTO pet_ficha_medica(id_pet, castrado, necessidades_especiais) 
                    VALUES(:id_pet,:castrado,:necessidades_especiais)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id_pet',$id_pet);
            $stmt->bindParam(':castrado',$castrado);
            $stmt->bindParam(':necessidades_especiais',$necEsp);
            $stmt->execute();

            $this->incluirVacinaVermifugo($pdo);

            $pd = $pdo->prepare("SELECT id_ficha_medica FROM pet_ficha_medica 
                      WHERE id_pet = :id_pet");
            $pd->bindParam(":id_pet", $id_pet);
            $pd->execute();
            $p = $pd->fetch();
            $fmp = $p['id_ficha_medica'];

            if($vacinado == 's'){
                $dataVacinado = $saudePet->getDataVacinado();

                $pd = $pdo->prepare("SELECT id_vacina FROM pet_vacina");
                $pd->execute();
                $p = $pd->fetch();
                $id_vacina = $p['id_vacina'];

                $pd = $pdo->prepare("INSERT INTO pet_vacinacao(id_vacina, id_ficha_medica, 
                      data_vacinacao) VALUES(:id_vacina, :id_ficha_medica, :data_vacinacao)");
                $pd->bindValue("id_vacina", $id_vacina);
                $pd->bindValue("id_ficha_medica", $fmp);
                $pd->bindValue(':data_vacinacao', $dataVacinado);
                $pd->execute();
            }

            if($vermifugado == 's'){
                $dataVermifugado = $saudePet->getDataVermifugado();

                $pd = $pdo->prepare("SELECT id_vermifugo FROM pet_vermifugo");
                $pd->execute();
                $p = $pd->fetch();
                $id_vermifugo = $p['id_vermifugo'];

                $pd = $pdo->prepare("INSERT INTO pet_vermifugacao(id_vermifugo, id_ficha_medica_vermifugo, 
                      data_vermifugacao) VALUES(:id_vermifugo, :id_ficha_medica_vermifugo, :data_vermifugacao)");
                $pd->bindValue("id_vermifugo", $id_vermifugo);
                $pd->bindValue("id_ficha_medica_vermifugo", $fmp);
                $pd->bindValue(':data_vermifugacao',$dataVermifugado);
                $pd->execute();
            }
            
            header('Location: ../../html/pet/informacao_saude_pet.php');
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pet_ficha_medica = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }        
    }

    public function incluirVacinaVermifugo($pdo){
        $pd = $pdo->prepare("SELECT COUNT(id_vacina) AS total FROM pet_vacina");
        $pd->execute();
        $p = $pd->fetch();

        if( $p['total'] == '0'){
            $pd = $pdo->prepare("INSERT INTO pet_vacina(nome,marca) VALUES( 'Vacina V3', 'genérica')");
            $pd->execute();
        }

        $pd = $pdo->prepare("SELECT COUNT(id_vermifugo) AS total FROM pet_vermifugo");
        $pd->execute();
        $p = $pd->fetch();
        
        if( $p['total'] == '0'){
            $pd = $pdo->prepare("INSERT INTO pet_vermifugo(nome,marca) VALUES( 'Vermivet Composto', 'Biovet')");
            $pd->execute();
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

    public function getPet($id_pet){
        $pdo = Conexao::connect();
        
        $pd = $pdo->prepare( "SELECT nome AS 'nome' FROM pet WHERE id_pet = :id_pet");

        $pd->bindValue('id_pet', $id_pet);
        $pd->execute();
        $p = $pd->fetch();
            
        return $p;
    }
}
