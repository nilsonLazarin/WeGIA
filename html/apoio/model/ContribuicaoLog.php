<?php
class ContribuicaoLog{
    private $id;
    private $valor;
    private $codigo;
    private $data_geracao;
    private $data_vencimento;
    private $id_socio;
    private $statusPagamento;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of valor
     */ 
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     *
     * @return  self
     */ 
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get the value of codigo
     */ 
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set the value of codigo
     *
     * @return  self
     */ 
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get the value of data_geracao
     */ 
    public function getData_geracao()
    {
        return $this->data_geracao;
    }

    /**
     * Set the value of data_geracao
     *
     * @return  self
     */ 
    public function setData_geracao($data_geracao)
    {
        $this->data_geracao = $data_geracao;

        return $this;
    }

    /**
     * Get the value of data_vencimento
     */ 
    public function getData_vencimento()
    {
        return $this->data_vencimento;
    }

    /**
     * Set the value of data_vencimento
     *
     * @return  self
     */ 
    public function setData_vencimento($data_vencimento)
    {
        $this->data_vencimento = $data_vencimento;

        return $this;
    }

    /**
     * Get the value of id_socio
     */ 
    public function getId_socio()
    {
        return $this->id_socio;
    }

    /**
     * Set the value of id_socio
     *
     * @return  self
     */ 
    public function setId_socio($id_socio)
    {
        $this->id_socio = $id_socio;

        return $this;
    }

    /**
     * Get the value of statusPagamento
     */ 
    public function getStatusPagamento()
    {
        return $this->statusPagamento;
    }

    /**
     * Set the value of statusPagamento
     *
     * @return  self
     */ 
    public function setStatusPagamento($statusPagamento)
    {
        $this->statusPagamento = $statusPagamento;

        return $this;
    }
}