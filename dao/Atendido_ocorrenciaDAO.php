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
            $consulta = $pdo->query("SELECT ao.idatendido_ocorrencias, p.nome, p.sobrenome, ao.data, ao.atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos FROM pessoa p INNER JOIN atendido a ON(p.id_pessoa=a.pessoa_id_pessoa) INNER JOIN atendido_ocorrencia ao ON (a.idatendido=ao.atendido_idatendido)");
            // $produtos = Array();
            $x=0;
            while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
            
                $ocorrencias[$x]=array('idatendido_ocorrencias'=>$linha['idatendido_ocorrencias'],'nome'=>$linha['nome'],'sobrenome'=>$linha['sobrenome'],'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos'=>$linha['atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos'], 'data'=>$linha['data']);
                $x++;
            }
            //$pdo->commit();
            //$pdo->close();
            } catch (PDOException $e){
                echo 'Error:' . $e->getMessage();
            }
            return json_encode($ocorrencias);
    }


	public function listarTodosComAnexo($id_ocorrencia)
	{
        /*Função não está sendo utilizada em nenhum local da aplicação. */
		try
		{
			$Despachos = array();
			$pdo = Conexao::connect();
			$consulta = $pdo->query("SELECT arquivo FROM atendido_ocorrencia_doc  WHERE idatendido_ocorrencia_doc=$id_memorando");
			$x = 0;

			while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) 
			{
				$Despachos[$x] = array('idatendido_ocorrencia_doc'=>$linha['idatendido_ocorrencia_doc']);
				$x++;
			}
		}
		catch(PDOException $e)
		{
			echo 'Error:' . $e->getMessage();
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
            
        } catch (PDOException $e) {
            echo 'Error: <b>  na tabela pessoas = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }
    }

    public function listarAnexo($id_anexo)
	{
		try
		{	
			$Anexo = array();
			$pdo = Conexao::connect();
			$consulta = $pdo->query("SELECT arquivo FROM arquivo_atendido_doc WHERE idatendido_ocorrencia_doc=$id_anexo");
			$x = 0;

			while($linha = $consulta->fetch(PDO::FETCH_ASSOC))
			{
				$AnexoDAO = new Atendido_ocorrenciaDAO;
				$decode = gzuncompress($linha['arquivo']);
				$Anexo[$x] = array('arquivo'=>$decode);
				$x++;
			}
		}
		catch(PDOException $e)
		{
			echo 'Error:' . $e->getMessage();
		}
		return $Anexo;
	}

    public function listar($id){
        try{
            echo $id;
            $pdo = Conexao::connect();
            // $sql = "SELECT atendido_idatendido, atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos, funcionario_id_funcionario, data, descricao FROM atendido_ocorrencia WHERE idatendido_ocorrencias= :id";
            $sql = "SELECT p.nome as nome_atendido, p.sobrenome as sobrenome_atendido,ao.data,ao.descricao as descricao_tipo,aod.arquivo_nome, aod.arquivo_extensao, ao.idatendido_ocorrencias, aod.arquivo,pp.nome as func,aot.descricao as descricao_ocorrencia from pessoa p join atendido a on (a.pessoa_id_pessoa = p.id_pessoa)
            join atendido_ocorrencia ao on (ao.atendido_idatendido = a.idatendido)
            join atendido_ocorrencia_tipos aot on (ao.atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos = aot.idatendido_ocorrencia_tipos) 
            join funcionario f on (ao.funcionario_id_funcionario = f.id_funcionario)
            join pessoa pp on (f.id_pessoa = pp.id_pessoa)
            join atendido_ocorrencia_doc aod on (aod.atentido_ocorrencia_idatentido_ocorrencias = ao.idatendido_ocorrencias)
            where ao.idatendido_ocorrencias = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $paciente=array();
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {

                // $paciente[]=array('atendido_idatendido'=>$linha['atendido_idatendido'],'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos'=>$linha['atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos'],'funcionario_id_funcionario'=>$linha['funcionario_id_funcionario'],'data'=>$linha['data'], 'descricao'=>$linha['descricao']);
                $paciente[]=array('nome_atendido'=>$linha['nome_atendido'],'arquivo_nome'=>$linha['arquivo_nome'],'arquivo_extensao'=>$linha['arquivo_extensao'],'idatendido_ocorrencias'=>$linha['idatendido_ocorrencias'],'sobrenome_atendido'=>$linha['sobrenome_atendido'],'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos'=>$linha['descricao_tipo'],'funcionario_id_funcionario'=>$linha['func'],
                'data'=>$linha['data'], 'descricao'=>$linha['descricao_ocorrencia']);
            }
        }catch (PDOException $e){
            echo 'Error: ' .  $e->getMessage();
        }
        return json_encode($paciente);
    }

}
?>
