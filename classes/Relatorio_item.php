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
                $params = $this->param($params, $cont).' origem.nome_origem = "'.$this->getOrigem().'" ';
                $cont++;
            }
            if ($this->getTipo()){
                $params = $this->param($params, $cont).' tipo_entrada.id_tipo = '.$this->getTipo().' ';
                $cont++;
            }
            if ($this->getResponsavel()){
                $params = $this->param($params, $cont).' pessoa.nome = "'.$this->getResponsavel().'" ';
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
            SUM(ientrada.qtd) as qtd_total, produto.descricao, SUM(ientrada.valor_unitario) as valor_total 
            FROM ientrada 
            LEFT JOIN entrada ON entrada.id_entrada = ientrada.id_entrada 
            LEFT JOIN produto ON produto.id_produto = ientrada.id_produto 
            LEFT JOIN origem ON origem.id_origem = entrada.id_origem 
            LEFT JOIN tipo_entrada ON tipo_entrada.id_tipo = entrada.id_tipo 
            LEFT JOIN almoxarifado ON almoxarifado.id_almoxarifado = entrada.id_almoxarifado 
            LEFT JOIN pessoa ON pessoa.id_pessoa = entrada.id_responsavel 
            ".$params."
            GROUP BY produto.descricao
            ;
            ");

        }else{
            $this->setQuery("
            SELECT 
            SUM(ientrada.qtd) as qtd_total, produto.descricao, SUM(ientrada.valor_unitario) as valor_total 
            FROM ientrada 
            LEFT JOIN produto ON produto.id_produto = ientrada.id_produto 
            GROUP BY produto.descricao
            ;
            ");
        }
    }

    private function saida(){
        if ($this->hasValue()){
            $params = "WHERE ";
            $cont = 0;
            if ($this->getDestino()){
                $params = $this->param($params, $cont).' destino.nome_destino = "'.$this->getDestino().'" ';
                $cont++;
            }
            if ($this->getTipo()){
                $params = $this->param($params, $cont).' tipo_saida.id_tipo = '.$this->getTipo().' ';
                $cont++;
            }
            if ($this->getResponsavel()){
                $params = $this->param($params, $cont).' pessoa.nome = "'.$this->getResponsavel().'" ';
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
            SUM(isaida.qtd) as qtd_total, produto.descricao, SUM(isaida.valor_unitario) as valor_total 
            FROM isaida 
            LEFT JOIN saida ON saida.id_saida = isaida.id_saida 
            LEFT JOIN produto ON produto.id_produto = isaida.id_produto 
            LEFT JOIN destino ON destino.id_destino = saida.id_destino 
            LEFT JOIN tipo_saida ON tipo_saida.id_tipo = saida.id_tipo 
            LEFT JOIN almoxarifado ON almoxarifado.id_almoxarifado = saida.id_almoxarifado 
            LEFT JOIN pessoa ON pessoa.id_pessoa = entrada.id_responsavel 
            ".$params."
            GROUP BY produto.descricao
            ;
            ");
        }else{
            $this->setQuery("
            SELECT 
            SUM(isaida.qtd) as qtd_total, produto.descricao, SUM(isaida.valor_unitario) as valor_total 
            FROM isaida 
            LEFT JOIN produto ON produto.id_produto = isaida.id_produto 
            GROUP BY produto.descricao
            ;
            ");
        }
    }

    private function estoque(){
        if ($this->hasValue()){
            $params = "WHERE ";
            $cont = 0;
            if ($this->getAlmoxarifado()){
                $params = $this->param($params, $cont).' almoxarifado.id_almoxarifado = '.$this->getAlmoxarifado().' ';
                $cont++;
            }
            $this->setQuery("
            SELECT
            SUM(estoque.qtd) as qtd_total, produto.descricao, SUM(produto.preco) as valor_total
            from estoque 
            LEFT JOIN produto ON produto.id_produto = estoque.id_produto 
            LEFT JOIN almoxarifado ON almoxarifado.id_almoxarifado = estoque.id_almoxarifado 
            ".$params."
            GROUP BY produto.descricao
            ;
            ");
        }else{
            $this->setQuery("
            SELECT
            SUM(estoque.qtd) as qtd_total, produto.descricao, SUM(produto.preco) as valor_total
            from estoque 
            LEFT JOIN produto ON produto.id_produto = estoque.id_produto 
            GROUP BY produto.descricao
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
        echo($this->getQuery());
    }

    public function display(){
        $this->selecRelatorio();
        $this->query();
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
}