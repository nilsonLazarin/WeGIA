<?php
require_once 'Pessoa.php';

class Atendido extends Pessoa
{

    private $idatendido;
    private $id_pessoa;
    private $intStatus;
    private $intTipo;

    public function getIdatendido()
    {
        return $this->idatendido;
    }
    public function getId_pessoa()
    {
        return $this->id_pessoa;
    }
    public function getIntStatus()
    {
        return $this->intStatus;
    }
    public function getIntTipo()
    {
        return $this->intTipo;
    }
   
    public function setIdatendido($idatendido)
    {
        $this->idatendido = $idatendido;
    }

    public function setIntStatus($intStatus)
    {
        $this->intStatus = $intStatus;
    }
    public function setIntTipo($intTipo)
    {
        $this->intTipo = $intTipo;
    }
    public function setId_pessoa($id_pessoa)
    {
        $this->id_pessoa = $id_pessoa;
    }
    
}