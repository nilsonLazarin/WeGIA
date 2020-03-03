<?php

class Pessoa_epi
{
	private $id_pessoa_epi;
    private $id_pessoa;
	private $id_epi;
	private $data;
    private $epi_status;

    public function getId_pessoa_epi()
    {
        return $this->id_pessoa_epi;
    }

    public function getId_pessoa()
    {
        return $this->id_pessoa;
    }

	public function getId_epi()
    {
        return $this->id_epi;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getEpi_status()
    {
        return $this->epi_status;
    }

    public function setId_pessoa_epi($id_pessoa_epi)
    {
        $this->id_pessoa_epi = $id_pessoa_epi;
    }

    public function setId_pessoa($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;
    }

    public function setId_epi($id_epi)
    {
        $this->id_epi = $id_epi;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setEpi_status($epi_status)
    {
        $this->epi_status = $epi_status;
    }

}