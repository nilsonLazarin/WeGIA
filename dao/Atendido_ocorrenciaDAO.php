<!-- BEGIN 
		declare ido int;
        INSERT INTO atendido_ocorrencia(atendido_idatendido, atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos, funcionario_id_funcionario, data, descricao)
        values (idatendido, id_ocorrencia, id_funcionario, data, descricao);
	
        SELECT max(id_ocorrencia) into ido from atendido_ocorrencia;
        
END
INSERT INTO `atendido_ocorrencia` (`idatendido_ocorrencias`, `atendido_idatendido`, `atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos`, `funcionario_id_funcionario`, `data`, `descricao`) VALUES ('1', '4', '1', '1', '2021-11-11', 'lalallalala'); -->
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
require_once ROOT."/classes/Atendido_ocorrencia.php";
require_once ROOT."/Functions/funcoes.php";
require_once ROOT."/dao/Atendido_ocorrenciaDAO.php";



class Atendido_ocorrenciaDAO
{
	public function listarTodos(){

        try{
            $ocorrencias=array();
            $pdo = Conexao::connect();
            $consulta = $pdo->query("SELECT p.nome, p.sobrenome, ao.data, ao.atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos FROM pessoa p INNER JOIN atendido a ON(p.id_pessoa=a.pessoa_id_pessoa) INNER JOIN atendido_ocorrencia ao ON (a.idatendido=ao.atendido_idatendido)");
            // $produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
            
                $ocorrencias[$x]=array('nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos'=>$linha['atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos'], 'data'=>$linha['data']);
                $x++;
            }
            //$pdo->commit();
            //$pdo->close();
            } catch (PDOExeption $e){
                echo 'Error:' . $e->getMessage;
            }
            return json_encode($ocorrencias);
    }


	public function listarTodosComAnexo($id_ocorrencia)
	{
		try
		{
			$Despachos = array();
			$pdo = Conexao::connect();
			$consulta = $pdo->query("SELECT DISTINCT d.id_despacho FROM despacho d JOIN anexo a ON(d.id_despacho=a.id_despacho) JOIN memorando m ON(d.id_memorando=m.id_memorando) WHERE d.id_memorando=$id_memorando");
			$x = 0;

			while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) 
			{
				$Despachos[$x] = array('id_despacho'=>$linha['id_despacho']);
				$x++;
			}
		}
		catch(PDOExeption $e)
		{
			echo 'Error:' . $e->getMessage;
		}

		return json_encode($Despachos);
	}

	
		public function incluir($ocorrencia)
    {               
        try {
            $sql = "INSERT INTO `atendido_ocorrencia` (`idatendido_ocorrencias`, `atendido_idatendido`, `atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos`, `funcionario_id_funcionario`, `data`, `descricao`) values (default, :atendido_idatendido, :id_tipos_ocorrencia, :funcionario_idfuncionario, :datao, :descricao)";
            //$sql = str_replace("'", "\'", $sql); 
            $pdo = Conexao::connect();
            $stmt = $pdo->prepare($sql);
            // $idatendido_ocorrencias=$ocorrencia->getIdatendido_ocorrencias();
            $atendido_idatendido=$ocorrencia->getAtendido_idatendido();
            $id_tipos_ocorrencia=$ocorrencia->getId_tipos_ocorrencia();
            $funcionario_idfuncionario=$ocorrencia->getFuncionario_idfuncionario();
            $datao=$ocorrencia->getData();
            $descricao=$ocorrencia->getDescricao();
			
			
            $stmt->bindParam(':descricao',$descricao);
            $stmt->bindParam(':atendido_idatendido',$atendido_idatendido);
			$stmt->bindParam(':funcionario_idfuncionario',$funcionario_idfuncionario);
            $stmt->bindParam(':id_tipos_ocorrencia',$id_tipos_ocorrencia);
			// $stmt->bindParam(':idatendido_ocorrencias',$id_atendido_ocorrencias);
            $stmt->bindParam(':datao',$datao);
			// $stmt->bindParam(':nome',$nome);
            $stmt->execute();
            $pdo->commit();
            $pdo->close();
            
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
        
    }

}
?>
