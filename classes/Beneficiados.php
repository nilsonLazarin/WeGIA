<?php

class Beneficiados
{
    //Atributos
    private $id_beneficiados;
    private $id_pessoa;
    private $id_beneficios;
    private $data_inicio;
    private $data_fim;
    private $beneficios_status;
    private $valor;

    /**
     * Retorna o id de um beneficiado
     */
    public function getId_Beneficiados()
    {
        return $this->id_beneficiados;
    }

    /**
     * Retorna o id de uma pessoa
     */
    public function getId_pessoa()
    {
        return $this->id_pessoa;
    }

    /**
     * Retorna o id de um benefício
     */
    public function getId_beneficios()
    {
        return $this->id_beneficios;
    }

    /**
     * Retorna a data de início de um benefício
     */
    public function getData_inicio()
    {
        return $this->data_inicio;
    }

    /**
     * Retorna a data final de um benefício
     */
    public function getData_fim()
    {
        return $this->data_fim;
    }

    /**
     * Retorna o status de um benefício
     */
    public function getBeneficios_status()
    {
        return $this->beneficios_status;
    }

    /**
     * Retorna o valor de um benefício
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Define o id de um beneficiado
     */
    public function setId_beneficiados($id_beneficiados)
    {
        if (!$id_beneficiados || !is_numeric($id_beneficiados) || $id_beneficiados < 1) {
            throw new InvalidArgumentException('O id de um beneficiado deve ser um inteiro positivo maior ou igual a 1.');
        }
        $this->id_beneficiados = $id_beneficiados;
    }

    /**
     * Define o id de uma pessoa
     */
    public function setId_pessoa($id_pessoa)
    {
        if (!$id_pessoa || !is_numeric($id_pessoa) || $id_pessoa < 1) {
            throw new InvalidArgumentException('O id de uma pessoa deve ser um inteiro positivo maior ou igual a 1.');
        }
        $this->id_pessoa = $id_pessoa;
    }

    /**
     * Define o id de um benefício
     */
    public function setId_beneficios($id_beneficios)
    {
        if (!$id_beneficios || !is_numeric($id_beneficios) || $id_beneficios < 1) {
            throw new InvalidArgumentException('O id de um benefício deve ser um inteiro positivo maior ou igual a 1.');
        }
        $this->id_beneficios = $id_beneficios;
    }

    /**
     * Define a data de início de um benefício
     */
    public function setData_inicio($data_inicio)
    {
        if (!$this->validarData($data_inicio)) {
            throw new InvalidArgumentException('A data informada não está no formato correto: YYYY-MM-DD');
        }
        $this->data_inicio = $data_inicio;
    }

    /**
     * Define a data final de um benefício
     */
    public function setData_fim($data_fim)
    {
        if (!$this->validarData($data_fim)) {
            throw new InvalidArgumentException('A data informada não está no formato correto: YYYY-MM-DD');
        }
        $this->data_fim = $data_fim;
    }

    /**
     * Define o status de um benefício
     */
    public function setBeneficios_status($beneficios_status)
    {
        if (!$beneficios_status || !is_numeric($beneficios_status) || $beneficios_status < 0) {
            throw new InvalidArgumentException('O status fornecido deve ser um inteiro não negativo.');
        }
        $this->beneficios_status = $beneficios_status;
    }

    /**
     * Define o valor de um benefício
     */
    public function setValor($valor)
    {
        if (!$valor || !is_numeric($valor) || $valor <= 0) {
            throw new InvalidArgumentException('O valor de um benefício deve ser um número maior que zero.');
        }
        $this->valor = $valor;
    }

    /**
     * Função para validar o formato de uma data
     */
    private function validarData(string $data, string $formato = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($formato, $data);
        return $d && $d->format($formato) === $data;
    }
}
