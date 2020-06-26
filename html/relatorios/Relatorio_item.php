<?php
require_once("../dao/Conexao.php");

class Item {

    private $relatorio;
    private $origem;
    private $destino;
    private $tipo;
    private $responsavel;
    private $periodo; // Array('inicio' => data de inicio, 'fim' => data de fim)
    private $almoxarifado;
    private $query;
    private $DDL_cmd;

    // Constructor

    public function __construct($relat, $o_d, $t, $resp, $p, $a){
        $this
            ->setRelatorio($relat)
            ->setOrigem($o_d)
            ->setDestino($o_d)
            ->setTipo($t)
            ->setResponsavel($resp)
            ->setPeriodo($p)
            ->setAlmoxarifado($a)
        ;
    }

    // Metodos

    private function hasValue(){
        return ($this->getOrigem()
        || $this->getTipo()
        || $this->getResponsavel()
        || $this->getPeriodo()['inicio']
        || $this->getPeriodo()['fim']
        || $this->getAlmoxarifado()
    );
    }

    private function param($params, $cont){
        if ($cont){
            return $params.'AND ';
        }
        return $params;
    }

    private function entrada(){
        if ($this->hasValue()){
            $params = "WHERE ";
            $cont = 0;
            if ($this->getOrigem()){
                $params = $this->param($params, $cont).' origem.id_origem = "'.$this->getOrigem().'" ';
                $cont++;
            }
            if ($this->getTipo()){
                $params = $this->param($params, $cont).' tipo_entrada.id_tipo = '.$this->getTipo().' ';
                $cont++;
            }
            if ($this->getResponsavel()){
                $params = $this->param($params, $cont).' pessoa.id_pessoa = "'.$this->getResponsavel().'" ';
                $cont++;
            }
            if ($this->getAlmoxarifado()){
                $params = $this->param($params, $cont).' almoxarifado.id_almoxarifado = '.$this->getAlmoxarifado().' ';
                $cont++;
            }
            if ($this->getPeriodo()['inicio']){
                $params = $this->param($params, $cont)." entrada.data >= '".$this->getPeriodo()['inicio']."' ";
                $cont++;
            }
            if ($this->getPeriodo()['fim']){
                $params = $this->param($params, $cont)." entrada.data <= '".$this->getPeriodo()['fim']."' ";
                $cont++;
            }
            $this->setQuery("
            SELECT 
            SUM(ientrada.qtd) as qtd_total, produto.descricao, SUM(ientrada.qtd*ientrada.valor_unitario) as valor_total, ientrada.valor_unitario 
            FROM ientrada 
            LEFT JOIN produto ON produto.id_produto = ientrada.id_produto 
            LEFT JOIN entrada ON entrada.id_entrada = ientrada.id_entrada 
            LEFT JOIN origem ON origem.id_origem = entrada.id_origem 
            LEFT JOIN tipo_entrada ON tipo_entrada.id_tipo = entrada.id_tipo 
            LEFT JOIN almoxarifado ON almoxarifado.id_almoxarifado = entrada.id_almoxarifado 
            LEFT JOIN pessoa ON pessoa.id_pessoa = entrada.id_responsavel 
            ".$params."
            GROUP BY concat(ientrada.id_produto,ientrada.valor_unitario)
            ;
            ");

        }else{
            $this->setQuery("
            SELECT 
            SUM(ientrada.qtd) as qtd_total, produto.descricao, SUM(ientrada.qtd*ientrada.valor_unitario) as valor_total, ientrada.valor_unitario 
            FROM ientrada 
            LEFT JOIN produto ON produto.id_produto = ientrada.id_produto 
            GROUP BY concat(ientrada.id_produto,ientrada.valor_unitario)
            ;
            ");
        }
    }

    private function saida(){
        if ($this->hasValue()){
            $params = "WHERE ";
            $cont = 0;
            if ($this->getDestino()){
                $params = $this->param($params, $cont).' destino.id_destino = "'.$this->getDestino().'" ';
                $cont++;
            }
            if ($this->getTipo()){
                $params = $this->param($params, $cont).' tipo_saida.id_tipo = '.$this->getTipo().' ';
                $cont++;
            }
            if ($this->getResponsavel()){
                $params = $this->param($params, $cont).' pessoa.id_pessoa = "'.$this->getResponsavel().'" ';
                $cont++;
            }
            if ($this->getAlmoxarifado()){
                $params = $this->param($params, $cont).' almoxarifado.id_almoxarifado = '.$this->getAlmoxarifado().' ';
                $cont++;
            }
            if ($this->getPeriodo()['inicio']){
                $params = $this->param($params, $cont)." saida.data >= '".$this->getPeriodo()['inicio']."' ";
                $cont++;
            }
            if ($this->getPeriodo()['fim']){
                $params = $this->param($params, $cont)." saida.data <= '".$this->getPeriodo()['fim']."' ";
                $cont++;
            }

            $this->setQuery("
            SELECT 
            SUM(isaida.qtd) as qtd_total, produto.descricao, SUM(isaida.qtd*isaida.valor_unitario) as valor_total, isaida.valor_unitario 
            FROM isaida 
            LEFT JOIN produto ON produto.id_produto = isaida.id_produto 
            LEFT JOIN saida ON saida.id_saida = isaida.id_saida 
            LEFT JOIN destino ON destino.id_destino = saida.id_destino 
            LEFT JOIN tipo_saida ON tipo_saida.id_tipo = saida.id_tipo 
            LEFT JOIN almoxarifado ON almoxarifado.id_almoxarifado = saida.id_almoxarifado 
            LEFT JOIN pessoa ON pessoa.id_pessoa = saida.id_responsavel 
            ".$params."
            GROUP BY concat(isaida.id_produto,isaida.valor_unitario)
            ;
            ");
        }else{
            $this->setQuery("
            SELECT 
            SUM(isaida.qtd) as qtd_total, produto.descricao, SUM(isaida.qtd*isaida.valor_unitario) as valor_total, ientrada.valor_unitario 
            FROM isaida 
            LEFT JOIN produto ON produto.id_produto = isaida.id_produto 
            GROUP BY concat(isaida.id_produto,isaida.valor_unitario)
            ;
            ");
        }
    }

    private function estoque(){
        if ($this->hasValue()){
            $params = "WHERE ";
            $cont = 0;
            if ($this->getAlmoxarifado()){
                $params = $this->param($params, $cont).' id_almoxarifado = '.$this->getAlmoxarifado().' ';
                $cont++;
            }
            $this->setDDL_cmd("
            CREATE TEMPORARY TABLE IF NOT EXISTS tabela1 
            SELECT produto.id_produto, sum(qtd) as somatorio, produto.descricao, (sum(qtd) * ientrada.valor_unitario) as Total, 
            concat(ientrada.id_produto,valor_unitario) as kungfu 
            FROM ientrada, produto 
            WHERE ientrada.id_produto=produto.id_produto 
            GROUP by kungfu 
            ORDER by produto.descricao;
            
            CREATE TEMPORARY TABLE IF NOT EXISTS tabela2 
            SELECT id_produto, (sum(Total)/sum(somatorio)) AS PrecoMedio 
            FROM tabela1 
            GROUP by tabela1.descricao;
            
            CREATE TEMPORARY TABLE IF NOT EXISTS estoque_com_preco_atualizado 
            SELECT estoque.id_produto, id_categoria_produto, id_unidade, codigo, qtd, descricao, PrecoMedio, (qtd*PrecoMedio) as Total, almoxarifado.id_almoxarifado
            FROM tabela2,estoque,produto,almoxarifado
            WHERE produto.id_produto=estoque.id_produto AND estoque.id_produto=tabela2.id_produto AND estoque.id_almoxarifado=almoxarifado.id_almoxarifado;
            ");
            $this->setQuery("
            SELECT qtd AS qtd_total, descricao, Total AS valor_total, PrecoMedio FROM estoque_com_preco_atualizado 
            ".$params."
            ;
            ");
        }else{
            $this->setDDL_cmd("
            CREATE TEMPORARY TABLE IF NOT EXISTS tabela1 
            SELECT produto.id_produto, sum(qtd) as somatorio, produto.descricao, (sum(qtd) * ientrada.valor_unitario) as Total, 
            concat(ientrada.id_produto,valor_unitario) as kungfu 
            FROM ientrada, produto 
            WHERE ientrada.id_produto=produto.id_produto 
            GROUP by kungfu 
            ORDER by produto.descricao;

            CREATE TEMPORARY TABLE IF NOT EXISTS tabela2 
            SELECT id_produto, (sum(Total)/sum(somatorio)) AS PrecoMedio 
            FROM tabela1 
            GROUP by tabela1.descricao;
            
            CREATE TEMPORARY TABLE IF NOT EXISTS estoque_com_preco_atualizado 
            SELECT estoque.id_produto, id_categoria_produto, id_unidade, codigo, qtd, descricao, PrecoMedio, (qtd*PrecoMedio) as Total
            FROM tabela2,estoque,produto
            WHERE produto.id_produto=estoque.id_produto AND estoque.id_produto=tabela2.id_produto;
            ");
            $this->setQuery("
            SELECT qtd AS qtd_total, descricao, Total AS valor_total, PrecoMedio FROM estoque_com_preco_atualizado;
            ;
            ");
        }
    }

    private function selecRelatorio(){
        switch ($this->getRelatorio()) {
            case 'entrada':
                $this->entrada();
            break;
            case 'saida':
                $this->saida();
            break;
            case 'estoque':
                $this->estoque();
            break;
        }
    }

    private function query(){
        $pdo = Conexao::connect();
        if ($this->getDDL_cmd()){
            $pdo->exec($this->getDDL_cmd());
        }
        $res = $pdo->query($this->getQuery());
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function display(){
        $this->selecRelatorio();
        $query = $this->query();
        $tot_val = 0;
        foreach ($query as $item){
            if ($this->getRelatorio() == 'estoque'){
                echo('
                    <tr>
                        <td scope="row">'.$item['qtd_total'].'</td>
                        <td>'.$item['descricao'].'</td>
                        <td>R$'.number_format($item['PrecoMedio'],2).'</td>
                    </tr>
                ');
            }else{
                echo('
                    <tr>
                        <td scope="row">'.$item['qtd_total'].'</td>
                        <td>'.$item['descricao'].'</td>
                        <td>R$'.number_format($item['valor_unitario'],2).'</td>
                        <td>R$'.number_format($item['valor_total'],2).'</td>
                    </tr>
                ');
            }
            $tot_val += $item['valor_total'];
        }
        echo('
        <tr class="table-info">
            <td scope="row" colspan="'.($this->getRelatorio() == 'estoque' ? 2 : 3 ).'">Valor total:</td>
            <td>R$'.number_format($tot_val,2).'</td>
        </tr>
        ');
    }

    // Getters e Setters

    public function getRelatorio()
    {
        return $this->relatorio;
    }

    public function setRelatorio($relatorio)
    {
        $this->relatorio = $relatorio;

        return $this;
    }

    public function getOrigem()
    {
        return $this->origem;
    }

    public function setOrigem($origem)
    {
        $this->origem = $origem;

        return $this;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getResponsavel()
    {
        return $this->responsavel;
    }

    public function setResponsavel($responsavel)
    {
        $this->responsavel = $responsavel;

        return $this;
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    public function getAlmoxarifado()
    {
        return $this->almoxarifado;
    }

    public function setAlmoxarifado($almoxarifado)
    {
        $this->almoxarifado = $almoxarifado;

        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    public function getDestino()
    {
        return $this->destino;
    }

    public function setDestino($destino)
    {
        $this->destino = $destino;

        return $this;
    }

    public function getDDL_cmd()
    {
        return $this->DDL_cmd;
    }

    public function setDDL_cmd($DDL_cmd)
    {
        $this->DDL_cmd = $DDL_cmd;

        return $this;
    }
}