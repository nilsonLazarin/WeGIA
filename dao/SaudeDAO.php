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
require_once ROOT."/classes/Saude.php";
require_once ROOT."/Functions/funcoes.php";

class SaudeDAO
{
    public function incluir($saude)
    {               
        try {
            $sql = "call saude_cad_fichamedica(:nome,:descricao)";
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            $nome=$saude->getNome();
            $descricao=$saude->getTexto();
            $stmt->bindParam(':nome',$nome);
            $stmt->bindParam(':descricao',$descricao);
            $stmt->execute();
            $pdo->commit();
            $pdo->close();
            
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
        
    }
    public function alterarImagem($id_fichamedica, $imagem)
    {
        $imagem = base64_encode($imagem);
        try {
            $pdo = Conexao::connect();
            $id_pessoa = (($pdo->query("SELECT id_pessoa FROM saude_fichamedica WHERE id_fichamedica=$id_fichamedica"))->fetch(PDO::FETCH_ASSOC))["id_pessoa"];
            
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
    }
    public function alterar($saude)
    {
        try {
            $sql = 'update pessoa as p inner join saude_fichamedica as sf on p.id_pessoa=sf.id_pessoa set p.imagem=:imagem where sf.id_pessoa=:id_pessoa';
            
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
   

    public function listarTodos(){

        try{
            $pacientes=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT s.id_fichamedica,p.imagem,p.nome,s.descricao,p.sobrenome FROM pessoa p INNER JOIN saude_fichamedica s ON s.id_pessoa = p.id_pessoa");
            // $produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
            
                $pacientes[$x]=array('id_fichamedica'=>$linha['id_fichamedica'], 'imagem'=>$linha['imagem'],'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'descricao'=>$linha['descricao']);
                $x++;
            }
            //$pdo->commit();
            //$pdo->close();
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($pacientes);
    }

    public function listar($id){
        try{
            echo $id;
            $pdo = Conexao::connect();
            /*$sql = "SELECT p.imagem,p.nome,p.sobrenome,p.cpf, p.senha, p.sexo, p.telefone,p.data_nascimento, p.cep,p.estado,p.cidade,p.bairro,p.logradouro,p.numero_endereco,p.complemento,p.ibge,p.registro_geral,p.orgao_emissor,p.data_expedicao,p.nome_pai,p.nome_mae,p.tipo_sanguineo, d.id_documento FROM pessoa p LEFT JOIN atendido a ON p.id_pessoa = a.pessoa_id_pessoa left join documento d on p.id_pessoa=d.id_pessoa WHERE a.idatendido=:id";*////

            $sql = "SELECT p.nome,p.sobrenome,p.imagem,p.sexo,p.data_nascimento,p.tipo_sanguineo FROM pessoa p 
            JOIN saude_fichamedica sf ON p.id_pessoa = sf.id_pessoa 
            WHERE sf.id_fichamedica=:id";
            // $sql = "SELECT nome from pessoa where id ='1'";

            // $sql = "SELECT p.nome, p.sobrenome, p.sexo, p.data_nascimento FROM pessoa p JOIN funcionario f ON p.id_pessoa=f.id_pessoa JOIN saude_fichamedica sf ON f.id_pessoa = sf.id_pessoa WHERE sf.id_fichamedica=:id";
            // o tipo sanguinio e a imagem vou ter que pegar de outra forma //

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id',$id);

            $stmt->execute();
            $paciente=array();
            // $pacienteFuncionario=array();
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $paciente[]=array('nome'=>$linha['nome'],'imagem'=>$linha['imagem'],'sobrenome'=>$linha['sobrenome'],'sexo'=>$linha['sexo'],'data_nascimento'=>$linha['data_nascimento'], 'tipo_sanguineo'=>$linha['tipo_sanguineo']);
                // $paciente[]=array('nome'=>$linha['nome']);
                // $pacienteFuncionario[]=array('nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'sexo'=>$linha['sexo'],'data_nascimento'=>$linha['data_nascimento']);
                // 'imagem'=>$linha['imagem']
                // 'tipo_sanguineo'=>$linha['tipo_sanguineo']
                // 'id_fichamedica'=>$linha['id_fichamedica']

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
            $sql = 'update pessoa as p inner join saude_fichamedica as s on p.id_pessoa=s.id_pessoa set tipo_sanguineo=:tipo_sanguineo where id_fichamedica=:id_fichamedica';
            
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
