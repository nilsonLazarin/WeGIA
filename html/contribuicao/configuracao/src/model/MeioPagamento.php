<?php
class MeioPagamento{
    private $id;
    private $descricao;
    private $gatewayId;

    public function __construct($descricao, $gatewayId)
    {
        $this->setDescricao($descricao);
        $this->setGatewayId($gatewayId);
    }

    /**
     * Pega os atributos $descricao e $gatewayId e realiza os procedimentos necessários para
     * inserir um novo meio de pagamento no sistema da aplicação.
     */
    public function cadastrar(){
        require_once '../dao/MeioPagamentoDAO.php';
        $meioPagamentoDao = new MeioPagamentoDAO();
        $meioPagamentoDao->cadastrar($this->descricao, $this->gatewayId);
    }

    /**
     * Get the value of descricao
     */ 
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     *
     * @return  self
     */ 
    public function setDescricao($descricao)
    {
        $descricaoLimpa = trim($descricao);
        if(!$descricaoLimpa || empty($descricaoLimpa)){
            throw new InvalidArgumentException();
        }

        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get the value of gatewayId
     */ 
    public function getGatewayId()
    {
        return $this->gatewayId;
    }

    /**
     * Set the value of gatewayId
     *
     * @return  self
     */ 
    public function setGatewayId($gatewayId)
    {
        if(!$gatewayId || $gatewayId < 1){
            throw new InvalidArgumentException();
        }

        $this->gatewayId = $gatewayId;

        return $this;
    }
}