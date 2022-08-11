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
    /*public function alterarImagem($id_fichamedica, $imagem)
    {
        $imagem = base64_encode($imagem);
        try {
            $pdo = Conexao::connect();
            $id_pessoa = (($pdo->query("SELECT id_pessoa FROM saudePet_fichamedica WHERE id_fichamedica=$id_fichamedica"))->fetch(PDO::FETCH_ASSOC))["id_pessoa"];
            
            $sql = "UPDATE pessoa SET imagem = :imagem WHERE id_pessoa = :id_pessoa;";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id_pessoa', $id_pessoa);
            $stmt->bindValue(':imagem',$imagem);
            $stmt->execute();
            $pdo->commit();
            $pdo->close();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoa = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }*/
    /*public function alterar($saudePet)
    {
        try {
            $sql = 'update pessoa as p inner join saudePet_fichamedica as sf on p.id_pessoa=sf.id_pessoa set p.imagem=:imagem where sf.id_pessoa=:id_pessoa';
            
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // $nome=$atendido->getNome();
            // $sobrenome=$atendido->getSobrenome();
            // $cpf=$atendido->getCpf();
            // $sexo=$atendido->getSexo();
            // $telefone=$atendido->getTelefone();
            // $nascimento=$atendido->getDataNascimento();

            // $stmt->bindParam('nome',$nome);
            // $stmt->bindParam('sobrenome',$sobrenome);
            // $stmt->bindParam(':cpf',$cpf);
            // $stmt->bindParam(':sexo',$sexo);
            // $stmt->bindParam(':telefone',$telefone);
            // $stmt->bindParam(':data_nascimento',$nascimento);
            $stmt->execute();
            $pdo->commit();
            $pdo->close();

            // mysqli_stmt_close($stmt);
            // mysqli_close($pdo);
            
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
   
*/

    public function listarTodos(){

        try{
            $pets=array();
            $pdo = Conexao::connect();
            $pd = $pdo->query("SELECT fm.id_ficha_medica AS 'id_ficha_medica', p.id_pet AS 'id', p.nome AS 'nome', pr.descricao AS 'raca',
            pc.descricao AS 'cor', fm.necessidades_especiais AS 'necessidades_especiais' FROM pet p INNER JOIN pet_ficha_medica fm ON fm.id_pet = p.id_pet JOIN pet_raca pr ON p.id_pet_raca = pr.id_pet_raca JOIN pet_cor pc ON p.id_pet_cor = pc.id_pet_cor");
            $pd->execute();
            $x=0;
            while($linha = $pd->fetch(PDO::FETCH_ASSOC)){
            
                $pets[$x]=array('id_ficha_medica'=>$linha['id_ficha_medica'],'nome'=>$linha['nome'],'raca'=>$linha['raca'],'cor'=>$linha['cor'],'necessidades_especiais'=>$linha['necessidades_especiais']);
                $x++;
            }
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($pets);
    }

    public function listar($id){
        try{
            echo $id;
            $pdo = Conexao::connect();
            /*$sql = "SELECT p.imagem,p.nome,p.sobrenome,p.cpf, p.senha, p.sexo, p.telefone,p.data_nascimento, p.cep,p.estado,p.cidade,p.bairro,p.logradouro,p.numero_endereco,p.complemento,p.ibge,p.registro_geral,p.orgao_emissor,p.data_expedicao,p.nome_pai,p.nome_mae,p.tipo_sanguineo, d.id_documento FROM pessoa p LEFT JOIN atendido a ON p.id_pessoa = a.pessoa_id_pessoa left join documento d on p.id_pessoa=d.id_pessoa WHERE a.idatendido=:id";*////

            $sql = "SELECT p.castrado,p.sobrenome,p.imagem,p.sexo,p.data_nascimento,p.tipo_sanguineo FROM pessoa p 
            JOIN saudePet_fichamedica sf ON p.id_pessoa = sf.id_pessoa 
            WHERE sf.id_fichamedica=:id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id',$id);

            $stmt->execute();
            $paciente=array();
            // $pacienteFuncionario=array();
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $paciente[]=array('nome'=>$linha['nome'],'imagem'=>$linha['imagem'],'sobrenome'=>$linha['sobrenome'],'sexo'=>$linha['sexo'],'data_nascimento'=>$linha['data_nascimento'], 'tipo_sanguineo'=>$linha['tipo_sanguineo']);

            }
        }catch (PDOExeption $e){
            echo 'Error: ' .  $e->getMessage();
        }
        return json_encode($paciente);
        // return json_encode($pacienteFuncionario);
    }

    public function alterarInfPessoal($paciente)
    {
        try {
            $sql = 'update pessoa as p inner join saudePet_fichamedica as s on p.id_pessoa=s.id_pessoa set tipo_sanguineo=:tipo_sanguineo where id_fichamedica=:id_fichamedica';
            
            $sql = str_replace("'", "\'", $sql);
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            $stmt = $pdo->prepare($sql);
            $id_fichamedica=$paciente->getId_pessoa();
            $tipoSanguineo=$paciente->getTipoSanguineo();
            $stmt->bindParam(':id_fichamedica',$id_fichamedica);
            $stmt->bindParam(':tipo_sanguineo',$tipoSanguineo);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }
    
}
