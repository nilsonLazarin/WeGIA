<?php
class ContribuicaoLog
{
    private $id;
    private $valor;
    private $codigo;
    private $dataGeracao;
    private $dataVencimento;
    private $idSocio;
    private $statusPagamento = 0;

    /**
     * Recebe como parâmetro um inteiro e retorna um código de caracteres aleatórios do tamanho informado
     */
    public function gerarCodigo(int $tamanho = 16)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $caracteresTamanho = strlen($caracteres);
        $codigoString = '';
        for ($i = 0; $i < $tamanho; $i++) {
            $codigoString .= $caracteres[rand(0, $caracteresTamanho - 1)];
        }
        return $codigoString;
    }

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
     * Get the value of dataGeracao
     */
    public function getDataGeracao()
    {
        return $this->dataGeracao;
    }

    /**
     * Set the value of dataGeracao
     *
     * @return  self
     */
    public function setDataGeracao($dataGeracao)
    {
        $this->dataGeracao = $dataGeracao;

        return $this;
    }

    /**
     * Get the value of dataVencimento
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * Set the value of dataVencimento
     *
     * @return  self
     */
    public function setDataVencimento($dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;

        return $this;
    }

    /**
     * Get the value of idSocio
     */
    public function getIdSocio()
    {
        return $this->idSocio;
    }

    /**
     * Set the value of idSocio
     *
     * @return  self
     */
    public function setIdSocio($idSocio)
    {
        $this->idSocio = $idSocio;

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
