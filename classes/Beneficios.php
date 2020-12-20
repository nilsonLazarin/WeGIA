<?php

require_once 'Beneficiados.php';

class Beneficios extends Beneficiados
{
	
	private $id_beneficios;
	private $descricao_beneficios;

	public function getId_beneficios()
    {
        return $this->id_beneficios;
    }

    public function getDescricao_beneficios()
    {
        return $this->descricao_beneficios;
    }

    public function setId_beneficios($id_beneficios)
    {
        $this->id_beneficios = $id_beneficios;
    }

    public function setDescricao_beneficios($descricao_beneficios)
    {
        $this->descricao_beneficios = $descricao_beneficios;
    }

}