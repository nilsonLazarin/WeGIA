<?php
require_once'../classes/Entrada.php';
require_once'Conexao.php';
require_once'../Functions/funcoes.php';

class EntradaDAO
{
	public function incluir($entrada){
        try{
            extract($_REQUEST);
            $pdo = Conexao::connect();

            $sql = 'INSERT entrada(id_origem,id_almoxarifado,id_tipo,id_responsavel,data,hora,valor_total) VALUES( :id_origem,:id_almoxarifado,:id_tipo,:id_responsavel,:data,:hora,:valor_total)';
            $sql = str_replace("'", "\'", $sql);            
            $stmt = $pdo->prepare($sql);

            $id_origem = $entrada->get_origem()->getId_origem();
            
            $id_almoxarifado = $entrada->get_almoxarifado()->getId_almoxarifado();
            $id_tipo = $entrada->get_tipo()->getId_tipo();
            $id_responsavel = $entrada->get_responsavel();
            $data = $entrada->getData();
            $hora = $entrada->getHora();
            $valor_total = $entrada->getValor_total();

            $stmt->bindParam(':id_origem',$id_origem);
            $stmt->bindParam(':id_almoxarifado',$id_almoxarifado);
            $stmt->bindParam(':id_tipo',$id_tipo);
            $stmt->bindParam(':id_responsavel',$id_responsavel);
            $stmt->bindParam(':data',$data);
            $stmt->bindParam(':hora',$hora);
            $stmt->bindParam(':valor_total',$valor_total);

            $stmt->execute();
        } catch(PDOExeption $e){
            echo 'Error: <b>  na tabela produto = ' . $sql . '</b> <br /><br />' . $e->getMessage();
        }

    }
	
	public function listarTodos(){

    try{
        $entradas=array();
        $pdo = Conexao::connect();
        $consulta = $pdo->query("SELECT e.id_entrada, o.nome_origem, a.descricao_almoxarifado, t.descricao, p.nome, e.data, e.hora, e.valor_total 
            FROM entrada e 
            INNER JOIN origem o ON o.id_origem = e.id_origem
            INNER JOIN almoxarifado a ON a.id_almoxarifado = e.id_almoxarifado
            INNER JOIN tipo_entrada t ON t.id_tipo = e.id_tipo
            INNER JOIN pessoa p ON p.id_pessoa = e.id_responsavel");
        $x=0;
        while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
            $entradas[$x]=array('id_entrada'=>$linha['id_entrada'],'nome_origem'=>$linha['nome_origem'],'descricao_almoxarifado'=>$linha['descricao_almoxarifado'],'descricao'=>$linha['descricao'],'nome'=>$linha['nome'],'data'=>$linha['data'],'hora'=>$linha['hora'],'valor_total'=>$linha['valor_total']);
            $x++;
        }
        } catch (PDOExeption $e){
            echo 'Error:' . $e->getMessage;
        }
        return json_encode($entradas);
    }
    public function listarUm($id)
        {
             try {
                $pdo = Conexao::connect();
                $sql = "SELECT id_entrada, data, hora, valor_total, id_responsavel FROM entrada where id_entrada = :id_entrada";
                $consulta = $pdo->prepare($sql);
                $consulta->execute(array(
                ':id_entrada' => $id,
            ));
            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $entrada = new Entrada($linha['data'],$linha['hora'],$linha['valor_total'],$linha['id_responsavel']);
                $entrada->setId_entrada($linha['id_entrada']);
            }
            } catch (PDOException $e) {
                throw $e;
            }
            return $entrada;
        }
    public function listarId($id_entrada){
        try{
        $entradas=array();
        $pdo = Conexao::connect();
        $sql = "SELECT e.id_entrada, o.nome_origem, a.descricao_almoxarifado, t.descricao, p.nome, e.data, e.hora, e.valor_total 
            FROM entrada e 
            INNER JOIN origem o ON o.id_origem = e.id_origem
            INNER JOIN almoxarifado a ON a.id_almoxarifado = e.id_almoxarifado
            INNER JOIN tipo_entrada t ON t.id_tipo = e.id_tipo
            INNER JOIN pessoa p ON p.id_pessoa = e.id_responsavel
            WHERE e.id_entrada = :id_entrada";
        $consulta = $pdo->prepare($sql);
        $consulta->execute(array(
            ':id_entrada' => $id_entrada
        ));
        
        while($linha = $consulta->fetch(PDO::FETCH_ASSOC)){
            $entradas[]=array('id_entrada'=>$linha['id_entrada'],'nome_origem'=>$linha['nome_origem'],'descricao_almoxarifado'=>$linha['descricao_almoxarifado'],'descricao'=>$linha['descricao'],'nome'=>$linha['nome'],'data'=>$linha['data'],'hora'=>$linha['hora'],'valor_total'=>$linha['valor_total']);
        }
        } catch (PDOExeption $e){
            echo 'Error:' . $e->getMessage;
        }
        return json_encode($entradas);
    }

    public function ultima(){
        $pdo = Conexao::connect();
        $sql = "SELECT MAX(id_entrada) as id_entrada FROM entrada";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
            $ultima = array('id_entrada'=>$linha['id_entrada']);
        }
        return $ultima;
    }
}
?>
