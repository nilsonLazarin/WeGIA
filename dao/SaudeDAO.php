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
            //$sql = str_replace("'", "\'", $sql); 
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
    public function listarTodos(){

        try{
            $pacientes=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT p.nome,s.descricao,p.sobrenome FROM pessoa p INNER JOIN saude_fichamedica s ON s.id_pessoa = p.id_pessoa");
            // $produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
            
                $pacientes[$x]=array('nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'descricao'=>$linha['descricao']);
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
            /*$sql = "SELECT p.imagem,p.nome,p.sobrenome,p.cpf, p.senha, p.sexo, p.telefone,p.data_nascimento, p.cep,p.estado,p.cidade,p.bairro,p.logradouro,p.numero_endereco,p.complemento,p.ibge,p.registro_geral,p.orgao_emissor,p.data_expedicao,p.nome_pai,p.nome_mae,p.tipo_sanguineo, d.id_documento FROM pessoa p LEFT JOIN atendido a ON p.id_pessoa = a.pessoa_id_pessoa left join documento d on p.id_pessoa=d.id_pessoa WHERE a.idatendido=:id";*/

            // tah listando o nome da última pessoa //
            $sql = "SELECT p.imagem,p.nome,p.sobrenome,p.sexo,p.tipo_sanguineo FROM pessoa p LEFT JOIN atendido a ON p.id_pessoa = a.pessoa_id_pessoa LEFT JOIN saude_fichamedica sf ON a.pessoa_id_pessoa = sf.id_pessoa WHERE sf.id_fichamedica=:id";
            
            // $teste = "SELECT id_pessoa FROM pessoa p JOIN atendido a ON (p.id_pessoa "

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id',$id);

            $stmt->execute();
            $pessoa=array();
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // estava cpf aqui no linha//
                // esse não informado eh uma funcao que esta no informações atendido, ou seja, posso pegar e colocar a desc no lugar do cpf//
                //if ($linha['nome']==="Não informado") {
                $pessoa[]=array('imagem'=>$linha['imagem'],'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'sexo'=>$linha['sexo'],'tipo_sanguineo'=>$linha['tipo_sanguineo'],'id_fichamedica'=>$linha['id_fichamedica'],'imgdoc'=>$linha['imgdoc'],'descricao'=>$linha['descricao']);
                
                //}
                // else{
                //     $pessoa[]=array('imagem'=>$linha['imagem'],'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'sexo'=>$linha['sexo'],'tipo_sanguineo'=>$linha['tipo_sanguineo'],'id_fichamedica'=>$linha['id_fichamedica'],'imgdoc'=>$linha['imgdoc'],'descricao'=>$linha['descricao']);
                // }
        }
        }catch (PDOExeption $e){
            echo 'Error: ' .  $e->getMessage();
        }
        return json_encode($pessoa);
    }
}
