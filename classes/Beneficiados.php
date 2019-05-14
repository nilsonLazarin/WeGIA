<?php

require_once 'Pessoa.php';

class Beneficiados extends Pessoa
{
	private $id_beneficiados;
	private $id_pessoa;
	private $id_beneficios;
    private $data_inicio;
    private $data_fim;
    private $beneficios_status;

    public function getId_Beneficiados()
    {
        return $this->id_beneficiados;
    }

    public function getId_pessoa()
    {
        return $this->id_pessoa;
    }

	public function getId_beneficios()
    {
        return $this->id_beneficios;
    }

    public function getData_inicio()
    {
        return $this->data_inicio;
    }

    public function getData_fim()
    {
        return $this->data_fim;
    }

    public function getBeneficios_status()
    {
        return $this->beneficios_status;
    }

    public function setId_beneficiados($id_beneficiados)
    {
        $this->id_beneficiados = $id_beneficiados;
    }

    public function setId_pessoa($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;
    }

    public function setId_beneficios($id_beneficios)
    {
        $this->id_beneficios = $id_beneficios;
    }

    public function setData_inicio($data_inicio)
    {
        $this->data_inicio = $data_inicio;
    }

    public function setData_fim($data_fim)
    {
        $this->data_fim = $data_fim;
    }

    public function setBeneficios_status($beneficios_status)
    {
        $this->beneficios_status = $beneficios_status;
    }

}