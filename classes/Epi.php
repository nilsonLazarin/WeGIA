<?php

class Epi
{
	
	private $id_epi;
	private $descricao_epi;

	public function getId_epi()
    {
        return $this->id_epi
    }

    public function getDescricao_epi()
    {
        return $this->descricao_epi;
    }

    public function setId_epi($id_epi)
    {
        $this->id_epi = $id_epi;
    }

    public function setDescricao_epi($descricao_epi)
    {
        $this->descricao_epi = $descricao_epi;
    }

}