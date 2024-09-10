<?php
class RegraPagamento
{
    private $meioPagamentoId;
    private $regraContribuicaoId;
    private $valor;

    /**
     * Instancia um objeto do tipo RegraPagamentoDAO e chama o seu método de cadastrar passando os 
     * valores de $meioPagamentoId, $regraContribuicaoId e $valor como parâmetros
     */
    public function cadastrar(){
        require_once '../dao/RegraPagamentoDAO.php';
        $gatewayPagamentoDao = new RegraPagamentoDAO();
        $gatewayPagamentoDao->cadastrar($this->meioPagamentoId, $this->regraContribuicaoId, $this->valor);
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
        $valor = floatval($valor);

        if(!$valor || $valor < 0){
            throw new InvalidArgumentException();
        }
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get the value of regraContribuicaoId
     */
    public function getRegraContribuicaoId()
    {
        return $this->regraContribuicaoId;
    }

    /**
     * Set the value of regraContribuicaoId
     *
     * @return  self
     */
    public function setRegraContribuicaoId($regraContribuicaoId)
    {
        $regraContribuicaoIdLimpo = trim($regraContribuicaoId);

        if(!$regraContribuicaoIdLimpo || $regraContribuicaoIdLimpo <1){
            throw new InvalidArgumentException();
        }
        $this->regraContribuicaoId = $regraContribuicaoIdLimpo;

        return $this;
    }

    /**
     * Get the value of meioPagamentoId
     */ 
    public function getMeioPagamentoId()
    {
       return $this->meioPagamentoId;
    }

    /**
     * Set the value of meioPagamentoId
     *
     * @return  self
     */ 
    public function setMeioPagamentoId($meioPagamentoId)
    {
        $meioPagamentoIdLimpo = trim($meioPagamentoId);

        if(!$meioPagamentoIdLimpo || $meioPagamentoIdLimpo <1){
            throw new InvalidArgumentException();
        }
        $this->meioPagamentoId = $meioPagamentoIdLimpo;

        return $this;
    }
}
